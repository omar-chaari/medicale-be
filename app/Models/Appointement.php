<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointement extends Model
{
    use HasFactory;

    public function professionalslist()
	{
		return $this->belongsTo('App\Models\Professional', 'users', 'id');
	}
    public function patientslist()
	{
		return $this->belongsTo('App\Models\Patient', 'patients', 'id');
	}
}
