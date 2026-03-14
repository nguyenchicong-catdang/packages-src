@props(['slug' => []])
@if ($slug)
    @env('local')
        {{-- {!! \Vendorpath\Wp\Esi\Categories\CategoryEsiIds::esi($slug) !!} --}}
        <p>/esi/{{ $slug }}</p>
    @else
        <esi:include src="/esi/{{ $slug }}" />
    @endenv
@else
<p>Bài viết sẽ được cập nhật sau</p>
@endif
