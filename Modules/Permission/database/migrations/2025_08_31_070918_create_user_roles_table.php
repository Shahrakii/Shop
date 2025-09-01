<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();

            // Foreign key to users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            // Foreign key to roles
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('cascade');

            $table->timestamps();

            // To prevent duplicates
            $table->unique(['user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
