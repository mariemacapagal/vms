<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
  use HasFactory;
  protected $fillable = [
    'visitor_name',
    'license_plate',
    'visit_purpose',
    'resident_name',
    'visit_date',
    'visitor_qrcode',
    'registered_date',
  ];
}
