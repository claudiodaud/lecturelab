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
        Schema::create('irons', function (Blueprint $table) {
            $table->id();

            $table->integer('co');                              // identificador de co
            $table->integer('number');                          // numero coorelativo 
            $table->string('name');                             // nombre de la muestra 
            $table->string('chq')->nullable();                  // chequeo
            $table->float('iron_grade', 12, 9)->nullable();     // lectura del satmagan
            $table->float('geo615', 12, 9)->nullable();         // factor10 
            $table->float('geo618', 12, 9)->nullable();         // factor 0,72
            $table->float('geo644', 12, 9)->nullable();         // viene desde el absorcion atomica
            $table->boolean('comparative')->default(0);         // 644 > 618

            $table->integer('cod_carta');             
            $table->string('element')->default('Fe');            

            $table->string('updated_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->string('written_by')->nullable();

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
        Schema::dropIfExists('irons');
    }
};
