@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Loading Text",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Loading Text List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Loading Text') }}</h3>
                        </div>
                        @can('loadingText_create')
                        <div class="col-4 text-right">
                            <a href="{{ route('loadingtext.create') }}"
                                class="btn btn-sm btn-primary">{{ __('Add Loading Text') }}</a>
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
                                <th>{{__('Text')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $cat)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $cat->text}}</td>
                              
                                <td class="d-flex">



                                    @can('loadingText_edit')
                                    <a class="btn btn-sm btn-outline-info btn-icon m-1"
                                        href="{{ route('loadingtext.edit', $cat->id) }}">
                                        <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
                                    </a>
                                    @endcan
                                    @can('loadingText_delete')

                                    <form action="{{ route('loadingtext.destroy', $cat) }}" method="post">
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