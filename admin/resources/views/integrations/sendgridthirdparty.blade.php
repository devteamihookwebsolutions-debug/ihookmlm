@include('components.common.header')
<!-- custom styles end-->
@include('components.common.topbars')
<!-- breadcrub navs start-->
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __('SendGrid') }}</h2>
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
                             <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Settings') }}</span>
                         </div>
                     </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Integration') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('SendGrid') }}</span>
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
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
            <!-- card -->
            <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                <div class="p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                        <form id="showsendgrid" action="{{$_ENV['BCPATH']}}/integration/update" method="POST" enctype="multipart/form-data" novalidate="novalidate" class="mx-auto validated-form">
                            <input aria-label="label" type="hidden" name="configure" value="{{$sub1}}">
                            <div class="mb-5">
                                <label for=""
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Key') }}
                                </label>
                                <input type="text" id="sendgrid_apikey"  name="sendgrid_apikey" value="{{$updatedrecord['sendgrid_apikey']}}"required
                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                    placeholder="" aria-describedby="apikey-error">
                                    <p id="apikey-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid Bonus name.') }}</p>
                            </div>
                            <div class="mb-5">
                                <table class="min-w-2xl  ">
                                    <tbody>
                                        <tr>
                                            <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __('Integration Status') }}
                                            </td>
                                            <td class="px-6  text-right">
                                                <div class="flex items-center p-2.5">
                                                    <!-- Left label -->
                                                    <span
                                                        class="text-sm font-medium text-black dark:text-white">{{ __('Suspend') }}
                                                    </span>

                                                    <!-- Toggleswitch -->
                                                    <label class="inline-flex items-center cursor-pointer mx-3">
                                                        <input type="checkbox" id="integration_status"
                                                            name="integration_status" value="1" @if($updatedrecord['integration_status'] == '1') checked @endif
                                                            class="sr-only peer">
                                                        <div
                                                            class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                        </div>
                                                    </label>

                                                    <!-- Right label -->
                                                    <span
                                                        class="text-sm font-medium text-black dark:text-white">{{ __('Active') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end pt-10">
                                <a  href="javascript:void(0);" onclick="window.history.back();"
                                class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</a>
                                <button type="submit"
                                    class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-black dark:text-white">{{ __('Help') }}</h3>
                <div class="mt-4">

                    <div class="mt-5">
                        <div class="flex items-center w-full space-x-2">
                            <input type="text" 
                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                readonly="" value="http://www.thinkministry.com/kb/ministryplatform/sendgrid/api-key/">
                            <a id="generate-levels-btn" href="http://www.thinkministry.com/kb/ministryplatform/sendgrid/api-key/" target="_blank" rel="noopener" 
                                class="p-2 text-green-600 bg-green-100 rounded-lg hover:bg-green-200 focus:ring-2 focus:ring-green-300 focus:outline-none dark:bg-green-900 dark:hover:bg-green-800 dark:focus:ring-green-800">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778">
                                    </path>
                                </svg>

                                <span class="sr-only">Generate</span>
                            </a>


                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <!-- Modal toggle -->
                        <button data-modal-target="sendgrid-modal" data-modal-toggle="sendgrid-modal"
                            type="button">
                            <img src="{{$_ENV['UI_ASSET_URL']}}/assets/img/integration/sendgrid_api1.png"
                                alt="send-grid"
                                class="border border-neutral-800 rounded-xl h-80 w-full object-cover">
                        </button>

                        <!-- Main modal -->
                        <div id="sendgrid-modal" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-neutral-200">
                                        <h3 class="text-xl font-semibold text-black dark:text-white">
                                            {{ __('Sendgrid') }}
                                        </h3>
                                        <button type="button"
                                            class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                                            data-modal-hide="sendgrid-modal">
                                            <svg class="w-3 h-3" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        <img src="{{$_ENV['UI_ASSET_URL']}}/assets/img/integration/sendgrid_api1.png"
                                            alt="send grid" class=" h-auto w-full object-cover">
                                    </div>
                                    <!-- Modal footer -->
                                    <div
                                        class="flex justify-end p-4 md:p-5 border-t border-neutral-200 rounded-b ">

                                        <button data-modal-hide="sendgrid-modal" type="button"
                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-black  focus:outline-none bg-white rounded-lg border border-neutral-200 hover:bg-neutral-100  focus:z-10 focus:ring-4 focus:ring-neutral-100 dark:focus:ring-neutral-700 dark:bg-neutral-900 dark:text-white  dark:hover:text-white dark:hover:bg-neutral-700">{{ __('Close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('components.common.footer')
@include('components.common.footer_scripts')
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
          form: document.getElementById('showsendgrid'),
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
@include('components.common.footer_end')