<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'fichier',
        'consultation',
        'description',

       
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation');
    }

}
