@php
$collection = [
    [
        'label' => 'Index',
        'slug' => '/'
    ],
    [
        'label' => 'Test Dev fe',
        'slug' => '/fe/test'
    ],
    [
        'label' => 'Dev Fe Category Slug',
        'slug' => '/fe/category/slug'
    ],
    [
        'label' => 'Dev Fe Post Slug',
        'slug' => '/fe/post/slug'
    ],
]
@endphp
<div class="list-group">
    <hr>
    @foreach ($collection as $item)
      <a href="{{$item['slug']}}" class="list-group-item list-group-item-action list-group-item-danger">{{$item['label']}}</a>
    @endforeach
    <hr>
</div>