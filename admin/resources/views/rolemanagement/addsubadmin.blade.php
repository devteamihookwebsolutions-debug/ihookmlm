@extends('admin::components.common.main')

@section('content')


<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white mb-2">{{ __('Add Subadmin') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="{{$_ENV['BCPATH']}}/adminhome" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __('Home') }}
                        </a>
                    </li>
                    <li aria-current="page">
                      <div class="flex items-center">
                          <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m1 9 4-4-4-4" />
                          </svg>
                          <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Team') }}</span>
                      </div>
                  </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Subadmin') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Add Subadmin') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->
<!-- breadcrub navs end-->

        <!-- Content area -->
        <main class="flex-grow">
             <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
                <!--Success and Failure Messge-->
            @include('components.common.info_message')
            <!--Success and Failure Messge-->
                <div class="flex p-4 mb-6 text-sm text-blue-800 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 border border-blue-300"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                        </path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>

                        <div>
                            <p class="mb-2">Admin can create multiple sub admins with the below customized menus. Only selected menus can be used by particular sub admin users.</p>


                        </div>
                    </div>
                </div>
                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                    <!-- card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">



                        <div>

                            <div class="p-4 rounded-lg" id="default-group" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">

                                    <!-- Left side: Form content -->

                                    <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5" >
                                        <form name="addsubadmin" id="addsubadmin" method="POST"  action="{{ route('subadmin.store') }}" enctype="multipart/form-data"
                                            novalidate="novalidate" class="mx-auto validated-form">

                                                @csrf
                                            <div class="mb-5">
                                                <label for=""
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Admin Name') }}</label>
                                                <input type="text" id="sadmin_name" name="sadmin_name"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                    placeholder="" required aria-describedby="adminname-error">
                                                    <p id="adminname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid name.</p>
                                            </div>

                                            <div class="mb-5">
                                                <label for=""
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Admin Password') }}</label>
                                                <input type="password" id="sadmin_password" name="sadmin_password"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                    placeholder="" required aria-describedby="adminpassword-error">
                                                    <p id="adminpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid password.</p>
                                            </div>

                                            <div class="mb-5">
                                                <label for=""
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Admin Email') }}</label>
                                                <input type="type" id="sadmin_email" name="sadmin_email"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                    placeholder="" required aria-describedby="adminemail-error">
                                                    <p id="adminemail-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid email.</p>
                                            </div>



                                            <div class="mb-5">
                                                <label for=""
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Select role') }}</label>
                                                    <select name="role_type" id="role_type"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" data-live-search="true">
                                                    {!! $showroles !!}
                                                    </select>
                                            </div>

                                            <div class="mb-5">
                                    <label for=""class="block mb-2 text-sm font-medium text-black dark:text-white">{{  __('Status') }}</label>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-black font-medium">{{  __('Off') }}</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" name="admin_status" id="admin_status"  value="1" onchange="updateText()" />
                                            <div class="w-12 h-6 bg-neutral-900 rounded-full peer peer-checked:bg-neutral-500 peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-neutral-300 after:rounded-full after:h-5 after:w-5 after:transition-transform"></div>
                                        </label>
                                        <span id="toggleText" class="text-black font-medium">{{ __('On') }}</span>
                                    </div>
                                </div>







                                            <div class="flex justify-end mt-5 border-t border-neutral-200  pt-5">
                                               <button type="button" onclick="window.history.back();"
                                                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
                                                <button type="submit"
                                                    class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- card -->

                    </div>
                    <!--Row-1-->

                </div>
        </main>

@include('components.common.footer')
@include('components.common.footer_scripts')
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
      form: document.getElementById('addsubadmin'),
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

          </script>




@endsection
