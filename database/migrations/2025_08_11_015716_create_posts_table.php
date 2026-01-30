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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->foreignId('repost_of_id')
                ->nullable()
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->string('content')
                ->nullable();
            $table->timestamps();

            $table->index('parent_id');
            $table->index(['profile_id', 'created_at']);

            $table->unique(['profile_id', 'repost_of_id'], 'unique_profile_repost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
