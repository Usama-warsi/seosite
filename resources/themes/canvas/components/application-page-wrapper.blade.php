<x-canvas-layout>
<div class="flex items-center space-x-4 py-5 lg:py-6"> </div>
    {{ $slot }}
    @if (!Widget::group('pages-sidebar')->isEmpty())
        <x-slot name="sidebar">
            <x-application-sidebar>
                @widgetGroup('pages-sidebar')
            </x-application-sidebar>
        </x-slot>
    @endif
</x-canvas-layout>
