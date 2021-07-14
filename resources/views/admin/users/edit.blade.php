@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.edit_user') }}</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary mt-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ trans('message.edit_user') }}</h3>
                        </div>

                        <form action="{{ route('users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ trans('message.name') }}</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ trans('message.input_name_of_user') }}" value="{{ $user->name }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.email') }}</label>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="{{ trans('message.input_email_of_user') }}" value="{{ $user->email }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.role') }}</label>
                                    <select class="form-control select2" name="role_id">
                                        @if($user->role_id == config('app.role'))
                                            <option selected value="{{ config('app.role') }}">{{ trans('message.admin') }}</option>
                                            <option>{{ trans('message.user') }}</option>
                                        @else
                                            <option value="{{ config('app.role') }}">{{ trans('message.admin') }}</option>
                                            <option selected>{{ trans('message.user') }}</option>
                                        @endif
                                    </select>
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
