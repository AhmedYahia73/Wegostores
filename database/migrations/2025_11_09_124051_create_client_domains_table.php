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
        Schema::create('client_domains', function (Blueprint $table) {
            $table->id();
            $table->string("img");
            $table->string("alt");
            $table->string("website");
            $table->string("facaebook");
            $table->boolean("app_status")->default(0);
            $table->boolean("is_client")->default(0);
            $table->string("ios");
            $table->string("android");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_domains');
    }
};
