@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.requests') }}</title>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-4 mb-4">
    <h2>{{ trans('message.request') }}</h2>
</div>
  <h2 class="mt-4 pb-2"></h2>
  
  <div class="input-group mb-3">
    <form action="#" method="GET" class="form-inline input-group">
      <input name="search" type="text" class="form-control" placeholder="">
      <div class="input-group-append" id="button-addon4">
        <button type="submit" class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
        <a href="#" class="btn btn-outline-secondary"><i class="fas fa-file-export"></i></a>
      </div>
    </form>
  </div>
  
  @if( session()->has('del_success'))
    <div class="alert alert-success">{{ session()->get('del_success') }}</div>
  @elseif( session()->has('approved_success'))
    <div class="alert alert-success">{{ session()->get('approved_success') }}</div>
    @elseif( session()->has('unapproved_success'))
    <div class="alert alert-success">{{ session()->get('unapproved_success') }}</div>
  @elseif( session()->has('rejected_success'))
    <div class="alert alert-success">{{ session()->get('rejected_success') }}</div>
  @endif
  
  <table class="table table-bordered bg-white">
    <thead>
      <tr>
        <th scope="col">{{ trans('message.id') }}</th>
        <th scope="col">{{ trans('message.user_name') }}</th>
        <th scope="col">{{ trans('message.email') }}</th>
        <th scope="col">{{ trans('message.title') }}</th>
        <th scope="col">{{ trans('message.borrow_date') }}</th>
        <th scope="col">{{ trans('message.return_date') }}</th>
        <th scope="col">{{ trans('message.check') }}</th>
        <th scope="col">{{ trans('message.delete') }}</th>
      </tr>
    </thead>
    <tbody>
  
      @foreach($borrows as $key => $borrow)
        <tr>
          <th scope="row">{{ $key+1 }}</th>
          <td>{{ $borrow->user->name }}</td>
          <td>{{ $borrow->user->email }}</td>
          <td>{{ $borrow->book->book_title }}</td>
          <td>{{date('d-m-Y', strtotime($borrow->borrow_date))}}</td>
          <td>{{date('d-m-Y', strtotime($borrow->return_date))}}</td>
          <td>
            @if($borrow->borrow_status == config('app.unapproved'))
              <a href="{{ route('request.approved', $borrow->borrow_id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-times"></i> {{ trans('user.request.nonapproved') }}</a>
              <a href="{{ route('request.rejected', $borrow->borrow_id) }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-ban"></i> {{ trans('user.request.reject') }}</a>
            @elseif($borrow->borrow_status == config('app.approved'))
              <a href="#" class="btn btn-sm btn-outline-success"><i class="fas fa-check-circle"></i> {{ trans('user.request.approved') }}</a>
            @else
              <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> {{ trans('user.request.rejected') }}</a>
            @endif
          </td>
          <td>
            @if($borrow->borrow_status == config('app.rejected'))
              <form action="{{ route('requests.destroy', $borrow->borrow_id) }}" method="post">
                <div class="input-group">
                  @csrf
                  @method('DELETE')
                  <div class="input-group-append" id="button-addon4">
                    <button class="btn btn-sm btn-outline-danger ml-1" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  </div>
                </div>
              </form>
            @endif
          </td>
        </tr>
      @endforeach
      
    </tbody>
  </table>
  <div class="col-md-12 text-center justify-content-center">
    <nav aria-label="Page navigation">
        {{ $borrows->links() }}
    </nav>
  </div>

@endsection
