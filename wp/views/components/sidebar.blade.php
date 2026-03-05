@env('local')
    {!! \Vendorpath\Wp\Esi\Sidebars\SidebarEsi::esi()->getContent() !!}
@else
    <esi:include src="/esi/sidebar" />
@endenv