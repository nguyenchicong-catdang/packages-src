@env('local')
    {!! \Vendorpath\Wp\Esi\Navbars\NavbarEsi::esi()->getContent() !!}
@else
    <esi:include src="/esi/navbar" />
@endenv