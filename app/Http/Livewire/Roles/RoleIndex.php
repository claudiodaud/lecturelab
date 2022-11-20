<?php

namespace App\Http\Livewire\Roles;


use App\Exports\RolesExport;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\withMessages;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use Spatie\Permission\Exceptions\UnauthorizedException;



class RoleIndex extends Component
{
    use WithPagination;


    public $deleteRole = false;
    public $forceDeleteRole = false;
    public $restoreRole = false;
    public $roleId; 
    public $password;
    


    public $createNewRole = false; 
    

    public $roleEdit;
    public $roleShow;

    
    public $editRole = false;
    public $showRole = false;

    public $search; 

    public $name;

    public $active = true;

    

    //Add and Remove Users
    public $addRemovePermissions;
    public $permissionsAddByRole;
    public $permissionsForAddByRole;
    public $permissions;  


    protected $rules = [
        'name' => 'required|string|max:70|min:1|unique:roles,name',        
    ];

    public function mount()
    {
        
        $this->getPermissions();
    }

    public function render()
    {
        

        if ($this->active == true) {

            $roles = Role::Where(function($query) {
                            $query  ->orWhere('roles.name', 'like', '%'.$this->search.'%')
                                    ->orWhere('roles.created_at', 'like', '%'.$this->search.'%')
                                    ->orWhere('roles.updated_at', 'like', '%'.$this->search.'%');                            
                            })->orderBy('roles.id', 'DESC')->paginate(10);
        }else{

            $roles = Role::Where(function($query) {
                            $query  ->orWhere('roles.name', 'like', '%'.$this->search.'%')
                                    ->orWhere('roles.created_at', 'like', '%'.$this->search.'%')
                                    ->orWhere('roles.updated_at', 'like', '%'.$this->search.'%');                            
                            })->orderBy('roles.id', 'DESC')->onlyTrashed()->paginate(10);
                                   
        }            

        

        if(in_array("viewRoles", $this->permissions)){
            
            return view('livewire.roles.role-index', [

                'roles' => $roles,

            ]);

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

        //dd($this->permissions);
    }

    public function updatingSearch()
    {
        $this->resetPage();        
    }

    public function confirmRoleDeletion($roleId)
    {
        $this->roleId = $roleId; 
        $this->deleteRole = true;
    }

    public function confirmForceRoleDeletion($roleId)
    {
        $this->roleId = $roleId; 
        $this->forceDeleteRole = true;
    }

    public function confirmRestoreRole($roleId)
    {
        $this->roleId = $roleId; 
        $this->restoreRole = true;
    }

    public function deleteRole()
    {

        if (! Hash::check($this->password, Auth::user()->password)) {

            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);

        }else{    

            Role::destroy($this->roleId);
            $this->deleteRole = false;
            $this->password = null;
            $this->roleId = null;
            $this->emit("deleted");

        }       
    }

    public function forceDeleteRole()
    {

        if (! Hash::check($this->password, Auth::user()->password)) {

            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);

        }else{    

            $role = Role::withTrashed()->find($this->roleId);
            $role->forceDelete();
            $this->forceDeleteRole = false;
            $this->password = null;
            $this->roleId = null;
            $this->emit("forceDeleted");

        }       
    }

    public function restoreRole()
    {

        if (! Hash::check($this->password, Auth::user()->password)) {

            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);

        }else{    

            $role = Role::withTrashed()->find($this->roleId);
            $role->restore();
            $this->restoreRole = false;
            $this->password = null;
            $this->roleId = null;
            $this->emit("restore");

        }       
    }

 
    public function saveRole()
    {
        $this->validate();
 
        $role = Role::create([
            'name' => $this->name,
            'guard_name' => $this->name,
        ]);

        

        $this->name = "";
        $this->createNewRole = false; 
        $this->active = true;
        $this->resetPage();
        $this->emit('created');
    }

    public function updatedCreateNewRole()
    {
        if ($this->createNewRole == false) {
            $this->name = "";
        }
    }

    public function editRole($id)
    {
        
        $role = Role::find($id);   
        
        $this->role = $role;
        
        $this->name = $role->name;

        $this->active = true;

        $this->editRole = true; 
    }

    public function updateRole()
    {
        $this->validate();             

        Role::find($this->role->id)->update([
            'name' => $this->name,
            'guard_name' => $this->name,
        ]);
                
        $this->name = null;     
        $this->role = null;
        $this->editRole = false; 
        $this->active = true;
        $this->emit('updated');
    }

    public function downloadRole()
    {        
        return (new RolesExport(['search' => $this->search], ['active' => $this->active]))->download('roles.xlsx'); 
    }

    public function showRole($id)
    {
        $this->roleShow = Role::where('id',$id)->first();
        $this->showRole = true;
        $this->active = true;
    }

    public function closeShowRole()
    {
        $this->showRole = false;

        $this->roleShow = null;        
    }

    public function addRemovePermissions($role_id)
    {
           
        $this->permissionsAddByRole = Role::find($role_id);
       
        $permissionsAddIds = [];
        foreach ($this->permissionsAddByRole->permissions as $key => $permission) {
            array_push($permissionsAddIds,$permission->id);
        }
        

        $this->permissionsForAddByRole = Permission::all();
        $permissionsForAddIds = [];
        foreach ($this->permissionsForAddByRole as $key => $permission) {
            array_push($permissionsForAddIds,$permission->id);
        }
        
        
        foreach($permissionsAddIds as $permission){
            $remove = array_search($permission, $permissionsForAddIds);
            unset($permissionsForAddIds[$remove]);
        }

       
    
        $this->permissionsForAddByRole = Permission::whereIn('id', $permissionsForAddIds)->get();

        
        $this->addRemovePermissions = true;
    }

    public function closeAddRemovePermission()
    {
        $this->addRemovePermissions = false;           
    }

    public function addPermissionToRole($permission_id,$role_id)
    {
        
        $role = Role::find($role_id);
        
        $role->permissions()->attach($permission_id);
        
        $this->addRemovePermissions($role_id);

    }

    public function removePermissionToRole($permission_id,$role_id)
    {
        $role = Role::find($role_id);
        
        $role->permissions()->detach($permission_id);
        
        $this->addRemovePermissions($role_id);

    }

    public function active($active)
    {
        
        $this->active = $active;
    }
}