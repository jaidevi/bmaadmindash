@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Vehicle Brand",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Vehicle Brand List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Vehicle Brand') }}</h3>
                        </div>
                        @can('vehicleBrand_create')
                        <div class="col-4 text-right">
                            <a href="{{ route('vehicleBrand.create') }}" class="btn btn-sm btn-primary">{{ __('Add Vehicle Brand') }}</a>
                        </div>
                        @endcan
                    </div>
                </div>

                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="table-responsive py-4">
                    <table id="dataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                               <th>#</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                   <tbody>
                  @foreach ($vehicleBrand as $cat)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $cat->name}}
                            @if ($cat->is_trending)
                    
                            <a href="#" class="badge badge-danger m-2 p-2">TRENDING</a>
                            @endif
                        </td>
                        <td>
                            <div class="  text-center" >
                    
                                <img class="mt-2 " src="{{ asset('upload') .'/'.$cat->icon}}" alt=""
                                    height="100" width="100" style="height: 50px;width: 50px">
                            </div>
                        </td>
                        <td>
                            @if ($cat->status)
                            <span class="badge   badge-success m-1">{{__('Active')}}</span>
                            @else
                            <span class="badge   badge-warning  m-1">{{__('Disabled')}}</span>
                    
                            @endif
                        </td>
                        <td class="d-flex">
                    
                    
                    
                            @can('vehicleBrand_edit')
                            <a class="btn btn-sm btn-outline-info btn-icon m-1" href="{{ route('vehicleBrand.edit', $cat->id) }}">
                                <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
                            </a>
                            @endcan
                            @can('vehicleBrand_delete')
                    
                            <form action="{{ route('vehicleBrand.destroy', $cat) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-sm btn-outline-danger btn-icon m-1"
                                    onclick="confirm('{{ __("Are you sure you want to delete this?") }}') ? this.parentElement.submit() : ''">
                                    <span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span>
                                </button>
                            </form>
                    
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection