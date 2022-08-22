@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Loading Text",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Loading Text',
'text'=>'Edit User'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Loading Text') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('loadingtext.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form enctype="multipart/form-data" action="{{ route("loadingtext.update", [$loadingtext->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="validationDefault01">{{__('text:')}}</label>
                                    <input type="text" name="text" value="{{ old('text',$loadingtext->text) }}"
                                        class="form-control  @error('text') invalid-input @enderror"
                                        placeholder="{{__('Please Enter text')}}" autofocus required>

                                    @error('text')
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