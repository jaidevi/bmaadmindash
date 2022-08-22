@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>" Sub Fuel Type",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>' Sub Fuel Type',
'text'=>'New Sub Fuel Type',
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('New  Sub Fuel Type Detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('subfueltype.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>


                <div class="card-body">

                    <form action="{{ route('subfueltype.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('Name:')}}</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control  @error('name') invalid-input @enderror"
                                        placeholder="{{__('Please Enter Name')}}" autofocus required>

                                    @error('name')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="validationDefault01">{{__('Fuel Type:')}}</label>
                                    <select name="fuel_type"
                                        class="form-control  @error('fuel_type') invalid-input @enderror">
                                        @foreach ($fueltype as $item)

                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('fuel_type')
                                    <div class="invalid-div">{{ $message }}</div>
                                    @enderror


                                </div>
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label for="inputEmail4" class="ul-form__label">
                                    {{__('Measurement Unit:')}}</label>
                                <select name="measurement_unit"
                                    class="form-control  @error('measurement_unit') invalid-input @enderror">
                                    <option value="Liter">Liter
                                    </option>
                                    <option value="Gallon">Gallon</option>
                                    <option value="KG">KG</option>
                                </select>
                                @error('measurement_unit')
                                <div class="invalid-div">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group d-flex">
                                    <label class="form-control-label"
                                        for="validationDefault01">{{__('Status:')}}</label>
                                    <label class="custom-toggle custom-toggle-primary ml-2">
                                        <input type="checkbox" value="1" name="status">
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