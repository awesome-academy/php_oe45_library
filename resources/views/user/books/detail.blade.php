@extends('user.layouts.app')

@section('content')
    <div class="row rowshow">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ trans('user.books.detailofbook') }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('images/'.$book->book_img) }}">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ trans('user.books.name') }}:</strong>
                {{ $book->book_title }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ trans('user.books.author') }}:</strong>
                {{ $book->author->author_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ trans('user.books.publisher') }}:</strong>
                {{ $book->publisher->pub_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ trans('user.books.quantity') }}:</strong>
                {{ $book->quantity }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            @if($book->quantity > 0)
                <a href="/request/create/{{$book->book_id}}" class="btn btn-primary">{{trans('user.books.borrow')}}</a>
            @else
                <p class="no-book">{{trans('user.books.nobook')}}</p>
            @endif
            <a href="#" class="btn btn-primary">{{trans('user.books.like')}}</a>
        </div>
    </div>
@endsection
