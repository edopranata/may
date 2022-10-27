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
        Schema::create('trade_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Trade::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Farmer::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

            $table->integer('weight');
            $table->double('price');
            $table->double('total');
            $table->dateTime('farmer_status')->nullable();


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
        Schema::dropIfExists('trade_details');
    }
};
