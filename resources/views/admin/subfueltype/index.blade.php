@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Sub Fuel Type",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Sub Fuel Type List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Sub Fuel Type') }}</h3>
                        </div>
                        @can('fuelType_create')
                        <div class="col-4 text-right">
                            <a href="{{ route('subfueltype.create') }}"
                                class="btn btn-sm btn-primary">{{ __('Add Sub Fuel Type') }}</a>
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
                                <th>{{__('Fuel')}}</th>
                                <th>{{__('Measurement Unit')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $cat)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $cat->name}}</td>
                                <td>
                                    {{$cat['fuel']['name']}}
                                </td>
                                <td>{{ $cat->measurement_unit}}</td>
                                <td>
                                    @if ($cat->status)
                                    <span class="badge   badge-success m-1">{{__('Active')}}</span>
                                    @else
                                    <span class="badge   badge-warning  m-1">{{__('Disabled')}}</span>

                                    @endif
                                </td>
                                <td class="d-flex">



                                    @can('subfueltype_edit')
                                    <a class="btn btn-sm btn-outline-info btn-icon m-1"
                                        href="{{ route('subfueltype.edit', $cat->id) }}">
                                        <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
                                    </a>
                                    @endcan
                                    @can('subfueltype_delete')

                                    <form action="{{ route('subfueltype.destroy', $cat) }}" method="post">
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