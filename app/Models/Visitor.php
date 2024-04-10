<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
  use HasFactory;
  protected $fillable = [
    'id',
    'visitor_first_name',
    'visitor_last_name',
    'license_plate',
    'visit_purpose',
    'resident_name',
    'from_visit_date',
    'to_visit_date',
    'visitor_qrcode',
    'valid_id',
    'registered_date',
    'user'
  ];
}
