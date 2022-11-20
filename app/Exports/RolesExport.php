<?php

namespace App\Exports;


use App\Models\Company;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RolesExport implements FromView
{
    use Exportable;

    protected $search;
    
    protected $active;

    public function __construct($search,$active)
    {

        $this->search = $search['search'];
        
        $this->active = $active['active'];

    }
    public function view(): View
    {
        
        if ($this->search != null) {
           
            
            if ($this->active == true) {

                $roles = Role::Where(function($query) {
                                 $query  ->orWhere('roles.name', 'like', '%'.$this->search.'%')
                                         ->orWhere('roles.created_at', 'like', '%'.$this->search.'%')
                                         ->orWhere('roles.updated_at', 'like', '%'.$this->search.'%');                            
                                    })->orderBy('roles.id', 'DESC')->get();
            }else{

                 $roles = Role::Where(function($query) {
                                 $query  ->orWhere('roles.name', 'like', '%'.$this->search.'%')                                         
                                         ->orWhere('roles.created_at', 'like', '%'.$this->search.'%')
                                         ->orWhere('roles.updated_at', 'like', '%'.$this->search.'%');                            
                                    })->orderBy('roles.id', 'DESC')->onlyTrashed()->get();
                                       
            }
            
            
            return view('exports.RoleExport', [
            'roles' => $roles,
            ]); 

        }else{

             if ($this->active == true) {

                $roles = Role::orderBy('roles.id', 'DESC')->get();

            }else{

                $roles = Role::orderBy('roles.id', 'DESC')->onlyTrashed()->get();

            }    
            
            return view('exports.RoleExport', [
            'roles' => $roles,
            ]);
        }
    }
}
