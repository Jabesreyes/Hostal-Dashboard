<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }
    public static function buscar($texto)
    {
        return self::where('nombre', 'like', '%' . $texto . '%')->paginate(5);
    }
}
