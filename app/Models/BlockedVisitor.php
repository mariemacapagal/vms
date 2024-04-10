<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedVisitor extends Model
{
  use HasFactory;
  protected $fillable = [
    'visitor_id',
    'visitor_first_name',
    'visitor_last_name',
    'license_plate',
    'valid_id',
    'registered_date',
    'blocked_date',
    'remarks',
    'user',
  ];
}
