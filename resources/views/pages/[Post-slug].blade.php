<x-layout>
<div class="bg-white px-6 py-32 lg:px-8">
  <div class="mx-auto max-w-3xl text-base/7 text-gray-700">
    <p class="text-base/7 font-semibold text-indigo-600">{{ $post->published_at->format('M d, Y') }}</p>
    <h1 class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">{{ $post->title}}</h1>
    <p class="mt-6 text-xl/8">{{ $post->content}}</p>
  </div>
</div>
</x-layout>
