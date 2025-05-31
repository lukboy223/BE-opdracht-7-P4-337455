<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoertuigInstructeur extends Model
{
    use HasFactory;

    protected $table = 'VoertuigInstructeur';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'VoertuigId',
        'InstructeurId',
        'DatumToekenning'
    ];

    public function voertuig()
    {
        return $this->belongsTo(Voertuig::class, 'VoertuigId', 'Id');
    }

    public function instructeur()
    {
        return $this->belongsTo(Instructeur::class, 'InstructeurId', 'Id');
    }
}
