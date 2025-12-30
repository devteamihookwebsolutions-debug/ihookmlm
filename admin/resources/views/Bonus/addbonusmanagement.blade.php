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
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Bonus</span>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Bonus</span>
            </div>
        </li>
    </ol>
</div>

<main class="flex-grow">
    <div>
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <!-- Card -->
            <div
                class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200">
                <div>
                    <div class="p-4 rounded-lg">
                        <!-- Card Header -->
                        <div class="flex justify-between ">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-10">
                                    {{ __('Add Bonus Details') }}
                                </h3>
                            </div>
                            <div class="form-submit">
                                <button type="button" onclick="addcondition()"
                                    class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                                    {{ __('Add Condition') }}
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                            <form action="{{ route('bonus.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="selectedcondition" name="selectedcondition">
                                <div class="mb-5">
                                    <label for="matrix_id"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Plan') }}</label>
                                    <select name="matrix_id" id="matrix_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                        <option value="">-- {{ __('Select') }} --</option>
                                        {!! $matrix !!}
                                    </select>
                                    <p id="matrixid-error"
                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please select a plan.') }}</p>
                                </div>
                                <div class="mb-5">
                                    <label for=""
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Name') }}

                                    </label>
                                    <input type="text" id="title" name="title" required
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                        placeholder="" aria-describedby="bonusname-error">
                                    <p id="bonusname-error"
                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid Bonus name.') }}</p>
                                </div>
                                <div class="mb-5" id="addpackage">
                                    <label for=""
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Package') }}

                                    </label>
                                    <div id="package" class="works_on"></div>
                                </div>
                                <div class="mb-5" id="addrank">
                                    <label for=""
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Rank') }}

                                    </label>
                                    <div id="rank" class="works_on"></div>
                                </div>
                                <div class="mb-5">
                                    <table class="min-w-2xl  ">
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="pe-6  text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                    {{ __('Period Status') }}
                                                </td>
                                                <td class="px-6  text-right">
                                                    <div class="flex items-center p-2.5">
                                                        <!-- Left label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Instant') }}
                                                        </span>

                                                        <!-- Toggleswitch -->
                                                        <label class="inline-flex items-center cursor-pointer mx-3">
                                                            <input type="checkbox" id="typeref" name="periodstatus"
                                                                value="" class="sr-only peer">
                                                            <div
                                                                class="relative w-11 h-6  bg-gray-200 rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-blue-600">
                                                            </div>
                                                        </label>

                                                        <!-- Right label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Period') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-5">
                                    <label for="lastname"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus To') }}

                                    </label>
                                    <select name="bonus_to" id="bonus_to"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                        <option value="">-- {{ __('Select') }} --</option>
                                        <option value="0">{{ __('Self') }}</option>
                                        <option value="1">{{ __('Sponsor') }}</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label for="lastname"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus Type') }}</label>
                                    <select name="Bonus_Type" id="Bonus_Type" onchange="bonustype(this.value)" ;
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                        <option value="">-- {{ __('Select') }} --</option>
                                        <option value="1">{{ __('One Time Bonus') }}</option>
                                        <option value="2">{{ __('Repeat') }}</option>
                                    </select>
                                </div>
                                <div class="mb-5" id="maximumlimit">
                                    <label for=""
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Maximum Amount Limit') }}

                                    </label>
                                    <input type="number" name="maximumlimit"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                        placeholder="">
                                </div>
                                <div class="mb-5" id="bonusmethod">
                                    <table class="min-w-2xl  ">
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="pe-6  text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                    {{ __('Method') }}
                                                </td>
                                                <td class="px-6  text-right">
                                                    <div class="flex items-center p-2.5">
                                                        <!-- Left label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Infinity') }}
                                                        </span>

                                                        <!-- Toggleswitch -->
                                                        <label class="inline-flex items-center cursor-pointer mx-3">
                                                            <input type="checkbox" id="methodtype" value=""
                                                                class="sr-only peer">
                                                            <div
                                                                class="relative w-11 h-6  bg-gray-200 rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-blue-600">
                                                            </div>
                                                        </label>

                                                        <!-- Right label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Limited') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-5" id="bonus_period">
                                    <label for="lastname"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Period') }}</label>
                                    <select name="Bonus_Period" id="Bonus_Period"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                        <option value="">-- {{ __('Select') }} --</option>
                                        <option value="1">{{ __('Daily') }}</option>
                                        <option value="2">{{ __('Weekly') }}</option>
                                        <option value="3">{{ __('Monthly') }}</option>
                                        <option value="4">{{ __('Quaterly') }}</option>
                                        <option value="5">{{ __('Half Yearly') }}</option>
                                        <option value="6">{{ __('Yearly') }}</option>
                                    </select>
                                    <p class="text-xs mt-2" id="quarterly">{{ __('3 Months once from current month') }}
                                    </p>
                                    <p class="text-xs mt-2" id="halfyearly">{{ __('6 Months once from current month') }}
                                    </p>
                                    <p class="text-xs mt-2" id="dailytime">{{ __('It will run every morning 12 AM') }}
                                    </p>
                                    <p class="text-xs mt-2" id="day">{{ __('It will run every month 1 day') }}</p>
                                    <p class="text-xs mt-2 " id="weekly">{{ __('It will run every week monday') }}</p>
                                    <p class="text-xs mt-2" id="yearly">
                                        {{ __('It will run january month every 1 day') }}</p>
                                </div>

                                <div class="mb-5">
                                    <table class="min-w-2xl  ">
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="pe-6  text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                    {{ __('Reward') }}
                                                </td>
                                                <td class="px-6  text-right">
                                                    <div class="flex items-center p-2.5">
                                                        <!-- Left label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Cash') }}
                                                        </span>

                                                        <!-- Toggleswitch -->
                                                        <label class="inline-flex items-center cursor-pointer mx-3">
                                                            <input type="checkbox" name="bonusreward" id="bonusreward"
                                                                value="1" class="sr-only peer">
                                                            <div
                                                                class="relative w-11 h-6  bg-gray-200 rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-blue-600">
                                                            </div>
                                                        </label>

                                                        <!-- Right label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Gift') }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-5" id="rewardgift">
                                    <label for="lastname"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('GIFT') }}</label>
                                    <input type="text" name="giftname" aria-describedby="helper-text-explanation"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                        placeholder="">
                                </div>
                                <div class="mb-5" id="rewardamt">
                                    <label for="lastname"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Amount') }}</label>
                                    <input type="number" id="amount" name="amount" min="0"
                                        aria-describedby="helper-text-explanation"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                        placeholder="" required aria-describedby="bonusamount-error">
                                    <p id="bonusamount-error"
                                        class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid Amount.') }}</p>
                                </div>

                                <div class="mb-5">
                                    <label for="accountype"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Account Type') }}</label>
                                    <select name="accountype" id="accountype"
                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                        <option value="">-- {{ __('Select') }} --</option>
                                        {!! $accountype !!}
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label for="lastname"
                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Works On') }}
                                    </label>
                                    <div class="works_on" id="works_on">
                                    </div>
                                </div>

                                <div class="mb-5">

                                    <table class="min-w-2xl  ">
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="pe-6  text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                    {{ __('Admin Approve') }}
                                                </td>
                                                <td class="px-6  text-right">
                                                    <div class="flex items-center p-2.5">
                                                        <!-- Left label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('No') }}
                                                        </span>
                                                        <!-- Toggleswitch -->
                                                        <label class="inline-flex items-center cursor-pointer mx-3">
                                                            <input type="checkbox" name="admin_approve_bonus"
                                                                id="admin_approve_bonus" value="1" class="sr-only peer">
                                                            <div
                                                                class="relative w-11 h-6  bg-gray-200 rounded-full peer dark:bg-gray-600 dark:text-white peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-blue-600">
                                                            </div>
                                                        </label>
                                                        <!-- Right label -->
                                                        <span
                                                            class="text-xs text-gray-600 dark:text-gray-300">{{ __('Yes') }}</span>
                                                    </div>

                                                </td>
                                                <p class="text-xs mt-2 text-gray-600 dark:text-gray-300">
                                                    {{ __('If yes means bonus will credit to user account after admin approve else it will credited automatically') }}
                                                </p>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="addconditions"></div>
                                <div id="selectcriteria"></div>

                                <div class="flex justify-end pt-6 mt-6 border-t dark:border-gray-700 space-x-2">
                                    <button type="button" onclick="window.history.back();"
                                        class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                                        {{ __('Cancel') }}
                                    </button>

                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!--chat-drawer:starts-->
