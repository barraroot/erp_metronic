<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaPostBlogEcommerce extends Model
{
    protected $fillable = [
        'nome'
    ];

    public function posts(){
        return $this->hasMany('App\Models\PostBlogEcommerce', 'categoria_id', 'id');
    }

}
