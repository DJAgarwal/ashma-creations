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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('image_path');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->json('json_ld')->nullable()->after('meta_description');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('is_featured');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->json('json_ld')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'json_ld']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'json_ld']);
        });
    }
};
