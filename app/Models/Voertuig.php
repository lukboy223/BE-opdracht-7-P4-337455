<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voertuig extends Model
{
    use HasFactory;

    protected $table = 'Voertuig';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Kenteken',
        'Type',
        'Bouwjaar',
        'Brandstof',
        'TypeVoertuigId'
    ];

    public function typeVoertuig()
    {
        return $this->belongsTo(TypeVoertuig::class, 'TypeVoertuigId', 'Id');
    }

    public function instructeurs()
    {
        return $this->belongsToMany(Instructeur::class, 'VoertuigInstructeur', 'VoertuigId', 'InstructeurId')
                    ->withPivot('DatumToekenning')
                    ->withPivot('Id');
    }
}
