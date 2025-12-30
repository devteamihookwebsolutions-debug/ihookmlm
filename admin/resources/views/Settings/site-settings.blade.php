@extends('admin::components.common.main')
@section('content')
        <!-- Breadcrumb -->

<div class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin/dashboard"
                class="inline-flex items-center text-xs font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">General Settings

                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Site Settings
                </a>
            </div>
        </li>
    </ol>
</div>
        <main class="flex-grow">
            <div class="container mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
                 @include('components.common.info_message')
                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 border dark:border-gray-800 dark:bg-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-5 p-6">
                        <form class="mx-auto validated-form" enctype="multipart/form-data" action="{{ route('site-settings.store') }}" method="POST">
                            @csrf
                            <div class="flex flex-col gap-3">
                                <div class="mb-4">
                                    <label for="site_name" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Name</label>
                                    <input type="text" id="site_name" name="site_name" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="Title" value="{{ $settings['site_name'] ?? '' }}" required aria-describedby="sitename-error">
                                    <p id="sitename-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid sitename.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="site_version" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Version</label>
                                    <input type="text" id="site_version" name="site_version" value="1.1" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" value="{{ $settings['site_version'] ?? '' }}" readonly>
                                </div>
                                <div class="mb-4">
                                    <label for="site_url" class="block mb-3 text-xs text-gray-600 dark:text-gray-300 ml-2">Site URL</label>
                                    <input type="text" id="site_url" name="site_url" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="http://domainname.com" value="{{ $settings['site_url'] ?? '' }}" required aria-describedby="siteurl-error">
                                    <p id="siteurl-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid sitename.</p>
                                </div>
                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-10">
                                    <div class="mb-2">
                                       <label for="site_logo" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Logo</label>
                                       <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                             <div class="flex justify-end px-4 pt-2">
                                                <label class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5 cursor-pointer">
                                                   <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
                                                   </svg>
                                                   <input type="file" name="site_logo" id="site_logo" class="hidden" data-preview-id="preview_site_logo" accept="image/png, image/jpg, image/jpeg, image/svg+xml">
                                                </label>
                                             </div>
                                             <div class="flex flex-col items-center pb-5">
                                                <img class="w-32 h-32 mb-3 rounded-full" src="{{ isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('img/placeholder.png') }}" id="preview_site_logo">
                                             </div>
                                       </div>
                                       <span class="text-xs text-gray-500 dark:text-gray-400">Allowed file format png, jpg, svg, (88 px X 50 px)</span>
                                    </div>
                                    <div class="mb-0 ml-3">
                                       <label for="login_site_logo" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Login Logo</label>
                                       <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                             <div class="flex justify-end px-4 pt-2">
                                                <label class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5 cursor-pointer">
                                                   <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
                                                   </svg>
                                                   <input type="file" name="login_site_logo" id="login_site_logo" class="hidden" data-preview-id="preview_login_logo" accept="image/png, image/jpg, image/jpeg, image/svg+xml">
                                                </label>
                                             </div>
                                             <div class="flex flex-col items-center pb-5">
                                                <img class="w-32 h-32 mb-3 rounded-full" src="{{ isset($settings['login_site_logo']) ? asset('storage/' . $settings['login_site_logo']) : asset('img/placeholder.png') }}" id="preview_login_logo">
                                             </div>
                                       </div>
                                       <span class="text-xs text-gray-500 dark:text-gray-400">Allowed file format png, jpg, svg, (88 px X 50 px)</span>
                                    </div>
                                    <!-- Register Logo -->
                                    <div class="mb-0 ml-3">
                                       <label for="register_logo" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Register Logo</label>
                                       <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                          <div class="flex justify-end px-4 pt-2">
                                                <label class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5 cursor-pointer">
                                                   <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
                                                   </svg>
                                                   <input type="file" name="register_logo" id="register_logo" class="hidden" data-preview-id="preview_register_logo" accept="image/png, image/jpg, image/jpeg, image/svg+xml">
                                                </label>
                                          </div>
                                          <div class="flex flex-col items-center pb-5">
                                                <img class="w-32 h-32 mb-3 rounded-full" src="{{ isset($settings['register_logo']) ? asset('storage/' . $settings['register_logo']) : asset('img/placeholder.png') }}" id="preview_register_logo">
                                          </div>
                                       </div>
                                       <span class="text-xs text-gray-500 dark:text-gray-400">Allowed file format png, jpg, svg, (88 px X 50 px)</span>
                                    </div>

                                    <!-- Site Favicon -->
                                    <div class="mb-0 ml-3">
                                       <label for="site_favicon" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Favicon</label>
                                       <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                          <div class="flex justify-end px-4 pt-2">
                                                <label class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5 cursor-pointer">
                                                   <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
                                                   </svg>
                                                   <input type="file" name="site_favicon" id="site_favicon" class="hidden" data-preview-id="preview_site_favicon" accept="image/png, image/jpg, image/jpeg, image/svg+xml, image/ico">
                                                </label>
                                          </div>
                                          <div class="flex flex-col items-center pb-5">
                                                <img class="w-32 h-32 mb-3 rounded-full" src="{{ isset($settings['site_favicon']) ? asset('storage/' . $settings['site_favicon']) : asset('img/placeholder.png') }}" id="preview_site_favicon">
                                          </div>
                                       </div>
                                       <span class="text-xs text-gray-500 dark:text-gray-400">Allowed file format png, jpg, svg, ico (32 px X 32 px)</span>
                                    </div>
                                 </div>
                                <div class="mb-4 mt-4">
                                    <label for="company_name" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Company Name</label>
                                    <input type="text" id="company_name" name="company_name" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" value="{{ $settings['company_name'] ?? '' }}" required aria-describedby="companyname-error">
                                    <p id="companyname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid company name.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="company_address" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Company Address</label>
                                    <textarea name="company_address" id="company_address" rows="4" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" required aria-describedby="companyaddress-error">{{ $settings['company_address'] ?? '' }}</textarea>
                                    <p id="companyaddress-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid company address.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="site_meta_title" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Meta Title</label>
                                    <input type="text" id="site_meta_title" name="site_meta_title" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" value="{{ $settings['site_meta_title'] ?? '' }}" required aria-describedby="sitemetatitle-error">
                                    <p id="sitemetatitle-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid site meta title.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="site_meta_keyword" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Meta Keywords</label>
                                    <input type="text" id="site_meta_keyword" name="site_meta_keyword" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" value="{{ $settings['site_meta_keyword'] ?? '' }}" required aria-describedby="sitemetakeyword-error">
                                    <p id="sitemetakeyword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid site meta keywords.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="site_meta_themecolor" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Meta Theme Color</label>
                                    <input type="text" id="site_meta_themecolor" name="site_meta_themecolor" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" value="{{ $settings['site_meta_themecolor'] ?? '' }}" required aria-describedby="sitemetathemecolor-error">
                                    <p id="sitemetathemecolor-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid site meta theme color.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="site_meta_description" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Site Meta Description</label>
                                    <textarea id="site_meta_description" name="site_meta_description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" required aria-describedby="sitemetadescription-error">{{ $settings['site_meta_description'] ?? '' }}</textarea>
                                    <p id="sitemetadescription-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid site meta description.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="site_footer_content" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Footer Content</label>
                                    <textarea id="site_footer_content" name="site_footer_content" rows="4" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" required aria-describedby="sitefootercontent-error">{{ $settings['site_footer_content'] ?? '' }}</textarea>
                                    <p id="sitefootercontent-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid footer content.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="sitedatetimeformat" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Date & Time Format</label>
                                    <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="sitedatetimeformat" id="sitedatetimeformat" data-live-search="true">
                                        <option value="d-M-Y" {{ ($settings['sitedatetimeformat'] ?? '') == 'd-M-Y' ? 'selected' : '' }}>dd-mmm-yyyy</option>
                                        <option value="m/d/Y" {{ ($settings['sitedatetimeformat'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>mm/dd/yyyy</option>
                                        <option value="d-M-Y h:i" {{ ($settings['sitedatetimeformat'] ?? '') == 'd-M-Y h:i' ? 'selected' : '' }}>dd-mmm-yyyy hh:mm</option>
                                        <option value="d-M-Y h:i:s" {{ ($settings['sitedatetimeformat'] ?? '') == 'd-M-Y h:i:s' ? 'selected' : '' }}>dd-mmm-yyyy hh:mm:ss</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="https_enble" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">HTTPS</label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="1" class="sr-only peer" name="https_enble" id="https_enble" {{ ($settings['https_enble'] ?? 0) == 1 ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </label>
                                    <div><span class="text-xs text-gray-500 dark:text-gray-400">If we change the http status change related http protocol in Site URL section also</span></div>
                                </div>
                                <div class="mb-4">
                                    <label for="default_matrix" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Default Plan</label>
                                    <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="default_matrix" id="default_matrix">
                                        <option value="">select</option>
                                        @foreach ($matrices as $id => $name)
                                            <option value="{{ $id }}" {{ ($settings['default_matrix'] ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="default_language" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Default Language</label>
                                    <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="default_language" id="default_language" required>
                                        <option value="">select</option>
                                        <option value="en" {{ ($settings['default_language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="du" {{ ($settings['default_language'] ?? '') == 'du' ? 'selected' : '' }}>Dutch</option>
                                        <option value="el" {{ ($settings['default_language'] ?? '') == 'el' ? 'selected' : '' }}>Ελληνικά</option>
                                        <option value="zh" {{ ($settings['default_language'] ?? '') == 'zh' ? 'selected' : '' }}>中文</option>
                                        <option value="ja" {{ ($settings['default_language'] ?? '') == 'ja' ? 'selected' : '' }}>日本語</option>
                                        <option value="ko" {{ ($settings['default_language'] ?? '') == 'ko' ? 'selected' : '' }}>한국어</option>
                                        <option value="es" {{ ($settings['default_language'] ?? '') == 'es' ? 'selected' : '' }}>Español</option>
                                        <option value="fr" {{ ($settings['default_language'] ?? '') == 'fr' ? 'selected' : '' }}>Français</option>
                                        <option value="ru" {{ ($settings['default_language'] ?? '') == 'ru' ? 'selected' : '' }}>Русский</option>
                                        <option value="ua" {{ ($settings['default_language'] ?? '') == 'ua' ? 'selected' : '' }}>Українська</option>
                                        <option value="it" {{ ($settings['default_language'] ?? '') == 'it' ? 'selected' : '' }}>Italiano</option>
                                        <option value="pt" {{ ($settings['default_language'] ?? '') == 'pt' ? 'selected' : '' }}>Português</option>
                                        <option value="ae" {{ ($settings['default_language'] ?? '') == 'ae' ? 'selected' : '' }}>العربية</option>
                                        <option value="ir" {{ ($settings['default_language'] ?? '') == 'ir' ? 'selected' : '' }}>فارسی</option>
                                        <option value="th" {{ ($settings['default_language'] ?? '') == 'th' ? 'selected' : '' }}>ไทย</option>
                                        <option value="id" {{ ($settings['default_language'] ?? '') == 'id' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="my" {{ ($settings['default_language'] ?? '') == 'my' ? 'selected' : '' }}>Malaysian</option>
                                        <option value="tr" {{ ($settings['default_language'] ?? '') == 'tr' ? 'selected' : '' }}>Türkçe</option>
                                        <option value="pl" {{ ($settings['default_language'] ?? '') == 'pl' ? 'selected' : '' }}>Polski</option>
                                        <option value="ro" {{ ($settings['default_language'] ?? '') == 'ro' ? 'selected' : '' }}>Român</option>
                                        <option value="gr" {{ ($settings['default_language'] ?? '') == 'gr' ? 'selected' : '' }}>German</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="options" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Register Type</label>
                                    <select id="options" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="options">
                                        <option value="">Register Type</option>
                                        <option value="rg1" {{ ($settings['options'] ?? '') == 'rg1' ? 'selected' : '' }}>Register 1</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="dashboard_type" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Dashboard Type</label>
                                    <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="dashboard_type" id="dashboard_type">
                                        <option value="">Select</option>
                                        <option value="1" {{ ($settings['dashboard_type'] ?? '') == '1' ? 'selected' : '' }}>MLM</option>
                                        <option value="2" {{ ($settings['dashboard_type'] ?? '') == '2' ? 'selected' : '' }}>Crypto</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="currency_format" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Currency Format</label>
                                    <select aria-label="label" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" name="currency_format" id="currency_format">
                                        <option value="">Select</option>
                                        <option value="USD"      {{ ($settings['currency_format'] ?? '') == 'USD'      ? 'selected' : '' }}>US</option>
                                        <option value="European"{{ ($settings['currency_format'] ?? '') == 'European'? 'selected' : '' }}>European</option>
                                        <option value="Others"  {{ ($settings['currency_format'] ?? '') == 'Others'  ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="subdomain_enble" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Subdomain</label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="1" class="sr-only peer" name="subdomain_enble" id="subdomain_enble" {{ ($settings['subdomain_enble'] ?? 0) == 1 ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </label>
                                    <div></div>
                                </div>
                                <div class="mb-4">
                                    <label for="login_content" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Login Content</label>
                                    <textarea id="login_content" name="login_content" rows="4" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="Grow Your Business" required aria-describedby="logincontent-error">{{ $settings['login_content'] ?? '' }}</textarea>
                                    <p id="logincontent-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid login content.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="login_sub_content" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Login Sub Content</label>
                                    <textarea id="login_sub_content" name="login_sub_content" rows="4" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="" aria-describedby="loginsubcontent-error">{{ $settings['login_sub_content'] ?? '' }}</textarea>
                                    <p id="loginsubcontent-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid login sub content.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="waitingliststatus" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Waiting List Status</label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="1" class="sr-only peer" name="waitingliststatus" id="waitingliststatus" {{ ($settings['waitingliststatus'] ?? 0) == 1 ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </label>
                                    <div><span class="text-sm"></span></div>
                                </div>
                                <div class="mb-4">
                                    <label for="user_profile_icon_based" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">User Profile Icon Based On</label>
                                    <div class="flex items-center mb-4">
                                        <input id="user_profile_icon_based1" type="radio" value="1" name="user_profile_icon_based" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ ($settings['user_profile_icon_based'] ?? '') == '1' ? 'checked' : '' }}>
                                        <label for="user_profile_icon_based1" class="ms-2 text-xs text-gray-600 dark:text-gray-300">First & Last Name</label>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input id="user_profile_icon_based2" type="radio" value="2" name="user_profile_icon_based" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ ($settings['user_profile_icon_based'] ?? '') == '2' ? 'checked' : '' }}>
                                        <label for="user_profile_icon_based2" class="ms-2 text-xs text-gray-600 dark:text-gray-300">Username</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="user_profile_icon_based3" type="radio" value="3" name="user_profile_icon_based" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ ($settings['user_profile_icon_based'] ?? '') == '3' ? 'checked' : '' }}>
                                        <label for="user_profile_icon_based3" class="ms-2 text-xs text-gray-600 dark:text-gray-300">Email ID</label>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 pt-6 mt-6 border-t dark:border-gray-700">
                                    <button type="submit" class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
                                        Submit
                                    </button>
                                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

    @endsection

   <script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to update preview
    function updatePreview(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Handle file input change
    document.querySelectorAll('input[type="file"]').forEach(input => {
        const previewId = input.getAttribute('data-preview-id');

        // On change
        input.addEventListener('change', function() {
            updatePreview(this, previewId);
        });

        // On page load: if there's already a file selected (unlikely), or just ensure correct image
        // But more importantly: trigger if there's a hidden input with old value
        const hiddenInput = document.querySelector(`input[name="hidden_${input.name}"]`);
        if (hiddenInput && hiddenInput.value) {
            const img = document.getElementById(previewId);
            img.src = `{{ url('storage') }}/` + hiddenInput.value;
        }
    });
});
</script>
