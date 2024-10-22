<div class="grid gap-0 lg:gap-4 grid-cols-1 lg:grid-cols-3">
	<div class="mb-4 lg:mb-0 p-4 sm:p-6 lg:p-8 space-y-10 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">
		<div>
			<x-input-label for="customer-group" :required="true" :value="__('messages.customer_group')" />
			<x-select name="customer_group" id="customer-group" required>
				@foreach ($groups as $group)
					<option value="{{ $group->id }}" {{ isset($customer) && $customer->customer_group == $group->id ? 'selected' : '' }}>{{ $group->title }}</option>
				@endforeach
			</x-select>
			<x-input-error :messages="$errors->get('customer_group')" />
		</div>
		<x-primary-button type="button" class="password-generator w-full mt-16">{{ __('messages.password_generator') }}</x-primary-button>
	</div>
	<div class="relative col-span-2 p-4 sm:p-6 lg:p-8 shadow-sm sm:rounded-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100">

		<div>
			<x-input-label for="login-email" :required="true" :value="__('messages.login_email')" />
			<x-text-input id="login-email" name="email" type="email" maxlength="255" required :value="isset($customer) ? old('email', $customer->email) : ''" />
			<x-input-error :messages="$errors->get('email')" />
		</div>
		<div class="grid gap-4 grid-cols-1 sm:grid-cols-2 py-4">
			<div>
				<x-input-label for="password" :required="true" :value="__('messages.password')" />
				<x-text-input id="password" name="password" type="text" rel="gp" data-size="12" data-character-set="a-z,A-Z,0-9,#" required />
				<x-input-error :messages="$errors->get('password')" />
			</div>
			<div>
				<x-input-label for="confirm-password" :required="true" :value="__('messages.confirm_password')" />
				<x-text-input id="confirm-password" name="password_confirmation" type="text" rel="gp" data-size="12" data-character-set="a-z,A-Z,0-9,#" required />
				<x-input-error :messages="$errors->get('confirm_password')" />
			</div>
		</div>
	</div>
</div>
<div class="flex items-center justify-end my-4"><h3 id="email-alert" class="hidden px-3 py-1.5 md:rounded-lg text-right text-sm lowercase text-white"></h3></div>

@push('slotscript')
	<script>
		var el = '';
		$(document).ready(function(){
			$('.password-generator').click(function(){
				el = $(this).parent().parent().find('input[rel="gp"]');
				el.val(generate(el));
			});

			$('#login-email').on('keyup', function(){
				checkEmail($(this).val());
			});
		});

		function generate(id) {
			var text	= '';
			var dataSet = $(id).attr('data-character-set').split(',');  
			var charSet = '';

			if ($.inArray('a-z', dataSet) >= 0){ charSet += 'abcdefghijklmnopqrstuvwxyz'; }
			if ($.inArray('A-Z', dataSet) >= 0){ charSet += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
			if ($.inArray('0-9', dataSet) >= 0){ charSet += '0123456789'; }
			if ($.inArray('#', dataSet) >= 0){ charSet += '![]{}()%&*$#^<>~@|'; }

			for (var i = 0; i < $(id).attr('data-size'); i++) {
				text += charSet.charAt(Math.floor(Math.random() * charSet.length));
			}
			return text;
		}

		function checkEmail(email) {
			$.ajax({
				url: "{{ route('customer.create') }}",
				type: 'GET',
				dataType: 'json',
				data: {
					email: email,
				},
				success: function(data) {
					if (!$.isEmptyObject(data)) {
						$('#email-alert').removeClass('hidden bg-teal-500 dark:bg-teal-600').addClass('bg-pink-500 dark:bg-pink-600').text('{{ __("messages.this_email_is_already_registered") }}');
					} else {
						$('#email-alert').removeClass('hidden bg-pink-500 dark:bg-pink-600').addClass('bg-teal-500 dark:bg-teal-600').text('{{ __("messages.email_address_can_be_used") }}');
					}
				}
			});
		}
	</script>
@endpush