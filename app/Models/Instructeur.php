<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructeur extends Model
{
    use HasFactory;

    protected $table = 'Instructeur';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Mobiel',
        'DatumInDienst',
        'AantalSterren'
    ];

    public function voertuigen()
    {
        return $this->belongsToMany(Voertuig::class, 'VoertuigInstructeur', 'InstructeurId', 'VoertuigId')
                    ->withPivot('DatumToekenning')
                    ->withPivot('Id');
    }
    
    public function getFullNameAttribute()
    {
        return $this->Voornaam . ' ' . ($this->Tussenvoegsel ? $this->Tussenvoegsel . ' ' : '') . $this->Achternaam;
    }
}
