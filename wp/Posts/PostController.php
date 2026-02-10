<?php
// Pots/PostController.php
namespace Vendorpath\Wp\Posts;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function show($slug, PostService $service)
    {
        $data = $service->toArray($slug);
        return view('wp-view::post', $data);
    }
}