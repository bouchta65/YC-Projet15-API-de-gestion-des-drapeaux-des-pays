<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Pays;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Promise\Create;

class PaysController extends Controller
{
    public function index(){
        $pays = Pays::all();
        if($pays){
            return response()->json(['pays'=> $pays],200);
        }else{
            return response()->json(['message' => 'Aucun pays disponible'],200);
        }
    }

    public function store(Request $request){
        
        $validator = $request->validate([
        'nom'=>'string|required|max:255',
        'capitale'=>'string|required|max:255',
        'population'=>'integer|required',
        'region'=>'string|required|max:255',
        'url_drapeau'=>'string|required|max:255',
        'devise'=>'string|max:255',
        'langue'=>'string|max:255'
        ]);
        try{
            $pays = Pays::create($validator);
            return response()->json(['message'=> 'Pays créé avec succès' , 'pays'=>$pays],201);

        }catch(\Exception $e){
            return response()->json(['message'=> 'Erreur lors de la création' , 'error'=>$e->getMessage()],500);

        }
    }

    public function update(request $request, $id){
        $validator = $request->validate([
            'nom'=>'string|required|max:255',
            'capitale'=>'string|required|max:255',
            'population'=>'integer|required',
            'region'=>'string|required|max:255',
            'url_drapeau'=>'string|required|max:255',
            'devise'=>'string|max:255',
            'langue'=>'string|max:255'
        ]);

        

        try{
            $pays = Pays::findOrFail($id);
            $pays->update($validator);
            return response()->json(['message'=> 'Pays mis à jour avec succès','pays'=>$pays],200);
        }catch(\Exception $e){
            return response()->json(['message'=> 'Erreur lors de la mise à jour','error'=>$e->getMessage()],500);
        }


    }

    public function delete($id){
        try{
            $pays = Pays::findOrFail($id);
            $pays->delete();
            return response()->json(['message'=>'Pays supprimé avec succès'],200);
        }catch(\Exception $e){
            return response()->json(['message'=>'Erreur lors de la suppression','error'=>$e->getMessage()],500);
        }
    }

    public function updateFlag(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'url_drapeau'=>'required|image|mimes:jpg,png,jpeg'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed','errors' => $validator->errors()], 400);
        }

        try{
            $pays = Pays::findOrFail($id);
            if($request->hasFile('url_drapeau')){
                $file = $request->file('url_drapeau');
                $filepath = $file->store('flags' , 'public');
                $pays->url_drapeau = $filepath;
                $pays->save();

            }
            return response()->json(['message'=> 'drapeau mis à jour avec succès','pays'=>$pays],200);

        }catch(\Exception $e){
            return response()->json(['message'=>'Erreur lors de la mise à jour de drapeau','error'=>$e->getMessage()],500);
        }


    }
    public function showImages($id){
        try{
            $pays = Pays::findOrFail($id);
            $image = $pays->url_drapeau;
                return response()->json(['images'=> $image],200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Aucun image disponible','error'=>$e->getMessage()],500);

        }
       
    }
}
