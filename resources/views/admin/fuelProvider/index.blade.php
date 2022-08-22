@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Provider",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Provider List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Provider') }}</h3>
                        </div>

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
                    <table id="dataTable" class="table table-flush" >
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Phone No')}}</th>
                                <th>{{__('Address')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($provider as $ss)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $ss->name}}</td>
                                <td><a href="mailto:{{$ss->email}}">{{$ss->email}}</a></td>
                                <td><a href="tel:{{$ss->phone_no}}">{{$ss->phone_no}}</a></td>
                                <td>{{$ss->address}}</td>
                                
                                <td>
                                    @if ($ss->status)
                                    <span
                                        class="badge  badge-success m-1">{{__('Active')}}</span>
                                    @else
                                    <span
                                        class="badge  badge-warning  m-1">{{__('Block')}}</span>

                                    @endif
                                </td>
                                <td class="d-flex">



                                    @can('fuelProvider_edit')

                                    <form action="{{ route('provider.statusChange', $ss) }}" method="post">
                                        @csrf

                                        <button type="button"
                                            class="btn btn-sm btn-outline-{{$ss->status ?'danger' :'primary'}} btn-icon m-1"
                                            onclick="confirm('{{ __("Are you sure you want to change status of this user?") }}') ? this.parentElement.submit() : ''">
                                            <span class="ul-btn__icon">
                                                @if ($ss->status)
                                                <i class="fas fa-ban"></i>
                                                @else
                                                <i class="fas fa-shield-alt"></i>
                                                @endif
                                            </span>
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