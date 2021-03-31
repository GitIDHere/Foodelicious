@unless ($breadcrumbs->isEmpty())

<div class="row white-bk breadcrumb pt-0 pb-5">
    <ul>
        @foreach ($breadcrumbs as $breadcrumb)

            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ul>
</div>

@endunless