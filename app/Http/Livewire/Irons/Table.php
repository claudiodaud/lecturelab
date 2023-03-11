<?php

namespace App\Http\Livewire\Irons;

use App\Models\Iron;
use DB;
use Livewire\Component;

class Table extends Component
{
    public $co;
    public $registers;

    public function render()
    {   
        $this->getRegisters();     
        return view('livewire.irons.table');
    }

    public function getRegisters()
    {
        //realizamos la busqueda en Mysql 
        $registers = Iron::where('co',$this->co)->get();
        
    }
}
