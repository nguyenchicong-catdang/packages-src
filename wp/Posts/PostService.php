<?php
// Posts/PostService.php
namespace Vendorpath\Wp\Posts;

class PostService
{

    public function toArray($slug)
    {
        // 1. Lấy dữ liệu Post (đã kèm theo quan hệ 'yoast' nhờ with() trong PostLoader)
        $postModel = app(PostLoader::class)->getPost($slug);

        // 2. Chuyển đổi sang Data Object (nếu cần)
        $postData = PostData::fromModel($postModel);

        // 3. Lấy Schema JSON trực tiếp từ model đã load
        // Laravel tự hiểu 'yoast_schema_json' sẽ gọi hàm 'getYoastSchemaJsonAttribute'
        // $yoastSchema = $postModel->yoast_schema_json;

        return [
            'post'   => $postModel,
            'data' => $postData
            // 'schema' => $yoastSchema // Decode nếu bạn muốn trả về object thay vì string

            // 'yoastSchema' => $yoastSchema,
            // 'schema' => json_decode($yoastSchema) // Decode nếu bạn muốn trả về object thay vì string
        ];
    }

    // public function toArray($slug)
    // {
    //     $data = app(PostLoader::class)->getPost($slug);
    //     return [
    //         'title' => $data?->title,
    //         'content' => $data?->content,
    //         'excerpt' => $data?->excerpt,
    //         'thumbnail_src' => $data?->thumbnail->attachment->url,
    //         'thumbnail_alt' =>$data?->thumbnail->attachment->alt
    //     ];
    // }
    // PostService.php
    // public function toArray($slug)
    // {
    //     $data = app(PostLoader::class)->getPost($slug);

    //     // Thử lấy thumbnail qua quan hệ đã được load sẵn
    //     // $thumb = $post->thumbnail;
    //     $post = PostData::fromModel($data);
    //     $yoast_schema_json = app(PostLoader::class)->getYoastSchemaJsonAttribute();

    //     return ['post' => $post];

    //     // return [
    //     //     'title'   => $post->title,
    //     //     'content' => $post->content,
    //     //     // Dùng phương thức getMeta để tận dụng collection 'meta' đã load
    //     //     'thumbnail_src' => $thumb?->attachment?->url,
    //     //     'thumbnail_alt' => $thumb?->attachment?->alt,
    //     // ];
    // }

    // public function toArray($slug)
    // {
    //     $post = app(PostLoader::class)->getPost($slug);

    //     // 1. Lấy thumbnail_id từ Meta đã load sẵn (không tốn thêm query)
    //     $thumbnailId = $post->meta->_thumbnail_id;

    //     // 2. Tìm Attachment (Bạn có thể dùng Model Attachment của Corcel hoặc Post)
    //     // Nếu bạn muốn giảm query tuyệt đối, hãy cân nhắc cache hoặc chỉ load khi cần.
    //     $thumbnail = \Corcel\Model\Attachment::with('meta')->find($thumbnailId);

    //     return [
    //         'title'   => $post->title,
    //         'content' => $post->content,
    //         'thumbnail_src' => $thumbnail?->url,
    //         'thumbnail_alt' => $thumbnail?->meta?->_wp_attachment_image_alt,
    //     ];
    // }
}