@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>{{__('Report')}}</h1>
    <ul>
        <li><a href="">{{__('Home')}}</a></li>
        <li>{{__('Report')}}</li>
    </ul>

</div>

<div class="separator-breadcrumb border-top"></div>
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
<div class="row mb-4">
    {{-- {{dd($req)}} --}}
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h6 class="card-title mb-3">{{__('Filleter')}}</h6>
                <form action="{{ route('reportGenerate') }}" method="POST">
                    @csrf
                    <div class="form-row ">
                        <div class="form-group col-md-2">
                            <label for="inputEmail4" class="ul-form__label">{{__('From:')}}</label>
                            <input type="date" value="{{ $req['from'] ?? '' }}" name="from"
                                class="form-control  @error('from') invalid-input @enderror" autofocus>

                            @error('from')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail4" class="ul-form__label">{{__('To:')}}</label>
                            <input type="date" name="to" value="{{ $req['to'] ?? '' }}"
                                class="form-control  @error('to') invalid-input @enderror">

                            @error('to')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-8" style="margin-top: 32px;">

                            <button type="submit"
                                class="btn btn-raised ripple btn-raised-primary m-1">{{__('Search')}}</button>
                            <button type="reset"
                                class=" btn btn-raised ripple btn-raised-secondary m-1">{{__('Reset')}}</button>

                        </div>

                    </div>
                    <div class="form-row ">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4" class="ul-form__label"> {{__('Provider:')}}</label>
                            <select class="js-example-basic-multiple form-control" name="provider">
                                <option {{ $req['provider'] == 'provider_id'}} value="provider_id">All</option>
                                @foreach ($provider as $per)

                                <option {{ $req['provider']  == $per['id'] ? 'selected' : ''}} value="{{$per['id']}}">
                                    {{$per['name']}}</option>
                                @endforeach

                            </select>
                            @error('provider')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4" class="ul-form__label"> {{__('Payment:')}}</label>
                            <select class="js-example-basic-multiple form-control" name="payment">

                                <option {{ $req['payment']  == 'payment' ? 'selected' : ''}} value="payment">All
                                </option>
                                <option {{ $req['payment'] == '0' ? 'selected' : ''}} value="0">Online
                                </option>
                                <option {{ $req['payment'] == '1' ? 'selected' : ''}} value="1">Offline
                                </option>


                            </select>
                            @error('payment')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4" class="ul-form__label"> {{__('Payment Status:')}}</label>
                            <select class="js-example-basic-multiple form-control" name="status">
                                <option {{ $req['status']  == 'shattle' ? 'selected' : ''}} value="shattle">All
                                </option>
                                <option {{ $req['status']  == '1' ? 'selected' : ''}} value="1">Settled</option>
                                <option {{ $req['status']  == '0' ? 'selected' : ''}} value="0">Unsettled</option>
                            </select>
                            @error('permissions')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">

            <div class="card-body">
                <h6 class="card-title mb-3">{{__('Report')}}</h6>

                <div class="table-responsive">
                    <table id="dataTable" class="display table dataTable " style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Job Id')}}</th>
                                <th>{{__('Job Date')}}</th>
                                <th>{{__('Service Provider')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Provider Share')}}</th>
                                <th>{{__('Admin Share')}}</th>
                                <th>{{__('Payment Type')}}</th>
                                <th>{{__('Paid')}}</th>
                                <th>{{__('Time')}}</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($master ?? [] as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $item['job_id']}}</td>
                                <td>{{ $item['job_date']}}</td>
                                <td>{{ $item['provider_name']}}</td>
                                <td>{{$req['currency']}}{{ $item['total']}}</td>
                                <td>{{$req['currency']}}{{ $item['admin_share']}}</td>
                                <td>{{$req['currency']}}{{ $item['provider_share']}}</td>
                                <td>
                                    @if ($item['payment_type'])
                                    {{__('ONLINE')}}
                                    @else
                                    {{__('OFFLINE')}}
                                    @endif
                                </td>
                                <td>

                                    @if ($item['paid'] =='0')
                                    {{__(' NOT PAID')}}
                                    @elseif($item['paid'] =='1')
                                    {{__(' PAID')}}
                                    @else
                                    {{__('CANCLE')}}
                                    @endif
                                </td>
                                <td>

                                    {{ $item['time']}}
                                </td>
                            </tr>
                            @endforeach



                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>{{__('Job Id')}}</th>
                                <th>{{__('Job Date')}}</th>
                                <th>{{__('Service Provider')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Provider Share')}}</th>
                                <th>{{__('Admin Share')}}</th>
                                <th>{{__('Payment Type')}}</th>
                                <th>{{__('Paid')}}</th>
                                <th>{{__('Time')}}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- end of breadcrumb --}}

@endsection