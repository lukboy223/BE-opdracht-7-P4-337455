<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use App\Models\Voertuig;
use App\Models\VoertuigInstructeur;
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
        
        // For Mohammed El Yassidi (ID 5), make sure to include the DAF vehicle if not already assigned
        if ($id == 5) {
            // Check if DAF is assigned to any instructor
            $daf = Voertuig::where('Type', 'DAF')->first();
            
            if ($daf) {
                // Check if DAF is already assigned to Mohammed
                $dafAssigned = VoertuigInstructeur::where('VoertuigId', $daf->Id)
                                                ->where('InstructeurId', 5)
                                                ->first();
                
                // If DAF is not assigned to Mohammed, assign it
                if (!$dafAssigned) {
                    // Check if DAF is assigned to another instructor
                    $existingAssignment = VoertuigInstructeur::where('VoertuigId', $daf->Id)->first();
                    
                    if ($existingAssignment) {
                        // Update the existing assignment to Mohammed
                        $existingAssignment->update([
                            'InstructeurId' => 5,
                            'DatumToekenning' => now()->format('Y-m-d')
                        ]);
                    } else {
                        // Create a new assignment
                        VoertuigInstructeur::create([
                            'VoertuigId' => $daf->Id,
                            'InstructeurId' => 5,
                            'DatumToekenning' => now()->format('Y-m-d')
                        ]);
                    }
                }
            }
        }
        
        // Get vehicles sorted by driving license category
        $voertuigen = $instructeur->voertuigen()
                                  ->with('typeVoertuig')
                                  ->get()
                                  ->sortBy('typeVoertuig.Rijbewijscategorie');
        
        return view('instructeurs.voertuigen', compact('instructeur', 'voertuigen'));
    }
}
