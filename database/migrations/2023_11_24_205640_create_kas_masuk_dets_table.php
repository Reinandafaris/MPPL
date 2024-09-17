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
    Schema::create('kas_masuk_det', function (Blueprint $table) {
      $table->unsignedBigInteger('idkm');
      $table->unsignedBigInteger('idakun');
      $table->double('nildb');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kas_masuk_det');
  }
};
