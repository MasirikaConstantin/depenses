<x-app-layout>

    <div class="py-6 my-6 m-12">
        <div id="categories" class="content-section">
            <div class="glass rounded-xl p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                @session('success')
                    <div class="flex items-center p-4 mb-4 text-sm text-green-800 dark:text-green-400 bg-green-50 dark:bg-gray-800/50 rounded-lg" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Message de success!</span> {{ session('success') }}
                        </div>
                    </div>
                @endsession
        
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Gestion des Catégories</h2>
                    <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle Catégorie
                    </a>
                </div>
        
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left">Nom</th>
                                <th class="px-4 py-3 text-left">Description</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Date de création</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $a=0;
                            @endphp
                            @foreach($categories as $categorie)
                            @php
                                $k=$a++ ."a";
                            @endphp
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 dark:bg-blue-600 text-white flex items-center justify-center mr-3">
                                            <span class="text-sm font-bold">{{ substr($categorie->nom, 0, 3) }}</span>
                                        </div>
                                        {{ $categorie->nom }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">{!! $categorie->description !!}</td>
                                <td class="px-6 py-4 font-medium">
                                    <span class="{{ $categorie->status === 1 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $categorie->status === 1 ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $categorie->created_at ? $categorie->created_at->format('d/m/Y'): "N/A" }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('categories.edit',['category'=>$categorie]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form id="delete-form-{{ $categorie->id }}" action="{{ route('categories.destroy', ['category' =>$categorie]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $categorie->id }}, '{{ $categorie->nom }}')" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('toggleStatus', $categorie->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 
                                                {{ $categorie->status === 1 ? 'bg-red-600 hover:bg-red-800' : 'bg-green-600 hover:bg-green-800' }}">
                                            {{ $categorie->status === 1 ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        
                <div class="flex justify-end mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
        
        <script>
            function confirmDelete(id, nom) {
                const confirmed = confirm(`Êtes-vous sûr de vouloir supprimer ${nom} ?`);
                if (confirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            }
        </script>
    </div>
</x-app-layout>
               