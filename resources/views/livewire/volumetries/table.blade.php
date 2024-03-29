<div>
    <x-jet-action-message class="" on="update">
      <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
        <div class="text-sm font-base px-4 text-indigo-800 ">
        {{ __('Update comparative samples registers and sync...') }}</div>  
      </div>        
    </x-jet-action-message>
    
    @if($registers)
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                   
                    <th scope="col" class="px-6 py-3 w-max rounded-tl-lg rounded-bl-lg">
                      {{ __('Number')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Name')}}
                    </th>                    
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Weight')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Spent')}}
                    </th>                    
                    <th scope="col" class="px-6 py-2 w-max ">
                      {{ __('Title')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Grade')}}
                    </th> 
                    <th scope="col" class="px-6 py-2 text-xs w-max rounded-tr-lg rounded-br-lg">
                      {{ __('Info')}}
                    </th>  
                                       
                    
                  </tr>
                </thead>
                <tbody>
                  {{--dd($registers)--}}
                  @if($registers)
                      @foreach ($registers as $key => $register)
                      <tr class="bg-white border-b hover:bg-gray-100 even:bg-gray-50">
                        <td class="px-6 py-2 w-max">

                          {{$register->number}}
                        </td>
                        <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                          @if($register->name == "STD")
                            {{$register->name}} - {{$this->standart}} 
                          @else
                            {{$register->name}} 
                          @endif
                        </td>

                        <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                          {{round($register->weight,5)}}
                        </td>

                        <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                           
                            
                            @if($key !== $keyIdSpent)  
                                @if(in_array("volumetries.spent", $permissions)) {{--actualizar el permiso a irons.grade--}}
                                  <div class="cursor-pointer"                            
                                  wire:click.prevent="$set('keyIdSpent',{{$key}})">
                                  {{$register->spent}} <i class="fa-solid fa-pen fa-2xs pl-4"></i>
                                  </div>
                                @else
                                  <div>                            
                                  {{$register->spent}} <i class="fa-solid fa-pen fa-2xs pl-4"></i>
                                  </div>                            
                                @endif
                                

                            @elseif($editSpent === true and $key === $keyIdSpent)
                            <div class="flex justify-center w-32">
                            <input type="text" id="spent-{{$key}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->spent}}" value="{{$register->spent}}" 
                                wire:model="spentField"
                                wire:keydown.enter="updateSpent({{$register->id}})" 
                                wire:keydown.arrow-up="$set('keyIdSpent',{{$keyIdSpent - 1 }})"
                                wire:keydown.arrow-down="$set('keyIdSpent',{{$keyIdSpent + 1 }})"
                                autofocus="autofocus" wire:key="spentField-{{$key}}">

                            <a href="" class="pt-2" wire:click.prevent="closeSpent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>

                            </div>
                            @endif

                        </td>
                    
                        <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                           
                            
                            @if($key !== $keyIdTitle)  
                                @if(in_array("volumetries.title", $permissions)) 
                                  <div class="flex justify-center">
                                    <div class="cursor-pointer"                            
                                    wire:click.prevent="$set('keyIdTitle',{{$key}})">
                                    {{$register->title}} <i class="fa-solid fa-pen fa-2xs pl-4"></i> 
                                      
                                    </div>
                                    <a href="" class="pt-2 -mt-2" wire:click.prevent="downTitle({{$register->id}})">
                                     
                                      <i class="px-3 fa-solid fa-arrow-down-short-wide"></i>
                                     
                                    </a>
                                    <a href="" class="pt-2 -mt-2" wire:click.prevent="calculateTitle({{$register->id}})">
                                      
                                      <i class="fa-solid fa-calculator"></i>

                                    </a>

                                  </div>
                                @else
                                  <div>                            
                                  {{$register->title}} 
                                  </div>                            
                                @endif
                                

                            @elseif($editTitle === true and $key === $keyIdTitle)
                            <div class="flex justify-center w-40">
                            <input type="text" id="title-{{$key}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->title}}" value="{{$register->title}}" 
                                wire:model="titleField"
                                wire:keydown.enter="updateTitle({{$register->id}})" 
                                wire:keydown.arrow-up="$set('keyIdTitle',{{$keyIdTitle - 1 }})"
                                wire:keydown.arrow-down="$set('keyIdTitle',{{$keyIdTitle + 1 }})"
                                autofocus="autofocus" wire:key="titleField-{{$key}}">

                            <a href="" class="pt-2" wire:click.prevent="closeTitle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>

                                                         

                            </div>
                            @endif

                        </td>

                        <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">                     
                           {{round($register->grade,3)}}
                        </td>

                        <td scope="row" class="px-6 py-2 font-medium text-xs text text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max" style="font-size: 0.8em;">                     
                          <div class="">{{ __('Written by')}}: {{$register->writtenUser->name ?? ''}}</div>
                          <div class="">{{ __('Upload by')}}: {{$register->updatedUser->name ?? ''}}</div>

                        </td>
                    
                      </tr> 
                     
                      @endforeach
                  @endif                   
                  
                </tbody>
              </table>
    
    @endif

  <!-- Confirmacion Update Modal -->
  <x-jet-dialog-modal wire:model="calculateModal"> 
      <x-slot name="title">
          <div class="flex justify-between my-4">
            <div class="ml-8">
            {{ __('Calculate Title') }}
            </div>
            <div class="flex justify-between mr-8">
              <div class="mr-4">
                         {{__('Titling')}}                   
              </div>
              <div>
              <input type="text" name="" wire:model="titling" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus"
              wire:keydown.enter="calculate()"                      
              placeholder="{{$titling}}" value="{{$titling}}">
              </div>
            
            </div> 
          </div>
      </x-slot>

      <x-slot name="content"> 

            <div class="flex justify-around">

              <table>
                <thead>
                  <tr class="flex justify-between">
                    <th class="w-32 text-left">
                       {{__('Weigth')}}
                    </th>
                    <th class="w-32 text-left">
                       {{__('Volume')}}
                    </th>
                    <th class="w-32 text-left">
                       {{__('Title')}}
                    </th>
                    <th class="w-32 text-left">
                       {{__('Grade')}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  

                  {{-- FILA 1 --}}
                  <tr class="flex justify-between text-center">
                    <td>
                      <input type="text" name="" wire:model="weight1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input1" onkeyup="saltar(event,'input2')">
                  
                    </td>
                    <td>
                      <input type="text" name="" wire:model="vol1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input2" onkeyup="saltar(event,'input3')">
                 
                    </td>                    
                    <td>
                      <input type="text" name="" wire:model="title1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                  
                    </td> 
                    <td>
                      <input type="text" name="" wire:model="grade1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                    </td>                  
                  </tr>
                  {{-- @if ($weight1 and $vol1 and $grade1 and $title1) --}}
                  {{-- FILA 2 --}}
                  <tr class="flex justify-between">
                    <td>
                       <input type="text" name="" wire:model="weight2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input3" onkeyup="saltar(event,'input4')">
                  
                    </td>
                    <td>
                       <input type="text" name="" wire:model="vol2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input4" onkeyup="saltar(event,'input5')">
                  
                    </td>
                    
                    <td>
                       <input type="text" name="" wire:model="title2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                   
                    </td> 
                    <td>
                       <input type="text" name="" wire:model="grade2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly >
                   
                    </td>                  
                  </tr>
                  {{-- @endif
                  @if ($weight2 and $vol2 and $grade2 and $title2) --}}
                  {{-- FILA 3 --}}
                   <tr class="flex justify-between">
                    <td>
                       <input type="text" name="" wire:model="weight3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input5" onkeyup="saltar(event,'input6')">
                  
                    </td>
                    <td>
                       <input type="text" name="" wire:model="vol3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input6" onkeyup="saltar(event,'input7')">
                  
                    </td>
                    
                    <td>
                       <input type="text" name="" wire:model="title3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                   
                    </td> 
                    <td>
                       <input type="text" name="" wire:model="grade3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                  
                    </td>                  
                  </tr>
                  {{-- @endif
                  @if ($weight3 and $vol3 and $grade3 and $title3) --}}
                  {{-- FILA 4 --}}
                   <tr class="flex justify-between">
                    <td>
                       <input type="text" name="" wire:model="weight4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input7" onkeyup="saltar(event,'input8')">
                   
                    </td>
                    <td>
                       <input type="text" name="" wire:model="vol4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input8" onkeyup="saltar(event,'input9')">
                    
                    </td>
                    
                    <td>
                       <input type="text" name="" wire:model="title4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                 
                    </td>
                    <td>
                       <input type="text" name="" wire:model="grade4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                  
                    </td>                   
                  </tr>
                 {{--  @endif
                  @if ($weight4 and $vol4 and $grade4 and $title4) --}}
                  {{-- FILA 5 --}}
                   <tr class="flex justify-between">
                    <td>
                       <input type="text" name="" wire:model="weight5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input9" onkeyup="saltar(event,'input10')">
                 
                    </td>
                    <td>
                       <input type="text" name="" wire:model="vol5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input10" onkeyup="saltar(event,'input11')">
                  
                    </td>
                    
                    <td>
                       <input type="text" name="" wire:model="title5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
             
                    </td> 
                    <td>
                       <input type="text" name="" wire:model="grade5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                       
                      
                    </td>                  
                  </tr>
                  {{-- @endif
                  @if ($weight5 and $vol5 and $grade5 and $title5) --}}
                  {{-- FILA 6 --}}
                   <tr class="flex justify-between">
                    <td>
                       <input type="text" name=""  wire:model="weight6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input11" onkeyup="saltar(event,'input12')">                
                        
                    </td>
                    <td>
                       <input type="text" name="" wire:model="vol6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" id="input12" onkeyup="saltar(event,'input1')">                 
                       
                    </td>
                    
                    <td>
                       <input type="text" name="" wire:model="title6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>             
           
                    </td>
                    <td>
                       <input type="text" name="" wire:model="grade6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>                       
                       
                    </td>                   
                  </tr>
                  {{-- @endif --}}

                  {{-- FILA X --}}
                  <tr class="flex justify-between text-center mt-4">

                    <td>{{ __('Average')}}</td>
                    <td></td>
                    <td></td>
                    <td></td>

                  </tr>
                  
                    
                   <tr class="flex justify-between border-gray-300 border-solid border-t-2">
                    <td>
                       <input type="text" name="" wire:model="weightX" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                    </td>
                    <td>
                       <input type="text" name="" wire:model="volX" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                    </td>
                    
                    <td>
                       <input type="text" name="" wire:model="titleX" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                    </td>
                    <td>
                       <input type="text" name="" wire:model="gradeX" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" disabled readonly>
                    </td>                   
                  </tr>

                  
                  
                  <tr class="flex justify-between text-center mt-4">
                    <td>
                      <x-jet-button class="" wire:click="calculate()" wire:loading.attr="disabled">
                          {{ __('Calculate Title') }}
                        </x-jet-button>                      
                    </td>
                    <td>
                      
                    </td>
                    <td>
                                         
                    </td>
                    <td>
                      <input type="text" name="" wire:model="titleCalculated" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus"
                      wire:keydown.enter="calculate()"                      
                      placeholder="{{$titleCalculated}}" value="{{$titleCalculated}}" disabled readonly>
                      
                    </td>                   
                  </tr>
                  
                  
                  
                </tbody>
                <tfoot>
                  
                  
                  <tr class="flex justify-between">
                    <th>
                      
                    </th>
                  </tr>
                </tfoot>
              </table>
               
            </div>        
            
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('calculateModal')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="updateCalculate({{$idModal}})" wire:loading.attr="disabled">
              {{ __('Update Title') }}
          </x-jet-danger-button>
          
      </x-slot>
  </x-jet-dialog-modal> 

  
    
</div>