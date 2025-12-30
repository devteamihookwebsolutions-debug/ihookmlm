@extends('admin::components.common.main')

@section('content')
<!-- breadcrub navs start-->
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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">E-Pin</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Send E-pin</span>
            </div>
        </li>

    </ol>
</div>
<!-- breadcrub navs end-->
<!-- Content area -->

<main class="flex-grow">
    <div class="">
     @include('components.common.info_message')


        <div class="flex items-start p-4 mb-4 text-xs text-blue-800 border border-blue-300 rounded-lg bg-gray-50 dark:bg-gray-900 dark:text-blue-400 dark:border-blue-800"
            role="alert">
            <svg class="flex-shrink-0 inline w-3 h-3 me-3 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">{{ __('Info') }}</span>
            <div class="">
                <div class="font-medium">{{ __('Use this tool to generate E-pin (Coupon Code) For package purchases or any other purchases within back-office, And will give to your close customers or active customers or anything you want.') }}</div>

            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-5 p-6">
                <!-- card -->

                <form class="validated-form" id="epinSettingsForm" method="POST" novalidate
                    action="{{ route('updateepins')}}" enctype="multipart/form-data">
                       @csrf
                    <input type="hidden" name="user_list[]" id="user_list">
                    <div>
                        <div class="mb-4">
                            <label for=""
                                class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Username') }}
                            </label>
                            <div id="search-combobox" class="relative mb-4" data-hs-combo-box="">
                                <div class="relative">
                                    <input type="text" name="username" id="username"
                                        class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        placeholder="Search..."  required aria-expanded="false" data-hs-combo-box-input=""
                                        onkeyup="filterSuggestions(this.value)" aria-describedby="username-error"/>
                                    <!-- <button type="button" onclick="genealogySearch();"
                                        class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-gray-700 rounded-e-lg border border-blue-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800"
                                        bis_size="{&quot;x&quot;:772,&quot;y&quot;:20,&quot;w&quot;:38,&quot;h&quot;:42,&quot;abs_x&quot;:1244,&quot;abs_y&quot;:6086}"><svg
                                            class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                                            bis_size="{&quot;x&quot;:783,&quot;y&quot;:33,&quot;w&quot;:16,&quot;h&quot;:16,&quot;abs_x&quot;:1255,&quot;abs_y&quot;:6099}">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                                bis_size="{&quot;x&quot;:783,&quot;y&quot;:33,&quot;w&quot;:14,&quot;h&quot;:14,&quot;abs_x&quot;:1255,&quot;abs_y&quot;:6099}">
                                            </path>
                                        </svg></button> -->
                                </div>
                                <div id="suggestion-box"
                                    class="absolute z-50 w-full h-32 mt-1 bg-white rounded-lg shadow-md overflow-y-auto hidden"
                                   >
                                  {!! $member !!}
                                </div>
                                <p id="username-error"
                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please select a valid username') }}.</p>
                        </div>
                        <div class="mb-4">
                            <label for=""
                                class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Count') }}</label>
                            <input type="text" id="count" name="count"
                                class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                placeholder="" value="" required aria-describedby="count-error">
                            <p id="count-error"
                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid username') }}.</p>
                        </div>

                        <div class="mb-4">
                            <label for="name"
                                class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Types') }}:</label>
                                {!!$epintype!!}
                                <p id="epintype-error"
                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid type') }}.</p>
                        </div>
                        <div class="mb-4">
                            <label for=""
                                class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Amount') }}</label>
                            <input type="text" id="epin_amount" name="epin_amount"
                                class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                placeholder="" value="" required aria-describedby="epinamount-error">
                            <p id="epinamount-error"
                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid amount') }}</p>
                        </div>
                        <input aria-label="label" type="hidden" name="epin_amount_package" id="epin_amount_package" value="">
                        <div class="mb-4">
                            <label for=""
                                class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Memo') }}</label>
                            <textarea name="memo" id="memo" rows="4"
                                class="text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                placeholder="" required
                                aria-describedby="memo-error"></textarea>
                            <p id="memo-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                {{ __('Please enter a valid company address') }}.</p>
                        </div>

                    </div>

                    <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                        <button type="submit"
                            class="px-5 py-2.5 me-2 mb-2 rounded bg-gray-800 text-white dark:bg-gray-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                            {{ __('Submit') }}
                        </button>
                        <button type="button" onclick="window.history.back();" class=" text-black dark:text-white bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-900  dark:hover:bg-gray-800 dark:hover:border-gray-600 dark:focus:ring-gray-700 ">{{ __('Cancel') }}</button>
                    </div>

            </form>
        </div>
            <div class="flex flex-col p-10">
                <!--image-space-->
                <img src="{{ asset('/img/host-party.svg') }}" alt="add-customer"
                    class="w-full sticky top-24 overflow-hidden">
                <!--image-space-->
            </div>
        </div>
        <!-- card -->
    </div>

