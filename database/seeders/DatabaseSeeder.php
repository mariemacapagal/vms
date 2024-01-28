<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $numberOfVisitors = 5;
    for ($i = 0; $i < $numberOfVisitors; $i++) {
      DB::table('visitors')->insert([
        'visitor_name' => 'Visitor Name',
        'license_plate' => Str::random(8),
        'visit_purpose' => 'Visit Purpose',
        'visit_date' => Carbon::create('2024', '01', '14'),
        'visitor_qrcode' => Str::random(16),
        'registered_date' => Carbon::create('2024', '01', '14'),
      ]);
    }
  }
}
