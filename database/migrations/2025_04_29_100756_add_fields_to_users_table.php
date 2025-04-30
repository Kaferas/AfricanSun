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
        Schema::table('users', function (Blueprint $table) {
            $table->string('agent_id')->nullable()->after('id');
            $table->string('phone')->nullable()->after('agent_id');
            $table->string('role')->nullable()->after('phone');
            $table->string('province')->nullable()->after('agent_id');
            $table->string('commune')->nullable()->after('province');
            $table->string('colline')->nullable()->after('commune');
            $table->string('zone')->nullable()->after('colline');
            $table->string('address')->nullable()->after('zone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
