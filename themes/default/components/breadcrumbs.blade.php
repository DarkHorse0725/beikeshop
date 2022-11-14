@unless ($breadcrumbs->isEmpty())
    <nav aria-label="breadcrumb" class="d-none d-md-block">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)

                @if (isset($breadcrumb['url']) && $breadcrumb['url'])
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
