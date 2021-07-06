<div class="leftside-navigation">
    <ul class="sidebar-menu" id="nav-accordion"> 
        @foreach($categories as $category)               
        <li class="sub-menu">
            <a href="javascript:;">
                {{ $category->cate_name }}
            </a>
            @include('user.common.childcate', ['category' => $category])
        </li>
        @endforeach
    </ul>
</div>
