
@section("titre","Tableau de Bord")
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tableau de bord administrateur') }}
            </h2>
            <div class="flex space-x-3">
                <span class="bg-green-500 px-3 py-1 rounded-full text-white text-sm">
                    {{ now()->format('d M Y') }}
                </span>
                <span class="bg-blue-500 px-3 py-1 rounded-full text-white text-sm">
                    {{ now()->format('H:i') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques générales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Présences du jour -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-500 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium">Dépenses aujourd'hui</p>
                            <p class="text-white text-2xl font-bold">{{ (number_format($montantTotal))??0 }} Fc</p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{ { route('presences.index') }}" class="text-white text-sm hover:text-blue-100">Voir détails →</a>
                    </div>
                </div>

                <!-- Total Agents -->
                <div class="bg-gradient-to-br from-pink-600 to-red-500 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium">Total Agents</p>
                            <p class="text-white text-2xl font-bold">{{ $totalAgents ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('users.index') }}" class="text-white text-sm hover:text-red-100">Gérer agents →</a>
                    </div>
                </div>

                <!-- Nombre de Lieux -->
                <!--div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium">Sites de travail</p>
                            <p class="text-white text-2xl font-bold">{ { $totalLieux ??0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{ { route('lieux.create') }}" class="text-white text-sm hover:text-yellow-100">Gérer sites →</a>
                    </div>
                </div-->

                <!-- Taux de présence -->
                <!--div class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white text-sm font-medium">Taux de présence</p>
                            <p class="text-white text-2xl font-bold">{ { $tauxPresence ??0 }}%</p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{ { route('statistiques.index') }}" class="text-white text-sm hover:text-green-100">Voir statistiques →</a>
                    </div>
                </div-->
            </div>

            <!-- Actions rapides -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions rapides</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('users.create') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all">
                            <span class="bg-blue-500 rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </span>
                            <span class="text-gray-700 dark:text-gray-200">Nouvel agent</span>
                        </a>


                        <!--a href="{ { route('lieux.create') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900/30 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/50 transition-all">
                            <span class="bg-green-500 rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                            </span>
                            <span class="text-gray-700 dark:text-gray-200">Nouveau site</span>
                        </a>


                        <a href="{ { route('presences.index') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900/30 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/50 transition-all">
                            <span class="bg-green-500 rounded-lg p-2 mr-3">
                                
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                                  </svg>
                                  
                            </span>
                            <span class="text-gray-700 dark:text-gray-200">Toutes les Présences</span>
                        </a-->



                        <a href="{{ route('admin.index') }}" class="flex items-center p-4 bg-red-200 dark:bg-red-900/30 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/50 transition-all">
                            <span class="bg-red-500 rounded-lg p-2 mr-3">
                                
                                <svg class="w-6 h-6 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z" clip-rule="evenodd"/>
                                  </svg>
                                  
                            </span>
                            <span class="text-gray-700 dark:text-gray-200">Tous les Administrateurs</span>
                        </a>

                        <a href="{ { route('categories.create') }}" class="flex items-center p-4 bg-yellow-200 dark:bg-yellow-900/30 rounded-xl hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-all">
                            <span class="bg-yellow-500 rounded-lg p-2 mr-3">
                                
                                <svg class="w-6 h-6 text-yellow-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z" clip-rule="evenodd"/>
                                  </svg>
                                  
                            </span>
                            <span class="text-gray-700 dark:text-gray-200">Toutes les Catégories</span>
                        </a>
                    </div>
                </div>

                <!-- Dernières activités -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dernières activités</h3>
                    <div class="space-y-4">
                            
                       
                        @forelse(($recentActivities) as $activity)
                        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-2">
                            <div class=" items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-300">{{ $activity->user->name }}</span>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($activity->description,30) }} : {{ number_format($activity->montant) }} Fc </p>

                            </div>
                            
                            <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>

                        @empty
                        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                              <span class="font-medium">Vide !</span> Aucune activité disponible pour aujourd'hui
                            </div>
                          </div>
                            
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Graphique des présences -->
            <!--div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Évolution des présences</h3>
                <div class="h-64"-->
                    <!-- Intégrez ici votre graphique préféré (Chart.js, ApexCharts, etc.) -->
                    <!--canvas id="presenceChart"></canvas>
                </div>
            </div-->
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('presenceChart').getContext('2d');
            const presenceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @ json($labels), // Utilisez les données de Laravel
                    datasets: [{
                        label: 'Présences',
                        data: @ json($ data),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        },
                        y: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        }
                    }
                }
            });
        });
    </script>
    
</x-app-layout>