@section('titre', $categorie->exists ? 'Editier la categorie' :'Nouvelle categorie')
<x-app-layout>
  <!-- Main modal -->
  <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
  <div   class=" w-full sm:max-w-md mt-6 px-3 py-2  shadow-md overflow-hidden sm:rounded-lg ">

   @session('success')
       
       <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
          <span class="font-medium">Message de success!</span> {{ session('success') }}.
        </div>
      </div>

   @endsession

      <div class="relative p-4 w-full max-w max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      {{ $categorie->exists ? "Editer la Catégorie": "Nouvelle categorie" }}
                  </h3>
                  <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                      
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5">
                  <form class="space-y-4" action="{{route($categorie->exists ? 'categories.update': 'categories.store', $categorie)}}" method="POST">

                    @csrf
                    @if ($categorie->exists)
                        @method("PUT")
                    @endif
                      <div>
                          <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                          <input type="name" name="nom" id="name" value="{{ old('name', $categorie->nom) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Technologie" required />

                          @error("nom")
                          <div class="p-4 mb-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">Erreur alert!</span> {{ $message }}.
                          </div>
                          @enderror
                      </div>

                      
                      <div>
                          
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer une description">{{ old('description',$categorie->description) }}</textarea>
                            @error("description")
                          <div class="p-4 mb-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">Erreur alert!</span> {{ $message }}.
                          </div>
                          @enderror
                        </div>
                        <div class="mb-4">
                          <label class="flex items-center">
                              <input type="checkbox" name="status" value="1" class="form-checkbox dark:bg-gray-800 dark:border-gray-600" {{ $categorie->status == 1 ? 'checked' : '' }}                                >
                              <span class="ml-2 text-gray-700 dark:text-gray-300">Publier immédiatement</span>
                          </label>
  
                      </div>
                      
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> 
        {{ $categorie->exists ? 'Modifier la Catégorie' : 'Ajouter une Catégorie' }}
            
            </button>
                      
                  </form>
              </div>
             <div class="py-3 px-6">
                <a href="{{ route('dashboard') }}#categories"
   class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
Retour à l'accueil
                    <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                    </a>

                  

             </div>
          </div>
          
      </div>

      
  </div> 
</div> 
</x-app-layout>
  