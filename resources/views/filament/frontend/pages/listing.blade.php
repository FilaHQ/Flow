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
        @php
        $tags = $post->terms('series')
        ->get();
        @endphp
        @foreach($tags as $term)
        @if (isset($term->taxo->options['route']))
                        <x-filament::link :href="$term->url" size="md">
                            {{$term->name}}
                        </x-filament::link>
                    @else
                        <x-filament::link size="md">
                            {{$term->name}}
                        </x-filament::link>
                    @endif
        @endforeach
        <br>
    {{ $post->content }}
    <br>
        @php
        $tags = $post->terms('tags')
                    ->get();
        @endphp
        @foreach($tags as $term)
    <x-filament::link size="sm">
        #{{$term->name}}
    </x-filament::link>
        @endforeach
</x-filament::section>
</a>
@endforeach
<div class="mt-2">
<x-filament::pagination :paginator="$posts" />
</div>
@endif
</x-filament-panels::page>
