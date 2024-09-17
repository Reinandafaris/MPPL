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
    Schema::create('buku_besar', function (Blueprint $table) {
      $table->id();
      $table->Integer('idtrans');
      $table->string('notran', 10);
      $table->date('tgltran');
      $table->string('catatan', 255);
      $table->double('jmldb')->nullable();
      $table->double('jmlcr')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('buku_besar');
  }
};
