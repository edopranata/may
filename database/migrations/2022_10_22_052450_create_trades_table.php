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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Driver::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Car::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

            $table->dateTime('trade_date');
            $table->string('description')->nullable();
            $table->double('gross_price')->default(0);      // harga beli dari petani
            $table->integer('gross_weight')->default(0);    // timbangan dari petani (kebun)
            $table->double('gross_total')->default(0);      // total harga beli petani x timbangan petani
            $table->double('net_price')->default(0);        // Harga jual ke pabrik
            $table->integer('net_weight')->default(0);      // timbangan pabrik
            $table->double('net_total')->default(0);        // total harga jual pabrik x timbangan pabrik
            $table->double('driver_fee')->default(0);       // Upah supir
            $table->double('car_fee')->default(0);          // Uang mobil (upah sewa mobil)
            $table->dateTime('driver_status')->nullable();        // status dan tanggal pembayaran ke driver
            $table->dateTime('car_status')->nullable();           // status dan tanggal pembayaran uang mobil
            $table->dateTime('trade_status')->nullable();         // status dan tanggal di bayar oleh pabrik

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
        Schema::dropIfExists('trades');
    }
};
