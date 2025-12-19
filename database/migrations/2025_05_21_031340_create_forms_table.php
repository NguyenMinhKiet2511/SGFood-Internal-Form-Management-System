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
       Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_number')->unique()->nullable();

            $table->timestamp('date_created');

            $table->string('name', 100); // Người đề nghị

            // RÀNG BUỘC ENUM CHO PHÒNG BAN
            $table->enum('department', ['IT', 'HR', 'Finance', 'Sale', 'Logistic','Production']); 

            $table->string('factory', 100);
            $table->text('content');
            $table->text('damage_description')->nullable();
            $table->date('completion_date');

            $table->enum('priority_level', ['low', 'medium', 'high'])->default('medium');

            // RÀNG BUỘC ENUM CHO PHÒNG BAN XỬ LÝ 
            $table->enum('processing_department', ['IT', 'HR', 'Finance', 'Sale', 'Logistic','Production']);

            $table->enum('status', ['pending', 'in_progress','approved','denied','accepted', 'done', 'rejected_byhandler'])->default('pending');
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
