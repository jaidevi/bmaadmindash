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
'title'=>"Review",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Review List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Review') }}</h3>
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
                                <th>{{__('User Name')}}</th>
                                <th>{{__('Fuel Provider')}}</th>
                                <th>{{__('Star')}}</th>
                                <th>{{__('Comment')}}</th>
                                <th>{{__('Date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $cat)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $cat['user']['name'] ?? ""}}</td>
                                <td>
                                    {{$cat['provider']['name'] ?? ""}}
                                </td>
                                <td>
                                @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star {{$i <= $cat->star ? 'activeStar' : ''}}">
                                    </i>
                                    @endfor</td>
                               <td>
                                   {{ $cat['cmt']}}
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