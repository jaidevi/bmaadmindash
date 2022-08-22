@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Provider",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>' '
])))
<style>
    .avatar img {
        height: 100%;
    }
</style>
<div class="container-fluid mt--7">
    <div class="row">




        <div class="col-xl-4 ">
            <div class="card card-profile">
                <img src="{{ asset('upload') .'/'.$data->image}}" alt="Image placeholder" class="card-img-top">

                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-center">

                        @if ($data->is_featured)
                        <a href="#" class="badge badge-danger m-2 p-2">featured</a>
                        @endif
                        @if ($data->is_online)
                        <a href="#" class="badge badge-success m-2 p-2">ONLINE</a>
                        @endif

                    </div>
                </div>
                <div class="card-body pt-0">

                    <div class="text-center">
                        <h5 class="h3">
                            {{ $data->name}}<span class="font-weight-light"></span>
                        </h5>
                        <h5 class="h3">
                            {{ $data->email}}<span class="font-weight-light"></span>
                        </h5>
                        <h5 class="h3">
                            {{ $data->phone_no}}<span class="font-weight-light"></span>
                        </h5>
                        {{-- <div class="h5 font-weight-300">
                            <i class="fas fa-street-view mr-2"></i>{{ $data->address}}
                    </div>
                    <div class="h5 mt-4">
                        <i class="far fa-clock mr-2"></i> {{ $data->start_time .' to '. $data->end_time}}
                    </div> --}}

                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-8 ">
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <!-- Title -->
                <h5 class="h3 mb-0">Pricing</h5>
            </div>
            <!-- Card body -->
            <div class="card-body py-0">
                <ul class="list-group list-group-flush">

                    @foreach ($data->pricing as $item)

                    <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
                        <div class="checklist-item checklist-item-danger checklist-item-checked">
                            <div class="checklist-info">
                                <h5 class="checklist-title mb-0">{{$item->title}}</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach ($item->fuel_pricing as $price)

                                    <li class="list-group-item">{{$price['name']}}<span class="float-right">{{$item->currency}}{{$price['pricing']}}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </li>
                    @endforeach
                </ul>
                <!-- List group -->

            </div>
        </div>

        <!-- Checklist -->


    </div>

</div>
<div class="row my-3">
    <div class="col-12">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Request`s</h3>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Employee</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->bookings as $booking)

                                <tr>
                                    <td>{{$booking->order_id}}</td>
                                    <td>{{$booking->user->name}}</td>
                                    <td>{{$booking->fuel_type}}</td>
                                    <td>{{$booking->currency}}{{$booking->price}}</td>
                                    <td>{{$booking->time}}</td>
                                    <td>
                                        @if ($booking->status == '0')
                                        <a href="#" class="btn btn-sm btn-warning float-right">Waiting</a>
                                        @elseif($booking->status == '1')
                                        <a href="#" class="btn btn-sm btn-default float-right">Approved</a>
                                        @elseif($booking->status == '2')
                                        <a href="#" class="btn btn-sm btn-info float-right">On the way</a>
                                        @elseif($booking->status == '3')
                                        <a href="#" class="btn btn-sm btn-info float-right">Complete</a>
                                        @elseif($booking->status == '4')
                                        <a href="#" class="btn btn-sm btn-danger float-right">Cancel</a>
                                        @elseif($booking->status == '6')
                                        <a href="#" class="btn btn-sm btn-primary float-right">Rejected</a>

                                        @endif


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
</div>
<div class="row my-3">
    <div class="col-12">
        <div class="row">
            <div class="col">
                <div class="card my-3">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Reviews</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data['reviews'] as $item)
    <div class="col-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <a href="#">
                        <img src="{{ asset('upload') .'/'.$item->user->image}}" class="avatar">
                    </a>
                    <div class="mx-3">
                        <a href="#" class="text-dark font-weight-600 text-sm">{{$item->user->name}}</a>
                        <small class="d-block text-muted">{{$item->created_at->diffForHumans()}}</small>

                    </div>

                </div>
                <div class="text-right ml-auto">
                    @for ($i =1 ; $i <= 5; $i++) <i class="fas fa-star {{ $i<= $item->star ? 'active-star' : ''}}">
                        </i>
                        @endfor</td>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
</div>
@endsection