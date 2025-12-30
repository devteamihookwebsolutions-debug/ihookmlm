@extends('admin::components.common.main')
@section('content')
<!-- Breadcrumb -->
<div class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin/dashboard"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                <div class="relative w-5 h-5 flex items-center justify-center">

                    <!-- Animated Border ONLY -->
                    <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                                                animate-ping opacity-60"></span>

                    <!-- Static Icon -->
                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                </div>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Compansation</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Generation Bonus</span>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Generation Bonus</span>
            </div>
        </li>
    </ol>
</div>

<main class="flex-grow">
    <div>
        <!-- Success and Failure Message -->
        @include('components.common.info_message')
        <!-- Row-1 -->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- Card -->
            <div
                class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900  border border-gray-200">
                <div>
                    <div class="p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                            <form id="add_generation_bonus"
                                action="{{ $matrix_id ? route('generationbonus.update', $matrix_id) : route('generationbonus.store') }}"
                                method="POST" enctype="multipart/form-data" novalidate="novalidate"
                                class="col-span-1 md:col-span-1 lg:col-span-2 mb-5 validated-form">
                                @csrf
                                @if($matrix_id)
                                @method('POST')
                                @endif
                                <div class="mb-5 lg:w-1/2">
                                    <label
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Select Plan') }}</label>
                                    {!! $addshowmatch !!}
                                    <p id="matrixid-error"
                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please select a plan.') }}</p>
                                </div>
                                @if($sub1 != '')
                                <div class="mb-5 lg:w-1/2">
                                    <label
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Generation Bonus Name') }}</label>
                                    <input type="text" id="generationalbonus_name" name="generationalbonus_name"
                                        value="{{ $generationalbonus_name ?? '' }}" required
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                        placeholder="" aria-describedby="bonusname-error">
                                    <p id="bonusname-error"
                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid Bonus name.') }}</p>
                                </div>
                                <div class="mb-5 lg:w-1/2">
                                    <label
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission Percentage') }}</label>
                                    <select name="commission_percentage" id="commissionpercentage"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                        <option value="2" {{ ($commission_percentage ?? 2) == 2 ? 'selected' : '' }}>
                                            {{ __('Product Sales') }}</option>
                                        <option value="1" {{ ($commission_percentage ?? 2) == 1 ? 'selected' : '' }}>
                                            {{ __('Paring Bonus') }}</option>
                                    </select>
                                </div>
                                <div class="mb-5 lg:w-1/2">
                                    <label
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Wallet') }}</label>
                                    <select id="wallet" name="wallet"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                        required>
                                        <option value="">{{ __('Select Wallet') }}</option>
                                        @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->wallet_type_id }}"
                                            {{ ($selected_wallet ?? '') == $wallet->wallet_type_id ? 'selected' : '' }}>
                                            {{ $wallet->wallet_name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="wallet-error"
                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please select a wallet.') }}</p>
                                </div>
                                <input aria-label="label" type="hidden" name="levelcount" id="levelcount"
                                    value="{{ count($ranks) }}">
                                <div class="mb-5 lg:w-1/2">
                                    <table class="min-w-2xl">
                                        <tbody>
                                            <tr>
                                                <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                    {{ __('Status') }}</td>
                                                <td class="px-6 text-right">
                                                    <div class="flex items-center p-2.5">
                                                        <span
                                                            class="text-gray-600 dark:text-gray-300 text-xs">{{ __('OFF') }}</span>
                                                        <input type="hidden" name="generationalbonus_status" value="0">
                                                        <label class="inline-flex items-center cursor-pointer mx-3">
                                                            <input type="checkbox" value="1"
                                                                id="generationalbonus_status"
                                                                name="generationalbonus_status" class="sr-only peer"
                                                                {{ ($generationalbonus_status ?? 0) == 1 ? 'checked' : '' }}>
                                                            <div
                                                                class="relative w-11 h-6 bg-gray-200  rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-blue-600">
                                                            </div>
                                                        </label>
                                                        <span
                                                            class="text-gray-600 dark:text-gray-300 text-xs">{{ __('ON') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @if(count($ranks) > 0)
                                <div class="col-span-2 relative overflow-x-auto bg-white rounded-lg  border shadow p-2 dark:bg-gray-900 dark:border-gray-800">
                                    <table id="tblEntLevelAttributes"
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 my-6">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Rank</th>
                                                <th scope="col" class="px-6 py-3">Own</th>
                                                <th scope="col" class="px-6 py-3">Amount</th>
                                                @foreach ($ranks as $rank)
                                                <th scope="col" class="px-6 py-3">{{ $rank->rank_value }}</th>
                                                @endforeach
                                                <th scope="col" class="px-6 py-3">Method</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ranks as $index => $rank)
                                            <tr id="rank_r{{ $index + 1 }}"
                                                class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                                <td class="p-4">
                                                    <select name="r_rank[]"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full px-2 py-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        required aria-describedby="r_rank_{{ $index + 1 }}-error">
                                                        <option value="">{{ __('Select Rank') }}</option>
                                                        @foreach ($ranks as $subRank)
                                                        <option value="{{ $subRank->rank_id }}"
                                                            {{ isset($gen_details[$index]['rank']) && $gen_details[$index]['rank'] == $subRank->rank_id ? 'selected' : '' }}>
                                                            {{ $subRank->rank_value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p id="r_rank_{{ $index + 1 }}-error"
                                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                                        {{ __('Please select a rank.') }}</p>
                                                </td>
                                                <td class="p-4">
                                                    <input aria-label="label"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-24 p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        type="number" name="r_own[]"
                                                        value="{{ isset($gen_details[$index]['own']) ? $gen_details[$index]['own'] : '' }}"
                                                        min="0" required
                                                        aria-describedby="r_own_{{ $index + 1 }}-error">
                                                    <p id="r_own_{{ $index + 1 }}-error"
                                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                                        {{ __('Please enter a valid value.') }}</p>
                                                </td>
                                                <td class="p-4">
                                                    <input aria-label="label"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-24 p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        type="number" name="r_admin[]"
                                                        value="{{ isset($gen_details[$index]['admin']) ? $gen_details[$index]['admin'] : '' }}"
                                                        min="0" required
                                                        aria-describedby="r_admin_{{ $index + 1 }}-error">
                                                    <p id="r_admin_{{ $index + 1 }}-error"
                                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                                        {{ __('Please enter a valid value.') }}</p>
                                                </td>
                                                @foreach ($ranks as $subRank)
                                                <td class="p-4">
                                                    <input aria-label="label"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        type="number" name="r_rank_{{ $subRank->rank_id }}[]"
                                                        value="{{ isset($gen_details[$index]['rank' . $subRank->rank_id]) ? $gen_details[$index]['rank' . $subRank->rank_id] : '' }}"
                                                        min="0" required
                                                        aria-describedby="r_rank_{{ $subRank->rank_id }}_{{ $index + 1 }}-error">
                                                    <p id="r_rank_{{ $subRank->rank_id }}_{{ $index + 1 }}-error"
                                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                                        {{ __('Please enter a valid value.') }}</p>
                                                </td>
                                                @endforeach
                                                <td class="p-4">
                                                    <select aria-label="label"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        name="r_method[]" required
                                                        aria-describedby="r_method_{{ $index + 1 }}-error">
                                                        <option value="2"
                                                            {{ isset($gen_details[$index]['method']) && $gen_details[$index]['method'] == 2 ? 'selected' : '' }}>
                                                            Flat</option>
                                                        <option value="1"
                                                            {{ isset($gen_details[$index]['method']) && $gen_details[$index]['method'] == 1 ? 'selected' : '' }}>
                                                            %</option>
                                                    </select>
                                                    <p id="r_method_{{ $index + 1 }}-error"
                                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                                        {{ __('Please select a method.') }}</p>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p class="text-sm text-gray-600 dark:text-gray-400">No ranks found for this plan. Please
                                    add ranks in the Rank Settings.</p>
                                @endif
                                <div class="flex justify-center pt-10 space-x-3">
                                    <a href="javascript:void(0);" onclick="window.history.back();"
                                        class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">{{ __('Cancel') }}</a>
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">{{ __('Submit') }}</button>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</main>
</main>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    const matrixIdSelect = document.getElementById('matrix_id');

    // Redirect to URL with selected matrix_id
    matrixIdSelect.addEventListener('change', function() {
        const matrixId = this.value;
        if (matrixId) {
            window.location.href = `/admin/generationbonus/addgen/${matrixId}`;
        } else {
            window.location.href = '/admin/generationbonus/addgen';
        }
    });

    // Form validation
    const FORM_CONFIG = {
        REQUIRED_PATTERNS: {
            generationalbonus_name: /.+/,
            'r_rank[]': /^[0-9]+$/,
            'r_own[]': /^[0-9]+$/,
            'r_admin[]': /^[0-9]+$/,
            'wallet': /^[0-9]+$/,
            'r_method[]': /^[1-2]$/,
            @foreach($ranks as $rank)
            'r_rank_{{ $rank->rank_id }}[]': /^[0-9]+$/, // Dynamic pattern for each rank column
            @endforeach
        },
    };

    class FormHandler {
        constructor() {
            this.initializeElements();
            this.attachEventListeners();
        }

        initializeElements() {
            this.elements = {
                form: document.getElementById('add_generation_bonus'),
            };
        }

        attachEventListeners() {
            this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));

            // Real-time validation
            document.querySelectorAll('input[required], select[required]').forEach((input) => {
                input.addEventListener('input', () => this.validateInput(input));
            });
        }

        validateInput(input) {
            const value = input.value.trim();
            const pattern = FORM_CONFIG.REQUIRED_PATTERNS[input.name];
            const errorElement = document.getElementById(input.getAttribute('aria-describedby'));

            let isValid = true;

            if (!value && input.hasAttribute('required')) {
                isValid = false;
                this.showError(input, errorElement, 'This field is required.');
            } else if (pattern && !pattern.test(value)) {
                isValid = false;
                this.showError(input, errorElement, `Please enter a valid ${input.name}.`);
            } else {
                this.clearError(input, errorElement);
            }

            return isValid;
        }

        showError(input, errorElement, message) {
            input.classList.add('border-red-500');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }
        }

        clearError(input, errorElement) {
            input.classList.remove('border-red-500');
            if (errorElement) {
                errorElement.classList.add('hidden');
            }
        }

        handleSubmit(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form.querySelectorAll(
                'input[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
                this.elements.form.submit();
            } else {
                console.error('Form validation failed.');
            }
        }
    }

    new FormHandler();
});
</script>
