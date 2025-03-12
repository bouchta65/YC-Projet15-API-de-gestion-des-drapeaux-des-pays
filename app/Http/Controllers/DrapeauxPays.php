<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pays;

class DrapeauxPays extends Controller
{
    public function index() {
        $pays = Pays::All();
        $data = [
            'status'=>200,
            'pays'=>$pays
        ];
        
        return response()->json($data,200);
    }
}
