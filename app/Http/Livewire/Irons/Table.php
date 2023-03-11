<?php

namespace App\Http\Livewire\Irons;

use App\Models\Iron;
use DB;
use Livewire\Component;

class Table extends Component
{
    public $co;
    public $codCart;
    public $coControl;
    public $registers;

    public $listeners = ['change_params'];

    public function render()
    {   
        $this->getRegisters(); 

        
        
        
        return view('livewire.irons.table');
    }

    public function getRegisters()
    {
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->codCart != null) {
            $this->registers = Iron::where('co',$this->co)->where('cod_carta',$this->codCart)->get();
            
        }


       
            
    }

    public function change_params($value){


        $this->co = $value['co'];
        $this->coControl = $value['coControl'];
        $this->codCart = $value['codCart'];
        
        if ($this->co != $this->coControl) {
            $this->registers = null;
        }

        $this->getRegisters();



    }

}
