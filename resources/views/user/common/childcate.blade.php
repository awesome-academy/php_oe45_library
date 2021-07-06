@if($category->subCategories->count())
    <ul class="sub">
        @foreach($category->subCategories as $childcate)
        <li>
            <a href="{{ route('show_bookcategory', $childcate->cate_id) }}">
                {{ $childcate->cate_name }}
            </a>
            @if($childcate->subCategories->count())
                @include('user.common.childcate', ['category' => $childcate])
            @endif
        </li>
        @endforeach
    </ul>
@endif
