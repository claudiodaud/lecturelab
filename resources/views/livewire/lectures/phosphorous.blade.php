<div>
      <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Phosphorous Module') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                
        


          {{--Component Table--}}

          <div class=" shadow-md sm:rounded-lg">
            <div class="p-4 ">
              <div class="block sm:flex sm:justify-between">
                <div class="block sm:flex justify-start ">
                  <div class="relative">
                  {{-- @if(in_array("company.filter", $permissions)) --}}
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                  {{-- @endif    --}}
                  
                  {{--@if(in_array("company.filter", $permissions))  --}}
                      <input type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 py-4  sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60" placeholder="{{__('Search Your Control')}}" wire:model="co" wire:keydown.enter="getCo">
                  {{-- @endif --}}
                </div>
                    
                {{--@if(in_array("company.deleted", $permissions))--}}    
                 
                    {{-- <a wire:click.prevent="active(false)" type='button' class='inline-flex items-center  px-2 sm:px-2 py-3 sm:mx-2 sm:py-0 mt-2 sm:mt-0 bg-white border border-gray-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:text-red-500 hover:bg-red-50 focus:outline-none focus:border-gary-300 focus:ring focus:ring-blue-200 active:text-red-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-40'>
                        {{ __('Deleted Registers') }}
                    </a> --}}
                    @if($methodsRegisters and $control)
                   
                    <select wire:model="methode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-4 py-3  sm:mx-0 mt-2 sm:mt-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60">
                            <option value="null" selected>{{__('Select your method')}}</option>
                        
                        @foreach ($methodsRegisters as $methodr)
                            
                            <option value="{{$methodr->GEO}}">{{$methodr->GEO}}</option>
                            
                        @endforeach            
                    </select> 
                    
                    @endif 
                    {{-- <a wire:click="getCo" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-60 py-3 sm:py-0 mt-2 sm:mt-0 sm:mx-2 mr-1'>
                        {{ __('Find CO') }}
                    </a>   
                     --}}
                  
                {{-- @endif  --}}
                </div> 
              
              
                <div class="flex sm:justify-end">
                  {{-- @if(in_array("company.create", $permissions))  --}}
                   {{--  <a wire:click="$toggle('createNewCompany')" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-60 py-3 sm:py-0 mt-2 sm:mt-0 sm:mx-2 mr-1'>
                        {{ __('Create New') }}
                    </a> --}}
                  {{-- @endif --}}
                  {{--@if(in_array("company.download", $permissions))  --}}
                     <a wire:click="downloadCompanies" type='button' class='inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full sm:w-60 py-3 sm:py-0 mt-2 sm:mt-0 sm:ml-2 ml-1 mr-4'>
                        {{ __('Download') }}
                    </a> 
                    {{--@endif--}}
                    <a wire:click.prevent="info" class="focus:ring-blue-500 focus:border-blue-500 block ml-2 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer mt-2">  
                        
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    </a>
                </div>

                </div>

                <div class="pt-4">
                @if ($control)
                    <div class="block sm:flex sm:justify-between ">
                        <div>
                            <p>{{-- dd($control[0]) --}}</p>
                            <div class="h4 text-sm text-gray-500 py-2">{{ __('CO')}} : <strong>{{$control[0]->CODIGO}} </strong> 
                                
                            </div>
                            <div class="h4 text-sm text-gray-500 py-2">{{ __('Customer')}} : <strong>{{$control[0]->CLIENTE}} </strong></div>
                            @if ($samples)
                                <div class="h4 text-sm text-gray-500 py-2">{{ __('Quantity')}} :<strong> {{count($samples)
                                }} </strong></div>
                            @endif
                            
                        </div>
                        <div>
                            @if ($samples)
                                <livewire:lectures.parameters />
                            @endif
                            
                            
                        </div>
                    </div>
                @endif
                </div> 
            </div>
            <div class="mx-4">

              {{--Flash Messages--}}
              <x-jet-action-message class="" on="deleted">
                <div class="text-xl font-normal  max-w-full flex-initial bg-red-100 p-4 my-4 rounded-lg border border-red-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-red-800 ">{{ __('Company register successfull deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="forceDeleted">
                <div class="text-xl font-normal  max-w-full flex-initial bg-fuchsia-100 p-4 my-4 rounded-lg border border-fuchsia-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-fuchsia-900 ">{{ __('Company register successfull force deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="restore">
                <div class="text-xl font-normal  max-w-full flex-initial bg-blue-100 p-4 my-4 rounded-lg border border-blue-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-blue-900 ">{{ __('Company register successfull restored') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="created">
                <div class="text-xl font-normal  max-w-full flex-initial bg-green-100 p-4 my-4 rounded-lg border border-green-800 ">
                  <div class="text-sm font-base px-4 text-green-800 ">{{ __('Company register successfull created') }}</div>  
                </div>        
              </x-jet-action-message>  

              <x-jet-action-message class="" on="updated">
                <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
                  <div class="text-sm font-base px-4 text-indigo-800 ">{{ __('Company register successfull update') }}</div>  
                </div>        
              </x-jet-action-message> 

              {{--Table--}}

              @if($samples != null   and $control and $samples)
              {{--count($registers)--}}
              <div class="relative overflow-x-auto">
                
                <livewire:lectures.table />
              {{-- <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 ">
                  <tr>
                    <th scope="col" class="px-6 py-3 w-max rounded-tl-lg rounded-bl-lg">
                      {{ __('Number')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Name')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Absorbance')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Weigth')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Aliquot')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Colorimetric Factor')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Dilution Factor')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Phosphorous %')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max rounded-tr-lg rounded-br-lg text-right">
                      {{__('Actions')}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {{--dd($registers)--}}  
                  {{-- @forelse ($registers as $key => $register)
                    <tr class="bg-white border-b hover:bg-gray-100 even:bg-gray-50">
                    <td class="px-6 py-2 w-max">

                      {{$register->number}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{$register->name}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                       
                        
                        @if($key !== $keyIdAbsorbance)  
                            <div class="cursor-pointer" wire:click.prevent="$set('keyIdAbsorbance',{{$key}})">{{$register->absorbance}}</div>  

                        @elseif($editAbsorbance === true and $key === $keyIdAbsorbance)
                            <div class="flex justify-center">
                            <input type="text" id="absorbance-{{$key}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->absorbance}}" value="{{$register->absorbance}}" wire:model="absorbanceField"
                            wire:keydown.enter="updateAbsorbance({{$register->id}})" autofocus="autofocus" wire:key="absorbance-{{$key}}">

                            <a href="" class="pt-2" wire:click.prevent="closeAbsorbance">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </a>
                            </div>

                        @else

                        @endif
                        

                        
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{round($register->weight,5)}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      
                      
                        @if($key !== $keyIdAliquot)  
                            <div class="cursor-pointer" wire:click.prevent="$set('keyIdAliquot',{{$key}})">{{$register->aliquot}}</div>  

                        @elseif($editAliquot === true and $key === $keyIdAliquot)
                            <div class="flex justify-center">
                            <input type="text" id="aliquot-{{$key}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->aliquot}}" value="{{$register->aliquot}}" wire:model="aliquotField"
                            wire:keydown.enter="updateAliquot({{$register->id}})" autofocus="autofocus" wire:key="aliquot-{{$key}}">
                            <a href="" class="pt-2" wire:click.prevent="closeAliquot">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </a>
                            </div>

                        @else                        

                        @endif
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                        @if($key !== $keyIdColorimetric)  
                            <div class="cursor-pointer" wire:click.prevent="$set('keyIdColorimetric',{{$key}})">{{$register->colorimetric_factor}}</div>  

                        @elseif($editColorimetric === true and $key === $keyIdColorimetric)
                            <div class="flex justify-center">
                            <input type="text" id="colorimetric-{{$key}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus" placeholder="{{$register->colorimetric_factor}}" value="{{$register->colorimetric_factor}}" wire:model="colorimetricField"
                            wire:keydown.enter="updateColorimetric({{$register->id}})" wire:key="colorimetric-{{$key}}" autofocus="autofocus">
                            
                            <a href="" class="pt-2" wire:click.prevent="closeColorimetric">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </a>
                            </div>

                        @else                        

                        @endif
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">                     
                       {{$register->dilution_factor}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{round($register->phosphorous,3)}}
                    </td>
                    <td>
                        <div class="flex justify-center">
                                                
                        <a wire:click.prevent="info" class="focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer">  
                        
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        </div>

                    </td>

                   
                    
                    {{-- @if($active == true)
                      <td class="px-6 py-4 text-right w-120">
                        <div class="flex justify-end">
                        @if(in_array("company.show", $permissions))
                          <a href="#" class="font-medium bg-indigo-300 text-white rounded-md px-2 hover:bg-indigo-500 px-2 py-1 mx-1" 
                              wire:click="showCompany({{$company->id}})" wire:loading.attr="disabled">{{__('Detail')}}</a>
                        @endif
                        @if(in_array("company.edit", $permissions))
                          <a  href="#" 
                              class="font-medium bg-blue-300 text-white rounded-md px-2 hover:bg-blue-500 px-2 py-1 mx-1" 
                              wire:click="editCompany({{$company->id}})" wire:loading.attr="disabled">{{__('Edit')}}</a>
                        @endif
                        @if(in_array("company.delete", $permissions))
                        <a  href="#" 
                            class="font-medium bg-red-300 text-white rounded-md px-2 hover:bg-red-500 px-2 py-1 mx-1"
                            wire:click="confirmCompanyDeletion({{$company->id}})" wire:loading.attr="disabled">{{__('Delete')}}</a>
                        @endif 
                        </div> -
                      </td>
                    @else
                      <td class="px-6 py-4 text-right w-120">
                        <div class="flex justify-end">
                        @if(in_array("company.restore", $permissions))                    
                          <a  href="#" 
                              class="font-medium bg-blue-300 text-white rounded-md px-2 hover:bg-blue-500 px-2 py-1 mx-1" 
                              wire:click="confirmRestoreCompany({{$company->id}})" wire:loading.attr="disabled">{{__('Restore')}}</a>
                        @endif
                        @if(in_array("company.forceDelete", $permissions))
                          <a  href="#" 
                              class="font-medium bg-red-300 text-white rounded-md px-2 hover:bg-red-500 px-2 py-1 mx-1"
                              wire:click="confirmForceCompanyDeletion({{$company->id}})" wire:loading.attr="disabled">{{__('Force Delete')}}
                          </a>
                        @endif 
                        </div> 
                      </td>
                    @endif --}}
                 {{--  </tr> 
                  @empty --}}
                    {{-- empty expr --}}
                 {{--  @endforelse
                  
                  
                </tbody>
              </table> --}} 
              </div>
              @endif
            </div>
            {{--Pagination--}}
            <div class="p-4">
            {{--$companies->links()--}}
            </div>
          </div>

          {{--End Component Table--}}
        
      </div>
    </div>
  </div>


 

{{-- <!-- Delete Company Modal -->
<x-jet-dialog-modal wire:model="deleteCompany">
    <x-slot name="title">
        {{ __('Delete Company') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to delete this company? Once your company account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your company account.') }}

        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Write your password here') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="deleteCompany" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('deleteCompany')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="deleteCompany" wire:loading.attr="disabled">
            {{ __('Delete Company Account') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>

<!-- Force Delete Company Modal -->
<x-jet-dialog-modal wire:model="forceDeleteCompany">
    <x-slot name="title">
        {{ __('Force Delete Company') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to force delete this company? Once your company account is force deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your company account.') }}

        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Write your password here') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="forceDeleteCompany" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('forceDeleteCompany')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="forceDeleteCompany" wire:loading.attr="disabled">
            {{ __('Delete Company Account') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>

<!-- restore Company Modal -->
<x-jet-dialog-modal wire:model="restoreCompany">
    <x-slot name="title">
        {{ __('Restore Company') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you want to restore this company? Once your company account is restore, all of its resources and data will be permanently restore. Please enter your password to confirm you would like to permanently restore your company account.') }}

        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Write your password here') }}"
                        x-ref="password"
                        wire:model.defer="password"
                        wire:keydown.enter="restoreCompany" />

            <x-jet-input-error for="password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('restoreCompany')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="restoreCompany" wire:loading.attr="disabled">
            {{ __('Restore Company Account') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-dialog-modal>


<!-- Create New Company Modal -->
  <x-jet-dialog-modal wire:model="createNewCompany"> 
      <x-slot name="title">
          {{ __('Create New Company') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Social name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  required autofocus wire:model="social_name"/>
            <x-jet-input-error for="social_name" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Fantasy name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="fantasy_name"/>
            <x-jet-input-error for="fantasy_name" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Email') }}" />
            <x-jet-input  class="block mt-1 w-full" type="email"  autofocus wire:model="email"/>
            <x-jet-input-error for="email" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Phone') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="phone"/>
            <x-jet-input-error for="phone" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Web site') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="web"/>
            <x-jet-input-error for="web" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Adress') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="adress"/>
            <x-jet-input-error for="adress" class="mt-2" />
        </div> 
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Dni') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="dni"/>
            <x-jet-input-error for="dni" class="mt-2" />
        </div> 
        <div class="col-span-6 sm:col-span-4 py-2">
            
            

            @if ($logo != null)
                {{ __('Photo Preview:') }}
                <img width="100px" src="{{ $logo->temporaryUrl() }}">
            @endif
            <x-jet-label for="name" value="{{ __('Logo') }}" />
            <x-jet-input  class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="file"  autofocus wire:model="logo"/>
            <x-jet-input-error for="logo" class="mt-2" />
        </div>  
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Headline name') }}" />
            <x-jet-input  class="block mt-1 w-full " type="text"  autofocus wire:model="headline_name"/>
            <x-jet-input-error for="headline_name" class="mt-2" />
        </div>      
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Bank name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="bank_name"/>
            <x-jet-input-error for="bank_name" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Type account') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="type_account"/>
            <x-jet-input-error for="type_account" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Account number') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="account_number"/>
            <x-jet-input-error for="account_number" class="mt-2" />
        </div> 
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Notification email') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  autofocus wire:model="notification_email"/>
            <x-jet-input-error for="notification_email" class="mt-2" />
        </div>   
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Detail') }}" />
            
            <textarea class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text" rows="4" autofocus wire:model="detail"></textarea>
            <x-jet-input-error for="detail" class="mt-2" />
        </div>        

         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('createNewCompany')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="saveCompany" wire:loading.attr="disabled">
              {{ __('Create Company Account') }}
          </x-jet-danger-button>
      </x-slot>
  </x-jet-dialog-modal> --}}


  <!-- Edit Company Modal -->
  <x-jet-dialog-modal wire:model="info"> 
      <x-slot name="title">
          {{ __('Update Company Account Data') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Social name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  required autofocus wire:model="social_name"/>
            <x-jet-input-error for="social_name" class="mt-2" />
        </div>   
        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('editCompany')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="updateCompany" wire:loading.attr="disabled">
              {{ __('Update Company Account Data') }}
          </x-jet-danger-button>
      </x-slot>
  </x-jet-dialog-modal> 


 {{--  <!-- Show Company Modal -->
  @if($companyShow)
  <x-jet-dialog-modal wire:model="showCompany"> 
      <x-slot name="title">
          {{ __('Show Company Account Data') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4">
            
              <!-- Start: Invoice -->
                <div class="w-full">  
                  <div class="flex justify-between">
                    <div class="text-xs text-gray-400">{{__('Register')}} #{{$companyShow->id}}</div>
                    <div class="text-xs text-gray-400">{{__('Created at')}}: {{$companyShow->created_at}}</div>

                  </div>            
                  
                  <hr>
                  <div class="w-full flex justify-between mt-10">                   
                    <div class="text-sm text-gray-400">{{__('Name')}}:</div>                          
                    <div class="text-sm text-gray-600">{{$companyShow->social_name}}</div>                            
                  </div> 
                  @if(count($companyShow->users) > 0 )
                  <hr>                    
                  <div>
                    <div class="mt-6">{{__('Associated users')}}</div>
                    <div>
                      @foreach ($companyShow->users as $user)
                        <div class="w-full flex justify-between mt-4">                   
                          <div class="text-xs text-gray-600">{{__('Name')}}: {{$user->social_name}}<br>
                            <div class="text-xs text-gray-400">{{__('Email')}}: {{$user->email}}</div>  
                          </div>                          
                                                    
                        </div>   
                      @endforeach
                    </div>
                  </div>
                  @endif
                </div>              
              <!-- END: Invoice -->
            
        </div>        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="closeShowCompany()" wire:loading.attr="disabled">
              {{ __('Return') }}
          </x-jet-secondary-button>
          
          
               
      </x-slot>
  </x-jet-dialog-modal>   
  @endif --}}
  
    
<script>
    window.addEventListener('focus-aliquot', event => {
        
        document.getElementById('aliquot-'+ event.detail.key).focus();
    })

    window.addEventListener('focus-colorimetric', event => {
        
        document.getElementById('colorimetric-'+ event.detail.key).focus();
    })

    window.addEventListener('focus-absorbance', event => {
        
        document.getElementById('absorbance-'+ event.detail.key).focus();
    })
</script>
    

   

</div>


