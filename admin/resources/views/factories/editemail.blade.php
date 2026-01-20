@extends('admin::components.common.main')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/richtexteditor/rte_theme_default.css') }}">
<script src="{{ asset('assets/richtexteditor/rte.js') }}"></script>
<script src="{{ asset('assets/richtexteditor/plugins/all_plugins.js') }}"></script>
<style>
    #div_editor1 .rte-content {
    max-height: 400px;
    overflow-y: auto;
}
</style>
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white mb-2">{{ __('Edit Email') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
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
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-neutral-900 dark:text-blue-400 dark:border-blue-800"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">{{ __('Info') }}</span>
            <div>
                {{ __('Do Not Change The Content Within The [].') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 "
>

                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">

                    <!--form-->
                    <div class="customer-form">
                        <form name="mailcontent" id="mailcontent" method="POST"  class="mb-5 mb-5 pt-4 validated-form"
                          action="{{ route('mail.update', [$mail->mail_id, $mail_lang]) }}"
 novalidate>
                     @csrf

                            <div class="mb-5">
                                <label for=""
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mail Name') }}</label>
                                <input type="" name="mail_name" id="mail_name"
                                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light"
                                    value="{{ $mail_name }}" disabled>
                            </div>
                            <div class="mb-5">
                                <label for="mail_from_name"
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Display Name') }}</label>
                                <input type="text" name="mail_from_name" id="mail_from_name"
                                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light"
                                    value="{{ $errval->mail_from_name }}" required
                                    aria-describedby="mail_from_name-error">
                                <p id="mail_from_name-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                            </div>
                            <div class="mb-5">
                                <label for="mail_from"
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('From Email Address') }}</label>
                                <input type="email" name="mail_from" id="mail_from"
                                    pattern="[a-zA-Z!#$%&‘*/=?^_+-`{|}~.]+@[^@]+\.[a-zA-Z]{2,6}"
                                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light"
                                    placeholder="" value="{{ $errval->mail_from }}" required
                                    aria-describedby="mail_from-error">
                                <p id="mail_from-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                            </div>
                            <div class="mb-5">
                                <label for="mail_subject"
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mail Subject') }}</label>
                                <input type="text" name="mail_subject" id="mail_subject"
                                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light"
                                    value="{{ $errval->mail_subject }}" required
                                    aria-describedby="mail_subject-error">
                                <p id="mail_subject-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                            </div>

                                  <div class="mb-5">
                                <label for="mail_content"
                                    class="block mb-2 text-sm font-medium text-black dark:text-white">
                                    {{ __('Mail Content') }} -
                                  
                                </label>
                                <div id="div_editor1" style="width: 100%">
                               {!! $previewmail_content !!}
                                </div>
                                <p id="mail_content-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                            </div>
                            <div class="mb-5">
                                <label
                                    for=""class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mail Status') }}</label>
                                <div class="flex items-center space-x-2">
                                    <span class="text-black font-medium">{{ __('Suspend') }}</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" name="mail_status"
                                            id="mail_status" value="1"
                                            @if ($errval->mail_status == '1') checked @endif />
                                        <div
                                            class="w-12 h-6 bg-neutral-900 rounded-full peer peer-checked:bg-neutral-500 peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-neutral-300 after:rounded-full after:h-5 after:w-5 after:transition-transform">
                                        </div>
                                    </label>
                                    <span id="toggleText"
                                        class="text-black font-medium">{{ __('Active') }}</span>
                                </div>
                            </div>
                            <input type="hidden" name="message_content" id="hidden-message-content">


                            <div class="flex justify-end">
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-neutral-700 focus:outline-none  focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                                    {{ __('Submit') }}
                                </button>
                                <a aria-label="link" href="/admin/viewemailsetting"><button
                                        type="button"
                                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105">{{ __('Cancel') }}</button></a>
                            </div>
                         </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
</main>
<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">

        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">

            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Preview') }}
                </h3>
                <button type="button"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                    data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <textarea id="message" rows="18" cols="18"
                    class="block p-2.5 w-full text-sm text-black dark:text-white bg-blue-50 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="">{{ $previewmail_content }}</textarea>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-neutral-200 rounded-b ">
                <a aria-label="link" href="{{ env('BCPATH') }}/viewemailsetting"><button type="button"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Close') }}</button></a>
            </div>
        </div>
    </div>
</div>

<!-- Content area end-->

<!-- Footer -->


<script>
	var editor1 = new RichTextEditor("#div_editor1");


const wysiwygContent = editor1.getHTMLCode();    
document.getElementById('hidden-message-content').value = wysiwygContent;


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
                form: document.getElementById('mailcontent'),
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
            const inputs = Array.from(this.elements.form.querySelectorAll(
                'input[required], select[required], textarea[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));
            const wysiwygContent = editor1.getHTMLCode();    
            document.getElementById('hidden-message-content').value = wysiwygContent;
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

    function showMessageContent() {
        document.getElementById('default-modal').classList.remove('hidden');
    }
</script>
@endsection