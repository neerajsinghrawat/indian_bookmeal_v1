@extends('layouts.defult')
@section('content')    
					<?php

							if(isset($subcategory[0]) && !empty($subcategory)){ ?>

                        <option class="selectcategory" value=""> -Select Sub Category-</option>
                        @foreach($subcategory as $subcategory_rec)
                            <option class="selectcategory" value="{{ $subcategory_rec->id }}">{{ ucwords($subcategory_rec->name) }}</option>
                        @endforeach
                
               		<?php }else{ ?>  
               		 <option class="selectcategory" value=""> -Sub Category not found-</option>
               		<?php } ?>  
  
@endsection
