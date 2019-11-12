<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenderosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senderos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('responsable')->nullable();
            $table->string('sendero')->nullable();
            $table->string('alcaldia')->nullable();
            $table->string('colonia')->nullable();
            $table->text('entrecalles')->nullable();
            $table->string('inaugurar')->nullable();
            $table->string('estatus')->nullable();
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
        Schema::dropIfExists('senderos');
    }
}
