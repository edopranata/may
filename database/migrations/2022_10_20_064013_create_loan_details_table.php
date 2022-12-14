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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date')->nullable();
            $table->integer('sequence')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('description')->nullable();
            $table->double('opening_balance')->default(0);
            $table->double('amount');
            $table->string('status');
            $table->foreignIdFor(\App\Models\Loan::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('loan_details');
    }
};
