<?php

namespace App\Http\Controllers;

use App\Models\Voertuig;
use App\Models\TypeVoertuig;
use App\Models\VoertuigInstructeur;
use App\Models\Instructeur;
use Illuminate\Http\Request;

class VoertuigController extends Controller
{
    public function edit($pivot_id)
    {
        $voertuigInstructeur = VoertuigInstructeur::findOrFail($pivot_id);
        $voertuig = $voertuigInstructeur->voertuig;
        $instructeur = $voertuigInstructeur->instructeur;
        
        return view('voertuigen.edit', compact('voertuig', 'instructeur', 'voertuigInstructeur'));
    }

    public function update(Request $request, $pivot_id)
    {
        $request->validate([
            'Type' => 'required|string|max:50',
            'Brandstof' => 'required|string|max:20',
            'Kenteken' => 'required|string|max:12',
        ]);

        $voertuigInstructeur = VoertuigInstructeur::findOrFail($pivot_id);
        $voertuig = $voertuigInstructeur->voertuig;
        $instructeur = $voertuigInstructeur->instructeur;

        $voertuig->update([
            'Type' => $request->Type,
            'Brandstof' => $request->Brandstof,
            'Kenteken' => $request->Kenteken,
        ]);

        return redirect()->route('instructeur.voertuigen', $instructeur->Id)
                         ->with('success', 'Voertuig succesvol gewijzigd.');
    }
}
