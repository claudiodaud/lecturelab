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
        Schema::create('volumetries', function (Blueprint $table) {
            $table->id();
            $table->integer('co');                              // identificador de co
            $table->integer('cod_carta');                             

            $table->string('method');                           // metodo de las muestras (502, 515, 541 hierro), (122 cobre)
            $table->string('element');
            $table->integer('number');                          // numero coorelativo 
            $table->string('name');                             // nombre de la muestra 
            $table->float('weight', 8, 5);                      // peso de la muestra     
            
                                          
            $table->string('chq')->nullable();                  // chequeo
            $table->float('spent', 12, 9)->nullable(); 
            $table->float('grade', 12, 9)->nullable();           
            $table->float('title', 12, 9)->nullable();              
                       

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
        Schema::dropIfExists('volumetries');
    }
};
