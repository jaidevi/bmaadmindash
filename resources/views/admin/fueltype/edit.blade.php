@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Fuel type",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Fuel type',
'text'=>'Edit User'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Fuel Type') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('fueltype.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form enctype="multipart/form-data"  action="{{ route("fueltype.update", [$fueltype->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Name:')}}</label>
                                    <input type="text" name="name" value="{{ old('name',$fueltype->name) }}"
                                        class="form-control  @error('name') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Name')}}" autofocus required>

                                    @error('name')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Icon:')}}</label>
                                    <input type="file" name="icon"
                                        class="form-control file-input  @error('icon') invalid-input @enderror" 
                                        accept="image/*">
                                    @error('icon')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror


                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group d-flex">
                                    <label class="form-control-label"
                                        for="validationDefault01">{{__('Trending:')}}</label>
                                    <label class="custom-toggle custom-toggle-primary ml-2">
                                        <input type="checkbox" value="1" name="is_trending" {{$fueltype->is_trending ? 'checked' : ''}}>
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No"
                                            data-label-on="Yes"></span>
                                    </label>
                                    @error('trending')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror


                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group d-flex">
                                    <label class="form-control-label"
                                        for="validationDefault01">{{__('Status:')}}</label>
                                    <label class="custom-toggle custom-toggle-primary ml-2">
                                        <input {{$fueltype->status ? 'checked' : ''}} type="checkbox" value="1" name="status">
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No"
                                            data-label-on="Yes"></span>
                                    </label>
                                    @error('status')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror


                                </div>
                            </div>


                        </div>

                        <button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
                    </form>
                </div>



            </div>
        </div>
    </div>
</div>
@endsection