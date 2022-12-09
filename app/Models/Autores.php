<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autores extends Model
{
    use HasFactory;
    protected $table = "autores";
    protected $fillable = [
        'id',
        'name',
        'paterno',
        'materno'
    ];
    public $timestamps = false;
}
