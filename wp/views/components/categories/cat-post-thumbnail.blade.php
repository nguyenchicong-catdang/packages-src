{{-- {{ debug($thumbnail) }} --}}
<img src="{{ $thumbnail->src }}" srcset="{{ $thumbnail->srcset }}" sizes="{{ $thumbnail->sizes }}"
    alt="{{ $thumbnail->alt }}" loading="lazy" class="object-cover">
