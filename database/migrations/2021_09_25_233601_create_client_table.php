<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->string('checked');
            $table->longText('description')->nullable();
            $table->text('interest')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('account')->nullable();
            $table->string('credit_card_type')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_name')->nullable();
            $table->string('credit_card_expirationDate')->nullable();
            $table->string('hash',64);
            $table->boolean('credit_card_identical_digits')->default(0);
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
        Schema::dropIfExists('client');
    }
}




