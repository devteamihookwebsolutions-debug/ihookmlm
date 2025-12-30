@extends('admin::components.common.main')
@section('content')

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
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Customer Bonus</span>
            </div>
        </li>
    </ol>
</div>


<main class="flex-grow">
        <!-- Success and Failure Message -->
        @include('components.common.info_message')
        <!-- Success and Failure Message -->
        <div class="flex p-4 mb-6 text-xs text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-3 h-3 me-3 mt-[2px]" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                </path>
            </svg>
            <span class="sr-only">{{ __('Info') }}</span>
            <div>
                <p class="mb-2">{{ __('This all customer bonus is applicable to shop order amount') }}</p>
            </div>
        </div>


        <!-- Card -->
        <div
            class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200">
            <div>
                <div class="p-4 rounded-lg">
                    <!-- Card Header -->
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-10">
                                {{ __('Customer Acquisition Bonus') }}</h3>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                        <form action="{{ route('customerbonus.update') }}" id="customerbounsform" method="POST"
                            enctype="multipart/form-data" novalidate="novalidate"
                            class="col-span-1 md:col-span-1 lg:col-span-1 mb-5 validated-form">
                            @csrf
                            <input type="hidden" name="{{ $token_id }}" value="{{ $token_value }}" />
                            <div class="mb-5">
                                <label for="cab_bonus_name"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Name') }}</label>
                                <input type="text" id="cab_bonus_name" name="cab_bonus_name" required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    placeholder="" aria-describedby="bonusname-error"
                                    value="{{ $cusbonusdetails['cab_bonus_name'] ?? '' }}">
                                <p id="bonusname-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please enter a valid Bonus name.') }}</p>
                            </div>
                            <div class="mb-5">
                                <label for="cab_bonus_percentage"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Percentage') }}</label>
                                <input type="number" id="cab_bonus_percentage" name="cab_bonus_percentage" required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    placeholder="" aria-describedby="bonuspercentage-error"
                                    value="{{ $cusbonusdetails['cab_bonus_percentage'] ?? '' }}">
                                <p id="bonuspercentage-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please enter a valid Bonus percentage.') }}</p>
                            </div>
                            <div class="mb-5">
                                <label for="cab_bonus_percentage_type"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Percentage Type') }}</label>
                                <select name="cab_bonus_percentage_type" id="cab_bonus_percentage_type" required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    aria-describedby="bonustype-error">
                                    <option value="">-- {{ __('Select') }} --</option>
                                    <option value="flat"
                                        {{ ($cusbonusdetails['cab_bonus_percentage_type'] ?? '') == 'flat' ? 'selected' : '' }}>
                                        {{ __('Flat') }}</option>
                                    <option value="%"
                                        {{ ($cusbonusdetails['cab_bonus_percentage_type'] ?? '') == '%' ? 'selected' : '' }}>
                                        %</option>
                                </select>
                                <p id="bonustype-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please select a valid Bonus Type.') }}</p>
                            </div>

                            <div class="mb-5">
                                <label for="cab_bonus_wallet_type"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Wallet') }}</label>
                                <select name="cab_bonus_wallet_type" id="cab_bonus_wallet_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    aria-describedby="cab-wallet-error">
                                    <option value="">{{ __('Select Wallet') }}</option>
                                    @foreach ($wallets as $wallet)
                                    <option value="{{ $wallet->wallet_type_id }}"
                                        {{ ($cusbonusdetails['cab_bonus_wallet_type'] ?? '') == $wallet->wallet_type_id ? 'selected' : '' }}>
                                        {{ $wallet->wallet_name }}</option>
                                    @endforeach
                                </select>
                                <p id="cab-wallet-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please select a wallet.') }}</p>
                            </div>
                            <div class="mb-5">
                                <label for="cab_bonus_sales_type"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Type') }}</label>
                                <input type="text" id="cab_bonus_sales_type" name="cab_bonus_sales_type"
                                    value="{{ __('First sales on cart') }}" readonly
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="mb-5">
                                <label for="cab_bonus_to"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus To') }}</label>
                                <input type="text" id="cab_bonus_to" name="cab_bonus_to" value="{{ __('Sponsor') }}"
                                    readonly
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="mb-5">
                                <table class="min-w-2xl">
                                    <tbody>
                                        <tr>
                                            <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                {{ __('Status') }}</td>
                                            <td class="px-6 text-right">
                                                <div class="flex items-center p-2.5">
                                                    <span
                                                        class="text-xs text-gray-600 dark:text-gray-300">{{ __('OFF') }}</span>
                                                    <input type="hidden" name="cab_bonus_status" value="0">
                                                    <label class="inline-flex items-center cursor-pointer mx-3">
                                                        <input type="checkbox" name="cab_bonus_status"
                                                            id="cab_bonus_status" value="1"
                                                            {{ ($cusbonusdetails['cab_bonus_status'] ?? '0') == '1' ? 'checked' : '' }}
                                                            class="sr-only peer">
                                                        <div
                                                            class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-blue-600">
                                                        </div>
                                                    </label>
                                                    <span
                                                        class="text-xs text-gray-600 dark:text-gray-300">{{ __('ON') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-10">
                                        {{ __('Retail Commission') }}</h3>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="retail_commission_name"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Name') }}</label>
                                <input type="text" id="retail_commission_name" name="retail_commission_name" required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    placeholder="" aria-describedby="bonusname-error"
                                    value="{{ $cusbonusdetails['retail_commission_name'] ?? '' }}">
                                <p id="bonusname-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please enter a valid Bonus name.') }}</p>
                            </div>
                            <div class="mb-5">
                                <label for="retail_commission_percenatge"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Percentage') }}</label>
                                <input type="number" id="retail_commission_percenatge"
                                    name="retail_commission_percenatge" required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    placeholder="" aria-describedby="bonuspercentage-error"
                                    value="{{ $cusbonusdetails['retail_commission_percenatge'] ?? '' }}">
                                <p id="bonuspercentage-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please enter a valid Bonus percentage.') }}</p>
                            </div>
                            <div class="mb-5">
                                <label for="retail_commission_percentage_type"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Percentage Type') }}</label>
                                <select name="retail_commission_percentage_type" id="retail_commission_percentage_type"
                                    required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    aria-describedby="bonustype-error">
                                    <option value="">-- {{ __('Select') }} --</option>
                                    <option value="flat"
                                        {{ ($cusbonusdetails['retail_commission_percentage_type'] ?? '') == 'flat' ? 'selected' : '' }}>
                                        {{ __('Flat') }}</option>
                                    <option value="%"
                                        {{ ($cusbonusdetails['retail_commission_percentage_type'] ?? '') == '%' ? 'selected' : '' }}>
                                        %</option>
                                </select>
                                <p id="bonustype-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please select a valid Bonus Type.') }}</p>
                            </div>

                            <div class="mb-5">
                                <label for="retail_commission_wallet_type"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Wallet') }}</label>
                                <select name="retail_commission_wallet_type" id="retail_commission_wallet_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    aria-describedby="retail-wallet-error">
                                    <option value="">{{ __('Select Wallet') }}</option>
                                    @foreach ($wallets as $wallet)
                                    <option value="{{ $wallet->wallet_type_id }}"
                                        {{ ($cusbonusdetails['retail_commission_wallet_type'] ?? '') == $wallet->wallet_type_id ? 'selected' : '' }}>
                                        {{ $wallet->wallet_name }}</option>
                                    @endforeach
                                </select>
                                <p id="retail-wallet-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please select a wallet.') }}</p>
                            </div>
                            <div class="mb-5">
                                <label for="retail_commission_type"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Type') }}</label>
                                <input type="text" id="retail_commission_type" name="retail_commission_type"
                                    value="{{ __('Sales on cart') }}" readonly
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="mb-5">
                                <label for="retail_commission_to"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus To') }}</label>
                                <input type="text" id="retail_commission_to" name="retail_commission_to"
                                    value="{{ __('Sponsor') }}" readonly
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="mb-5">
                                <table class="min-w-2xl">
                                    <tbody>
                                        <tr>
                                            <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                {{ __('Status') }}</td>
                                            <td class="px-6 text-right">
                                                <div class="flex items-center p-2.5">
                                                    <span
                                                        class="text-gray-600 dark:text-gray-300 text-xs">{{ __('OFF') }}</span>
                                                    <input type="hidden" name="retail_commission_status" value="0">
                                                    <label class="inline-flex items-center cursor-pointer mx-3">
                                                        <input type="checkbox" name="retail_commission_status"
                                                            id="retail_commission_status" value="1"
                                                            {{ ($cusbonusdetails['retail_commission_status'] ?? '0') == '1' ? 'checked' : '' }}
                                                            class="sr-only peer">
                                                        <div
                                                            class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-blue-600">
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
                            <div class="flex justify-end pt-6 mt-6 border-t dark:border-gray-700 space-x-2">
                                <button type="button" onclick="window.history.back();"
                                    class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">{{ __('Cancel') }}</button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">{{ __('Submit') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</main>

<script>
const FORM_CONFIG = {
    REQUIRED_PATTERNS: {
        cab_bonus_name: /.+/,
        cab_bonus_percentage: /^\d+(\.\d+)?$/,
        retail_commission_name: /.+/,
        retail_commission_percenatge: /^\d+(\.\d+)?$/,
    },
};

class FormHandler {
    constructor() {
        this.initializeElements();
        this.attachEventListeners();
    }

    initializeElements() {
        this.elements = {
            form: document.getElementById('customerbounsform'),
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
            this.showError(input, errorElement, `Please enter a valid ${input.name.replace(/_/g, ' ')}.`);
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
        const inputs = Array.from(this.elements.form.querySelectorAll('input[required], select[required]'));
        const allValid = inputs.every((input) => this.validateInput(input));

        if (allValid) {
            this.elements.form.submit();
        } else {
            console.error('Form validation failed.');
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new FormHandler();
});
</script>
@endsection
