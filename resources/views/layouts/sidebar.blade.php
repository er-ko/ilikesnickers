<div class="w-full sm:min-h-screen sm:flex flex-col sm:flex-row">
	<div
		class="w-full sm:w-64 lg:w-72 flex flex-col flex-shrink-0 py-2 bg-white text-gray-900 dark:text-gray-200 dark:bg-gray-800"
		x-data="{ open: false }"
		@click.away="open = false"
	>
		<div class="flex flex-row flex-shrink-0 items-center justify-between px-8 py-8 sm:p-4 lg:px-8 lg:py-6">
			<a
				href="/"
				class="font-semibold text-lg uppercase tracking-widest text-gray-900 dark:text-white focus:outline-none focus:shadow-outline"
			>
			@auth
				{{ $title }}
			@else
				{{ $app_name }}
			@endif
			</a>
			<button class="sm:hidden" @click="open = !open">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path x-show="!open" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
					<path x-show="open" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
				</svg>
			</button>
		</div>
		<nav class="h-full sm:block px-4 sm:px-2 lg:px-4 pb-4 sm:pb-0 sm:mb-16 sm:overflow-y-auto" :class="{ 'block': open, 'hidden': !open }">
			@auth

				<x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
					{{ __('dashboard') }}
				</x-sidebar-link>
				<x-sidebar-link :href="route('task.index')" :active="request()->routeIs('task.index')">
					{{ __('task') }}
				</x-sidebar-link>
				<x-sidebar-dropdown :active="request()->routeIs([
					'page.index', 'page.create', 'page.edit',
					'post.index', 'post.create', 'post.edit',
					'faq.index', 'faq.create', 'faq.edit',
					'contact.edit'
				])">
					<x-slot name="trigger">
						<span>{{ __('pages') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-sidebar-dropdown-link :href="route('welcome.edit')">
							{{ __('welcome') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('contact.edit')">
							{{ __('contact') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('faq.index')">
							{{ __('faq') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('page.index')">
							{{ __('page') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('post.index')">
							{{ __('blog') }}
						</x-sidebar-dropdown-link>
					</x-slot>
				</x-sidebar-dropdown>
				<x-sidebar-dropdown :active="request()->routeIs([
					'product.index', 'product.create', 'product.edit',
					'category.index', 'category.create', 'category.edit',
					'product-group.index', 'product-group.create', 'product-group.edit',
					'manufacturer.index', 'manufacturer.create', 'manufacturer.edit',
					'customer.index', 'customer.create', 'customer.edit',
					'customer-group.index', 'customer-group.create', 'customer-group.edit',
				])">
					<x-slot name="trigger">
						<span>{{ __('shop') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-sidebar-dropdown-link :href="route('product.index')">
							{{ __('product') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('category.index')">
							{{ __('category') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('product-group.index')">
							{{ __('product_group') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('manufacturer.index')">
							{{ __('manufacturer') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('customer.index')">
							{{ __('customer') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('customer-group.index')">
							{{ __('customer_group') }}
						</x-sidebar-dropdown-link>
					</x-slot>
				</x-sidebar-dropdown>
				<x-sidebar-dropdown :active="request()->routeIs(['address-book.index', 'address-book.create', 'address-book.edit'])">
					<x-slot name="trigger">
						<span>{{ __('messages.accountancy') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-sidebar-dropdown-link :href="route('address-book.index')">
							{{ __('address_book') }}
						</x-sidebar-dropdown-link>
					</x-slot>
				</x-sidebar-dropdown>
				<x-sidebar-dropdown :active="request()->routeIs(['language.index', 'language.edit', 'profile.edit'])">
					<x-slot name="trigger">
						<span>{{ __('settings') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-sidebar-dropdown-link :href="route('country.index')">
							{{ __('country') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('language.index')">
							{{ __('language') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('currency.index')">
							{{ __('currency') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('system.edit')">
							{{ __('system') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('profile.edit')">
							{{ __('profile') }}
						</x-sidebar-dropdown-link>
						<x-sidebar-dropdown-link :href="route('user.index')">
							{{ __('user') }}
						</x-sidebar-dropdown-link>
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<x-sidebar-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
								{{ __('logout') }}
							</x-sidebar-dropdown-link>
						</form>
					</x-slot>
				</x-sidebar-dropdown>

			@else

				<x-sidebar-link :href="route('welcome')" :active="request()->routeIs('welcome')">
					{{ __('welcome') }}
				</x-sidebar-link>
				<x-sidebar-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">
					{{ __('contact') }}
				</x-sidebar-link>
				<x-sidebar-link :href="route('faq.index')" :active="request()->routeIs('faq.index')">
					{{ __('faq') }}
				</x-sidebar-link>
				<x-sidebar-link :href="route('booking.index')" :active="request()->routeIs('booking.index')">
					{{ __('booking') }}
				</x-sidebar-link>
				<x-sidebar-link :href="route('category.index')" :active="request()->routeIs(['category.index', 'product.show'])">
					{{ __('shop') }}
				</x-sidebar-link>
				<x-sidebar-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.show'])">
					{{ __('blog') }}
				</x-sidebar-link>

				<div class="flex sm:absolute sm:bottom-3 sm:inset-x-0 mt-8 sm:mt-0 items-center justify-center">
					@if (Route::has('login'))
						<a href="{{ route('login') }}" target="_self" class="py-3 pr-3.5 pl-5 rounded-l-full duration-300 bg-white hover:bg-gray-200 dark:bg-gray-950 dark:hover:bg-gray-900 border border-gray-200 dark:border-gray-800">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 dark:text-gray-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
							</svg>
						</a>
					@endif
					@include('components.lang-switch')
					@include('components.dark-mode')
				</div>

			@endif
		</nav>
	</div>
</div>