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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->nullable()->unique();
            $table->string('invoice_number')->nullable()->unique();
            $table->integer('customer_id')->nullable();
            $table->integer('order_status')->nullable()->default(0);
            $table->integer('order_delete_status')->nullable()->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->string('order_delete_comment')->nullable();
            $table->date('date_facturation')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders_details',function (Blueprint $table){
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->string('ref_order_code')->nullable();
            $table->string('service_name')->nullable();
            $table->string('service_price')->nullable();
            $table->float('sold_qty')->nullable();
            $table->float('sold_price')->nullable();
            $table->float('htva_price')->nullable();
            $table->float('tva_price')->nullable();
            $table->float('tc_price')->nullable();
            $table->float('pf_price')->nullable();
            $table->integer('detail_status')->nullable()->default(0);
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('orders_details');
    }
};
