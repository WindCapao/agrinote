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
        // Update articles table
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft')->after('user_id');
        });
        
        // Update books table
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('books', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft')->after('user_id');
        });
        
        // Update images table
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('images', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert articles table
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('draft')->after('user_id');
        });
        
        // Revert books table
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('books', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('draft')->after('user_id');
        });
        
        // Revert images table
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('images', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('draft')->after('user_id');
        });
    }
};