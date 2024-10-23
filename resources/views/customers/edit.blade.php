<x-app-layout>

	<x-slot name="meta_title">{{ __('messages.edit_customer') }}</x-slot>
	<x-slot name="meta_desc">{{ __('messages.edit_customer') }}</x-slot>
	<x-slot name="title">{{ __('messages.edit_customer') }}</x-slot>

	<div class="flex items-center justify-center mt-2 mb-6 space-x-1">
		<button
			form="form-store"
			type="submit"
			class="px-4 py-1 text-base lowercase sm:rounded-md duration-300 bg-teal-600 text-white hover:bg-teal-700"
		>
			{{ __('messages.save') }}
		</button>
		<a
			href="{{ route('customer.index') }}"
			class="px-4 py-1 text-base lowercase sm:rounded-md duration-300 bg-pink-600 text-white hover:bg-pink-700"
		>
			{{ __('messages.cancel') }}
		</a>
	</div>

	<form method="POST" action="{{ route('customer.update', $customer) }}" id="form-store">
		@csrf
		@method('patch')
		@include('customers.partials.general')
	</form>
	@push('slotscript')
		<script>
			$(document).ready(function(){
				$('#login-email').prop('readonly', true);
			});
		</script>
	@endpush
</x-app-layout>