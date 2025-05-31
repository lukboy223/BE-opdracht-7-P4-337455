<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use Illuminate\Http\Request;

class InstructeurController extends Controller
{
    public function index()
    {
        // Get all instructors sorted by number of stars (descending)
        $instructeurs = Instructeur::orderByRaw('LENGTH(AantalSterren) DESC')
                                  ->orderBy('AantalSterren', 'DESC')
                                  ->get();
        
        return view('instructeurs.index', compact('instructeurs'));
    }

    public function voertuigen($id)
    {
        $instructeur = Instructeur::findOrFail($id);
        
        // Get vehicles sorted by driving license category
        $voertuigen = $instructeur->voertuigen()
                                  ->with('typeVoertuig')
                                  ->get()
                                  ->sortBy('typeVoertuig.Rijbewijscategorie');
        
        return view('instructeurs.voertuigen', compact('instructeur', 'voertuigen'));
    }
}
