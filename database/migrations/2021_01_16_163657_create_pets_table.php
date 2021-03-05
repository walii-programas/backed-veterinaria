<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->string('breed');
            $table->string('color');
            $table->date('birthdate');
            $table->string('sex');
            $table->string('photo')->nullable();
            // $table->foreignId('fk_id_user')->constrained('clients');
            $table->unsignedBigInteger('fk_id_user');
            $table->foreign('fk_id_user')->references('fk_id_user')->on('clients');
            
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
        Schema::dropIfExists('pets');
    }
}
