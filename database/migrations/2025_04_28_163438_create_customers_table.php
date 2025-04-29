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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_firstname')->nullable();
            $table->string('customer_lastname')->nullable();
            $table->string('customer_cni')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_province')->nullable();
            $table->string('customer_commune')->nullable();
            $table->string('customer_zone')->nullable();
            $table->string('customer_colline')->nullable();
            $table->integer('customer_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
