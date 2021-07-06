@extends('user.layouts.app')

@section('content')  
    <div class="container main mt-5">
        @foreach($category_name as $catename)
            <h1>{{ $catename->cate_name }}</h1>
        @endforeach
        <div class="row">
            @foreach($books as $book)
                <div class="col-lg-4 mb-5">
                    <div class="card text-center rounded-lg" >
                        <img class="card-img-top" src="/images/{{$book->book_img}}" alt="Card image">
                        <div class="card-body">
                            <h6 class="card-title">{{$book->book_title}}</h6>
                            <a href="{{ route('user.bookdetail', $book->book_id) }}" class="btn btn-primary">{{trans('user.books.showone')}}</a>
                            @if($book->quantity > 0)
                                <a href="/request/create/{{$book->book_id}}" class="btn btn-primary">{{trans('user.books.borrow')}}</a>
                            @else
                                <p class="no-book">{{trans('user.books.nobook')}}</p>
                            @endif
                            <a href="#" class="btn btn-primary">{{trans('user.books.like')}}</a>
                        </div>
                    </div>
                </div>   
            @endforeach
        </div>
        {{$books->links()}}
    </div>
@endsection
