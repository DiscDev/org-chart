<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->date('scheduled_date');
            $table->date('completed_date')->nullable();
            $table->string('status'); // scheduled, completed, cancelled
            $table->text('objectives')->nullable();
            $table->text('achievements')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('feedback')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->text('development_plan')->nullable();
            $table->text('next_review_goals')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};