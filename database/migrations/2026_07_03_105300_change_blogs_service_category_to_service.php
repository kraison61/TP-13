<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);
            $table->dropColumn('service_category_id');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->after('cover_image')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('service_category_id')->nullable()->after('cover_image')->constrained()->nullOnDelete();
        });
    }
};
