<?php

namespace App\Http\Controllers;

use App\Models\Voertuig;
use App\Models\TypeVoertuig;
use App\Models\VoertuigInstructeur;
use App\Models\Instructeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoertuigController extends Controller
{
    public function edit($pivot_id)
    {
        $voertuigInstructeur = VoertuigInstructeur::findOrFail($pivot_id);
        $voertuig = $voertuigInstructeur->voertuig;
        $instructeur = $voertuigInstructeur->instructeur;
        $instructeurs = Instructeur::all();
        
        return view('voertuigen.edit', compact('voertuig', 'instructeur', 'voertuigInstructeur', 'instructeurs'));
    }

    public function update(Request $request, $pivot_id)
    {
        $request->validate([
            'Type' => 'required|string|max:50',
            'Brandstof' => 'required|string|max:20',
            'Kenteken' => 'required|string|max:12',
            'InstructeurId' => 'required|exists:Instructeur,Id',
        ]);

        $voertuigInstructeur = VoertuigInstructeur::findOrFail($pivot_id);
        $voertuig = $voertuigInstructeur->voertuig;
        $originalInstructeurId = $voertuigInstructeur->InstructeurId;

        // Update vehicle details - notice Bouwjaar is not included
        $voertuig->update([
            'Type' => $request->Type,
            'Brandstof' => $request->Brandstof,
            'Kenteken' => $request->Kenteken,
        ]);

        // If instructor changed, update the assignment
        if ($request->InstructeurId != $originalInstructeurId) {
            // Check if this vehicle is already assigned to the new instructor
            $existingAssignment = VoertuigInstructeur::where('VoertuigId', $voertuig->Id)
                                                   ->where('InstructeurId', $request->InstructeurId)
                                                   ->first();
            
            if ($existingAssignment) {
                // Just delete the current assignment as it already exists for the new instructor
                $voertuigInstructeur->delete();
            } else {
                // Update the instructor assignment
                $voertuigInstructeur->update([
                    'InstructeurId' => $request->InstructeurId,
                    'DatumToekenning' => now()->format('Y-m-d'),
                ]);
            }
        }

        return redirect()->route('instructeur.voertuigen', $originalInstructeurId)
                         ->with('success', 'Voertuig succesvol gewijzigd en/of toegewezen aan een andere instructeur.');
    }

    // New methods for scenario 3
    public function available($instructeurId)
    {
        $instructeur = Instructeur::findOrFail($instructeurId);
        
        // Get all vehicles that are not assigned to any instructor
        $assignedVoertuigIds = VoertuigInstructeur::pluck('VoertuigId')->toArray();
        $availableVoertuigen = Voertuig::whereNotIn('Id', $assignedVoertuigIds)
                                       ->with('typeVoertuig')
                                       ->get()
                                       ->sortBy('typeVoertuig.Rijbewijscategorie');
        
        return view('voertuigen.available', compact('availableVoertuigen', 'instructeur'));
    }

    public function editUnassigned($voertuigId, $instructeurId)
    {
        $voertuig = Voertuig::findOrFail($voertuigId);
        $instructeur = Instructeur::findOrFail($instructeurId);
        $instructeurs = Instructeur::all();
        
        return view('voertuigen.edit-unassigned', compact('voertuig', 'instructeur', 'instructeurs'));
    }

    public function updateUnassigned(Request $request, $voertuigId, $instructeurId)
    {
        $request->validate([
            'Type' => 'required|string|max:50',
            'Brandstof' => 'required|string|max:20',
            'Kenteken' => 'required|string|max:12',
            'Assign' => 'boolean',
        ]);

        $voertuig = Voertuig::findOrFail($voertuigId);
        $instructeur = Instructeur::findOrFail($instructeurId);

        // Update vehicle details - notice Bouwjaar is not included
        $voertuig->update([
            'Type' => $request->Type,
            'Brandstof' => $request->Brandstof,
            'Kenteken' => $request->Kenteken,
        ]);

        // If assign checkbox is checked, assign the vehicle to the instructor
        if ($request->has('Assign') && $request->Assign) {
            VoertuigInstructeur::create([
                'VoertuigId' => $voertuig->Id,
                'InstructeurId' => $instructeurId,
                'DatumToekenning' => now()->format('Y-m-d'),
            ]);
            
            return redirect()->route('instructeur.voertuigen', $instructeurId)
                             ->with('success', 'Voertuig succesvol gewijzigd en toegewezen aan instructeur.');
        }
        
        return redirect()->route('voertuig.available', $instructeurId)
                         ->with('success', 'Voertuig succesvol gewijzigd.');
    }
}
