@inject('WebImage', Vector\Spider\Http\Controllers\BaseControllers\SEOBase::class)
@php
    $image = $WebImage::get_image($src);
    $css = '';
    $s = $image['webimage_slug'];
    foreach ($image['webimage_srcset'] as $theme => $varients) {
        foreach ($varients as $varient => $filename) {
            $temp="";
            $url = url("webimage/$theme/$varient/" . $image['webimage_slug']);
            $temp = ($theme == 'default' ? '' : ":root[data-theme='$theme'] ") . ".img_wrap #img_$s {content: url(\"$url\");}";
            $css .= $varient != 'default' ? ("@container (max-width:{$varient}px) { $temp }") : $temp;
        }
    }
@endphp
@push('css')
    <style>
        {!! $css !!}
    </style>
@endpush
<div class="img_wrap">
    <img src="{{ url('webimage/default/default/' . $image['webimage_slug']) }}" alt=""
    id="img_{{ $image['webimage_slug'] }}">
</div>
