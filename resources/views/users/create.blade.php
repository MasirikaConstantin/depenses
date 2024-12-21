<x-app-layout>

    <div class="container mx-auto p-6">
           <h1 class="text-2xl text-gray-200 font-bold mb-6"> {{ $user->exists ? 'Modifier un utilisateur' : 'Créer un utilisateur' }}</h1>
           
           @if(session('success'))
               <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                   <span class="block sm:inline">{{ session('success') }}</span>
                   
               </div>
           @endif

           <form method="POST"  action="{{ route($user->exists ? 'users.update' : 'users.store', $user) }}" class="mt-4 md:grid md:grid-cols-2 gap-8" enctype="multipart/form-data" >
            @csrf
            @if($user->exists)
            @method('PUT') <!-- Indique que cette requête est une mise à jour -->
        @endif 
       
           
           <div class="bg-gray-700 shadow-md rounded px-8 pt-6 pb-8 mb-4" >


                        <div class="mb-4">
                            <label class="block text-gray-200 text-sm font-bold mb-2" for="nom">
                                Nom :
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                type="text" 
                                id="nom" 
                                name="name" 
                                value="{{ old('name',$user->name) }}"
                                required>
                                @error("name")
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                        <label class="block text-gray-200 text-sm font-bold mb-2" for="nom">
                            E- mail :
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email',$user->email) }}"
                                required>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                <span>En cas de email inexistant n'oubliez pas de créer un</span>
                                </div>

                                @error("email")
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror                       
                                
                    </div>
                
                    
                        
                
                        <div class="mb-4">
                            <label class="block text-gray-200 text-sm font-bold mb-2" for="password">
                                Mot de passe :
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                type="password" 
                                id="password" 
                                name="password" 
                                >
                                @error("password")
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                                    type="submit">
                                {{ $user->exists ? 'Modifier l\'utilisateur' : 'Créer l\'utilisateur' }}
                            </button>
                        
                        </div>
                    </div>
                    <div class="bg-gray-700 shadow-md rounded px-8 pt-6 pb-8 mb-4">

                        <div class="mb-1">
                            <label for="formFile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisir une photo</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"  name="image" type="file" id="fileUpload">
                          </div>

                          <div class="col-sm mb-3 rounded rounded-lg ">
                            <div class="flex flex-col  items-center justify-center pt-5 pb-6" >
                            
                                
                                <img id='imageDiv'  class="h-100 rounded rounded-xl shadow-md shadow-blue-800/80" style=" height:220px ; width: 100% ; height: 350px; object-fit: cover "  />
                              
                              
                              
                            </div>
                            
                          </div> 
                          @error("image")
                              {{ $message }}
                          @enderror
                        </div>
                    
           </div>
           <a href="{{ route('dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
            Retour au tableau de bord
        </a>

        
       </div>
    </form>

       <script>
        document.getElementById('fileUpload').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imageDiv').src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        });
        </script>
        <script>
        document.getElementById('fileUpload').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                document.getElementById('imageDiv').appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        });
        </script>
   
   </x-app-layout>
   