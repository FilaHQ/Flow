
<div>
    @php
        $posts = $getRecord()->get();

@endphp
    <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        @foreach($posts as $post)

      <li class="relative">
        <div class="group overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
          <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80" alt="" class="pointer-events-none aspect-[16/9] object-cover group-hover:opacity-75">
          <button type="button" class="absolute inset-0 focus:outline-none">
            <span class="sr-only">123</span>
          </button>
        </div>
        <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900">{{ $post->title}}</p>
        <p class="pointer-events-none block text-sm font-medium text-gray-500">{{$post->published_at->format('d-m-Y')}}</p>
      </li>
        @endforeach

      <!-- More files... -->
    </ul>
</div>
