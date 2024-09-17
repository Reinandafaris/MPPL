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
    Schema::create('akuns', function (Blueprint $table) {
      $table->id();
      $table->string('kdakun', 10);
      $table->string('nmakun', 50);
      $table->string('klasifikasi', 30);
      $table->string('subklasifikasi', 100);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('akuns');
  }
};
