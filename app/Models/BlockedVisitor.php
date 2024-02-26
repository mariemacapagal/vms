<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedVisitor extends Model
{
  use HasFactory;
  protected $fillable = [
    'visitor_id',
    'visitor_name',
    'license_plate',
    'visit_purpose',
    'resident_name',
    'visit_date',
    'visitor_qrcode',
    'registered_date',
  ];
}