<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_attributions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('source_page')->index();
            $table->string('utm_source')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('customer_name')->nullable();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['generated', 'applied', 'expired'])->default('generated')->index();
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->dateTime('used_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();

            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_attributions');
    }
};
