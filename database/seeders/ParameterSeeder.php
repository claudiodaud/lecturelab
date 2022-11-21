<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Phosphorous
        Parameter::create(['control' => 'phosphorous', 'type_var' => 'absorbance'           ,'value' => 0]);
        Parameter::create(['control' => 'phosphorous', 'type_var' => 'aliquot'              ,'value' => 25]);
        Parameter::create(['control' => 'phosphorous', 'type_var' => 'colorimetric_factor'  ,'value' => 0.125359884]);        

    }
}