<script>
const FORM_CONFIG = {
    REQUIRED_PATTERNS: {
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        phone: /^\d{10}$/,
        // Add more fields as needed
    },
};

class FormHandler {
    constructor() {
        this.initializeElements();
        this.attachEventListeners();
    }

    initializeElements() {
        this.elements = {
            form: document.getElementById('addbonusmanagemnt'),
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
            this.showError(input, errorElement);
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



document.addEventListener('DOMContentLoaded', function() {
    var worksOn = document.getElementById('works_on');
    document.getElementById('addpackage').classList.add('hidden');
    document.getElementById('addrank').classList.add('hidden');
    document.getElementById('bonus_period').classList.add('hidden');
    document.getElementById('day').classList.add('hidden');
    document.getElementById('weekly').classList.add('hidden');
    document.getElementById('yearly').classList.add('hidden');
    document.getElementById('quarterly').classList.add('hidden');
    document.getElementById('halfyearly').classList.add('hidden');
    document.getElementById('rewardgift').classList.add('hidden');
    document.getElementById('bonusmethod').classList.add('hidden');
    document.getElementById('maximumlimit').classList.add('hidden');
    document.getElementById('selectedcondition').value = "c,d,e,f,g,h,i,j,k,";

    var workson = `
        <select aria-label="label" name="workson" id="works_o" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
            <option value="Registration">Registration</option>
            <option value="Recruit New User">Recruit New User</option>
            <option value="Upgrade Network">Upgrade Network</option>
            <option value="Package Upgrade">Package Upgrade</option>
            <option value="Auto">Auto</option>
        </select>`;
    worksOn.innerHTML = workson;
});


document.getElementById('typeref').addEventListener('change', function(event) {
    var state = event.target.checked; // Check the switch state
    var bonusPeriod = document.getElementById('bonus_period');
    var worksOn = document.getElementById('works_on');
    var selectedCondition = document.getElementById('selectedcondition');
    var addConditions = document.getElementById('addconditions');
    var selectCriteria = document.getElementById('selectcriteria');
    if (!state) {
        var workson = `
            <select aria-label="label" name="workson" id="works_o" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                <option value="Registration">Registration</option>
                <option value="Recruit New User" >Recruit New User</option>
                <option value="Upgrade Network" >Upgrade Network</option>
                <option value="Package Upgrade" >Package Upgrade</option>
                <option value="Auto">Auto</option>
            </select>`;

        bonusPeriod.classList.add('hidden');
        selectedCondition.value = "c,d,e,f,g,h,i,j,k,";
        addConditions.innerHTML = "";
        selectCriteria.classList.add('hidden');
        worksOn.innerHTML = workson;
    } else {
        var workson = `
            <select aria-label="label" name="workson" id="works_o" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                <option value="Auto">Auto</option>
            </select>`;
        bonusPeriod.classList.remove('hidden');
        selectCriteria.classList.add('hidden');
        selectedCondition.value = "";
        addConditions.innerHTML = "";
        worksOn.innerHTML = workson;
    }
});

document.getElementById('bonusreward').addEventListener('change', function(event) {
    const state = event.target.checked; // Check the switch state
    const rewardGift = document.getElementById('rewardgift');
    const rewardAmt = document.getElementById('rewardamt');
    const showAccountType = document.getElementById('showaccounttype');
    const amountInput = document.getElementById('amount');

    if (!state) {
        rewardGift.classList.add('hidden');
        rewardAmt.classList.remove('hidden');
        showAccountType.classList.remove('hidden');
        amountInput.setAttribute('required', '');
    } else {
        amountInput.removeAttribute('required');
        rewardGift.classList.remove('hidden');
        rewardAmt.classList.add('hidden');
        showAccountType.classList.add('hidden');
    }
});

document.getElementById('methodtype').addEventListener('change', function(event) {
    const state = event.target.checked; // Check the switch state
    const maximumLimit = document.getElementById('maximumlimit');

    if (state) {
        maximumLimit.classList.add('hidden'); // Add the 'hidden' class
    } else {
        maximumLimit.classList.remove('hidden'); // Remove the 'hidden' class
    }
});

function addcondition() {
    // Show the select criteria element
    document.getElementById('selectcriteria').classList.remove('hidden');

    // Get the value of selectedcondition
    var selectedcondition = document.getElementById('selectedcondition').value;

    // Start building the select box HTML
    var selectbox =
        `
    <div class="mb-5">
        <label  class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Condition') }}</label>
        <div class="flex items-center justify-between">
        <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" id="conditionbox" name="conditionbox">`;

    // Check for each condition and add an option if it doesn't exist in selectedcondition
    if (!selectedcondition.includes("a")) {
        selectbox += `<option value="a">{{ __('Add Package') }}</option>`;
    }
    if (!selectedcondition.includes("b")) {
        selectbox += `<option value="b">{{ __('Add Rank') }}</option>`;
    }
    if (!selectedcondition.includes("c")) {
        selectbox += `<option value="c">{{ __('No of Direct Referrals') }}</option>`;
    }
    if (!selectedcondition.includes("d")) {
        selectbox += `<option value="d">{{ __('No of Group Referrals') }}</option>`;
    }
    if (!selectedcondition.includes("e")) {
        selectbox += `<option value="e">{{ __('Number of Sales') }}</option>`;
    }
    if (!selectedcondition.includes("f")) {
        selectbox += `<option value="f">{{ __('Number of Products sold') }}</option>`;
    }
    if (!selectedcondition.includes("g")) {
        selectbox += `<option value="g">{{ __('PV Points') }}</option>`;
    }
    if (!selectedcondition.includes("h")) {
        selectbox += `<option value="h">{{ __('GPV points') }}</option>`;
    }
    if (!selectedcondition.includes("i")) {
        selectbox += `<option value="i">{{ __('Sales Target') }}</option>`;
    }
    if (!selectedcondition.includes("j")) {
        selectbox += `<option value="j">{{ __('Group Sales Target') }}</option>`;
    }
    if (!selectedcondition.includes("k")) {
        selectbox += `<option value="k">{{ __('Levels') }}</option>`;
    }

    // Close the select element and add the "Add" button
    selectbox += `
                </select>

                    <button type="button" id="add_condn" onclick="add()"
                            class="px-4 py-2 ml-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">{{ __('ADD') }}</button>
            </div>
        </div>`;

    // Update the inner HTML of the selectcriteria element
    document.getElementById('selectcriteria').innerHTML = selectbox;

}


function add() {
    var selectedcondition = document.getElementById('selectedcondition').value;
    var conditionbox = document.getElementById('conditionbox').value;
    var addconditions = "";

    if (conditionbox === "a") {
        var matrix_id = document.getElementById('matrix_id').value;
        if (matrix_id === "") {
            Swal.fire({
                title: "Select Plan",
                text: "Bonus",
                icon: "warning",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    text: 'text-sm text-black',
                    confirmButton: 'bg-black text-white hover:bg-gray-800 font-semibold py-2 px-4 rounded-lg',
                    cancelButton: 'bg-gray-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                },
                confirmButtonText: "Ok"
            });
            return false;
        } else {
            document.getElementById('addpackage').classList.remove('hidden');
            fetch(`/admin/getpackages/get/${matrix_id}`)
                .then(response => response.text())
                .then(result => {
                    document.getElementById('package').innerHTML = result;
                });
            document.getElementById('selectedcondition').value = selectedcondition + "a,";
        }
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "b") {
        var matrix_id = document.getElementById('matrix_id').value;
        if (matrix_id === "") {
            Swal.fire({
                title: "Select Plan",
                text: "Bonus",
                icon: "warning",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    text: 'text-sm text-black',
                    confirmButton: 'bg-black text-white hover:bg-gray-800 font-semibold py-2 px-4 rounded-lg',
                    cancelButton: 'bg-gray-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                },
                confirmButtonText: "Ok"
            });
            return false;
        } else {
            document.getElementById('addrank').classList.remove('hidden');
            fetch(`/admin/getranks/get/${matrix_id}`)
                .then(response => response.text())
                .then(result => {
                    document.getElementById('rank').innerHTML = result;
                });
            document.getElementById('selectedcondition').value = selectedcondition + "b,";
        }
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "c") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">No of Direct Referrals</label>
            <input type="number" name="No_of_Direct_Referals"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "c,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "d") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">No of Group Referrals</label>
            <input type="number" name="No_of_Group_Referals"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "d,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "e") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Number of Sales</label>
            <input type="number" name="Number_of_Sales"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "e,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "f") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Number of Products sold</label>
            <input type="number" name="Number_of_Products_sold"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "f,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "g") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">PV Points</label>
            <input type="number" name="PV_Points"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "g,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "h") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">GPV points</label>
            <input type="number" name="GPV_points"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "h,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "i") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Sales Target</label>
            <input type="number" name="Sales_Target"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "i,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "j") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Group Sales Target</label>
            <input type="number" name="Group_Sales_Target"
                aria-describedby="helper-text-explanation"
                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                placeholder="" >
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "j,";
        document.getElementById('selectcriteria').classList.add('hidden');
    } else if (conditionbox === "k") {
        addconditions += `
        <div class="mb-5">
            <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Levels</label>
            <textarea aria-label="label" name="levels" rows="6" cols="43"></textarea>(eg : LL1-4, LL2-8, LL3-10)
        </div>`;
        document.getElementById('addconditions').insertAdjacentHTML('beforeend', addconditions);
        document.getElementById('selectedcondition').value = selectedcondition + "k,";
        document.getElementById('selectcriteria').classList.add('hidden');
    }
}

function redirectback() {
    window.location = "/admin/showbonuslist";
}

function bonustype() {
    var bonusType = document.getElementById('Bonus_Type').value;
    var bonusMethod = document.getElementById('bonusmethod');

    if (bonusType == 1) {
        bonusMethod.classList.add('hidden'); // Adds the hidden class
    } else if (bonusType == 2) {
        bonusMethod.classList.remove('hidden'); // Removes the hidden class
    }
}
</script>
@endsection
