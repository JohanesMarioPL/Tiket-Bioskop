<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. LOCATIONS
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // bigint unsigned primary key
            $table->string('name');
            $table->string('city');
            $table->text('address');
            $table->timestamps();
        });

        // 2. USERS (Sesuai diagram)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user'); // admin/user
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. STUDIOS
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->string('studio_name');
            $table->string('studio_type'); // Regular/Premiere
            $table->integer('capacity');
            $table->timestamps();
        });

        // 4. MOVIES
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('genre');
            $table->integer('duration_minutes');
            $table->string('rating_age');
            $table->string('poster_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
