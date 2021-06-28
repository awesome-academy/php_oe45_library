@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.edit_publisher') }}</title>
@endsection

@section('content')
<div class="content-wrapper">
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ trans('message.whoop') }}</strong> {{ trans('message.wronginput') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary mt-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ trans('message.edit_publisher') }}</h3>
                        </div>

                        <form action="{{ route('publishers.update', $publisher->pub_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ trans('message.name') }}</label>
                                    <input type="text" class="form-control" name="pub_name" value="{{ $publisher->pub_name }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.description') }}</label>
                                    <textarea class="form-control" name="pub_desc" rows="3">{{ $publisher->pub_desc }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans('message.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection