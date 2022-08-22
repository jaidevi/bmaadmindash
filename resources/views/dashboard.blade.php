@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['all_user']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">New Provider</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['all_provider']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">All Booking</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['all_booking']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Today Booking</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['today_booking']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Waiting For Approval</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['waiting']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Ongoing Booking</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['book_ongoing']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Complete Booking</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['book_complete']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Cancel / Rejected Booking</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$master['book_rejected']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row mt-5">

        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Booking</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('booking')}}" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Count</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    Total
                                </th>
                                <td>
                                    {{$master['book_total']}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">100%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-danger" role="progressbar"
                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    Waiting
                                </th>
                                <td>
                                    {{$master['waiting']}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{$master['waiting_per']}}%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success" role="progressbar"
                                                    aria-valuenow="{{$master['waiting_per']}}" aria-valuemin="0"
                                                    aria-valuemax="100" style="width: {{$master['waiting_per']}}%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    On Going
                                </th>
                                <td>
                                    {{$master['book_ongoing']}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{$master['book_ongoing_per']}}%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success" role="progressbar"
                                                    aria-valuenow="{{$master['book_ongoing_per']}}" aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    style="width: {{$master['book_ongoing_per']}}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Complete Booking
                                </th>
                                <td>
                                    {{$master['book_complete']}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{$master['book_complete_per']}}%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-primary" role="progressbar"
                                                    aria-valuenow="{{$master['book_complete_per']}}" aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    style="width: {{$master['book_complete_per']}}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Cancel / Rejected Booking
                                </th>
                                <td>
                                    {{$master['book_rejected']}}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">{{$master['book_rejected_per']}}%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info" role="progressbar"
                                                    aria-valuenow="{{$master['book_rejected_per']}}" aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    style="width: {{$master['book_rejected_per']}}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card bg-gradient-orange mb-4">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Service Provide</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$master['sub_fuel_type']}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card bg-gradient-primary mb-4">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Review</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$master['review_count']}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card bg-gradient-default mb-4">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Fuel Type</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$master['fuel_type']}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
