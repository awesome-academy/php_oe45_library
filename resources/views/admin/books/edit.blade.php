@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.edit_book') }}</title>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary mt-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ trans('message.edit_book') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('books.update', $book->book_id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ trans('message.title') }}</label>
                                    <input type="text" class="form-control" name="book_title"
                                        placeholder="{{ trans('message.input_name_of_book') }}" value="{{ $book->book_title }}">
                                    @if ($errors->has('book_title'))
                                        <span class="error text-danger">
                                            {{ $errors->first('book_title') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.description') }}</label>
                                    <textarea class="form-control" rows="3"
                                        placeholder="{{ trans('message.enter') }}" name="book_desc">{{ $book->book_desc }}</textarea>
                                    @if ($errors->has('book_desc'))
                                        <span class="error text-danger">
                                            {{ $errors->first('book_desc') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile02" name="book_img">
                                        @if($book->book_img)
                                        <label class="custom-file-label"
                                        for="inputGroupFile02">{{ $book->book_img }}</label>
                                        @else
                                        <label class="custom-file-label"
                                            for="inputGroupFile02">{{ trans('message.choose_file') }}</label>
                                        @endif
                                        <img src="{{ asset('images/'.$book->book_img) }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="mt-5">{{ trans('message.available_books') }}</label>
                                    <input type="text" class="form-control" name="quantity"
                                        placeholder="{{ trans('message.input_num_of_available_books') }}" value="{{ $book->quantity }}">
                                    @if ($errors->has('quantity'))
                                        <span class="error text-danger">
                                            {{ $errors->first('quantity') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.category') }}</label>
                                    <select class="form-control select2" name="cate_id">
                                        <option selected></option>
                                        {!! $categoryOption !!}
                                    </select>
                                    @if ($errors->has('cate_id'))
                                        <span class="error text-danger">
                                            {{ $errors->first('cate_id') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.author') }}</label>
                                    <select class="form-control select2" name="author_id">
                                        <option></option>
                                        @foreach($authors as $key => $author)
                                           @if($author->author_id == $book->author_id)
                                               <option selected value="{{$author->author_id}}">{{$author->author_name}}</option>
                                           @else
                                               <option value="{{$author->author_id}}">{{$author->author_name}}</option>
                                           @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('author_id'))
                                        <span class="error text-danger">
                                            {{ $errors->first('author_id') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('message.publisher') }}</label>
                                    <select class="form-control select2" name="pub_id">
                                        <option></option>
                                        @foreach($publishers as $key => $publisher)
                                           @if($publisher->pub_id == $book->pub_id)
                                               <option selected value="{{$publisher->pub_id}}">{{$publisher->pub_name}}</option>
                                           @else
                                               <option value="{{$publisher->pub_id}}">{{$publisher->pub_name}}</option>
                                           @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pub_id'))
                                        <span class="error text-danger">
                                            {{ $errors->first('pub_id') }}
                                        </span>
                                    @endif
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
