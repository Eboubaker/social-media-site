@php($atts=$attributes->getAttributes())
<div class="scroll-view-container {{ $atts['class'] }}">
    <x-chevron :innerColor="$atts['chevron-inner-color']??null" :class="$atts['chevron-class']??null" />
    <div class="scroll-view @isset($atts['auto-scroll'])auto-scroll @endisset">
        <div class="flex view-slide">
            {{ $slot }}
        </div>
    </div>
    <x-chevron :innerColor="$atts['chevron-inner-color']??null" dir="right" :class="$atts['chevron-class']??null" />
</div>