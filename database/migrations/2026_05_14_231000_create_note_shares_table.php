<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained('notes')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->string('permission', 16)->default('read');
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();

            $table->unique(['note_id', 'recipient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_shares');
    }
};