</main>

<!--- form validateion-->
<script>
class FormHandler {
    constructor(formId) {
        this.form = document.getElementById(formId);
        if (!this.form) return;
        this.submitButton = this.form.querySelector('button[type="submit"]');
        this.attachListeners();
    }

    attachListeners() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        // Real-time validation
        this.form.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
            input.addEventListener('input', () => this.validateInput(input));
        });
    }

    validateInput(input) {
        const value = input.value.trim();
        const errorId = input.getAttribute('aria-describedby');
        const errorElement = document.getElementById(errorId);

        if (!value) {
            input.classList.add('border-red-500');
            if (errorElement) {
                errorElement.textContent = 'This field is required';
                errorElement.classList.remove('hidden');
            }
            return false;
        } else {
            input.classList.remove('border-red-500');
            if (errorElement) errorElement.classList.add('hidden');
            return true;
        }
    }

    handleSubmit(e) {
        e.preventDefault();
        const inputs = Array.from(this.form.querySelectorAll('input[required], select[required], textarea[required]'));
        const allValid = inputs.every(input => this.validateInput(input));
        if (!allValid) return;

        if (this.submitButton) {
            this.submitButton.disabled = true;
            this.submitButton.textContent = 'Submitting...';
        }

        this.form.submit(); // submit once
    }
}

// Initialize
new FormHandler('epinSettingsForm');
</script>


<!--username check-->
    <script>
    let typingTimeout;

function filterSuggestions(query) {
    // alert(query);
    const suggestionBox = document.getElementById("suggestion-box");
    const items = suggestionBox.querySelectorAll("div[data-username]");

    if (query.trim() === "") {
        suggestionBox.classList.add("hidden");
        return;
    }

    let hasVisible = false;

    items.forEach((item) => {
        if (item.dataset.username.toLowerCase().includes(query.toLowerCase())) {
            item.classList.remove("hidden");
            hasVisible = true;
        } else {
            item.classList.add("hidden");
        }
    });

    if (hasVisible) {
        suggestionBox.classList.remove("hidden");
    } else {
        suggestionBox.classList.add("hidden");
    }

    clearTimeout(typingTimeout);

    typingTimeout = setTimeout(() => {
        checkUsernameExists(query);
    }, 500);
}


async function checkUsernameExists(username) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    const response = await fetch("{{ route('admin.usernamecheck') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ username })
    });

    const data = await response.json();

    console.log("Response:", data);

    if (data.status === "success") {
        // save member_id in hidden field
        document.getElementById("user_list").value = data.member_id;
        return true;
    } else {
        document.getElementById("user_list").value = "";
        return false;
    }
}
function selectSuggestion(el) {
    const id = el.dataset.id;
    const username = el.dataset.username;

    document.querySelector("[data-hs-combo-box-input]").value = username;
    document.getElementById("user_list").value = id;

    document.getElementById("suggestion-box").classList.add("hidden");
}



function showPackageAmount(id) {
    const epinAmount = document.getElementById("epin_amount");
    const epinAmountPackage = document.getElementById("epin_amount_package");

    // Initially disable the input field
    epinAmount.disabled = true;

    if (id === '100000000000001') {
        epinAmount.disabled = false;
    } else {
        const [packageId, tid] = id.split(",");
    fetch(`/admin/sendepin/getpackageamount/${packageId}/${tid}`)
    .then(response => response.json())
    .then(data => {
        epinAmount.value = data.amount;
        epinAmountPackage.value = data.amount;
    })
    .catch(error => console.error("Error fetching package amount:", error));
    }
}

</script>

@endsection
