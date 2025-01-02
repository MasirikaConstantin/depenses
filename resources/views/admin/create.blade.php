<x-app-layout>
@section("titre","Créer un Administrateur")
<div class="container mx-auto p-6"  >
    <div class="bg-white p-6 mx-auto rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ $user->exists ? 'Modifier un Administrateur' : 'Créer Un Administrateur' }}</h1>
        
        <!-- Affichage des messages -->
        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif
        
        
        <!-- Formulaire -->
        <form method="POST" action="{{ route($user->exists ? 'admin.update' : 'admin.store', $user) }}">
            @csrf
            @if($user->exists)
               @method('PUT') <!-- Indique que cette requête est une mise à jour -->
           @endif
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Nom :</label>
                <input type="text" id="name" name="name" value="{{ old('name',$user->name) }}" required class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error("name")
                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email :</label>
                <input type="email" id="email" name="email" value="{{ old('email',$user->email) }}" required class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error("email")
                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Mot de passe :</label>
                <input type="password" id="password" name="password"  class="mt-2 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error("password")
                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    
                @enderror
            </div>
            
            @if ($user ==null)
                
            @else
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="etat" value="1" checked class="form-checkbox text-blue-600">
                    <span class="ml-2 text-gray-700">Compte actif</span>
                </label>
            </div>
            @endif
            
            <button type="submit" class="w-full bg-blue-500 text-white font-semibold p-2 rounded-lg hover:bg-blue-600 transition-colors">{{ $user->exists ? 'Modifier L\'Administrateur' : 'Créer L\'Administrateur' }}</button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('admin.index') }}" class="text-blue-500 hover:underline">Retour</a>
        </div>
    </div>
           <a href="{{ route('dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
               Retour au tableau de bord
           </a>
       </div>
    </div>
   </x-app-layout>
   