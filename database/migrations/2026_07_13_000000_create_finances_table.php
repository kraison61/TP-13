<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('color', 20);
            $table->string('rgba_color', 40);
            $table->string('link');
            $table->string('img');
            $table->string('icon', 50);
            $table->string('max_amount');
            $table->string('rate');
            $table->json('features');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
