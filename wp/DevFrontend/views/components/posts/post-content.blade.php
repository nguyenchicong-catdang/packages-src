@mock('post_content')
@if (!isset($data))
    {{debug($data ?? 'null: Data post_content')}}
@else
    {{-- {{debug($data)}} --}}
    <div class="container">

        {!! htmlspecialchars_decode($data) !!}
    </div>
@endif