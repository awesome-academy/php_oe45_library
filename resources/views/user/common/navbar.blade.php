<ul class="nav justify-content-center nav-pills" id="navbar-user">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('user.books') }}">{{ trans('user.books.allbooks') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('request.index', Auth::id()) }}">{{ trans('user.books.borrows') }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">{{ trans('user.books.booksliked') }}</a>
    </li>
</ul>
