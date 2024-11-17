<div class="w-full md:min-h-screen md:flex flex-col md:flex-row">
	<div
		class="w-full sm:w-64 lg:w-72 flex flex-col flex-shrink-0 py-2 bg-white text-gray-900 dark:text-gray-200 dark:bg-gray-800"
		x-data="{ open: false }"
		@click.away="open = false"
	>
		<div class="flex flex-row flex-shrink-0 items-center justify-between px-8 py-8 sm:p-4 lg:px-8 lg:py-6">
			<a
				href="#"
				class="font-semibold text-lg uppercase tracking-widest text-gray-900 dark:text-white focus:outline-none focus:shadow-outline"
			>
				{{ $title }}
			</a>
			<button class="md:hidden" @click="open = !open">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path x-show="!open" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
					<path x-show="open" fill-rule="evenodd" clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
				</svg>
			</button>
		</div>
		<nav
			class="flex-grow md:block px-4 sm:px-2 lg:px-4 pb-4 md:pb-0 md:overflow-y-auto"
			:class="{'block': open, 'hidden': !open}"
		>
			<x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
				{{ __('messages.dashboard') }}
			</x-sidebar-link>
			<x-sidebar-link :href="route('task.index')" :active="request()->routeIs('task.index')">
				{{ __('messages.task') }}
			</x-sidebar-link>
			<x-sidebar-dropdown :active="request()->routeIs([
				'page.index', 'page.create', 'page.edit',
				'post.index', 'post.create', 'post.edit',
				'faq.index', 'faq.create', 'faq.edit',
				'contact.edit'
			])">
				<x-slot name="trigger">
					<span>{{ __('messages.pages') }}</span>
					<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
						<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
					</svg>
				</x-slot>
				<x-slot name="content">
					<x-sidebar-dropdown-link :href="route('page.index')">
						{{ __('messages.page') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('contact.edit')">
						{{ __('messages.contact') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('faq.index')">
						{{ __('messages.faq') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('post.index')">
						{{ __('messages.blog') }}
					</x-sidebar-dropdown-link>
				</x-slot>
			</x-sidebar-dropdown>
			<x-sidebar-dropdown :active="request()->routeIs([
				'category.index', 'category.create', 'category.edit',
				'product-group.index', 'product-group.create', 'product-group.edit',
				'manufacturer.index', 'manufacturer.create', 'manufacturer.edit',
				'customer.index', 'customer.create', 'customer.edit',
				'customer-group.index', 'customer-group.create', 'customer-group.edit',
			])">
				<x-slot name="trigger">
					<span>{{ __('messages.shop') }}</span>
					<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
						<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
					</svg>
				</x-slot>
				<x-slot name="content">
					<x-sidebar-dropdown-link :href="route('category.index')">
						{{ __('messages.category') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('product-group.index')">
						{{ __('messages.product_group') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('manufacturer.index')">
						{{ __('messages.manufacturer') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('customer.index')">
						{{ __('messages.customer') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('customer-group.index')">
						{{ __('messages.customer_group') }}
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
						{{ __('messages.address_book') }}
					</x-sidebar-dropdown-link>
				</x-slot>
			</x-sidebar-dropdown>
			<x-sidebar-dropdown :active="request()->routeIs(['language.index', 'language.edit', 'profile.edit'])">
				<x-slot name="trigger">
					<span>{{ __('Settings') }}</span>
					<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 ml-1 transition-transform duration-200 transform">
						<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
					</svg>
				</x-slot>
				<x-slot name="content">
					<x-sidebar-dropdown-link :href="route('country.index')">
						{{ __('messages.country') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('language.index')">
						{{ __('messages.language') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('system.edit')">
						{{ __('messages.system') }}
					</x-sidebar-dropdown-link>
					<x-sidebar-dropdown-link :href="route('profile.edit')">
						{{ __('messages.profile') }}
					</x-sidebar-dropdown-link>
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<x-sidebar-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
							{{ __('messages.logout') }}
						</x-sidebar-dropdown-link>
					</form>
				</x-slot>
			</x-sidebar-dropdown>
		</nav>
	</div>
</div>