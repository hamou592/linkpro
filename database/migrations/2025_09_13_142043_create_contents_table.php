<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('color')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('background_path')->nullable();
            $table->json('links')->nullable(); // {tiktok,facebook,...}
            $table->json('geolocation')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('contents');
    }
};

