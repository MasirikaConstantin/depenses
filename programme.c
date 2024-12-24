#include <mpi.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define M 4  // Nombre de lignes de A
#define N 4  // Nombre de colonnes de A et de lignes de B 
#define P 4  // Nombre de colonnes de B
#define NB_PROCS 4  // Nombre fixe de processeurs

void lire_matrice_csv(const char *fichier, double matrice[][N], int lignes, int colonnes) {
    FILE *fp = fopen(fichier, "r");
    if (fp == NULL) {
        fprintf(stderr, "Erreur : Impossible d'ouvrir le fichier %s\n", fichier);
        MPI_Abort(MPI_COMM_WORLD, 1);
    }

    char ligne[1024];
    for (int i = 0; i < lignes; i++) {
        if (fgets(ligne, sizeof(ligne), fp) == NULL) {
            fprintf(stderr, "Erreur : Pas assez de lignes dans le fichier %s\n", fichier);
            fclose(fp);
            MPI_Abort(MPI_COMM_WORLD, 1);
        }

        char *valeur = strtok(ligne, ",");
        for (int j = 0; j < colonnes; j++) {
            if (valeur == NULL) {
                fprintf(stderr, "Erreur : Pas assez de colonnes à la ligne %d dans le fichier %s\n", i + 1, fichier);
                fclose(fp);
                MPI_Abort(MPI_COMM_WORLD, 1);
            }
            matrice[i][j] = atof(valeur);
            valeur = strtok(NULL, ",");
        }
    }
    fclose(fp);
}

int main(int argc, char **argv) {
    int rank, size;
    double A[M][N], B[N][P];
    double local_A[M/NB_PROCS][N];  // Chaque processeur reçoit 1 ligne (M/4 = 1)
    double local_C[M/NB_PROCS][P];
    double C[M][P];

    MPI_Init(&argc, &argv);
    MPI_Comm_rank(MPI_COMM_WORLD, &rank);
    MPI_Comm_size(MPI_COMM_WORLD, &size);

    // Vérifier qu'on a exactement 4 processeurs
    if (size != NB_PROCS) {
        if (rank == 0) {
            fprintf(stderr, "Ce programme doit être exécuté avec exactement %d processeurs.\n", NB_PROCS);
        }
        MPI_Finalize();
        return 1;
    }

    // Lecture des matrices par le processus 0
    if (rank == 0) {
        printf("Lecture des matrices depuis les fichiers CSV...\n");
        lire_matrice_csv("A.csv", A, M, N);
        lire_matrice_csv("B.csv", B, N, P);
    }

    // Distribution des données
    MPI_Scatter(A, (M/NB_PROCS) * N, MPI_DOUBLE, 
                local_A, (M/NB_PROCS) * N, MPI_DOUBLE, 
                0, MPI_COMM_WORLD);
    
    // Diffusion de B à tous les processus
    MPI_Bcast(B, N * P, MPI_DOUBLE, 0, MPI_COMM_WORLD);

    // Calcul du produit matriciel local
    for (int i = 0; i < M/NB_PROCS; i++) {
        for (int j = 0; j < P; j++) {
            local_C[i][j] = 0.0;
            for (int k = 0; k < N; k++) {
                local_C[i][j] += local_A[i][k] * B[k][j];
            }
        }
    }

    // Rassemblement des résultats
    MPI_Gather(local_C, (M/NB_PROCS) * P, MPI_DOUBLE,
               C, (M/NB_PROCS) * P, MPI_DOUBLE,
               0, MPI_COMM_WORLD);

    // Affichage et sauvegarde du résultat
    if (rank == 0) {
        printf("Résultat : Matrice C\n");
        FILE *fp = fopen("C.txt", "w");
        if (fp == NULL) {
            fprintf(stderr, "Erreur : Impossible d'écrire le fichier de sortie C.txt\n");
            MPI_Abort(MPI_COMM_WORLD, 1);
        }
        
        for (int i = 0; i < M; i++) {
            for (int j = 0; j < P; j++) {
                fprintf(fp, "%.2f ", C[i][j]);
                printf("%.2f ", C[i][j]);
            }
            fprintf(fp, "\n");
            printf("\n");
        }
        fclose(fp);
        printf("Matrice C sauvegardée dans le fichier C.txt\n");
    }

    MPI_Finalize();
    return 0;
}