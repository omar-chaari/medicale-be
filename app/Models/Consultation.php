<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    /*
patient	professional	date	motif	notes
    */
    protected $fillable = [
        'professional',
        'patient',
        'date',
        'motif',
        'notes'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'consultation');
    }
    

}
