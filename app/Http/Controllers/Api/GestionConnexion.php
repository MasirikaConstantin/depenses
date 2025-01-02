<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageVAlidate;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
class GestionConnexion extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:users',
                'password' => 'required|min:4|confirmed',
                "adresse"=>"nullable|min:5",
                'image'=> ["nullable",'max:5120', 'mimes:png,jpg,jpeg,gif,PNG,JPEG,JPG'],

                

            ]);

            $user = User::create([
                'name' => $validated['name'],
                'adresse' => $validated['adresse']?? null,
                'email' => $validated['email'] ?? null,
                'image' => $validated['image']?? null,
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User créé avec succès',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
{
    try {
        $validated = $request->validate([
            'matricule' => 'required|string',
            'password' => 'required',
        ]);

        // Récupérer l'User par son matricule
        $user = User::where('matricule', $validated['matricule'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Identifiants invalides'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Une erreur est survenue',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json([
                'message' => 'Déconnexion réussie'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = $request->user();

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                "adresse"=>"nullable|min:5",
                'password' => 'sometimes|min:4|confirmed',
                'image'=> ["nullable",'max:5120', 'mimes:png,jpg,jpeg,gif,PNG,JPEG,JPG'],

            ]);

            $updateData = [];
            if (isset($validated['name'])) $updateData['name'] = $validated['name'];
            if (isset($validated['adresse'])) $updateData['adresse'] = $validated['adresse'];
            if (isset($validated['email'])) $updateData['email'] = $validated['email'];
            if (isset($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $user->update($updateData);

            return response()->json([
                'message' => 'Profil mis à jour avec succès',
                'user' => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            $user->delete();

            return response()->json([
                'message' => 'Compte supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show(User $user){
        return new UserResource($user);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required','sometimes','min:4', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
    public function updateImage(User $user,ImageVAlidate $request)
    {
       
        $user->update($this->extractData($user ,$request));
        

        return new UserResource($user);
    }
    private function extractData(User $user,  Request $request){

        $validated =$request->validate([
            'image'=> ["nullable",'max:5120', 'mimes:png,jpg,jpeg,gif,PNG,JPEG,JPG'],

        ]);
        $data=[
            'image' => $validated['image'] ?? '',
        ];
        //dd($data);
        /**
        * @var UploadedFile $image
         */
        $image=$data['image'];
        if($image==null || $image->getError()){
            return $data;
        }
        if($user->image){
            Storage::disk('public')->delete($user->image);
        }
            $data['image']=$image->store("profil",'public');
        return $data;
    }

    public function imagedeledata(User $user)
    {
        try {
            if ($user->image) {
                // Extraire le chemin relatif de l'URL complète
                $relativePath = str_replace(env('APP_URL') . '/storage/', '', $user->getRawOriginal('image'));
                
                // Supprimer le fichier physique
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
    
                // Mettre à null le champ image dans la BDD
                $user->image = null;
                $user->save();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Image supprimée avec succès',
                    'user' => new UserResource($user)
                ], 200);
            }
    
            return response()->json([
                'status' => false,
                'message' => 'Aucune image à supprimer'
            ], 404);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ], 500);
        }
    }

}