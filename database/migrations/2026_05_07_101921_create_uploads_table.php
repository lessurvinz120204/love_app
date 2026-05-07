<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('uploads', function (Blueprint $table) {
        $table->id();
        $table->string('type'); // 'letter', 'song', 'photo'
        $table->string('title')->nullable();
        $table->string('file_path');
        $table->string('original_name');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
