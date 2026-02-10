<?php

namespace Vendorpath\Wp\Posts;

use Corcel\Model\Post;

class PostLoader extends Post
{
    protected $connection = 'wordpress';
    protected $appends = ['featured_src'];

    

    public function getPost($slug)
    {
        return self::status('publish')
            ->where('post_name', $slug)
            ->with(['thumbnail']) // "Tối thượng": Load Post -> Load Ảnh -> Load toàn bộ Meta của ảnh
            ->firstOrFail();
    }

}