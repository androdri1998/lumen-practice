<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model{
  
  protected $table = 'cars';

  protected $fillable = [
    'name',
    'description',
    'model'
  ];

  protected $casts = [
    'created_at' => 'Timestamp',
    'updated_at' => 'Timestamp'
  ];
  
}