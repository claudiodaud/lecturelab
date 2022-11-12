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
        Schema::create('presamples', function (Blueprint $table) {
            $table->id();
            $table->integer('co');
            $table->integer('cod_carta');
            $table->string('method');
            $table->integer('number');
            $table->string('name');
            $table->float('absorbance', 6, 3)->nullable();
            $table->float('weight', 8, 2);
            $table->integer('aliquot')->nullable();
            $table->float('colorimetric_factor', 12, 9)->nullable();
            $table->float('dilution_factor', 12, 7)->nullable();
            $table->float('phosphorous', 6, 3)->nullable();
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
        Schema::dropIfExists('presamples');
    }
};
