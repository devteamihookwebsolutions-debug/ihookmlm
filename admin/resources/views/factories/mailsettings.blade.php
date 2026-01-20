@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __('Mail') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ env('BCPATH')}}/adminhome"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                    clip-rule="evenodd" />
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
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Settings') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">
                                {{ __('Notifications') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">
                                {{ __('Mail') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->



<!-- Content area -->
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                        data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-black hover:text-black dark:text-white dark:hover:text-black border-neutral-600 dark:border-neutral-500"
                        data-tabs-inactive-classes="text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        role="tablist">

                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab"
                                data-tabs-target="#default-group" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">{{ __('Email Notification') }}</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-black hover:border-neutral-300 dark:hover:text-neutral-300"
                                id="dashboard-styled-tab" data-tabs-target="#personal-group" type="button"
                                role="tab" aria-controls="dashboard"
                                aria-selected="false">{{ __('Settings') }}</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-black hover:border-neutral-300 dark:hover:text-neutral-300"
                                id="dashboard-styled-tab" data-tabs-target="#general-group" type="button"
                                role="tab" aria-controls="dashboard"
                                aria-selected="false">{{ __('General Settings') }}</button>
                        </li>
                    </ul>
                </div>
                <div id="default-styled-tab-content">
                    <div class="hidden p-4 rounded-lg " id="default-group" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <div class="datatable-wrapper datatable-loading no-footer sortable fixed-columns">
                            <div class="datatable-top">
                            </div>
                            <div class="datatable-container">
                                {!! $email_set !!}
                            </div>
                        </div>
                    </div>
                    <div class="hidden p-4 rounded-lg " id="personal-group" role="tabpanel"
                        aria-labelledby="dashboard-tab">
                        <!--personal-group-->
                        <!--select-group-button-->
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-5">
                            <div class="">
                                <div class=" mb-3">
                                    <form class="" id="updatemailsettings" name="updatemailsettings"
                                        action="{{ route('emailsettings.store') }}" method="post"
                                        enctype="multipart/form-data">
                                            @csrf
                                        <div class="">
                                            <!-- Mail Type Dropdown -->
                                            <div class="mb-4">
                                                <label for=""
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mail Type') }}</label>
                                            <select id="smtp_perfer" name="smtp_perfer"
                                                onchange="viewSmtpSettings(this.value);"
                                                class="text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                required>

                                            <option value="0" @if ($errval->smtp_perfer == 0) selected @endif>
                                                {{ __('PHP') }}
                                            </option>

                                            <option value="1" @if ($errval->smtp_perfer == 1) selected @endif>
                                                {{ __('SMTP') }}
                                            </option>

                                            <option value="2" @if ($errval->smtp_perfer == 2) selected @endif>
                                                {{ __('SendGrid') }}
                                            </option>

                                            <option value="3" @if ($errval->smtp_perfer == 3) selected @endif>
                                                {{ __('Mailchimp') }}
                                            </option>

                                            <option value="4" @if ($errval->smtp_perfer == 4) selected @endif>
                                                {{ __('MailJet') }}
                                            </option>

                                            <option value="5" @if ($errval->smtp_perfer == 5) selected @endif>
                                                {{ __('Brevo') }}
                                            </option>

                                        </select>

                                            </div>
                                            <div id="view" class="mb-5 hidden">
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('SMTP Host Name') }}</label>
                                                    <input type="text" id="smtp_hname" name="smtp_hname"
                                                        value="{{ $errval->smtp_hname }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('SMTP Port') }}</label>
                                                    <input type="text" id="smtp_port" name="smtp_port"
                                                        value="{{ $errval->smtp_port }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('SMTP Username') }}</label>
                                                    <input type="text" id="smtp_user" name="smtp_user"
                                                        value="{{ $errval->smtp_user }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('SMTP Password') }}</label>
                                                    <input type="text" id="smtp_pass" name="smtp_pass"
                                                        value="{{ $errval->smtp_pass }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Sender Mail') }}</label>
                                                    <input type="text" id="sender_email" name="sender_email"
                                                        value="{{ $errval->sender_email }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Sender Name') }}</label>
                                                    <input type="text" id="sender_name" name="sender_name"
                                                        value="{{ $errval->sender_name }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                            <div id="viewmailjet" class="mb-5 hidden">
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Public Key') }}</label>
                                                    <input type="text" id="mailjet_public_key"
                                                        name="mailjet_public_key"
                                                        value="{{ $errval->mailjet_public_key }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Private Key') }}</label>
                                                    <input type="text" id="mailjet_private_key"
                                                        name="mailjet_private_key"
                                                        value="{{ $errval->mailjet_private_key }}"
                                                        class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                            <div class="flex justify-end gap-2 border-t pt-4 mt-6">
                                                <button type="submit" name="submit" id="submit"
                                                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">{{ __('Submit') }}</button>
                                                <a aria-label="link" href="javascript:void(0);"
                                                    onclick="window.history.back();"><button type="button"
                                                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105">{{ __('Cancel') }}</button></a>
                                            </div>
                                            <!-- Hidden Mail Type Input -->
                                            <input type="hidden" id="selectMailType" name="selectMailType"
                                                value="0">

                                            <!-- Submit & Cancel Buttons -->
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="hidden p-4 rounded-lg " id="general-group" role="tabpanel"
                        aria-labelledby="dashboard-tab">
                        <!--personal-group-->
                        <!--select-group-button-->
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-5">
                            <div class="">
                                <div class=" mb-3">
                                    <form class="validated-form" novalidate id="updategeneralsettings"
                                        name="updategeneralsettings"
                                        action="{{ route('emailsettings.add') }}" method="post"
                                        enctype="multipart/form-data">
                                @csrf
                                        <div class="">
                                            <div class="col-span-2 mb-4">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white"
                                                    for="mail_sitelogo">{{ __('Mail SiteLogo') }}</label>
                                                <input
                                                    class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400"
                                                    id="mail_sitelogo" name="mail_sitelogo" type="file"
                                                    accept="image/x-png,image/gif,image/jpeg,image/png"
                                                    onchange="previewImage(event, 'sitelogoPreview', 'sitelogoError')"
                                                    value="{{ $mail_sitelogo }}">
                                                <input aria-label="label" type="hidden" name="MAX_FILE_SIZE"
                                                    value="10485760" />

                                                <!-- Preview and Error -->
                                                <div id="sitelogoPreview" class="mt-2 hidden">
                                                    <img id="previewSiteLogo" src="{{ $mail_sitelogocdn }}"
                                                        alt="Site Logo Preview"
                                                        class="w-32 h-32 object-cover rounded-md">
                                                </div>
                                                <span id="sitelogoError"
                                                    class="text-red-500 text-sm mt-2 hidden"></span>
                                            </div>

                                            <input aria-label="label" type="hidden" name="hidden_mail_sitelogo"
                                                value="{{ $mail_sitelogo }}">

                                            <div class="col-span-2 mb-4">
                                                <label
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white"
                                                    for="mail_background">{{ __('Mail Background') }}</label>
                                                <input
                                                    class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400"
                                                    id="mail_background" name="mail_background" type="file"
                                                    accept="image/x-png,image/gif,image/jpeg,image/png"
                                                    onchange="previewImage(event, 'backgroundPreview', 'backgroundError')"
                                                    value="{{ $mail_backgroundcdn }}">
                                                <input aria-label="label" type="hidden" name="MAX_FILE_SIZE"
                                                    value="10485760" />

                                                <!-- Preview and Error -->
                                                <div id="backgroundPreview" class="mt-2 hidden">
                                                    <img id="previewBackground" src="{{ $mail_backgroundcdn }}"
                                                        alt="Background Preview"
                                                        class="w-32 h-32 object-cover rounded-md">
                                                </div>
                                                <span id="backgroundError"
                                                    class="text-red-500 text-sm mt-2 hidden"></span>
                                            </div>
                                            <input aria-label="label" type="hidden" name="hidden_mail_background"
                                                value="{{ $mail_background }}">


                                            <div class="mb-4">
                                                <label for="facebooklinkurl"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Facebook') }}</label>
                                                <input type="text" name="facebooklinkurl" id="facebooklinkurl"
                                            value="{{ $show_sitesettings['facebooklinkurl'] ?? '' }}"
                                                    class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="" required aria-describedby="facebooklinkurl-error">
                                                <p id="facebooklinkurl-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                </p>
                                            </div>
                                            <div class="mb-4">
                                                <label for="twitterlinkurl"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Twitter') }}</label>
                                                <input type="text" name="twitterlinkurl" id="twitterlinkurl"
                                                 value="{{ $show_sitesettings['twitterlinkurl'] ?? '' }}"
                                                    class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="" required aria-describedby="twitterlinkurl-error">
                                                <p id="twitterlinkurl-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                </p>
                                            </div>
                                            <div class="mb-4">
                                                <label for="linkedinlinkurl"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('LinkedIn') }}</label>
                                                <input type="text" name="linkedinlinkurl" id="linkedinlinkurl"
                                                   value="{{ $show_sitesettings['linkedinlinkurl'] ?? '' }}"
                                                    class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="" required aria-describedby="linkedinlinkurl-error">
                                                <p id="linkedinlinkurl-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                </p>
                                            </div>
                                            <div class="mb-4">
                                                <label for="name"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Instagram') }}</label>
                                                <input type="text" name="instalinkurl" id="instalinkurl"
                                                    class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="" value="{{ $show_sitesettings['instalinkurl'] ?? '' }}"
                                                    required aria-describedby="facebooklinkurl-error">
                                                <p id="facebooklinkurl-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                </p>
                                            </div>
                                            <div class="mb-4">
                                                <label for="googlelinkurl"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Google') }}</label>
                                                <input type="text" name="googlelinkurl" id="googlelinkurl"
                                                  value="{{ $show_sitesettings['googlelinkurl'] ?? '' }}"
                                                    class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="" required aria-describedby="googlelinkurl-error">
                                                <p id="googlelinkurl-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                </p>
                                            </div>
                                            <div class="flex justify-end gap-2 border-t pt-4 mt-6">
                                                <button type="submit"
                                                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                                                    {{ __('Submit') }}
                                                </button>
                                                <a aria-label="link" href="javascript:void(0);"
                                                    onclick="window.history.back();"><button type="button"
                                                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105">{{ __('Cancel') }}</button></a>
                                            </div>
                                            <!-- Hidden Mail Type Input -->
                                            <input type="hidden" id="selectMailType" name="selectMailType"
                                                value="0">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
        </div>
        <!--Row-1-->
    </div>
