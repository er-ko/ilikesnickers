<x-app-layout>

    <x-slot name="meta_title">{{ __('messages.customers') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.customers') }}</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight text-gray-800 dark:text-gray-200">
                {{ __('messages.customers') }}
            </h2>
            <a href="{{ route('customer.create') }}" target="_self" class="px-2 text-teal-600 hover:text-teal-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                @if ($customers->isEmpty())
                    <p class="py-4 italic text-center font-light lowercase dark:text-gray-400">{{ __('messages.no_customers') }}</p>
                @else
                    <div class="overflow-auto">
                        <table class="table-auto w-full text-sm">
                            <thead>
                                <tr class="lowercase bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                                    <th class="px-2 pt-4 pb-2 text-center sm:rounded-tl-lg">#</th>
                                    <th class="px-2 pt-4 pb-2 text-left">{{ __('messages.email') }}</th>
                                    <th class="px-2 pt-4 pb-2 text-left">{{ __('messages.group') }}</th>
                                    <th class="px-2 pt-4 pb-2 sm:rounded-tr-lg"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $customer)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 transition duration-400">
                                    <td class="p-2 w-20 min-w-20 text-center">{{ $customer->id }}</td>
                                    <td class="p-2 whitespace-nowrap">{{ $customer->email }}</td>
                                    <td class="p-2 whitespace-nowrap w-40 min-w-40">{{ $customer->group_name }}</td>
                                    <td class="p-2 w-24 min-w-24 text-center">
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="inline-block text-gray-300 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300 transition duration-400 relative top-0.5 mx-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('customer.destroy', $customer->id) }}" class="inline-block relative top-0.5" x-data>
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
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>