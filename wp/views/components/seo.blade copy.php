@props(['data' => []])

@php
    $title = $data['seo_title'] ?? $data['name'] ?? 'Trang chủ';
    $description = $data['seo_description'] ?? '';
    $url = request()->url();
    $image = $data['og_image'] ?? asset('images/default-share.jpg');
@endphp

{{-- SEO Meta Tags --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}" />

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

{{-- Twitter --}}
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">

{{-- Structured Data JSON-LD --}}
@php
    $jsonLd = [
        "@context" => "https://schema.org",
        "@type" => "CollectionPage",
        "name" => $data['name'] ?? '',
        "description" => $data['seo_description'] ?? '',
        "url" => request()->url(),
        "mainEntity" => [
            "@type" => "ItemList",
            "itemListElement" => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => $data['name'] ?? 'Category',
                    "item" => request()->url(),
                ]
            ]
        ]
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>