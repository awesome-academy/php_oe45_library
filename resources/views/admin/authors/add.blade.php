@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.add_author') }}</title>
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
                            <h3 class="card-title">{{ trans('message.add_author') }}</h3>
                        </div>

                        <form action="{{ route('authors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ trans('message.name') }}</label>
                                    <input type="text" class="form-control" name="author_name"
                                        placeholder="{{ trans('message.input_name_of_author') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.description') }}</label>
                                    <textarea class="form-control" rows="3"
                                        placeholder="{{ trans('message.enter') }}" name="author_desc"></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans('message.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection