<?php

namespace App\Exports;

use App\Models\User;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
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

                $users = User::Where(function($query) {
                                 $query  ->orWhere('users.name', 'like', '%'.$this->search.'%')
                                         ->orWhere('users.email', 'like', '%'.$this->search.'%')   
                                         ->orWhere('users.created_at', 'like', '%'.$this->search.'%')
                                         ->orWhere('users.updated_at', 'like', '%'.$this->search.'%');                            
                                    })->orderBy('users.id', 'DESC')->get();
            }else{

                 $users = User::Where(function($query) {
                                 $query  ->orWhere('users.name', 'like', '%'.$this->search.'%')
                                         ->orWhere('users.email', 'like', '%'.$this->search.'%')   
                                         ->orWhere('users.created_at', 'like', '%'.$this->search.'%')
                                         ->orWhere('users.updated_at', 'like', '%'.$this->search.'%');                            
                                    })->orderBy('users.id', 'DESC')->onlyTrashed()->get();
                                       
            }
            
            
            return view('exports.UsersExport', [
            'users' => $users,
            ]); 
        }else{

            if ($this->active == true) {

                $users = User::orderBy('users.id', 'DESC')->get();

            }else{

                $users = User::orderBy('users.id', 'DESC')->onlyTrashed()->get();

            }    
            
            return view('exports.UsersExport', [
            'users' => $users,
            
            ]); 
        }
    }
}

