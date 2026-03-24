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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('professional_id')->constrained('professionals')->cascadeOnDelete();
            $table->enum('type', ['chat', 'video'])->default('chat');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'waiting_payment', 'paid', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->datetime('scheduled_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('topic')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
