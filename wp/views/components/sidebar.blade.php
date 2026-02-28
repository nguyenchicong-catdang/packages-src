@env('nginx')
    {{-- Trả về thẻ kỹ thuật cho Ngĩn Server --}}
        <!-- #include virtual="/esi/sidebar" -->
@else
        {{-- Trả về thẻ kỹ thuật cho Cache Server --}}
    <esi:include src="/esi/sidebar" />
@endenv
@env('local')
    {{-- Render trực tiếp component gốc --}}
    <x-wp-compName::sidebar-component />
@endenv
