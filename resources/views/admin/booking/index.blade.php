@extends('layouts.app')
<style>
    .activeStar {
        color: goldenrod
    }
</style>
@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Booking",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Booking List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Booking') }}</h3>
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
                    <table id="dataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>{{__('Unique ID')}}</th>
                                <th>{{__('User Name')}}</th>
                                <th>{{__('Fuel Provider')}}</th>
                                <th>{{__('Address')}}</th>
                                <th>{{__('Fuel Type - QTY')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Created at')}}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $cat)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $cat['order_id']}}</td>
                                <td>{{ $cat['user']['name'] ?? ""}}</td>
                                <td>
                                    {{$cat['provider']['name'] ?? ""}}
                                </td>
                                <td>{{ $cat['address']}}</td>
                                <td>{{ $cat['fuel_type'] .' - '. $cat['qty']}}</td>
                                <td>{{ $cat['currency'] . $cat['price']}}</td>
                                <td>{{ $cat['time']}}</td>
                                <td>@if ($cat->status == 0)
                                    {{__(' Wait For Approval')}}
                                    @elseif($cat->status == 1)
                                    {{__('Accepted')}}
                                    @elseif($cat->status == 2)
                                    {{__('On the Way')}}
                                    @elseif($cat->status == 3)
                                    {{__('Complete')}}
                                    @elseif($cat->status == 4)
                                    {{__('Cancel')}}
                                    @elseif($cat->status == 6)
                                    {{__('Rejected')}}
                                    @else

                                    @endif
                                </td>
                                
                                <td>
                                    {{ $cat['created_at']}}
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