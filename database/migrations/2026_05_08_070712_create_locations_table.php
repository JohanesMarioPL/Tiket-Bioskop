<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
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
            $table->string('rating_age'); // SU/R13/D17
            $table->string('poster_url')->nullable();
            $table->timestamps();
        });

        // 5. SCHEDULES
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->foreignId('studio_id')->constrained('studios')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->decimal('base_price', 12, 2);
            $table->timestamps();
        });

        // 6. SEATS
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('studios')->onDelete('cascade');
            $table->string('seat_number'); // A1, A2, etc
            $table->timestamps();
        });

        // 7. TRANSACTIONS
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('transaction_code')->unique();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();
        });

        // 8. PAYMENTS
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('payment_method'); // Bank/E-Wallet
            $table->string('payment_status');
            $table->dateTime('payment_time')->nullable();
            $table->timestamps();
        });

        // 9. TICKETS
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->string('ticket_type'); // Adult/Child
            $table->decimal('final_price', 12, 2);
            $table->timestamps();
        });

        // 10. SEAT_RESERVATIONS
        Schema::create('seat_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade');
            $table->timestamps();
        });

        // 11. REVIEWS
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('seat_reservations');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('seats');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('studios');
        Schema::dropIfExists('users');
        Schema::dropIfExists('locations');
    }
};