<div class="flex flex-col gap-4">
    @foreach ($posts as $post)
    <div class="max-w-4xl px-6 my-4 py-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="h-full flex items-center justify-between">
            <span class="font-light dark:text-gray-300">{{$post->created_at->diffForHumans()}}</span>
            <div class="flex items-end gap-2">
                @foreach ($post->tags as $tag)
                <a class="px-2 py-1 bg-gray-500 dark:text-gray-300 font-bold rounded" href="#">{{$tag->name}}</a>
                @endforeach
            </div>
        </div>
        <div class="mt-2">
            <a class="text-2xl dark:text-gray-300 font-bold hover:text-gray-600" href="#">{{$post->title}}</a>
            <p class="mt-2 dark:text-gray-500">{{$post->content}}</p>
        </div>
        <div class="flex justify-between items-center mt-4">
            <a class="dark:text-blue-300 hover:underline" href="#">Read more</a>
            <div>
                <a class="flex items-center gap-2" href="#">
                    <img class="w-10 h-10 object-cover rounded-full hidden sm:block" src="{{$post->author->profile_photo_path}}" alt="avatar">
                    <h1 class="font-bold dark:text-gray-500">{{$post->author->name}}</h1>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
