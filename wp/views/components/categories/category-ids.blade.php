@env('local')
    {{-- {!! \Vendorpath\Wp\Esi\Navbars\NavbarEsi::esi()->getContent() !!} --}}
    <p>/esi/category/{{$slug}}</p>
@else
    <esi:include src="/esi/category/" />
@endenv