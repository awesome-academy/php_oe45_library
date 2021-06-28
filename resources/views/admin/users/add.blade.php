@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.add_user') }}</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary mt-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ trans('message.add_user') }}</h3>
                        </div>

                        <form method="POST" action="">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ trans('message.name') }}</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ trans('message.input_name_of_user') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.email') }}</label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="{{ trans('message.input_email_of_user') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.password') }}</label>
                                    <input type="password" class="form-control" name="password">
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
