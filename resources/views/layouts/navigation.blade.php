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
				@auth {{ $title }} @else {{ $app_name }} @endif
			</a>
			<button class="sm:hidden" @click="open = !open">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path x-show="!open" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
					<path x-show="open" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
				</svg>
			</button>
		</div>
		<nav class="h-full sm:block px-4 sm:px-2 lg:px-4 pb-4 sm:pb-0 @guest sm:mb-16 @endguest sm:overflow-y-auto" :class="{ 'block': open, 'hidden': !open }">
			@auth

				<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
					{{ __('dashboard') }}
				</x-nav-link>
				<x-nav-link :href="route('task.index')" :active="request()->routeIs('task.index')">
					{{ __('task') }}
				</x-nav-link>
				<x-nav-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.create', 'post.edit'])">
					{{ __('blog') }}
				</x-nav-link>
				<x-dropdown :active="request()->routeIs([
					'welcome.edit', 'contact.edit',
					'faq.index', 'faq.create', 'faq.edit',
					'page.index', 'page.create', 'page.edit',
				])">
					<x-slot name="trigger">
						<span>{{ __('pages') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-dropdown-link :href="route('welcome.edit')" :active="request()->routeIs('welcome.edit')">
							{{ __('welcome') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('contact.edit')" :active="request()->routeIs('contact.edit')">
							{{ __('contact') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('faq.index')" :active="request()->routeIs(['faq.index', 'faq.create', 'faq.edit'])">
							{{ __('faq') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('page.index')" :active="request()->routeIs(['page.index', 'page.create', 'page.edit'])">
							{{ __('info') }}
						</x-dropdown-link>
					</x-slot>
				</x-dropdown>
				<x-dropdown :active="request()->routeIs([
					'booking.index', 'booking.edit',
					'booking.activity.index', 'booking.activity.create', 'booking.activity.edit',
					'booking.slot.index', 'booking.slot.create', 'booking.slot.edit',
				])">
					<x-slot name="trigger">
						<span>{{ __('booking') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-dropdown-link :href="route('booking.index')" :active="request()->routeIs('booking.index')">
							{{ __('booked') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('booking.activity.index')" :active="request()->routeIs(['booking.activity.index', 'booking.activity.create', 'booking.activity.edit'])">
							{{ __('activity') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('booking.slot.index')" :active="request()->routeIs(['booking.slot.index', 'booking.slot.create', 'booking.slot.edit'])">
							{{ __('slot') }}
						</x-dropdown-link>
					</x-slot>
				</x-dropdown>
				<x-dropdown :active="request()->routeIs([
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
						<x-dropdown-link :href="route('product.index')" :active="request()->routeIs(['product.index', 'product.create', 'product.edit'])">
							{{ __('product') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('category.index')" :active="request()->routeIs(['category.index', 'category.create', 'category.edit'])">
							{{ __('category') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('product-group.index')" :active="request()->routeIs(['product-group.index', 'product-group.create', 'product-group.edit'])">
							{{ __('product_group') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('manufacturer.index')" :active="request()->routeIs(['manufacturer.index', 'manufacturer.create', 'manufacturer.edit'])">
							{{ __('manufacturer') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('customer.index')" :active="request()->routeIs(['customer.index', 'customer.create', 'customer.edit'])">
							{{ __('customer') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('customer-group.index')" :active="request()->routeIs(['customer-group.index', 'customer-group.create', 'customer-group.edit'])">
							{{ __('customer_group') }}
						</x-dropdown-link>
					</x-slot>
				</x-dropdown>
				<x-dropdown :active="request()->routeIs(['address-book.index', 'address-book.create', 'address-book.edit'])">
					<x-slot name="trigger">
						<span>{{ __('accountancy') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-dropdown-link :href="route('address-book.index')" :active="request()->routeIs(['address-book.index', 'address-book.create', 'address-book.edit'])">
							{{ __('address_book') }}
						</x-dropdown-link>
					</x-slot>
				</x-dropdown>
				<x-dropdown :active="request()->routeIs(['country.index', 'country.edit', 'language.index', 'language.edit', 'currency.index', 'system.edit', 'profile.edit'])">
					<x-slot name="trigger">
						<span>{{ __('settings') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-dropdown-link :href="route('country.index')" :active="request()->routeIs(['country.index', 'country.edit'])">
							{{ __('country') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('language.index')" :active="request()->routeIs(['language.index', 'language.edit'])">
							{{ __('language') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('currency.index')" :active="request()->routeIs(['currency.index'])">
							{{ __('currency') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('system.edit')" :active="request()->routeIs(['system.edit'])">
							{{ __('system') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('profile.edit')" :active="request()->routeIs(['profile.edit'])">
							{{ __('profile') }}
						</x-dropdown-link>
						<x-dropdown-link :href="route('user.index')">
							{{ __('user') }}
						</x-dropdown-link>
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
								{{ __('logout') }}
							</x-dropdown-link>
						</form>
					</x-slot>
				</x-dropdown>

			@else

				<x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
					{{ __('welcome') }}
				</x-nav-link>
				<x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">
					{{ __('contact') }}
				</x-nav-link>
				<x-nav-link :href="route('booking.index')" :active="request()->routeIs('booking.index')">
					{{ __('booking') }}
				</x-nav-link>
				<x-nav-link :href="route('category.index')" :active="request()->routeIs(['category.index', 'product.show', 'manufacturer.show'])">
					{{ __('shop') }}
				</x-nav-link>
				<x-nav-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.show'])">
					{{ __('blog') }}
				</x-nav-link>
				<x-dropdown :active="request()->routeIs(['page.show', 'faq.index'])">
					<x-slot name="trigger">
						<span>{{ __('info') }}</span>
						<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
							<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</x-slot>
					<x-slot name="content">
						<x-dropdown-link :href="route('faq.index')" :active="request()->routeIs('faq.index')">
							{{ __('faq') }}
						</x-dropdown-link>
						@if (!$pages->isEmpty())
							@foreach ($pages as $page)
								<x-dropdown-link :href="route('page.show', $page->slug)" :active="request()->routeIs('page.show') && request()->segment(2) === $page->slug">
									{{ $page->title }}
								</x-dropdown-link>
							@endforeach
						@endif
					</x-slot>
				</x-dropdown>

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