@unless ($breadcrumbs->isEmpty())

<div class="row">
    <div class="col-md-12">
        <div class="breadcrumb">
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
    </div>
</div>

@endunless
