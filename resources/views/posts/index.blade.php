@auth

<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.posts') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.posts') }}</x-slot>
    <x-slot name="title">{{ __('messages.blog') }}</x-slot>

    <x-slot name="submit">
        <a href="{{ route('post.create') }}" class="p-2.5 pl-4 duration-300 shadow rounded-l-full bg-teal-600 text-white hover:bg-teal-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    </x-slot>

    <div class="p-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        @if ($posts->isEmpty())
            <p class="py-4 italic text-center font-light dark:text-gray-400">create your first post with something valuable</p>
        @else
            <div class="overflow-auto">
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="lowercase bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                            <th class="px-2 pt-4 pb-2 text-center sm:rounded-tl-lg">#</th>
                            <th class="px-2 pt-4 pb-2 text-left">{{ __('messages.title') }}</th>
                            <th class="px-2 pt-4 pb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>
                            </th>
                            <th class="px-2 pt-4 pb-2">{{ __('messages.public') }}</th>
                            <th class="px-2 pt-4 pb-2 sm:rounded-tr-lg"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 transition duration-400">
                            <td class="p-2 w-20 min-w-20 text-center">{{ $post->id }}</td>
                            <td class="p-2 whitespace-nowrap">{{ $post->title }}</td>
                            <td class="p-2 w-28 min-w-28 text-center">{{ date(request()->session()->get('date_format'), strtotime($post->created_at)) }}</td>
                            <td class="p-2 w-16 min-w-16 text-center">
                                @if($post->public)
                                    <span class="inline-flex p-1 rounded-full bg-teal-500/20 text-teal-800 dark:bg-teal-500/50 dark:text-teal-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>                                              
                                    </span>
                                @else
                                <span class="inline-flex p-1 rounded-full bg-pink-500/20 text-pink-800 dark:bg-pink-500/50 dark:text-pink-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </span>
                                @endif
                            </td>
                            <td class="p-2 w-24 min-w-24 text-center">
                                <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="inline-block text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300 transition duration-400 relative top-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('post.edit', $post->id) }}" class="inline-block text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300 transition duration-400 relative top-0.5 mx-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('post.destroy', $post->id) }}" class="inline-block relative top-0.5" x-data>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-pink-600" @click="if(!confirm('{{ __('messages.alert.are_you_sure') }}?')) $event.preventDefault()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        {{ $posts->links() }}
    </div>
</x-app-layout>

@else

<x-public-layout>

    <x-slot name="meta_title">{{ __('messages.blog') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.blog') }}</x-slot>

    <div class="w-full">
        @if ($posts->isEmpty())
            <p class="py-4 italic text-center font-light dark:text-gray-400">{{ __('messages.no_posts_to_show') }}</p>
        @else
            @foreach ($posts as $post)
                @if ($post->locale === app()->getLocale() && $post->public)
                    <div class="flex items-center justify-between flex-wrap mb-4 p-8 duration-300 shadow-sm hover:shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-white dark:border-gray-800 dark:hover:border-gray-700">
                        <div class="flex flex-col items-start justify-center">
                            <h2 class="mb-1 font-bold text-xl text-black dark:text-white">{{ $post->title_h1 }}</h2>
                            <h4 class="font-semibold text-sm text-gray-500">{{ date(request()->session()->get('date_format'), strtotime($post->created_at)) }}</h4>
                        </div>
                        <a href="{{ route('post.show', $post->slug) }}" target="_self" class="py-3 px-4 sm:rounded-lg uppercase bg-gray-100">{{ __('messages.read') }}</a>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</x-public-layout>

@endauth