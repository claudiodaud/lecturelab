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
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volumetry_id')->nullable()->index();
            $table->string('sample_name');
            $table->string('method');
            $table->string('element');
            $table->integer('co');
            $table->integer('cart');  
            $table->float('weight1',9,5)->nullable();
            $table->float('weight2',9,5)->nullable();
            $table->float('weight3',9,5)->nullable();
            $table->float('weight4',9,5)->nullable();
            $table->float('weight5',9,5)->nullable();
            $table->float('weight6',9,5)->nullable();
            $table->float('vol1',9,5)->nullable();
            $table->float('vol2',9,5)->nullable();
            $table->float('vol3',9,5)->nullable();
            $table->float('vol4',9,5)->nullable();
            $table->float('vol5',9,5)->nullable();
            $table->float('vol6',9,5)->nullable();
            $table->float('grade1',9,5)->nullable();
            $table->float('grade2',9,5)->nullable();
            $table->float('grade3',9,5)->nullable();
            $table->float('grade4',9,5)->nullable();
            $table->float('grade5',9,5)->nullable();
            $table->float('grade6',9,5)->nullable();
            $table->float('title1',9,5)->nullable();
            $table->float('title2',9,5)->nullable();
            $table->float('title3',9,5)->nullable();
            $table->float('title4',9,5)->nullable();
            $table->float('title5',9,5)->nullable();
            $table->float('title6',9,5)->nullable();
            $table->float('title',9,5)->nullable();
            $table->float('titling',9,5)->nullable();
            $table->float('titleCalculated',9,5)->nullable();
            $table->float('weightX',9,5)->nullable();
            $table->float('volX',9,5)->nullable();
            $table->float('gradeX',9,5)->nullable();
            $table->float('titleX',9,5)->nullable();
            $table->foreignId('update_user_id')->nullable()->index();
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
        Schema::dropIfExists('titles');
    }
};
