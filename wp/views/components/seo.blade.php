@props(['data' => []])

@php
    $title = $data['seo_title'] ?? $data['name'] ?? 'Trang chủ';
    $description = $data['seo_description'] ?? '';
    $url = request()->url();
    $siteName = config('app.name', 'Tên Website');
    $homeUrl = url('/');

    // Xử lý URL ảnh tuyệt đối
    $imagePath = $data['seo_image'] ?? asset('images/default-share.jpg');
    $image = str_starts_with($imagePath, 'http') ? $imagePath : url($imagePath);
    $imageAlt = $data['featured_image_alt'] ?? $title;
@endphp

{{-- 1. SEO Meta cơ bản --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="{{ $url }}" />

{{-- 2. Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:alt" content="{{ $imageAlt }}">

{{-- 3. Twitter (Sử dụng 'name' thay vì 'property' cho chuẩn cũ) --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
<meta name="twitter:image:alt" content="{{ $imageAlt }}">

{{-- 4. Structured Data JSON-LD (@graph giúp gộp nhiều thực thể) --}}
@php
    $schema = [
        "@context" => "https://schema.org",
        "@graph" => [
            // Breadcrumb: Giúp hiện "Trang chủ > Tên danh mục" trên Google
            [
                "@type" => "BreadcrumbList",
                "itemListElement" => [
                    [
                        "@type" => "ListItem",
                        "position" => 1,
                        "name" => "Trang chủ",
                        "item" => $homeUrl
                    ],
                    [
                        "@type" => "ListItem",
                        "position" => 2,
                        "name" => $data['name'] ?? $title,
                        "item" => $url
                    ]
                ]
            ],
            // CollectionPage: Định nghĩa thực thể chính của trang
            [
                "@type" => "CollectionPage",
                "@id" => $url . "#collectionpage",
                "url" => $url,
                "name" => $title,
                "description" => $description,
                "image" => [
                    "@type" => "ImageObject",
                    "url" => $image,
                    "caption" => $imageAlt
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "@id" => $homeUrl . "#organization",
                    "name" => $siteName,
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => asset('logo.png')
                    ]
                ],
                "mainEntity" => [
                    "@type" => "ItemList",
                    "itemListElement" => [
                        [
                            "@type" => "ListItem",
                            "position" => 1,
                            "name" => $data['name'] ?? $title,
                            "item" => $url
                        ]
                    ]
                ]
            ]
        ]
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>