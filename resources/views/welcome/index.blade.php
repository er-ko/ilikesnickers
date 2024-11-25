<x-public-layout>

    <x-slot name="meta_title">{{ isset($data->meta_title) ? $data->meta_title : __('welcome') }}</x-slot>
	<x-slot name="meta_desc">{{ isset($data->meta_description) ? $data->meta_description : __('welcome') }}</x-slot>

    <div class="w-full h-full flex flex-col items-center justify-center">

        @if (isset($data->title))
            <div class="w-full mb-8 font-bold text-center">
                {{ $data->title }}    
            </div>
        @endif
        
        @if ($content_status == 1 && $content_priority == 1)
            <div class="w-full text-center">
                {!! $data->content !!}
            </div>
        @endif
        
        @if ($slider_status == 1)
            <div class="w-full flex flex-col items-center justify-center {{ $slider_priority == 1 ? 'mb-8' : 'mt-8' }}">
                @if ($sliders)
                    <div class="carousel w-full" data-flickity='{ "freeScroll": true, "wrapAround": true }'>
                        @foreach ($sliders as $slider)
                            <div class="carousel-cell">
                                <img src="{{ asset('/storage/welcomes/'. $slider->file) }}" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        @if ($content_status == 1 && $content_priority == 2)
            <div class="w-full text-center">
                {!! $data->content !!}
            </div>
        @endif

    </div>

    @push('slotscript')
		<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    @endpush
</x-public-layout>
