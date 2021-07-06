@extends('user.layouts.app')

@section('content')  
    <div class="container">
        <h2 class="text-secondary">{{ trans('user.request.create') }}</h2>
        <form action="{{route('request.store')}}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="{{ asset('images/'.$book->book_img) }}" alt="">
                        </div>
                        <div class="col-sm-10">
                            <h2 class="text-danger">{{$book->book_title}}</h2>
                            <p>{{ trans('user.books.author') }}: {{ $book->author->author_name }}</p>
                            <p>{{ trans('user.books.publisher') }}: {{ $book->publisher->pub_name }}</p>
                        </div> 
                    </div>
                    <input type="hidden" name="book_id" id="task-name" class="form-control" value="{{$book->book_id}}">
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="task" class="col-sm-3 control-label">{{ trans('user.request.borrowdate')}}:</label>
                    <input id="datepickerborrow" name="borrow_date" type="date"/>
                    @error('borrow_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="task" class="col-sm-3 control-label">{{ trans('user.request.returndate')}}:</label>
                    <input id="datepickerpay" name="return_date" type="date"/>
                    @error('return_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('user.request.add')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
