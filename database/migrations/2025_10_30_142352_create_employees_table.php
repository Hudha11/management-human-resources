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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birth_date')->nullable();
            $table->date('hire_date')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'resigned'])->default('active');
            $table->decimal('salary', 15, 2)->nullable();
            $table->timestamps();

            // foreign key (optional) - uncomment jika tabel departments ada
            // $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            // $table->foreign('position_id')->references('id')->on('position')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
