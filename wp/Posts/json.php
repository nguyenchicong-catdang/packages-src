<script type="application/ld+json">
    {
        !!$post - > yoast_schema_json!!
    }
</script>

public function getYoastSchemaJsonAttribute()

{

    // Giả sử bạn đã query dòng "edit3" và lưu vào biến $indexable

    $indexable = \DB::connection('wordpress')

        ->table('wp_yoast_indexable')

        ->where('object_id', $this->ID)

        ->first();



    if (!$indexable) return null;



    $imageMeta = json_decode($indexable->open_graph_image_meta, true);



    // Lắp ghép thành cấu trúc JSON-LD y hệt Yoast

    $schema = [

        "@context" => "https://schema.org",

        "@graph" => [

            [

                "@type" => "Article",

                "@id" => $indexable->permalink . "#article",

                "headline" => $indexable->title ?? $this->post_title,

                "description" => $indexable->description,

                "image" => [

                    "@type" => "ImageObject",

                    "url" => asset($indexable->open_graph_image),

                    "width" => $imageMeta['width'] ?? 960,

                    "height" => $imageMeta['height'] ?? 1280

                ],

                "datePublished" => $indexable->object_published_at,

                "dateModified" => $indexable->object_last_modified,

                "author" => [

                    "name" => "admin" // Bạn có thể lấy từ bảng users

                ]

            ]

        ]

    ];



    return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

}