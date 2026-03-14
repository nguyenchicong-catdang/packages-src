@props(['slug' => ''])
@env('local')
    {!! \Vendorpath\Wp\Esi\Categories\CategoryEsiIds::esi($slug) !!}
@else
    <esi:include src="/esi/category/{{$slug}}" />
@endenv