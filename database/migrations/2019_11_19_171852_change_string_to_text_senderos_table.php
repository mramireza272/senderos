<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStringToTextSenderosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('senderos', function (Blueprint $table) {
            $table->text('responsable')->change();
            $table->text('sendero')->change();
            $table->text('alcaldia')->change();
            $table->text('colonia')->change();
            $table->text('inaugurar')->change();
            $table->text('estatus')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_senderos', function (Blueprint $table) {
            //
        });
    }
}
