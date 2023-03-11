<?php

namespace App\Http\Livewire\Irons;

use App\Models\Iron;
use App\Models\Role;
use App\Models\User;
use DB;
use Livewire\Component;

class Irons extends Component
{

    public $co = 63635;    
    public $samples;  
    public $control;
    public $codControl;
    public $coControl;
    public $cart;
    public $codCart;
    public $standart;   

    //permissions
    public $permissions;


    
    public function mount()
    {
        
        $this->getPermissions();
    }
   
    public function render()
    {
        
        if(in_array("viewPhosphorous", $this->permissions)){
            

            $this->getCo(); 
            
            
            return view('livewire.irons.irons');

        }else{

            throw UnauthorizedException::forPermissions($this->permissions);

        }

    }

    public function getPermissions()
    {
        $userWithRolesAndPermissions = User::where('id',auth()->user()->id)->with('roles')->first();
        $userWithDirectsPermissions = User::where('id',auth()->user()->id)->with('permissions')->first();
        
        
        $permissions = [];

        //find permissions for roles
        foreach ($userWithRolesAndPermissions->roles as $key => $role) {
           
            $role = Role::where('id',$role->id)->with('permissions')->first();
                
                foreach ($role->permissions as $key => $permission) {
                    array_push($permissions,$permission->name);
                }                
        }

        //find directs permissions
        foreach ($userWithDirectsPermissions->permissions as $key => $permission) {
        
            array_push($permissions,$permission->name);
                         
        }

        $this->permissions = array_unique($permissions);

    }

    public function getCo()
    {       
        
        //verificamos que la variable CO no sea null 
        if ($this->co) {
            
            //realizamos la busqueda en plusmanager por el CO
            $query = "SELECT * FROM dbo.CONTROL WHERE CODIGO = $this->co";
            $this->control = DB::connection('sqlsrv')->select($query); 

            //verificamos lo que encontramos 
            if ($this->control != null) {
                // si la variable control tiene algo asignamos el cod control que debe ser igual al co 
                $this->codControl = $this->control[0]->COD_CONTROL;
                $this->coControl = $this->control[0]->CODIGO;

                //si el codControl es igual co buscamos la carta 
                if ($this->coControl == strval($this->co)) {
                    $query = "SELECT * FROM CARTA WHERE COD_CONTROL = $this->codControl";
                    $this->cart = DB::connection('sqlsrv')->select($query);
                    if ($this->cart) {
                        $this->codCart = $this->cart[0]->CODCARTA;
                        
                        //realizamos la busqueda en plusmanager por el CO
                        $query = "SELECT * FROM movimiento WHERE analisis = $this->co order by numero ASC";
                        //CONTAMOS LAS MUESTRAS EN EL BACK Y LAS PASAMOS AL FRONT COMO NUMERO SUMADO 
                        $this->samples = DB::connection('sqlsrv')->select($query);  
                        
                        $this->syncSamples();


                        

                        $standart = DB::connection('sqlsrv')->select('SELECT standart FROM standar_co WHERE co = ? ',[$this->co]);
                        $this->standart = $standart[0]->standart;

                        // cuando encuentra mustras y el co coincide con el encontrado en en la carta 
                        if ($this->coControl == strval($this->co)) {
                        $this->emit('change_params',[
                                'co' => $this->co,
                                'coControl' => $this->coControl,
                                'codCart' => $this->codCart, 
                                'standart' => $this->standart,
                               ]);
                        $this->emit('samples');
                        }
                                              
                    }
                }
                
            }
        }


    }

    public function updatingCo()
    {
        // cuando se actualiza la variable co y no coincide con la del control encontrado 
        // manda a null las variables y actualiza register en el controlador de la tabla 
        if ($this->coControl == strval($this->co)) {
        $this->emit('change_params',[
                'co' => null,
                'coControl' => null,
                'codCart' => null,
                'standart' => null, 
               ]);
        
        }
    }

       
    
    // guardar las muestras en la base de datos MySQL
    public function syncSamples()
    {   
        // traer el array de muestras en mysql y revisar que exista en el array de sqlserver si existe, no hago nada, si no existe lo elimino de mysql, significaria que la muestra fue eliminada.
        //traemos las muestras 
        $samplesMySQL = DB::table('irons')->where('co', $this->co)->where('cod_carta', $this->codCart)->get('number');
        
        $arrayMySQL = [];

        $arraySQLServer = [];
        
        foreach ($samplesMySQL as $key => $sample) {
            array_push($arrayMySQL, $sample->number);
        }   

        if ($this->samples) {

            foreach ($this->samples as $key => $sample) {
                array_push($arraySQLServer, $sample->numero);
            }

        }
    
        $diffArrayToDelete = array_diff($arrayMySQL, $arraySQLServer);    
        $diffArrayToCreate = array_diff($arraySQLServer, $arrayMySQL);   
        $diffArrayToUpdate = array_intersect($arraySQLServer, $arrayMySQL);      
        
        //dd([$this->samples,$diffArrayToDelete,$diffArrayToCreate,$diffArrayToUpdate]);    
        // para eliminar 
        foreach ($diffArrayToDelete as $key => $r) {
            
            Iron::where('co',$this->co)
                    ->where('cod_carta', $this->codCart)
                    ->where('number',$r)->forceDelete();        
        }

        // para crear     
        foreach ($diffArrayToCreate as $key => $r) {
            
            $query = "SELECT *  FROM movimiento WHERE codcarta = $this->codCart and numero = $r";      
            $sample = DB::connection('sqlsrv')->select($query);

            Iron::create([ 
                    
                'co'            => $this->co,
                'number'        => $r,                         
                'name'          => $sample[0]->muestra,                     
                'chq'           =>$sample[0]->chq,
                'iron_grade'    => 0,
                'geo615'        => 0,
                'geo618'        => 0,
                'geo644'        => 0,
                'comparative'   => false,
                'cod_carta'     => $this->codCart,      
                'element'       => 'Fe',  
                'updated_by'    => null,
                'updated_date'  => null,
                'written_by'    => null,

            ]);         
        }

        // para actualizar         
        foreach ($this->samples as $key => $r) { 

                   
            // VOY A BUSCAR LA MUeSTRA, LA TRAIGO, SI EXISTE ACTUALIZO EL PESO Y RECALCULO LOS VALORES EN BASE A LOS VALORES GUARDADOS INICIALES  
            $samplex = Iron::where('co',$this->co)
                    ->where('cod_carta', $this->codCart)
                    ->where('number',$r->numero)->first();
            
            //guardamos el peso 
            $samplex->name = $r->muestra;
            $samplex->chq = $r->chq;
            $samplex->save();
        }  


    }

    
}

    





