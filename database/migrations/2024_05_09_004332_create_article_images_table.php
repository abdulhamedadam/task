<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id_fk');
            $table->foreign('article_id_fk')->references('id')->on('articles');
            $table->string('image');
            $table->string('image_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_images', function (Blueprint $table) {
            // Use raw SQL to drop foreign key constraint
            DB::statement('ALTER TABLE article_images DROP FOREIGN KEY article_images_article_id_fk_foreign');
            $table->dropColumn(['article_id_fk', 'image', 'image_name']);
        });

    }
};
