<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = [
        'value', 'client_id'
    ];

    public function clientJuck(){
        return $this->belongsTo(ClientJuck::class, 'client_id');
    }
}
