<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisaoGrade extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome', 'sub_divisao'
    ];
}
