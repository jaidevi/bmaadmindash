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
       <div class="col-lg-4 col-xl-4">
           <div class="card">
               <img class="d-block w-100" src="{{ asset('upload').'/'.$provider->image}}" alt="First slide"
                   height="250">
               <div class="card-body">
                   <div class="ul-contact-detail__info">
                       <div class="row">
                           <div class="col-12 text-center">
                               <div class="ul-contact-detail__info-1">
                                   <h5>{{__('Name')}}</h5>
                                   <span>{{$provider->name}}</span>
                               </div>

                           </div>
                           <div class="col-6 text-center">
                               <div class="ul-contact-detail__info-1">
                                   <h5>{{__('Email')}}</h5>
                                   <span>{{$provider->email}}</span>
                               </div>
                           </div>
                           <div class="col-6 text-center">
                               <div class="ul-contact-detail__info-1">
                                   <h5>{{__('Phone no')}}</h5>
                                   <span>{{$provider->phone_no}}</span>
                               </div>
                           </div>

                           <div class="col-12 text-center">
                               <div class="ul-contact-detail__info-1">
                                   <h5>{{__('Address')}}</h5>
                                   <span>{{$provider->address}}</span>
                               </div>
                           </div>
                           {{-- <div class="col-12 text-center">

                                <div class="ul-contact-detail__social">
                                    <div class="ul-contact-detail__social-1">
                                        <button type="button" class="btn btn-facebook btn-icon m-1">
                                            <span class="ul-btn__icon"><i class="fas fa-tasks"></i></span>
                                        </button>
                                        <span class="t-font-boldest ul-contact-detail__followers">400</span>
                                    </div>
                                    <div class="ul-contact-detail__social-1">
                                        <button type="button" class="btn btn-twitter btn-icon m-1">
                                            <span class="ul-btn__icon"><i class="fas fa-dollar-sign"></i></span>

                                        </button>
                                        <span class="t-font-boldest ul-contact-detail__followers">900</span>
                                    </div>
                                    <div class="ul-contact-detail__social-1">
                                        <button type="button" class="btn btn-dribble btn-icon m-1">
                                            <span class="ul-btn__icon"><i class="i-Dribble"></i></span>

                                        </button>
                                        <span class="t-font-boldest ul-contact-detail__followers">658</span>
                                    </div>
                                </div>

                            </div> --}}
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="col-lg-8 col-xl-8">
           <!-- begin::basic-tab -->
           <div class="card mb-4 ">
               <div class="card-header bg-transparent">{{__('Information')}}</div>

               <div class="card-body">
                   <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">
                       <li class="nav-item">
                           <a class="nav-link active" id="nav-tab" data-toggle="tab" href="#nav-home" role="tab"
                               aria-controls="timeline" aria-selected="false">{{__('Earning
                                List')}}</a>
                       </li>
                       <li class="nav-item">
                           <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                               aria-controls="about" aria-selected="true">{{__('Summery')}}</a>
                       </li>

                   </ul>
                   <div class="tab-content ul-tab__content" id="nav-tabContent">
                       <div class="tab-pane fade active show" id="nav-home" role="tabpanel"
                           aria-labelledby="nav-home-tab">
                           <h6 class="card-title mb-3">{{__('Earning')}}</h6>
                           <div class="table-responsive">
                               <table id="dataTable" class="display table dataTable " style="width:100%">
                                   <thead>
                                       <tr>
                                           <th>#</th>
                                           <th>{{__('Job ID')}}</th>
                                           <th>{{__('Total')}}</th>
                                           <th>{{__('Provider Share')}}</th>
                                           <th>{{__('Admin Share')}}</th>
                                           <th>{{__('Payment Type')}}</th>
                                           <th>{{__('Paid')}}</th>
                                           <th>{{__('Time')}}</th>
                                           {{-- <th>{{__('Action')}}</th> --}}

                                       </tr>
                                   </thead>
                                   <tbody>

                                       @foreach ($earning['data'] as $item)

                                       <tr>
                                           <td>
                                               {{$loop->index}}
                                           </td>
                                           <td>{{$item['bookingData']['order_id']}}</td>

                                           <td>
                                               {{$provider->currency}} {{$item['bookingData']['price']}}
                                           </td>
                                           <td>
                                               {{$provider->currency}} {{$item->provider_share}}
                                           </td>
                                           <td>
                                               {{$provider->currency}}{{$item->admin_share}}
                                           </td>
                                           <td>
                                               @if ($item->payment)
                                               {{__('ONLINE')}}
                                               @else
                                               {{__('OFFLINE')}}
                                               @endif

                                           </td>
                                           <td>
                                               @if ($item->shattle =='0')
                                               {{__(' NOT PAID')}}
                                               @elseif($item->shattle =='1')
                                               {{__(' PAID')}}
                                               @else
                                               {{__('CANCLE')}}
                                               @endif

                                           </td>
                                           <td>
                                               {{$item->created_at}}
                                           </td>
                                       </tr>
                                       @endforeach

                                   </tbody>
                                   <tfoot>
                                       <tr>
                                           <th>#</th>
                                           <th>{{__('Job ID')}}</th>
                                           <th>{{__('Total')}}</th>
                                           <th>{{__('Provider Share')}}</th>
                                           <th>{{__('Admin Share')}}</th>
                                           <th>{{__('Payment Type')}}</th>
                                           <th>{{__('Paid')}}</th>
                                           <th>{{__('Time')}}</th>
                                           {{-- <th>{{__('Action')}}</th> --}}
                                       </tr>
                                   </tfoot>

                               </table>
                           </div>
                       </div>
                       <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                           <div class="row">
                               <div class="col-lg-12 col-xl-12">
                                   <div class="ul-contact-detail__profile">
                                       <div class="ul-contact-detail__inner-profile">
                                           <h4 class="heading">{{__('Total Job Count')}}</h4>
                                           <span class="tetx-muted">{{$earning['d_total_task']}}</span>
                                       </div>

                                       <div class="ul-contact-detail__inner-profile">
                                           <h4 class="heading">{{__('Total Amount')}}</h4>
                                           <span
                                               class="tetx-muted">{{$provider->currency}}{{$earning['d_total_amount']}}</span>
                                       </div>
                                       <div class="ul-contact-detail__inner-profile">
                                           <h4 class="heading">{{__('Admin Commission')}}</h4>
                                           <span
                                               class="tetx-muted">{{$provider->currency}}{{$earning['d_admin_share']}}</span>
                                       </div>
                                       <div class="ul-contact-detail__inner-profile">
                                           <h4 class="heading">{{__('Provider Earning')}}</h4>
                                           <span
                                               class="tetx-muted">{{$provider->currency}}{{$earning['d_provider_share']}}</span>
                                       </div>
                                       <div class="ul-contact-detail__inner-profile">
                                           <h4 class="heading">{{__('Offline Payment - Online Payment')}}</h4>
                                           <span
                                               class="tetx-muted">{{$provider->currency}}{{$earning['d_provider_to_admin']}}
                                               - {{$provider->currency}}{{$earning['d_admin_to_provider']}}</span>
                                       </div>
                                   </div>
                                   <div class="custom-separator"></div>
                               </div>

                               <div class="col-lg-12 col-xl-12">
                                   <h4 class="card-title mb-3">{{__('Amount Settlement')}}</h4>
                                   <div class="custom-separator"></div>

                                   <span class=""> {{__('Amount to be given by Admin to Provider')}}</span>
                                   <div class="progress mb-3 mt-2">
                                       <div class="progress-bar bg-danger" role="progressbar" style="width: 10%"
                                           aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                           {{$provider->currency}}{{$earning['d_admin_to_provider']}}</div>
                                   </div>

                                   <span class=""> {{__('Amount to be given by Provider to Admin')}}</span>
                                   <div class="progress mb-3 mt-2">
                                       <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                           aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                           {{$provider->currency}}{{$earning['d_provider_to_admin']}}</div>
                                   </div>


                               </div>

                           </div>
                       </div>

                   </div>
               </div>
           </div>
           @can('earning_settle')
           <form action="{{ route('earning.settle') }}" method="post">
               @csrf
               <input type="hidden" name="provider_id" value="{{$provider->id}}">
               @if ($earning['d_provider_to_admin'] > 0 || $earning['d_admin_to_provider'] > 0)
               <button type="button" class="btn btn-lg btn-primary btn-block m-1 mb-3"
                   onclick="confirm('{{ __("Are you sure you want to take this action?") }}') ? this.parentElement.submit() : ''">{{__('Settle
                    All Payment')}}</button>
               @else
               <button type="button" class="btn btn-lg btn-primary btn-block m-1 mb-3">
                   {{__('All Payment Are Settle')}}</button>
               @endif
           </form>
           @endcan

           <!-- end::basic-tab -->
       </div>
   </div>
</div>
@endsection
