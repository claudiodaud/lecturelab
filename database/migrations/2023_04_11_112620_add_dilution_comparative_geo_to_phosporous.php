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
        Schema::table('presamples', function (Blueprint $table) {
           
            $table->float('dilution', 12, 9)->nullable()->after('dilution_factor');
            $table->string('geo')->nullable()->after('phosphorous');
            $table->float('geo_comparative', 12, 9)->nullable()->after('geo');         // viene desde los mismos datos ya subidos. 
            $table->boolean('comparative')->default(0)->after('geo_comparative');         // xxx > xxx
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presamples', function (Blueprint $table) {
            $table->dropColumn('dilution');
            $table->dropColumn('geo');
            $table->dropColumn('geo_comparative');
            $table->dropColumn('comparative');
        });
    }
};
