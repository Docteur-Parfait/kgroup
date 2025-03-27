<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <img src="{{ asset('storage/qrcodes/' . $getState() . '.svg') }}" class="h-32" alt="QR Code">
    </div>
</x-dynamic-component>
