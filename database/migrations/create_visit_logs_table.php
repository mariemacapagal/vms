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
    Schema::create('visit_logs', function (Blueprint $table) {
      $table->id();
      $table->string('visitor_id');
      $table->string('visit_purpose', 30);
      $table->string('resident_name', 80);
      $table->string('check_in');
      $table->string('check_out')->nullable();
      $table->date('log_date');
      $table->string('status', 3);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visit_logs');
  }
};
