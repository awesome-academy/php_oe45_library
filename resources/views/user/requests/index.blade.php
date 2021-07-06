@extends('user.layouts.app')

@section('content')
<h2 class="text-secondary mt-4">{{ trans('user.request.all') }}</h2>

@if( session()->has('create_success'))
<div class="alert alert-success">{{ session()->get('create_success') }}</div>
@endif

<table class="table">
    <thead>
      <tr>
        <th scope="col">{{ trans('message.id') }}</th>
        <th scope="col">{{ trans('user.books.name') }}</th>
        <th scope="col">{{ trans('user.request.status') }}</th>
        <th scope="col">{{ trans('user.request.borrowdate') }}</th>
        <th scope="col">{{ trans('user.request.returndate') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($borrows as $key => $borrow)
      <tr>
        <th>{{ $key+1 }}</th>
        <td>{{ $borrow->book_title }}</td>
        <td>
            @if($borrow->borrow_status == config('app.unapproved'))
                {{ trans('user.request.nonapproved') }}
            @elseif($borrow->borrow_status == config('app.approved'))
                {{ trans('user.request.approved') }}
            @else
                {{ trans('user.request.rejected') }}
            @endif
        </td>
        <td>{{date('d-m-Y', strtotime($borrow->borrow_date))}}</td>
        <td>{{date('d-m-Y', strtotime($borrow->return_date))}}</td>
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
