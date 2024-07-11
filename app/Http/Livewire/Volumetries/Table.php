<?php

namespace App\Http\Livewire\Volumetries;

use App\Models\Role;
use App\Models\Title;
use App\Models\User;
use App\Models\Volumetry;
use DB;
use Livewire\Component;

class Table extends Component
{

    public $registers;
    public $register;
    public $co;
    public $coControl;
    public $codCart;
    public $methode;
    public $standart;
    public $title;
    public $titling;
    public $titleCalculated = null;

    public $keyIdSpent;
    public $spentField;
    public $editSpent;

    public $keyIdTitle;
    public $titleField;
    public $editTitle;
 
    // Modal VARs //////////////////////////////////////////
    public $calculateModal = false; //open and close modal
    public $findTitleModal = false;
    public $idModal;
    public $sample_name;


    public $weight1;
    public $weight2;
    public $weight3;
    public $weight4;
    public $weight5;
    public $weight6;

    public $vol1;
    public $vol2;
    public $vol3;
    public $vol4;
    public $vol5;
    public $vol6;

    public $grade1;
    public $grade2;
    public $grade3;
    public $grade4;
    public $grade5;
    public $grade6;

    public $title1;
    public $title2;
    public $title3;
    public $title4;
    public $title5;
    public $title6;

    public $weightX;
    public $volX;
    public $gradeX;
    public $titleX;

    // titles vars

    ////////////////////////////////////////////////////////


    public $listeners = ['change_params'];


    public function mount()
    {
        $this->getPermissions();
    }

    
    public function render()
    {
        //esta linea debe estar aqui paraq la actualizacion de registros es para mantener la carga directa 


        $this->getRegisters();
        

        return view('livewire.volumetries.table');
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

        //dd($this->permissions);
    }

    
    public function change_params($value)
    {
        //dd($value);
        $this->co = $value['co'];
        $this->coControl = $value['coControl'];
        $this->methode = $value['methode'];
        $this->codCart = $value['codCart'];
        $this->standart = $value['standart'];
        $this->title = $value['title'];
        

        $this->keyIdSpent = null;        
        $this->editSpent = null; 
        $this->spentField = null;

        $this->keyIdTitle = null;        
        $this->editTitle = null; 
        $this->titleField = null;
       
        $this->getRegisters();
    }