</main>




<!-- Content area end-->

<!-- Footer -->

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
                form: document.getElementById('updategeneralsettings'),
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
    // JavaScript function to show SMTP or SendGrid settings based on selection
    function showSmtpSettings(mailType) {
        var smtpFields = document.getElementById('viewsmtp');
        var sendgridFields = document.getElementById('viewsendgrid');
        if (mailType == '1') { // SMTP selected
            smtpFields.style.display = 'block';
            sendgridFields.style.display = 'none';
        } else if (mailType == '2') { // SendGrid selected
            smtpFields.style.display = 'none';
            sendgridFields.style.display = 'block';
        } else {
            smtpFields.style.display = 'none';
            sendgridFields.style.display = 'none';
        }
    }

    function updateMailTemplates(lid, id) {
        window.open('/admin/editemail/edit/' + id + '/' + lid, 'popUpWindow',
            'height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes'
            )
      
    }

    function previewImage(event, previewId, errorId) {
        const file = event.target.files[0];
        const fileSize = file.size / 1024; // Size in KB
        const errorMessage = document.getElementById(errorId);
        const previewContainer = document.getElementById(previewId);
        const previewImage = previewContainer.querySelector('img');

        // Clear previous error and preview
        errorMessage.classList.add('hidden');
        previewContainer.classList.add('hidden');
        previewImage.src = "";

        // Validate file size (max 300KB)
        if (fileSize > 300) {
            errorMessage.textContent = 'File size exceeds 300KB.';
            errorMessage.classList.remove('hidden');
            return;
        }

        // Show image preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function viewSmtpSettings(id) {
        if (id == '1') {
            document.getElementById('view').classList.remove('hidden');
            document.getElementById('viewmailjet').classList.add('hidden');
            document.getElementById('smtp_hname').classList.remove('hidden');
            document.getElementById('smtp_port').classList.remove('hidden');
            document.getElementById('smtp_user').classList.remove('hidden');
            document.getElementById('smtp_pass').classList.remove('hidden');
            document.getElementById('sender_name').classList.remove('hidden');
            document.getElementById('sender_email').classList.remove('hidden');
        } else if (id == '2') {
            document.getElementById('view').classList.add('hidden');
            document.getElementById('viewmailjet').classList.add('hidden');
            document.getElementById('smtp_hname').classList.add('hidden');
            document.getElementById('smtp_port').classList.add('hidden');
            document.getElementById('smtp_user').classList.add('hidden');
            document.getElementById('smtp_pass').classList.add('hidden');
            document.getElementById('sender_name').classList.add('hidden');
            document.getElementById('sender_email').classList.add('hidden');
        } else if (id == '3') {
            document.getElementById('view').classList.add('hidden');
            document.getElementById('viewmailjet').classList.add('hidden');
            document.getElementById('smtp_hname').classList.add('hidden');
            document.getElementById('smtp_port').classList.add('hidden');
            document.getElementById('smtp_user').classList.add('hidden');
            document.getElementById('smtp_pass').classList.add('hidden');
            document.getElementById('sender_name').classList.add('hidden');
            document.getElementById('sender_email').classList.add('hidden');
        } else if (id == '4') {
            document.getElementById('view').classList.add('hidden');
            document.getElementById('viewmailjet').classList.remove('hidden');
            document.getElementById('smtp_hname').classList.add('hidden');
            document.getElementById('smtp_port').classList.add('hidden');
            document.getElementById('smtp_user').classList.add('hidden');
            document.getElementById('smtp_pass').classList.add('hidden');
            document.getElementById('sender_name').classList.add('hidden');
            document.getElementById('sender_email').classList.add('hidden');
        } else {
            document.getElementById('view').classList.add('hidden');
            document.getElementById('viewmailjet').classList.add('hidden');
            document.getElementById('smtp_hname').classList.add('hidden');
            document.getElementById('smtp_port').classList.add('hidden');
            document.getElementById('smtp_user').classList.add('hidden');
            document.getElementById('smtp_pass').classList.add('hidden');
            document.getElementById('sender_name').classList.add('hidden');
            document.getElementById('sender_email').classList.add('hidden');
        }
    }
</script>


@endsection
