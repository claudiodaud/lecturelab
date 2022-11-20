<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
       
      <span class="text-gray-700">{{__(' Roles Index')}}</span>
    </h2>
  </x-slot>   

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                
        

          {{--Component Table--}}

          <div class="shadow-md sm:rounded-lg">
            <div class="p-4 ">
              <div class="block sm:flex sm:justify-between">
                <div class="block sm:flex justify-start ">
                  <div class="relative">
                  @if(in_array("role.filter", $permissions))
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                  @endif   
                  
                  @if(in_array("role.filter", $permissions))
                      <input type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 py-3  sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60" placeholder="Search for items" wire:model="search">
                  @endif
                </div>
                    
                @if(in_array("role.deleted", $permissions))    
                  @if($active == true)
                    <a wire:click.prevent="active(false)" type='button' class='inline-flex items-center  px-2 sm:px-2 py-3 sm:mx-2 sm:py-0 mt-2 sm:mt-0 bg-white border border-gray-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:text-red-500 hover:bg-red-50 focus:outline-none focus:border-gary-300 focus:ring focus:ring-blue-200 active:text-red-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-60'>
                        {{ __('Deleted Registers') }}
                    </a>
                  @elseif($active == false)
                    <a wire:click.prevent="active(true)" type='button' class='inline-flex items-center px-2 sm:px-2 py-3 sm:mx-2 sm:py-0 mt-2 sm:mt-0 bg-white border border-gray-300 rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest shadow-sm hover:text-green-500 hover:bg-green-50 focus:outline-none focus:border-gray-300 focus:ring focus:ring-blue-200 active:text-green-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-60'>
                        {{ __('Actives Registers') }}
                    </a>
                  @endif
                @endif 
                </div> 
              
              
                <div class="flex sm:justify-end">
                  @if(in_array("role.create", $permissions))
                    <a wire:click="$toggle('createNewRole')" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-40 py-3 sm:py-0 mt-2 sm:mt-0 sm:mx-2 mr-1'>
                        {{ __('Create New') }}
                    </a>
                  @endif
                  @if(in_array("role.download", $permissions))
                    <a wire:click="downloadRole" type='button' class='inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-40 py-3 sm:py-0 mt-2 sm:mt-0 sm:mx-2 ml-1 mr-1'>
                        {{ __('Download') }}
                    </a>
                  @endif
                    
                </div>
              </div>
            </div>
            <div class="mx-4">

              {{--Flash Messages--}}
              <x-jet-action-message class="" on="deleted">
                <div class="text-xl font-normal  max-w-full flex-initial bg-red-100 p-4 my-4 rounded-lg border border-red-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-red-800 ">{{ __('Role register successfull deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="forceDeleted">
                <div class="text-xl font-normal  max-w-full flex-initial bg-fuchsia-100 p-4 my-4 rounded-lg border border-fuchsia-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-fuchsia-900 ">{{ __('Role register successfull force deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="restore">
                <div class="text-xl font-normal  max-w-full flex-initial bg-blue-100 p-4 my-4 rounded-lg border border-blue-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-blue-900 ">{{ __('Role register successfull restored') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="created">
                <div class="text-xl font-normal  max-w-full flex-initial bg-green-100 p-4 my-4 rounded-lg border border-green-800 ">
                  <div class="text-sm font-base px-4 text-green-800 ">{{ __('Role register successfull created') }}</div>  
                </div>        
              </x-jet-action-message>  

              <x-jet-action-message class="" on="updated">
                <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
                  <div class="text-sm font-base px-4 text-indigo-800 ">{{ __('Role register successfull update') }}</div>  
                </div>        
              </x-jet-action-message> 

              {{--Table--}}
              <div class="relative overflow-x-auto">
              <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 ">
                  <tr>
                    <th scope="col" class="px-6 py-3 w-max rounded-tl-lg rounded-bl-lg">
                      {{ __('Id')}}
                    </th>
                    <th scope="col" class="px-6 py-3 w-max">
                      {{ __('Name')}}
                    </th>
                    @if(in_array("viewPermissions", $permissions))
                      <th scope="col" class="px-6 py-3 w-max">
                        {{ __('Permissions')}}
                      </th>
                    @endif                    
                    <th scope="col" class="px-6 py-3 w-max rounded-tr-lg rounded-br-lg text-right">
                      {{__('Actions')}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($roles as $role)
                    <tr class="bg-white border-b hover:bg-gray-100 even:bg-gray-50">
                    <td class="px-6 py-4 w-max">
                      #{{$role->id}}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{$role->name}}
                    </th>

                    <td class="px-6 py-4 w-30">
                        @if(in_array("viewPermissions", $permissions))                    
                          <a wire:click="addRemovePermissions({{$role->id}})" href="#{{--route('users.index.company', $contract->company->id)--}}" 
                             type='button' 
                             class='font-medium bg-gray-300 text-white rounded-md px-2 hover:bg-gray-500 px-2 py-1 w-max'>
                            {{$role->permissions->count()}} {{ __('Permissions') }}
                          </a>
                        @endif

                    </td>
                    
                    @if($active == true)
                      <td class="px-6 py-4 text-right w-120">
                        <div class="flex justify-end">
                        @if(in_array("role.show", $permissions))
                        <a href="#" class="font-medium bg-indigo-300 text-white rounded-md px-2 hover:bg-indigo-500 px-2 py-1 mx-1" 
                            wire:click="showRole({{$role->id}})" wire:loading.attr="disabled">{{__('Detail')}}</a>
                        @endif
                        @if(in_array("role.edit", $permissions))
                        <a  href="#" 
                            class="font-medium bg-blue-300 text-white rounded-md px-2 hover:bg-blue-500 px-2 py-1 mx-1" 
                            wire:click="editRole({{$role->id}})" wire:loading.attr="disabled">{{__('Edit')}}</a>
                        @endif
                        @if(in_array("role.delete", $permissions))
                        <a  href="#" 
                            class="font-medium bg-red-300 text-white rounded-md px-2 hover:bg-red-500 px-2 py-1 mx-1"
                            wire:click="confirmRoleDeletion({{$role->id}})" wire:loading.attr="disabled">{{__('Delete')}}</a>
                        @endif    
                        </div>
                      </td>
                    @else
                      <td class="px-6 py-4 text-right w-120">
                        <div class="flex justify-end">
                        @if(in_array("role.restore", $permissions))                    
                        <a  href="#" 
                            class="font-medium bg-blue-300 text-white rounded-md px-2 hover:bg-blue-500 px-2 py-1 mx-1" 
                            wire:click="confirmRestoreRole({{$role->id}})" wire:loading.attr="disabled">{{__('Restore')}}</a>
                        @endif
                        @if(in_array("role.forceDelete", $permissions))
                        <a  href="#" 
                            class="font-medium bg-red-300 text-white rounded-md px-2 hover:bg-red-500 px-2 py-1 mx-1"
                            wire:click="confirmForceRoleDeletion({{$role->id}})" wire:loading.attr="disabled">{{__('Force Delete')}}
                        </a>
                        @endif
                        </div>
                      </td>
                    @endif
                  </tr>
                  @empty
                    {{-- empty expr --}}
                  @endforelse
                  
                </tbody>
              </table>
              </div>
            </div>
            {{--Pagination--}}
            <div class="p-4">
            {{$roles->links()}}
            </div>
          </div>

          {{--End Component Table--}}
        
      </div>
    </div>
  </div>


 

<!-- Delete Role Modal -->
<x-jet-dialog-modal wire:model="deleteRole">
    <x-slot name="title">
        {{ __('Delete Role') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to delete this role? Once your role account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your role account.') }}

        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Write your password here') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="deleteRole" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('deleteRole')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="deleteRole" wire:loading.attr="disabled">
            {{ __('Delete Role Account') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>

<!-- Force Delete Role Modal -->
<x-jet-dialog-modal wire:model="forceDeleteRole">
    <x-slot name="title">
        {{ __('Force Delete Role') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to force delete this role? Once your role account is force deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your role account.') }}

        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Write your password here') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="forceDeleteRole" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('forceDeleteRole')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="forceDeleteRole" wire:loading.attr="disabled">
            {{ __('Delete Role Account') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>

<!-- restore Role Modal -->
<x-jet-dialog-modal wire:model="restoreRole">
    <x-slot name="title">
        {{ __('Restore Role') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to restore this role? Once your role account is restore, all of its resources and data will be permanently restore. Please enter your password to confirm you would like to permanently restore your role account.') }}

        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Write your password here') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="restoreRole" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('restoreRole')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="restoreRole" wire:loading.attr="disabled">
            {{ __('Restore Role Account') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>


<!-- Create New Role Modal -->
  <x-jet-dialog-modal wire:model="createNewRole"> 
      <x-slot name="title">
          {{ __('Create New Role') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  required autofocus wire:model="name"/>
            <x-jet-input-error for="name" class="mt-2" />
        </div>        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('createNewRole')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="saveRole" wire:loading.attr="disabled">
              {{ __('Create Role Account') }}
          </x-jet-danger-button>
      </x-slot>
  </x-jet-dialog-modal>


  <!-- Edit Role Modal -->
  <x-jet-dialog-modal wire:model="editRole"> 
      <x-slot name="title">
          {{ __('Update Role Account Data') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  value="" required autofocus wire:model="name"/>
            <x-jet-input-error for="name" class="mt-2" />
        </div>        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('editRole')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>
          @if(in_array("role.edit", $permissions))
          <x-jet-danger-button class="ml-3" wire:click="updateRole" wire:loading.attr="disabled">
              {{ __('Update Role Account Data') }}
          </x-jet-danger-button>
          @endif
      </x-slot>
  </x-jet-dialog-modal>


  <!-- Show Role Modal -->
  @if($roleShow)
  <x-jet-dialog-modal wire:model="showRole"> 
      <x-slot name="title">
          {{ __('Show Role Account Data') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4">
            
              <!-- Start: Invoice -->
                <div class="w-full">  
                  <div class="flex justify-between">
                    <div class="text-xs text-gray-400">{{__('Register')}} #{{$roleShow->id}}</div>
                    <div class="text-xs text-gray-400">{{__('Created at')}}: {{$roleShow->created_at}}</div>

                  </div>            
                  
                  <hr>
                  <div class="w-full flex justify-between mt-10">                   
                    <div class="text-sm text-gray-400">{{__('Name')}}:</div>                          
                    <div class="text-sm text-gray-600">{{$roleShow->name}}</div>                            
                  </div> 
                  
                </div>              
              <!-- END: Invoice -->
            
        </div>        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="closeShowRole()" wire:loading.attr="disabled">
              {{ __('Return') }}
          </x-jet-secondary-button>
          
          
               
      </x-slot>
  </x-jet-dialog-modal>   
  @endif

   <!-- Add / Remove Contract Modal -->
  <x-jet-dialog-modal wire:model="addRemovePermissions" maxWidth="xl"> 
      <x-slot name="title">
          {{ __('Add or remove permissions to ') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4">
            @if($permissionsAddByRole)
              <!-- Start: Invoice -->
                <div class="w-full">  
                            
                   @foreach($permissionsAddByRole->permissions as $permission)
                      
                        <hr>
                        <div class="w-full flex justify-between mt-4">                   
                          <div class="text-sm text-gray-400">
                            <span class="uppercase"><strong>{{$permission->name}}</strong></span></div>                          
                          <div class="text-sm text-gray-600 uppercase">
                            @if(in_array("role.removePermissions", $permissions))
                            <x-jet-danger-button class="mb-4" 
                            wire:click="removePermissionToRole({{$permission->id}},{{$permissionsAddByRole->id}})" 
                            wire:loading.attr="disabled">
                                {{ __('Remove') }}
                            </x-jet-danger-button>
                            @endif
                          </div>                            
                        </div> 
                      
                    @endforeach 
                  
                  
                    @foreach($permissionsForAddByRole as $permission)
                      
                        <hr>
                        <div class="w-full flex justify-between mt-4">                   
                          <div class="text-sm text-gray-400">
                            <span class="uppercase"><strong>{{$permission->name}}</strong></span></div>                          
                          <div class="text-sm text-gray-600 uppercase"> 
                            @if(in_array("role.addPermissions", $permissions))
                            <x-jet-secondary-button class="mb-4" 
                            wire:click="addPermissionToRole({{$permission->id}},{{$permissionsAddByRole->id}})"
                            wire:loading.attr="disabled">
                                {{ __('Add') }}
                            </x-jet-secondary-button>
                            @endif 
                          </div>                            
                        </div> 
                      
                    @endforeach
                                  
                </div>              
              <!-- END: Invoice -->
            @endif
            
        </div>        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="closeAddRemovePermission()" wire:loading.attr="disabled">
              {{ __('Return') }}
          </x-jet-secondary-button>      
      </x-slot>
  </x-jet-dialog-modal>   
</div>