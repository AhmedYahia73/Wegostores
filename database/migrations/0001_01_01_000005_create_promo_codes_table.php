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
        if (!Schema::hasTable('promo_codes')) {
            Schema::create('promo_codes', function (Blueprint $table) {
                $table->id();
                $table->string('code');
                $table->string('title');
                $table->enum('promo_status', ['fixed', 'unlimited']);
                $table->enum('calculation_method',allowed: ['percentage','amount']);
                $table->integer('usage')->nullable();
                $table->integer('user_usage')->nullable();
                $table->enum('user_type',['first_usage','renueve']);
                $table->date('start_date');
                $table->date('end_date');
                $table->float('amount')->nullable();
                $table->float('quarterly')->nullable();
                $table->float('semi_annual')->nullable();
                $table->float('yearly')->nullable();
                $table->float('monthly')->nullable();
                $table->enum('promo_type', ['plan', 'extra', 'domain', 'cart', 'setup_fees']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
