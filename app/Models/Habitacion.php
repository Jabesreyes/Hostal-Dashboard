<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function estados()
    {
        return $this->belongsTo(Estado::class);
    }
}
