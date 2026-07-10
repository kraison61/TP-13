<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('name');
            $table->string('phone');
            $table->string('service');
            $table->string('expected_budget');
            $table->unsignedInteger('requested_discount')->default(0);
            $table->text('detail')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index('reference');
            $table->index('phone');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
