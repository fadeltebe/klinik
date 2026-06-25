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
            $table->foreignId('patient_profile_id')->constrained('patient_profiles')->onDelete('restrict');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('restrict');
            $table->foreignId('booked_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('appointment_date');
            $table->integer('queue_number')->nullable();
            $table->time('estimated_service_time')->nullable();
            $table->enum('status', ['pending', 'approved', 'checked_in', 'calling', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            
            $table->unique(['patient_profile_id', 'doctor_id', 'appointment_date'], 'appt_patient_doc_date_unique');
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
