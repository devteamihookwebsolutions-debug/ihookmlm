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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Settings</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">System</span>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Wordpress E-Wallet API</span>
            </div>
        </li>
    </ol>
</div>



<main class="flex-grow">
<div class=" mx-auto flex p-4 mb-6 text-xs text-blue-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-300" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
           <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">{{ __('Info') }}</span>
        <div>
           <div>
              <p class="mb-2">{{ __('Use this tool to generate custom payment gateway for E-Wallet exclusively customized for woocommerce shop checkout.') }}</p>
           </div>
        </div>
     </div>
        <div class=" mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
             <!--Success and Failure Messge-->
       @include('components.common.info_message')
     <!--Success and Failure Messge-->


            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 dark:text-white border border-gray-200">

                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">

                    <!--form-->
                        <div class="customer-form">
                              <form name="ewalletgateway" id="ewalletgateway" method="POST"
                                action="{{ route('admin.updateewallet')}}" class="mb-5 pt-4 validated-form" novalidate>
                              @csrf
                                <div class="mb-5">
                                  <label for="apiusername"
                                                    class="block text-xs text-gray-600 dark:text-gray-300 mb-3">API
                                                    Username</label>
                                <input
    type="text"
    class="w-full bg-gray-50 px-4 py-2 border border-gray-300 text-xs text-gray-600 rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
    name="apiusername"
    value="{{ old('apiusername', $apiusername) }}"
    required
    aria-describedby="apiusername-error">

                                    <p id="apiusername-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                </div>
                                <div class="mb-5">
                                    <label for="apipassword"
                                                    class="block text-xs text-gray-600 dark:text-gray-300 mb-3">API
                                                    Password</label>
                                <input
    type="text"



    name="apipassword"
    id="apipassword"
    class="w-full bg-gray-50 px-4 py-2 border border-gray-300 text-xs text-gray-600 rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
    value="{{ old('apipassword', $apipassword) }}"
    readonly
    required
    aria-describedby="apipassword-error">

                                    <p id="apipassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                </div>
                                <div class="mb-5">
                                <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-xs px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600"
 onclick="getkey()">{{ __('Generate Token') }}</button>
                                </div>
                                <div class="mb-5">
                                          <label for=""
                                                    class="block text-xs text-gray-600 dark:text-gray-300 mb-3">Ewallet
                                                    Status :</label>
                                    <div class="flex items-center space-x-2">
                                         <span class="text-xs text-gray-600 dark:text-gray-300">Off</span>
                                      <label class="inline-flex items-center cursor-pointer mx-3">
                                            <input type="checkbox" class="sr-only peer" name="ewallet-gateway_status" id="ewallet-gateway_status" value="1" @if($apistatus == '1') checked @endif/>
                                            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                        <span id="toggleText" class="text-xs text-gray-600 dark:text-gray-300">{{ __('On') }}</span>
                                    </div>
                                </div>
                                        <div class="flex items-center justify-end pt-6 space-x-3 border-t dark:border-gray-700">
                                                <button
                                                    class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:border-gray-700">
                                                    Cancel
                                                </button>
                                                <button
                                                    class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
                                                    Submit
                                                </button>
                                            </div>
                                </div>
                            </form>
                         </div>

                         <div class="flex flex-col p-10">


                         </div>
                    </div>
                </div>
            </div>
        </main>

<!-- Content area end-->

<!-- Footer -->

<script>
var loadFile = function(event) {
    var input = event.target;
    var file = input.files[0];
    var type = file.type;

    // Get the preview ID from the data-preview-id attribute
    var previewId = input.getAttribute('data-preview-id');
    var output = document.getElementById(previewId);

    if (output) {
        output.src = URL.createObjectURL(file);
        output.onload = function() {
            URL.revokeObjectURL(output.src); // free memory
        };
    } else {
        console.error("Preview element not found for ID:", previewId);
    }
};

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
      form: document.getElementById('ewalletgateway'),
    };
  }

  attachEventListeners() {
    this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));

    // Real-time validation for required inputs, selects, and textareas
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach((input) => {
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
      this.showError(input, errorElement, 'Invalid format.');
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
    const inputs = Array.from(this.elements.form.querySelectorAll('input[required], select[required], textarea[required]'));
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

<script>
    function getkey() {
 fetch('{{ route('generateKey') }}', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
})

    .then(response => response.text()) // Assumes the response is plain text
    .then(response => {
        document.getElementById('apipassword').value = response;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script>
@endsection
