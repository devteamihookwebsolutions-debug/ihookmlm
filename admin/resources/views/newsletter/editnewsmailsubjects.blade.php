@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white mb-2">{{ __('Edit Newsletter Template') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="admin/adminhome"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"></path>
                            </svg>
                            {{ __('Marketing') }}
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <a href="admin/newslettertemplate"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            {{ __('Newsletter Template') }}
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            {{ __('Edit Newsletter Template') }}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>                
    </div>
</div>
<!-- breadcrub navs end-->

    <main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
             <!--Success and Failure Messge-->
       @include('components.common.info_message')
     <!--Success and Failure Messge-->

            
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">            
                <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 "
>
                 
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                    
                    <!--form-->
                        <div class="customer-form">
                              <form  id="newlist" method="POST"
                                action="{{route('newslettertemplate.update', $sub1)}}" class="mb-5 pt-4 validated-form" novalidate>
                                    @csrf
                                      @method('PUT')
                                <div class="mb-5">
                                <label for="template_name"
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Template Name') }}</label>
                                <input type="text" name="template_name" id="template_name" 
                                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light"  value="{{ old('category_templates_name', $template->category_templates_name) }}"  required aria-describedby="template_name-error">
                                    <p id="template_name-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                </div>
                                <div class="mb-5">
                                    <label for=""class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status') }}</label>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-black font-medium">{{ __('Suspend') }}</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" name="status" id="status"  value="1" {{$template->category_templates_status == 1 ? 'checked' : '' }}>
                                            <div class="w-12 h-6 bg-neutral-900 rounded-full peer peer-checked:bg-neutral-500 peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-neutral-300 after:rounded-full after:h-5 after:w-5 after:transition-transform"></div>
                                              <input type="hidden" name="status" value="0">
                                        </label>
                                        <span id="toggleText" class="text-black font-medium">{{ __('Active') }}</span>
                                    </div>

                                </div>
                                <div class="flex justify-end p-4">
                                    <div class="form-submit">
                                        <button type="submit" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>                                              {{ __('Submit') }}</button>
                                        <a aria-label="link" href="javascript:void(0);" onclick="window.history.back();"><button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>                                           {{ __('Cancel') }}</button></a>
                                     </div>
                                </div>
                            </form>
                         </div>
                        
                         </div>    
                    </div>                   
                </div>
            </div>
        </main>



<!-- Content area end-->


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
      form: document.getElementById('newlist'),
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

@endsection