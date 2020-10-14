@extends('layouts.defult')
@section('content')      
                   <label for="exampleInputEmail1">Feature Group</label>
                      <select class="form-control  selectpicker" data-live-search="true" name="feature_group_id">
                        <option class="selectcategory" value=""> -Select Feature Group-</option>
                        @foreach($featurecategory as $featurecat)
                            <option class="selectcategory" value="{{ $featurecat->id }}">{{ ucwords($featurecat->name) }}</option>
                        @endforeach
                    </select>
               
  
@endsection
