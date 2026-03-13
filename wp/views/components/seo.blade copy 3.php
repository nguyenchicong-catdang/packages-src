@props(['data' => []])

@php
    $title = $data['seo_title'] ?? $data['name'] ?? 'Trang chủ';
    $description = $data['seo_description'] ?? '';
    $url = request()->url();
    // Đảm bảo URL ảnh là tuyệt đối và không bị lỗi nếu là path tương đối
    $imagePath = $data['seo_image'] ?? asset('images/default-share.jpg');
    $image = str_starts_with($imagePath, 'http') ? $imagePath : url($imagePath);
    $siteName = config('app.name', 'Tên Website');
@endphp

{{-- SEO Meta Tags --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:site_name" content="{{ $siteName }}"> {{-- Bổ sung --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:alt" content="{{ $data['featured_image_alt'] ?? $title }}"> {{-- Tốt cho SEO ảnh --}}

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
<meta name="twitter:image:alt" content="{{ $data['featured_image_alt'] ?? $title }}"> {{-- Tốt cho SEO ảnh --}}

{{-- Structured Data JSON-LD --}}
@php
    $jsonLd = [
        "@context" => "https://schema.org",
        "@type" => "CollectionPage",
        "name" => $title,
        "description" => $description,
        "url" => $url,
        "image" => $image, // BỔ SUNG TRƯỜNG ẢNH VÀO ĐÂY
        "publisher" => [
            "@type" => "Organization",
            "name" => $siteName,
            "logo" => [
                "@type" => "ImageObject",
                "url" => asset('logo.png') // Nên có logo tổ chức
            ]
        ],
        "mainEntity" => [
            "@type" => "ItemList",
            "itemListElement" => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => $data['name'] ?? 'Category',
                    "item" => $url,
                ]
            ]
        ]
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>