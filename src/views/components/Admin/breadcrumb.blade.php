@once
    @prepend('css')
        <style>
            .breadcrumb {
                padding: 20px 0;
                font-weight: 600;
                font-size: 0.9em;
            }

            .breadcrumb .breadcrumb-link {
                color: var(--prime);
                text-decoration: none;
            }

            .breadcrumb .breadcrumb-link::after {
                content: '/';
                padding: 0 5px;
            }

            .page_title {
                font-size: 2.6rem;
                color: var(--prime_text);
            }

            .page_desc {
                margin-top: 7px;
                font-size: 0.9em;
                color: var(--sec_text);
            }
        </style>
    @endprepend
@endonce
<div class="page_details">
    <h1 class="page_title">{{ $current['page_title'] ?? 'Dashboard'}}</h1>
    @isset($pageDesc)
        <h6 class="page_desc">{{ $pageDesc }}</h6>
    @endisset
    <div class="breadcrumb">
        <a href="{{ url('') }}" class="breadcrumb-link">Home</a>
        @for ($i = 0; $i < count($path) - 1; $i++)
            <a href="{{ $path[$i]['link'] }}" class="breadcrumb-link">
                {{ ucfirst($path[$i]['title']) }}
            </a>
        @endfor
        <span class="breadcrumb-stop">{{ ucfirst($path[count($path) - 1]['title']) }}</span>
    </div>
</div>
