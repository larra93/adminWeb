<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $dates = ['deleted_at'];
    protected $table = "servicios";
    protected $fillable = ['nombre','descripcion','imagen'];
}
