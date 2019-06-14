@component('client-email.layout.layout')
    {{-- Header --}}
    @slot('header')
        @component('client-email.header.header',['header_image'=>$header_image])
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Footer --}}
    @slot('footer')
        @component('client-email.footer.footer', ['footer_caption'=>$footer_caption, 'footer_link'=>$footer_link, 'footer_email'=>$footer_email])
        @endcomponent
    @endslot
@endcomponent