    public function getRegisters()
    {
        
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
                 
            $this->registers = Volumetry::where('co', $this->co)
                                                    ->where('cod_carta', $this->codCart)
                                                    ->where('method', $this->methode)
                                                    ->with('writtenUser','updatedUser')
                                                    ->orderBy('number', 'ASC')->get();
        }else{
            
            $this->registers = false;
        }  
        
        
    }


    public function updatedKeyIdSpent($keyIdSpent)
    {
        $this->keyIdSpent = $keyIdSpent;
        $this->dispatchBrowserEvent('spent', ['key' => $this->keyIdSpent]);
    }

   
    
    public function updatingKeyIdSpent($key)
    {
            $this->keyIdSpent = null;
            $this->editSpent = false;
            $this->keyIdSpent = $key;
            $this->editSpent = true;

    }

    public function updateSpent($id)
    {
        

        if ($this->spentField != null) {
           //buscamos el registro a actualizar
           $register = Volumetry::find($id);

           $register->spent = $this->spentField;
          
           // realizar calculos sobre el titulante y calculo de la ley  
           $register->save();
          
           // realizar calculos sobre el titulante y calculo de la ley  
            if ($register->weight == 0) {
               $register->grade == 0; 
            }else{
               $register->grade = $register->title*$register->spent/$register->weight*100; 
            }
           $register->save();
          
           $register->written_by = auth()->user()->id;
           $register->save();

           $this->getRegisters();


        }

        $this->spentField = null;
        if (count($this->registers) > $this->keyIdSpent + 1) {
            
            $this->keyIdSpent = $this->keyIdSpent + 1;
            $this->editSpent = true;
            $this->dispatchBrowserEvent('spent', ['key' => $this->keyIdSpent]);
            
            
        }else{
            $this->closeSpent();
           
        }        

    }

    public function closeSpent()
    {
        $this->keyIdSpent = null;
        $this->editSpent = false;
    }


    /// TITLE COLUMN ///
    public function updatedKeyIdTitle($keyIdTitle)
    {
        $this->keyIdTitle = $keyIdTitle;
        $this->dispatchBrowserEvent('title', ['key' => $this->keyIdTitle]);
    }

   
    
    public function updatingKeyIdTitle($key)
    {
            $this->keyIdTitle = null;
            $this->editTitle = false;
            $this->keyIdTitle = $key;
            $this->editTitle = true;

    }

    public function updateTitle($id)
    {
        

        if ($this->titleField != null) {
           //buscamos el registro a actualizar
           $register = Volumetry::find($id);

           $register->title = $this->titleField;
           $register->save();
          
           // realizar calculos sobre el titulante y calculo de la ley  
            if ($register->weight == 0) {
               $register->grade == 0; 
            }else{
               $register->grade = $register->title*$register->spent/$register->weight*100; 
            }
           $register->save();
          
           $register->written_by = auth()->user()->id;
           $register->save();

           $this->getRegisters();




        }

        $this->titleField = null;

        if (count($this->registers) > $this->keyIdTitle + 1) {
            
            $this->keyIdTitle = $this->keyIdTitle + 1;
            $this->editTitle = true;
            $this->dispatchBrowserEvent('title', ['key' => $this->keyIdTitle]);
            
            
        }else{
            $this->closeTitle(); 
        }
         
             

    }

    public function closeTitle()
    {
        $this->keyIdTitle = null;
        $this->editTitle = false;
    }

    public function downTitle($id)
    {
        $registerToCopy = Volumetry::find($id);

        $registers = Volumetry::where('co',$this->co)->where('method', $this->methode)->where('number','>=',$registerToCopy->number)->get('id');
        // ->update([
            // 'title' => $registerToCopy->title]);

        foreach ($registers as $key => $r) {
            $register = Volumetry::find($r->id);
            $register->title = $registerToCopy->title;

            $register->save();
          
            // realizar calculos sobre el titulante y calculo de la ley  
            if ($register->weight == 0) {
               $register->grade == 0; 
            }else{
               $register->grade = $register->title*$register->spent/$register->weight*100; 
            }
            
            $register->save();
          
            $register->written_by = auth()->user()->id;
            $register->save();

        }

        
        
    }




    public function calculateTitle($id)
    {
       $this->idModal = $id;
       $this->register = Volumetry::find($id);
       $this->calculateModal = true;

    }

    public function updateCalculate($id)
    {
        
        // recuperar el registro
        $register = Volumetry::find($this->idModal);

        //calcular el titulo de esa muestra 
        $register->title = $this->titleCalculated;
        $register->save();

        $register->grade = $register->title*$register->spent/$register->weight*100;
        $register->save();
        
        //limpiar variables 
        $this->weight1 = null;
        $this->weight2 = null;
        $this->weight3 = null;
        $this->weight4 = null;
        $this->weight5 = null;
        $this->weight6 = null;

        $this->vol1 = null;
        $this->vol2 = null;
        $this->vol3 = null;
        $this->vol4 = null;
        $this->vol5 = null;
        $this->vol6 = null;

        $this->grade1 = null;
        $this->grade2 = null;
        $this->grade3 = null;
        $this->grade4 = null;
        $this->grade5 = null;
        $this->grade6 = null;

        $this->title1 = null;
        $this->title2 = null;
        $this->title3 = null;
        $this->title4 = null;
        $this->title5 = null;
        $this->title6 = null;

        $this->title    = null;
        $this->titling  = null;
        $this->titleCalculated  = null;

        $this->weightX   = null;
        $this->volX     = null;
        $this->gradeX   = null;
        $this->titleX   = null;  

        // AQUI GUARDAR LA INFORMACION DEL CALCULO DEL TITULO MODELO TITULO      
        
        

        //cerrar el modal 
        $this->idModal = null;
        $this->calculateModal = false;


    }

    public function calculate()
    {

        //////////////////////////////////////////////
        // FOMRULA PARA EL CALCULO DE NUEVO TITULO  //
        // =+((weightX*62,86)/volX)/100              //
        //////////////////////////////////////////////

        if ($this->weight1 and $this->vol1 ) {
            
            

            $this->weightX = round($this->weight1,7);
            $this->volX = round($this->vol1,7);
            $this->titleCalculated = round(+(($this->weightX*$this->titling)/$this->volX)/100,7);
            $this->title1 = round($this->titleCalculated,7);
            $this->grade1 = round($this->vol1 / $this->weight1 * $this->title1 * 100,7);

            
            $this->gradeX = round($this->grade1,7);
            $this->titleX = round($this->title1,7);

            // // Create Title 
            // $this->createTitle();

            

        }else{

             $this->grade1 = null;
             $this->title1 = null;

             $this->weight2 = null;
             $this->vol2 = null;
             $this->title2 = null;
             $this->grade2 = null;

             $this->weight3 = null;
             $this->vol3 = null;
             $this->title3 = null;
             $this->grade3 = null;

             $this->weight4 = null;
             $this->vol4 = null;
             $this->title4 = null;
             $this->grade4 = null;

             $this->weight5 = null;
             $this->vol5 = null;
             $this->title5 = null;
             $this->grade5 = null;

             $this->weight6 = null;
             $this->vol6 = null;
             $this->title6 = null;
             $this->grade6 = null;

        }

        if ($this->weight2 and $this->vol2) {
            
            
            $this->weightX   = round(($this->weight1 + $this->weight2)/2,7);
            $this->volX     = round(($this->vol1 + $this->vol2)/2,7);
            $this->titleCalculated = round(+(($this->weightX*$this->titling)/$this->volX)/100,7);
            $this->title1 = round($this->titleCalculated,7);
            $this->title2 = round($this->titleCalculated,7);
            $this->grade2 = round($this->vol2 / $this->weight2 * $this->title2 * 100,7);

            

            
            $this->gradeX   = round(($this->grade1 + $this->grade2)/2,7);
            $this->titleX   = round(($this->title1 + $this->title2)/2,7);

            // // Create Title 
            // $this->createTitle();
            

        }else{
             
             $this->grade2 = null;
             $this->title2 = null;

             $this->weight3 = null;
             $this->vol3 = null;
             $this->title3 = null;
             $this->grade3 = null;

             $this->weight4 = null;
             $this->vol4 = null;
             $this->title4 = null;
             $this->grade4 = null;

             $this->weight5 = null;
             $this->vol5 = null;
             $this->title5 = null;
             $this->grade5 = null;

             $this->weight6 = null;
             $this->vol6 = null;
             $this->title6 = null;
             $this->grade6 = null;

        }

        if ($this->weight3 and $this->vol3) {

            $this->weightX   = round(($this->weight1 + $this->weight2 + $this->weight3)/3,7);
            $this->volX     = round(($this->vol1 + $this->vol2 + $this->vol3)/3,7);
            $this->titleCalculated = round(+(($this->weightX*$this->titling)/$this->volX)/100,7);
            $this->title1 = round($this->titleCalculated,7);
            $this->title2 = round($this->titleCalculated,7);
            $this->title3 = round($this->titleCalculated,7);
            $this->grade3 = round($this->vol3 / $this->weight3 * $this->title3 * 100,7);
            
            
            
            $this->gradeX   = round(($this->grade1 + $this->grade2 + $this->grade3)/3,7);
            $this->titleX   = round(($this->title1 + $this->title2 + $this->title3)/3,7);

            // // Create Title 
            // $this->createTitle();
           

        }else{

             $this->grade3 = null;
             $this->title3 = null;

             $this->weight4 = null;
             $this->vol4 = null;
             $this->title4 = null;
             $this->grade4 = null;

             $this->weight5 = null;
             $this->vol5 = null;
             $this->title5 = null;
             $this->grade5 = null;

             $this->weight6 = null;
             $this->vol6 = null;
             $this->title6 = null;
             $this->grade6 = null;

        }

        if ($this->weight4 and $this->vol4) {

            $this->weightX   = round(($this->weight1 + $this->weight2 + $this->weight3 + $this->weight4)/4,7);
            $this->volX     = round(($this->vol1 + $this->vol2 + $this->vol3 + $this->vol4)/4,7);
            $this->titleCalculated = round(+(($this->weightX*$this->titling)/$this->volX)/100,7);
            $this->title1 = round($this->titleCalculated,7);
            $this->title2 = round($this->titleCalculated,7);
            $this->title3 = round($this->titleCalculated,7);
            $this->title4 = round($this->titleCalculated,7);
            $this->grade4 = round($this->vol4 / $this->weight4 * $this->title4 * 100,7);
            
            
            $this->gradeX   = round(($this->grade1 + $this->grade2 + $this->grade3 + $this->grade4)/4,7);
            $this->titleX   = round(($this->title1 + $this->title2 + $this->title3 + $this->title4)/4,7);

            // // Create Title 
            // $this->createTitle();
            

        }else{

             $this->grade4 = null;
             $this->title4 = null;

             $this->weight5 = null;
             $this->vol5 = null;
             $this->title5 = null;
             $this->grade5 = null;

             $this->weight6 = null;
             $this->vol6 = null;
             $this->title6 = null;
             $this->grade6 = null;

        }

        if ($this->weight5 and $this->vol5) {

            $this->weightX   = round(($this->weight1 + $this->weight2 + $this->weight3 + $this->weight4 + $this->weight5)/5,7);
            $this->volX     = round(($this->vol1   + $this->vol2   + $this->vol3   + $this->vol4 + $this->vol5)/5,7);
            $this->titleCalculated = round(+(($this->weightX*$this->titling)/$this->volX)/100,7);
            $this->title1 = round($this->titleCalculated,7);
            $this->title2 = round($this->titleCalculated,7);
            $this->title3 = round($this->titleCalculated,7);
            $this->title4 = round($this->titleCalculated,7);
            $this->title5 = round($this->titleCalculated,7);
            $this->grade5 = round($this->vol5 / $this->weight5 * $this->title5 * 100,7);
            
            
            $this->gradeX   = round(($this->grade1 + $this->grade2 + $this->grade3 + $this->grade4 + $this->grade5)/5,7);
            $this->titleX   = round(($this->title1 + $this->title2 + $this->title3 + $this->title4 + $this->title5)/5,7);
        
            // // Create Title 
            // $this->createTitle();
            
        }else{

             $this->grade5 = null;
             $this->title5 = null;

             $this->weight6 = null;
             $this->vol6 = null;
             $this->title6 = null;
             $this->grade6 = null;

        }

        if ($this->weight6 and $this->vol6) {

            $this->weightX   = round(($this->weight1 + $this->weight2 + $this->weight3 + $this->weight4 + $this->weight5 + $this->weight6)/6,7);
            $this->volX     = round(($this->vol1   + $this->vol2   + $this->vol3   + $this->vol4   + $this->vol5   + $this->vol6)/6,7);
            $this->titleCalculated = round(+(($this->weightX*$this->titling)/$this->volX)/100,7);
            $this->title1 = round($this->titleCalculated,7);
            $this->title2 = round($this->titleCalculated,7);
            $this->title3 = round($this->titleCalculated,7);
            $this->title4 = round($this->titleCalculated,7);
            $this->title5 = round($this->titleCalculated,7);
            $this->title6 = round($this->titleCalculated,7);
            $this->grade6 = round($this->vol6 / $this->weight6 * $this->title6 * 100,7);
            
            
            $this->gradeX   = round(($this->grade1 + $this->grade2 + $this->grade3 + $this->grade4 + $this->grade5 + $this->grade6)/6,7);
            $this->titleX   = round(($this->title1 + $this->title2 + $this->title3 + $this->title4 + $this->title5 + $this->title6)/6,7);

            // // Create Title 
            // $this->createTitle();

        }else{

            
             $this->grade6 = null;
             $this->title6 = null;

        }

        // Create Title 
        $this->createTitle();

    }

    public function createTitle()
    {
        // dd($this->titleX);
        // SAVE VARS //////////////////////////////////////////////////////////////////////////////////////////// 
        Title::create([
            'volumetry_id' => $this->register->id,
            'sample_name' => $this->register->name,
            'method' => $this->register->method,
            'element' => $this->register->element,
            'co' => $this->register->co,
            'cart' => $this->codCart,
            'weight1' => $this->weight1,
            'weight2' => $this->weight2,
            'weight3' => $this->weight3,
            'weight4' => $this->weight4,
            'weight5' => $this->weight5,
            'weight6' => $this->weight6,
            'vol1' => $this->vol1,
            'vol2' => $this->vol2,
            'vol3' => $this->vol3,
            'vol4' => $this->vol4,
            'vol5' => $this->vol5,
            'vol6' => $this->vol6,
            'grade1' => $this->grade1,
            'grade2' => $this->grade2,
            'grade3' => $this->grade3,
            'grade4' => $this->grade4,
            'grade5' => $this->grade5,
            'grade6' => $this->grade6,
            'title1' => $this->title1,
            'title2' => $this->title2,
            'title3' => $this->title3,
            'title4' => $this->title4,
            'title5' => $this->title5,
            'title6' => $this->title6,
            'title' => $this->title,
            'titling' => $this->titling,
            'titleCalculated' => $this->titleCalculated,
            'weightX' => $this->weightX,
            'volX' => $this->volX,
            'gradeX' => $this->gradeX,
            'titleX' => $this->titleX,
            'update_user_id' => auth()->user()->id,

        ]);

    }

    public function showFindTitleModal()
    {
        $this->findTitleModal = true; 
        $this->titles;
        
    }

    public function getTitlesProperty()
    {
        return Title::all();
    }
    
    
}
