<?php

namespace App\View\Components;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\Component;

class AppLayout extends Component
{
  
    public function render()
    {
        
        return view('layouts.app');
    }
   
}
