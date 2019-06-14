@component('client-emails.template-1.layout')
    {{-- Header --}}
    @slot('header')
        @component('client-emails.template-1.header',['header_image'=>$header_image])
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Footer --}}
    @slot('footer')
        @component('client-emails.template-1.footer', ['footer_caption'=>$footer_caption, 'footer_link'=>$footer_link, 'footer_email'=>$footer_email])
        @endcomponent
    @endslot
@endcomponent
