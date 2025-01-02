<x-app-layout>
         
    <div class="container mx-auto px-4 py-6">
        <!-- Titre -->
        <h1 class="text-3xl font-extrabold text-gray-200 mb-6">Liste des Utilisateurs</h1>
    
        <!-- Lien retour -->
        <a href="{{ route('dashboard') }}" class="inline-block mb-6 text-blue-600 hover:text-blue-800 transition">← Retour au tableau de bord</a>
        <div class="py-5">
            <a href="{{ route('admin.create') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all">
                <span class="bg-blue-500 rounded-lg p-2 mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </span>
                <span class="text-gray-700 dark:text-gray-200">Nouvel Administrateur</span>
            </a>
            
            
        </div>
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
        <div class="overflow-x-auto shadow-md rounded-lg">
            
            <table id="myTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Nom</th>
                        <th scope="col" class="px-6 py-3">État</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm">{{ $user->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('admin.show', ['admin' => $user]) }}" class="text-blue-600 hover:underline">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 font-medium">
                            <span class="{{ $user->role === 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $user->role === 0 ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.toggleStatus', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                    class="focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 
                                        {{ $user->role === 0 ? 'bg-red-600 hover:bg-red-800' : 'bg-green-600 hover:bg-green-800' }}">
                                    {{ $user->role === 0 ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                        
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
            
            </script>
   
</x-app-layout>


