<div>

    <x-jet-action-message class="" on="update">
      <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
        <div class="text-sm font-base px-4 text-indigo-800 ">
        {{ __('Update samples registers and GEO-644 sync...') }}</div>  
      </div>        
    </x-jet-action-message> 

    <x-jet-action-message class="pb-6" on="samples">
      <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
        <div class="text-sm font-base px-4 text-indigo-800 ">
        {{ __('Loading samples registers ...') }}</div>  
      </div>        
    </x-jet-action-message> 

    @if($registers)
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="px-6 py-3 w-max rounded-tl-lg rounded-bl-lg text-center">
                      {{ __('Number')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max text-center">
                      {{ __('Name')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max text-center">
                      {{ __('Satmagan')}} <br>
                      {{ __('reading')}}                      
                    </th>
                    <th scope="col" class="px-6 py-2 w-max text-center">
                      {{ __('Geo-615')}}
                      {{ __('Fe3O4')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max text-center">
                      {{ __('geo-618')}}<br>
                      {{ __('FeMag')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max sm:w-48 text-center">
                    
                        @if(in_array("phosphorous.upload", $permissions))
                            <a wire:click.prevent="getGeo644()" type='button' class='block items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full py-3 sm:py-2 sm:mt-0 sm:ml-2 ml-1'>
                                {{__('Sync GEO-644')}}
                                
                                {{-- <div class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                </div> --}}
                            </a> 
                            
                        @endif
                    
                    </th>
                    <th scope="col" class="px-6 py-2 w-max rounded-tr-lg rounded-br-lg text-center">
                      {{ __('Comparative')}} <br>
                      {{ __('Geo-644 > Geo-618')}}
                    </th>
                    
                    
                  </tr>
                </thead>
                <tbody>
                  
                  @forelse ($registers as $key => $register)
                    <tr class="bg-white border-b hover:bg-gray-100 even:bg-gray-50">
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">

                      {{$register->number}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">
                      @if($register->name == "STD")
                        {{$register->name}} - <h6 class="text-xs capitalize">{{$this->standart}}</h6>
                      @else
                        {{$register->name}}
                        @if($register->chq == "N")
                        @else
                          {{__('Chq')}}
                        @endif
                      @endif
                    </td>
                    
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">

                        @if($key !== $keyIdIronGrade)  
                            @if(in_array("irons.find", $permissions)) {{--actualizar el permiso a irons.grade--}}
                              <div class="cursor-pointer"                            
                              wire:click.prevent="$set('keyIdIronGrade',{{$key}})">
                              {{$register->iron_grade}}
                              </div>
                            @else
                              <div>                            
                              {{$register->iron_grade}}
                              </div>                            
                            @endif
                            

                        @elseif($editIronGrade === true and $key === $keyIdIronGrade)
                        <input type="text" id="iron-{{$key}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->iron_grade}}" value="{{$register->iron_grade}}" 
                            wire:model="ironGradeField"
                            wire:keydown.enter="updateIronGrade({{$register->id}})" 
                            wire:keydown.arrow-up="$set('keyIdIronGrade',{{$keyIdIronGrade - 1 }})"
                            wire:keydown.arrow-down="$set('keyIdIronGrade',{{$keyIdIronGrade + 1 }})"
                            autofocus="autofocus" wire:key="ironGradeField-{{$key}}">
                        @endif

                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">

                      {{$register->geo615}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">

                      {{$register->geo618}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">

                      {{$register->geo644}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max text-center">
                      @if($register->geo644 >= $register->geo618)
                          <i class="fa-solid fa-square-check text-green-500"></i>
                      @else
                          <i class="fa-solid fa-square-xmark text-red-500"></i>
                      @endif
                      
                    </td>
                    {{-- <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                       
                        
                        @if($key !== $keyIdAbsorbance)  
                            @if(in_array("phosphorous.absorbance", $permissions))
                              <div class="cursor-pointer"                            
                              wire:click.prevent="$set('keyIdAbsorbance',{{$key}})">
                              {{$register->absorbance}}
                              </div>
                            @else
                              <div>                            
                              {{$register->absorbance}}
                              </div>                            
                            @endif
                            

                        @elseif($editAbsorbance === true and $key === $keyIdAbsorbance)
                            <div class="flex justify-center">
                            <input type="text" id="absorbance-{{$key}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->absorbance}}" value="{{$register->absorbance}}" 
                            wire:model="absorbanceField"
                            wire:keydown.enter="updateAbsorbance({{$register->id}})" 
                            wire:keydown.arrow-up="$set('keyIdAbsorbance',{{$keyIdAbsorbance - 1 }})"
                            wire:keydown.arrow-down="$set('keyIdAbsorbance',{{$keyIdAbsorbance + 1 }})"
                            wire:keydown.arrow-left="moveToColorimetric({{$keyIdAbsorbance}})"
                            wire:keydown.arrow-right="moveToAliquot({{$keyIdAbsorbance}})"
                            autofocus="autofocus" wire:key="absorbance-{{$key}}">

                            <a href="" class="pt-2" wire:click.prevent="closeAbsorbance">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </a>
                            </div>

                        @else

                        @endif
                        

                        
                    </td> --}}
                    {{-- <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{round($register->weight,5)}}
                    </td> --}}
                    {{-- <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      
                      
                        @if($key !== $keyIdAliquot)  
                            @if(in_array("phosphorous.aliquot", $permissions))
                              <div class="cursor-pointer" 
                              wire:click.prevent="$set('keyIdAliquot',{{$key}})">
                              {{$register->aliquot}}
                              </div>  
                            @else
                              <div>{{$register->aliquot}}</div>  
                            @endif

                        @elseif($editAliquot === true and $key === $keyIdAliquot)
                            <div class="flex justify-center">
                            <input type="text" id="aliquot-{{$key}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->aliquot}}" value="{{$register->aliquot}}" wire:model="aliquotField"
                            wire:keydown.enter="updateAliquot({{$register->id}})" 
                            wire:keydown.arrow-up="$set('keyIdAliquot',{{$keyIdAliquot - 1 }})"
                            wire:keydown.arrow-down="$set('keyIdAliquot',{{$keyIdAliquot + 1 }})"
                            wire:keydown.arrow-left="moveToAbsorbance({{$keyIdAliquot}})"
                            wire:keydown.arrow-right="moveToColorimetric({{$keyIdAliquot}})"
                             autofocus="autofocus" wire:key="aliquot-{{$key}}">
                            <a href="" class="pt-2" wire:click.prevent="closeAliquot">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </a>
                            </div>

                        @else                        

                        @endif
                    </td> --}}
                    {{-- <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                        @if($key !== $keyIdColorimetric)  
                            @if(in_array("phosphorous.colorimetric", $permissions))
                              <div class="cursor-pointer" 
                              wire:click.prevent="$set('keyIdColorimetric',{{$key}})">
                              {{$register->colorimetric_factor}}
                              </div>
                            @else 
                              <div>{{$register->colorimetric_factor}}</div>
                            @endif  

                        @elseif($editColorimetric === true and $key === $keyIdColorimetric)
                            <div class="flex justify-center">
                            <input type="text" id="colorimetric-{{$key}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus" placeholder="{{$register->colorimetric_factor}}" value="{{$register->colorimetric_factor}}" wire:model="colorimetricField"
                            wire:keydown.enter="updateColorimetric({{$register->id}})" 
                            wire:keydown.arrow-up="$set('keyIdColorimetric',{{$keyIdColorimetric - 1 }})"
                            wire:keydown.arrow-down="$set('keyIdColorimetric',{{$keyIdColorimetric + 1 }})"
                            wire:keydown.arrow-left="moveToAliquot({{$keyIdColorimetric}})"
                            wire:keydown.arrow-right="moveToAbsorbance({{$keyIdColorimetric}})"
                            wire:key="colorimetric-{{$key}}" autofocus="autofocus">
                            
                            <a href="" class="pt-2" wire:click.prevent="closeColorimetric">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </a>
                            </div>

                        @else                        

                        @endif
                    </td> --}}
                    {{-- <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">                     
                       {{$register->dilution_factor}}
                    </td> --}}
                   {{--  <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{round($register->phosphorous,3)}}
                    </td> --}}
                    

                   
                    
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
                  </tr> 
                  @empty
                    {{-- empty expr --}}
                  @endforelse
                  
                  
                </tbody>
              </table>
    
    @endif
    
</div>
