<!DOCTYPE html>
<head>
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{ asset('css/style.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('css/morris.css') }}" type="text/css"/>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/jsgrid.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/noti.css') }}">

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ mix('js/jquery2.0.3.min.js') }}"></script>
<script src="{{ mix('js/raphael-min.js') }}"></script>
<script src="{{ mix('js/morris.js') }}"></script>
<script src="{{ mix('js/pusher.js') }}"></script>
<script type="text/javascript" src="{{asset('js/ajax.js')}}"></script>

</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="#" class="logo">
        {{ trans('message.admin') }}
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm nav pull-right top-menu">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    {{ trans('message.language') }}
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('lang', ['lang' => 'en']) }}">{{ trans('message.english') }}</a>
                                    <a class="dropdown-item" href="{{ route('lang', ['lang' => 'vi']) }}">{{ trans('message.vietnamese') }}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ trans('message.login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ trans('message.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown dropdown-notifications">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-bell notification-icon"></i>
                                <span class="badge badge-light" id="count-notification">{{Auth::user()->unreadNotifications->count()}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right menu-notification" aria-labelledby="navbarDropdown">
                                <div class="menu-body">
                                    @for ($i = 0; $i < config('app.limit_notifications') ; $i++)
                                         @if (isset(Auth::user()->notifications[$i]))
                                             <a class="dropdown-item card notification-item" href="{{Auth::user()->notifications[$i]->data['link']}}">
                                                 <h5 class="card-title">{{Auth::user()->notifications[$i]->data['title']}}</h5>
                                                  <p class="card-text">{{Auth::user()->notifications[$i]->data['content']}}</p>
                                                 <p class="card-text">{{Auth::user()->notifications[$i]->data['time']}}</p>
                                             </a>
                                         @endif
                                     @endfor 
                                 </div>
                                 <a type="button" class="dropdown-item text-center bg-info" id="all" data-toggle="modal" data-target="#myModal">
                                     <p class="card-text all-text" >{{ trans('message.viewall') }}</p>
                                 </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ trans('message.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                   <h4 class="modal-title">{{ trans('message.allnoti') }}</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                @foreach (Auth::user()->notifications as $noti)
                    <a class="dropdown-item notification-item card mb-2" href="{{$noti->data['link']}}">
                        <h5 class="card-title">{{$noti->data['title']}}</h5>
                        <p class="card-text">{{$noti->data['content']}}</p>
                        <p class="card-text">{{$noti->data['time']}}</p> 
                    </a>
                @endforeach
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('message.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li class="sub-menu">
                    <a href="{{ route('charts.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>{{ trans('message.charts') }}</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('categories.index') }}">
                        <i class="fas fa-align-center"></i>
                        <span>{{ trans('message.categories') }}</span>
                    </a>
                </li>
				<li class="sub-menu">
                    <a href="{{ route('books.index') }}">
                        <i class="fa fa-book"></i>
                        <span>{{ trans('message.books') }}</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('authors.index') }}">
                        <i class="fas fa-pen-nib"></i>
                        <span>{{ trans('message.authors') }}</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('publishers.index') }}" class="nav-link">
                        <i class="fas fa-building"></i>
                        <span>{{ trans('message.publishers') }}</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-user"></i>
                        <span>{{ trans('message.users') }}</span>
                    </a>
                </li>
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fas fa-question"></i>
                        <span>{{ trans('message.borrows_management') }}</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{ route('user_request.index', ['borrow_status' => config('app.both')]) }}">{{ trans('message.all') }}</a></li>
						<li><a href="{{ route('user_request.index', ['borrow_status' => config('app.approved')]) }}">{{ trans('message.approved') }}</a></li>
                        <li><a href="{{ route('user_request.index', ['borrow_status' => config('app.unapproved')]) }}">{{ trans('message.non_approved') }}</a></li>
                        <li><a href="{{ route('user_request.index', ['borrow_status' => config('app.rejected')]) }}">{{ trans('message.reject') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
       @yield('content')
    </section>
       @yield('javascript')
</section>
<!--main content end-->
</section>
<script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>

<script type="text/javascript">
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
    encrypted: true,
    cluster: "ap1",
    });
    var channel = pusher.subscribe("NotificationEvent");
    channel.bind("send-message", function (data) {
        var newNotificationHtml = `
        <a class="dropdown-item card" href="${data.link}">
            <h5 class="card-title">${data.title}</h5>
            <p class="card-text">${data.content}</p>
            <p class="card-text">${data.time}</p>
        </a>
        `;
        $(".menu-body").prepend(newNotificationHtml);
        $(".modal-body").prepend(newNotificationHtml);
        count = count + 1;
        document.getElementById("count-notification").innerHTML = count;
    });

    var count = {{ Auth::user()->unreadNotifications->count() }};

    $("#navbarDropdown").click(function () {
        count = 0;
        document.getElementById("count-notification").innerHTML = count;
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "/notification",
            method: "POST",
            data: { _token: _token },
            success: function (data) {},
        });
    });
</script>

<script src="{{ mix('js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ mix('js/scripts.js') }}"></script>
<script src="{{ mix('js/jquery.slimscroll.js') }}"></script>
<script src="{{ mix('js/jquery.nicescroll.js') }}"></script>

</body>
</html>
