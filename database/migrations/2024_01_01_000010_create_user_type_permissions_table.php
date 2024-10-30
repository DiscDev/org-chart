<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_type_permissions', function (Blueprint $table) {
            $table->foreignId('user_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->primary(['user_type_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_type_permissions');
    }
};