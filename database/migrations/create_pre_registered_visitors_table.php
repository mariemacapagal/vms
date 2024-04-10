<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('pre_registered_visitors', function (Blueprint $table) {
      $table->id();
      $table->string('visitor_first_name', 40);
      $table->string('visitor_last_name', 40);
      $table->string('license_plate', 13);
      $table->string('visit_purpose', 30);
      $table->string('resident_name', 80);
      $table->date('from_visit_date');
      $table->date('to_visit_date');
      $table->string('valid_id');
      $table->date('registered_date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pre_registered_visitors');
  }
};
