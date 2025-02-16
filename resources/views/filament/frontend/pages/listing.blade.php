<x-filament-panels::page>
@if($posts)
@foreach($posts as $post)
<a href="{{ $post->url }}" class="block">
<x-filament::section  aside>
    <x-slot name="heading">
        {{ $post->title }}
    </x-slot>

    <x-slot name="description">
        {{ $post->published_at->format('F j, Y') }}
    </x-slot>
    {{ $post->content }}
    <br>
</x-filament::section>
</a>
@endforeach
<div class="mt-2">
<x-filament::pagination :paginator="$posts" />
</div>
@endif
</x-filament-panels::page>
