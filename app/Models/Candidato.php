<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
  use HasFactory;

  protected $hidden = [
    'updated_at',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'source',
    'owner',
    'created_by',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'id' => 'integer',
    'owner' => 'integer',
    'created_by' => 'integer',
  ];

  public function owner()
  {
    return $this->belongsTo(Usuario::class);
  }

  public function createdBy()
  {
    return $this->belongsTo(Usuario::class);
  }
}
