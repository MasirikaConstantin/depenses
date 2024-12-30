@section('titre','Utilisateur')
<x-app-layout>
    @php
    \Carbon\Carbon::setLocale('fr');
@endphp
    <div class="container mx-auto px-4 py-6">
        <!-- Titre -->
        <h1 class="text-3xl font-extrabold text-gray-200 mb-6">Liste des Utilisateurs</h1>
    
        <!-- Lien retour -->
        <a href="{{ route('dashboard') }}" class="inline-block mb-6 text-blue-600 hover:text-blue-800 transition">← Retour au tableau de bord</a>
    
        <!-- Barre de recherche -->
        <div class="w-full md:w-2/3 lg:w-1/2 mb-6">
            <form>
                <label for="default-search" class="sr-only">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" id="myInput" onkeyup="filterTable()" class="block w-full p-4 pl-10 text-sm text-gray-700 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Recherche Rapide" required />
                    <button type="submit" class="absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-4 py-2 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    
        @if (session('success'))
        <div class="p-4 mb-6 text-sm bg-green-100 text-green-800 rounded-lg" role="alert">
            <span class="font-medium">Astuce :</span> {{ session("success") }}
        </div>
        @endif
        
    
        <!-- Tableau des utilisateurs -->
       <!-- index.blade.php -->
<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <div class="text-gray-300">{{ now()->translatedFormat('l, d F Y') }}</div>

    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Dépenses Aujourd'hui</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($totalGeneral, 0, ',', ' ') }} FC</p>
                </div>
            </div>
        </div>
        <!-- Ajoutez d'autres stats si nécessaire -->
    </div>

    <!-- Users List -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Utilisateurs</h2>
                <div class="flex space-x-2">
                    <!-- Add filters or search if needed -->
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dépenses du Jour</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($user->image)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profilUrl() }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-sm">{{ substr($user->name, 0, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-gray-500 text-sm">ID: {{ $user->id }}-{{  $user->matricule }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->depenses_jour->isNotEmpty())
                                    <div class="space-y-2">
                                        @foreach ($user->depenses_jour as $depense)
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="text-gray-600">{{ Str::limit($depense->description, 15) }}</span>
                                                <span class="font-medium">{{ number_format($depense->montant, 0, ',', ' ') }} FC</span>
                                            </div>
                                        @endforeach
                                        <div class="pt-2 border-t">
                                            <div class="flex justify-between items-center font-medium">
                                                <span>Total</span>
                                                <span class="text-blue-600">{{ number_format($user->total_jour, 0, ',', ' ') }} FC</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-500">Aucune dépense aujourd'hui</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Moy. journalière:</span>
                                        <span class="font-medium">{{ number_format($user->moyenne_jour, 0, ',', ' ') }} FC</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Total semaine:</span>
                                        <span class="font-medium">{{ number_format($user->total_semaine, 0, ',', ' ') }} FC</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('voir', $user->id) }}" 
                                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Détails
                                    </a>
                                    @if($user->depenses->isEmpty())
                                    <button data-modal-target="deleteModal{{ $user->id }}" 
                                            data-modal-toggle="deleteModal{{ $user->id }}"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Supprimer
                                    </button>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 text-sm text-gray-500" title="Impossible de supprimer un utilisateur ayant des dépenses">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4 0h2m-6 0h2" />
                                        </svg>
                                        Non supprimable
                                    </span>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modals -->
    @foreach ($users as $user)
        <div id="deleteModal{{ $user->id }}" tabindex="-1" class="fixed inset-0 z-50 hidden p-4 overflow-y-auto bg-gray-900 bg-opacity-50">
            <!-- Modal content remains the same -->

               <div class="relative w-full max-w-md mx-auto">
                   <div class="bg-white rounded-lg shadow-md">
                       <button type="button" 
                               class="absolute top-3 right-3 text-gray-400 hover:text-gray-700" 
                               data-modal-hide="deleteModal{{ $user->id }}">
                           <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                           </svg>
                       </button>
                       <div class="p-6">
                           <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                           </svg>
                           <h3 class="mb-5 text-lg text-gray-700 text-center">
                               Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                           </h3>
                           <div class="flex justify-center gap-4">
                               <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" 
                                           class="bg-red-600 text-white hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                       Oui, supprimer
                                   </button>
                               </form>
                               <button data-modal-hide="deleteModal{{ $user->id }}" 
                                       class="bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                   Non, annuler
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>

        
    @endforeach
</div>
    
        <!-- Retour -->
        <a href="{{ route('dashboard') }}" class="inline-block mt-6 text-blue-600 hover:text-blue-800 transition">← Retour au tableau de bord</a>
    </div>
    
        <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const deleteButtons = document.querySelectorAll('[data-modal-toggle]');
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                });
            });
    
            const cancelButtons = document.querySelectorAll('[data-modal-hide]');
            cancelButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-hide');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                });
            });
        });
        </script>
    
   
     <script>
                    
                    // Sélectionnez tous les éléments du tableau
            var elements = document.querySelectorAll("table #tr");
            
            // Parcourez tous les éléments
            for(var i = 0; i < elements.length; i++) {
                // Si l'élément est supérieur à 3, cachez-le
                if(i >= 15) {
                    elements[i].style.display = "none";
                }
            }
            
            // Sélectionnez tous les éléments du tableau
            var elements = document.querySelectorAll("table #trs");
            
            // Parcourez tous les éléments
            for(var i = 0; i < elements.length; i++) {
                // Si l'élément est supérieur à 3, cachez-le
                if(i >= 50) {
                    elements[i].style.display = "none";
                }
            }
            
            function filterTable() {
            
                // Declare variables
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
            
                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
            
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            
            }
            function confirmDelete(id, name) {
    const confirmed = confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur ${name} ?`);
    if (confirmed) {
        document.getElementById(`delete-form-${id}`).submit();
    }
}
            
            </script>
   
</x-app-layout>
