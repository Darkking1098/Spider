@if (class_exists(App\Models\Webpage::class))
    @inject('meta', App\Models\Webpage::class)
    @php
        $slug = substr(request()->getPathInfo(), 1);
        if (strlen($slug) > 0 && $slug[-1] == '/') {
            $slug = substr($slug, 0, -1);
        }
        $universal = $meta::where('webpage_slug', '*')->first();
        $data = $meta::where('webpage_slug', $slug)->first();
    @endphp
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    {{-- browser support meta tags --}}
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Developer Attribute --}}
    <meta author="Ajay Kumar" />
    <meta designer="Ajay Kumar" />
    <meta developer="Ajay Kumar" />
    @if (is_file(public_path('manifest.json')))
        {{-- Manifest --}}
        <link rel="manifest" href="{{ url('manifest.json') }}" />
    @endif
    @if ($data['canonical_url'] ?? '')
        {{-- Canonical Tag --}}
        <link rel="canonical" href="{{ $data['canonical_url'] }}" />
    @endif
    {{-- Title Tag for website --}}
    <title>{{ $data['webpage_title'] ?? '' ?: $title ?? ($universal['webpage_title'] ?? '') ?: 'Page Title' }}</title>
    {{-- Meta Keywords --}}
    <meta name="keywords"
        content="{{ $data['webpage_keywords'] ?? '' ?: $keywords ?? ($universal['webpage_keywords'] ?? '') ?: 'Page Keywords' }}" />
    {{-- Meta Description --}}
    <meta name="description"
        content="{{ $data['webpage_desc'] ?? '' ?: $description ?? ($universal['webpage_desc'] ?? '') ?: 'Page Description' }}" />
    {{-- Other Meta tags that are usesd on all pages --}}
    {!! $universal['webpage_other_meta'] ?? ($data['webpage_other_meta'] ?? '') !!}
    {{-- If page has specific Meta Tags --}}
    @stack('meta')
    {{-- html page Theme Color --}}
    <meta name="theme-color" content="#002346" />
    {{-- html page icons --}}
    <link rel="icon" href="{{ config('app.app_logo_white') }}"" type="imagepng" />
    <link rel="apple-touch-icon" href="{{ config('app.app_logo_white') }}" />
    {{-- Stacking css --}}
    @yield('styles')
</head>

@yield('body')

</html>
