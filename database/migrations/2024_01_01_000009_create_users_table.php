<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email_work')->unique();
            $table->string('email_personal')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('profile')->nullable();
            $table->text('activities')->nullable();
            $table->string('job_title');
            $table->text('job_description')->nullable();
            $table->foreignId('timezone_id')->constrained();
            $table->string('location');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->string('photo_url')->nullable();
            $table->foreignId('agency_id')->constrained();
            $table->decimal('salary', 10, 2)->nullable();
            $table->decimal('salary_including_agency_fees', 10, 2)->nullable();
            $table->text('bonus_structure')->nullable();
            $table->string('slack')->nullable();
            $table->string('skype')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->foreignId('user_type_id')->constrained();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};