<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.languages') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.language') }}</x-slot>
    <x-slot name="title">{{ __('messages.language') }}</x-slot>

    <div class="flex flex-wrap xl:space-x-4">
        <div class="w-full xl:max-w-[300px] h-fit mb-4 xl:mb-0 py-6 px-2 sm:p-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <form method="POST" action="{{ route('language.index') }}">
                @csrf
                @method('patch')
                <div class="mb-4">
                    <x-input-label for="locale">{{ __('messages.change') }}</x-input-label>
                    <x-select id="locale">
                        @foreach ($languages as $language)
                            @if ($language->public)
                                <option value="{{ $language->locale }}" {{ $language->locale === app()->getLocale() ? 'selected': '' }}>{{ $language->name }}</option>
                            @endif
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('locale')" />
                </div>
                <div>
                    <x-input-label for="default">{{ __('messages.default') }}</x-input-label>
                    <x-select name="default" id="default">
                        @foreach ($languages as $language)
                            @if ($language->public)
                                <option value="{{ $language->locale }}" {{ $language->default ? 'selected': '' }}>{{ $language->name }}</option>
                            @endif
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('default')" />
                </div>
            </form>
        </div>
        <div class="flex-1 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-auto">
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="lowercase bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                            <th class="px-2 pt-4 pb-2 text-center sm:rounded-tl-lg">#</th>
                            <th class="px-2 pt-4 pb-2 text-center">{{ __('messages.flag') }}</th>
                            <th class="px-2 pt-4 pb-2 text-center">{{ __('messages.locale') }}</th>
                            <th class="px-2 pt-4 pb-2 text-left">{{ __('messages.name') }}</th>
                            <th class="px-2 pt-4 pb-2">{{ __('messages.priority') }}</th>
                            <th class="px-2 pt-4 pb-2">{{ __('messages.default') }}</th>
                            <th class="px-2 pt-4 pb-2">{{ __('messages.public') }}</th>
                            <th class="px-2 pt-4 pb-2 sm:rounded-tr-lg"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($languages as $language)
                        <tr class="duration-300 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-900">
                            <td class="p-2 w-20 min-w-20 text-center">{{ $language->id }}</td>
                            <td class="p-2 w-12 min-w-12 text-center">@if ($language->flag) <img src="/storage/flags/{{ $language->flag }}" class="w-4 mx-auto" /> @endif</td>
                            <td class="p-2 w-20 min-w-20 text-center">{{ $language->locale }}</td>
                            <td class="p-2 whitespace-nowrap">{{ $language->name }}</td>
                            <td class="p-2 w-16 min-w-16 text-center">{{ $language->priority }}</td>
                            <td class="p-2 w-16 min-w-16 text-center">
                                @if($language->default)
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
                            <td class="p-2 w-16 min-w-16 text-center">
                                @if($language->public)
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
                            <td class="p-2 w-12 min-w-12 text-center">
                                <a href="{{ route('language.edit', $language->id) }}" class="inline-block duration-300 text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $languages->links() }}
        </div>
    </div>

    @push('slotscript')
        <script>
            $(document).ready(function () {
                $("#locale").change(function() {
                    window.location.href = '/locale/' + $(this).val();
                });

                $('#default').change(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('language.index') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            locale: $(this).val(),
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                });
            });
            $(document).ajaxStop(function() {
                setInterval(function() {
                    location.reload();
                }, 300);
            });
        </script>
    @endpush
</x-app-layout>