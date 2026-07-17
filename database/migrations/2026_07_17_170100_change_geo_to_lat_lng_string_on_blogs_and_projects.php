<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const DEFAULT_GEO = '13.836991,100.443780';

    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('geo');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('geo', 32)->default(self::DEFAULT_GEO)->after('author');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('geo');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('geo', 32)->default(self::DEFAULT_GEO)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('geo');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->json('geo')->default('{"latitude":"13.000000","longitude":"100.000000"}')->after('author');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('geo');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->json('geo')->default('{"latitude":"13.000000","longitude":"100.000000"}')->after('status');
        });
    }
};
