<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeVoertuig extends Model
{
    use HasFactory;

    protected $table = 'TypeVoertuig';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'TypeVoertuig',
        'Rijbewijscategorie'
    ];

    public function voertuigen()
    {
        return $this->hasMany(Voertuig::class, 'TypeVoertuigId', 'Id');
    }
}
