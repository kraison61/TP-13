<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->string('meta_des')->nullable();
            $table->text('description')->nullable();
            $table->string('h1')->nullable();
            $table->text('content')->nullable();
            $table->decimal('rating_value', 3, 1)->default(5);
            $table->unsignedInteger('review_count')->default(0);
            $table->string('schema_type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('price_type', ['fixed', 'starting_at', 'range', 'call_to_ask', 'variable'])->default('fixed');
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('max_price', 12, 2)->nullable();
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->string('unit')->nullable();
            $table->string('price_currency', 3)->default('THB');
            $table->date('price_valid_until')->nullable();
            $table->string('availability')->default('https://schema.org/InStock');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('labor_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('labor_categories')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('labor_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('labor_categories')->cascadeOnDelete();
            $table->string('item_name');
            $table->string('unit');
            $table->decimal('cost_per_unit', 12, 2)->default(0);
            $table->string('remark')->nullable();
            $table->string('document_ref')->default('ว 809');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('project_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('phase_number');
            $table->string('title');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->decimal('project_length', 12, 2)->nullable();
            $table->text('content')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('completion_date')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('author_name');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('review_text');
            $table->string('location')->nullable();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description');
            $table->text('content');
            $table->string('cover_image')->nullable();
            $table->foreignId('service_category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('image_uploads', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('img_url');
            $table->string('location')->nullable();
            $table->dateTime('worked_date')->nullable();
            $table->timestamps();

            $table->index(['location', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_uploads');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('project_phases');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('labor_costs');
        Schema::dropIfExists('labor_categories');
        Schema::dropIfExists('service_prices');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
    }
};
