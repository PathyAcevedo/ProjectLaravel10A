<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    protected $table = "libros";
    protected $fillable = [
        'id',
        'isbn',
        'title',
        'description',
        'published_date',
        'category_id',
        'editorial_id'
    ];
    public $timestamps = false;

    public function bookDownload(){
        return $this->hasOne(BookDownloads::class);
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function editorial(){
        return $this->belongsTo(Editorial::class, 'editorial_id','id');
    }
    public function autores(){
        return $this->belongsToMany(Autores::class,
         'autores_libros',
         'libros_id',
         'autores_id');
    }

}
