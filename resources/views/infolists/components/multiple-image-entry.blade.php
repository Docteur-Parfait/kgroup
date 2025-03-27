<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
        @if ($getRecord()->pictures != null)
            @foreach ($getRecord()->pictures as $image)
                <a href="{{ asset("storage/$image") }}" class="p-3">
                    <img class="h-auto max-w-full rounded-lg" src="{{ asset("storage/$image") }}" alt="Gallery image" />
                </a>
            @endforeach
        @endif




    </div>
</x-dynamic-component>
