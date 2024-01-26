<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
  use HasFactory;
  protected $fillable = ['visitor_id', 'check_in', 'check_out', 'log_date', 'status'];
}
