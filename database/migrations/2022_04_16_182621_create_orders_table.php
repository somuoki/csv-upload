<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char('InvoiceNo')->nullable();
            $table->char('StockCode')->nullable();
            $table->text('Description')->nullable();
            $table->integer('Quantity')->nullable();
            $table->dateTime('InvoiceDate')->nullable();
            $table->float('UnitPrice')->nullable();
            $table->integer('Customer')->nullable();
            $table->text('Country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
