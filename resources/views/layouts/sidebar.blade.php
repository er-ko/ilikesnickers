<div class="w-full max-w-[300px] flex flex-col">
	<div class="flex flex-1 flex-col items-start justify-start rounded-r-lg shadow bg-white dark:bg-gray-800">

		<div class="w-full flex items-center justify-start px-4 lg:px-6 py-5 rounded-tr-lg bg-gray-500 text-white dark:bg-black">
			<div id="sidebar-toggle" class="p-1 rounded-lg me-3 duration-300 hover:cursor-pointer text-gray-300 hover:bg-white hover:text-gray-500 border border-gray-400">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 close">
					<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
				</svg>
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 open hidden">
					<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
				</svg>
			</div>
			<h3 class="font-semibold text-lg">{{ $title }}</h3>
		</div>
		<nav class="w-full">
			<ul>
				<li>
					<x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-3">
							<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
						</svg>
						<span>{{ __('messages.dashboard') }}</span>
					</x-sidebar-link>
				</li>
				<li>
					<x-sidebar-link :href="route('task.index')" :active="request()->routeIs('task.index')">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-3">
							<path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
						</svg>
						<span>{{ __('messages.task') }}</span>
					</x-sidebar-link>
				</li>
				<li>
					<x-sidebar-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.create', 'post.edit'])">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-3">
							<path stroke-linecap="round" stroke-linejoin="round" d="M2.243 4.493v7.5m0 0v7.502m0-7.501h10.5m0-7.5v7.5m0 0v7.501m4.501-8.627 2.25-1.5v10.126m0 0h-2.25m2.25 0h2.25" />
						</svg>
						<span>{{ __('messages.blog') }}</span>
					</x-sidebar-link>
				</li>
				<li>
					<x-sidebar-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.create', 'post.edit'])">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-3">
							<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
						</svg>
						<span>{{ __('messages.shop') }}</span>
					</x-sidebar-link>
				</li>
				<li>
					<x-sidebar-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.create', 'post.edit'])">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-3">
							<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
						</svg>
						<span>{{ __('messages.accountancy') }}</span>
					</x-sidebar-link>
				</li>
				<li>
					<x-sidebar-link :href="route('post.index')" :active="request()->routeIs(['post.index', 'post.create', 'post.edit'])">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-3">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
						</svg>
						<span>{{ __('Settings') }}</span>
					</x-sidebar-link>
				</li>
			</ul>
		</nav>
	</div>
	<footer class="w-full flex items-center justify-center pt-4 pb-2 space-x-4">

		<a href="{{ route('dashboard') }}" class="logo">
			<x-application-logo class="w-8" />
		</a>
		
		<!-- Authentication -->
		<form method="POST" action="{{ route('logout') }}">
			@csrf

			<a href="{{ route('logout') }}" class="block text-pink-600 hover:text-pink-700" onclick="event.preventDefault(); this.closest('form').submit();">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
				</svg>
			</a>
		</form>
		@include('components.app-dark-mode')

	</footer>
</div>

@push('slotscript')
	<script>
		$(document).ready(function(){
			$('#sidebar-toggle').click(function(){
				$(this).find('.close').toggleClass('hidden');
				$(this).find('.open').toggleClass('hidden');
				$(this).parent().find('h3').toggleClass('hidden');
				$('#sidebar-wrapper').find('nav a svg').toggleClass('me-3');
				$('#sidebar-wrapper').find('nav span').toggleClass('hidden');
				$('#sidebar-wrapper').toggleClass('w-[75px]');
				$('#sidebar-wrapper footer').toggleClass('space-x-4');
				$('#sidebar-wrapper footer').find('.logo').toggleClass('hidden');
			});
		});
	</script>
@endpush