<div class="hidden" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Edit Profile Data') }}</h2>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="border-b border-gray-200 dark:border-gray-700 mb-8">
            <ul class="flex flex-wrap text-xs" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="mr-8" role="presentation">
                    <a href="{{ route('distributors.show', ['id' => $members_id, 'tab' => 'personal-info']) }}"
                        class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->query('tab', 'personal-info') == 'personal-info' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300' }}"
                        id="personal-info-tab" data-tabs-target="#personal-info" role="tab"
                        aria-controls="personal-info"
                        aria-selected="{{ request()->query('tab', 'personal-info') == 'personal-info' ? 'true' : 'false' }}">{{ __('Personal Information') }}</a>
                </li>
                <li class="me-2" role="presentation">
                    <a href="{{ route('distributors.show', ['id' => $members_id, 'tab' => 'contact-info']) }}"
                        class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->query('tab') == 'contact-info' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300' }}"
                        id="contact-info-tab" data-tabs-target="#contact-info" role="tab" aria-controls="contact-info"
                        aria-selected="{{ request()->query('tab') == 'contact-info' ? 'true' : 'false' }}">{{ __('Contact Information') }}</a>
                </li>
                <li class="me-2" role="presentation">
                    <a href="{{ route('distributors.show', ['id' => $members_id, 'tab' => 'my-sites']) }}"
                        class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->query('tab') == 'my-sites' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300' }}"
                        id="my-sites-tab" data-tabs-target="#my-sites" role="tab" aria-controls="my-sites"
                        aria-selected="{{ request()->query('tab') == 'my-sites' ? 'true' : 'false' }}">{{ __('My Sites') }}</a>
                </li>
                <li class="me-2" role="presentation">
                    <a href="{{ route('distributors.show', ['id' => $members_id, 'tab' => 'social-media']) }}"
                        class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->query('tab') == 'social-media' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300' }}"
                        id="social-media-tab" data-tabs-target="#social-media" role="tab" aria-controls="social-media"
                        aria-selected="{{ request()->query('tab') == 'social-media' ? 'true' : 'false' }}">{{ __('Social Media') }}</a>
                </li>
                <li role="presentation">
                    <a href="{{ route('distributors.show', ['id' => $members_id, 'tab' => 'billing-address']) }}"
                        class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->query('tab') == 'billing-address' ? 'text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300' }}"
                        id="billing-address-tab" data-tabs-target="#billing-address" role="tab"
                        aria-controls="billing-address"
                        aria-selected="{{ request()->query('tab') == 'billing-address' ? 'true' : 'false' }}">{{ __('Billing Address') }}</a>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <!-- Personal Information Tab -->
        <div id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
            <form action="{{ route('distributors.updatepersonalinfo') }}" method="POST" id="personalinfoform"
                enctype="multipart/form-data" class="validated-form">
                @csrf
                <input type="hidden" name="members_id" value="{{ $members_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-300 mb-2">First Name</label>
                        <input type="text" name="firstname"
                            value="{{ old('firstname', $members_firstname ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                            required>
                        @error('firstname')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-300 mb-2">Last Name</label>
                        <input type="text" name="lastname"
                            value="{{ old('lastname', $members_lastname ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                            required>
                        @error('lastname')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Of Birth -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-300 mb-2">Date Of Birth</label>
                        <input type="date" name="dob"
                            value="{{ old('dob', $members_dob ? \Carbon\Carbon::parse($members_dob)->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                        @error('dob')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Name -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-300 mb-2">Company Name</label>
                        <input type="text" name="company_name"
                            value="{{ old('company_name', $members_company_name ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                        @error('company_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SSN / Tax Number (EFIN) -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-300 mb-2">SSN / Tax Number (EFIN)</label>
                        <input type="text" name="ssn_number"
                            value="{{ old('ssn_number', $members_ssn_number ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                        @error('ssn_number')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- subdomain -->
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-300 mb-2">Sub Domain</label>
                        <input type="text" name="sub_domain"
                            value="{{ old('sub_domain', $members_subdomain ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                        @error('sub_domain')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="px-6 py-2.5 text-xs font-medium bg-gray-800 hover:bg-gray-900 text-white rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600 transition">
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>

            <!-- Contact Information Tab -->
            <div id="contact-info" role="tabpanel" aria-labelledby="contact-info-tab">
                <form action="{{ route('distributors.updatecontactdetails') }}" method="POST" id="usercontactinfo"
                    enctype="multipart/form-data" novalidate="novalidate" class="validated-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="name@flowbite.com" value="{{ old('email', $members_email) }}"
                                aria-describedby="email-error">
                            @error('email')
                            <p id="email-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                            <input type="hidden" name="members_id" value="{{ $members_id }}">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Phone') }}</label>
                            <input type="tel" name="phone" id="phone" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                                value="{{ old('phone', $members_phone) }}" aria-describedby="phone-error">
                            @error('phone')
                            <p id="phone-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Country') }}</label>
                            <select id="country" name="country"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                                <option value="">{{ __('Select a country') }}</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->country_master_id }}"
                                    {{ old('country', $members_country) == $country->country_master_id ? 'selected' : '' }}>
                                    {{ $country->country_master_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('country')
                            <p class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('City') }}</label>
                            <input type="text" id="city" name="city" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter city') }}" value="{{ old('city', $members_city) }}"
                                aria-describedby="city-error">
                            @error('city')
                            <p id="city-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Address -->
                        <div>
                            <label for="address"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Street Address') }}</label>
                            <input type="text" id="address" name="address" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter street address') }}"
                                value="{{ old('address', $members_address) }}" aria-describedby="address-error">
                            @error('address')
                            <p id="address-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Address 2 -->
                        <div>
                            <label for="address2"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Street Address 2') }}</label>
                            <input type="text" id="address2" name="address2"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter street address (optional)') }}"
                                value="{{ old('address2', $members_address2) }}">
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('State') }}</label>
                            <select id="state" name="state"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                                <option value="">{{ __('Select a state') }}</option>
                                @foreach ($states as $state)
                                <option value="{{ $state->state_id }}"
                                    {{ old('state', $members_state) == $state->state_id ? 'selected' : '' }}>
                                    {{ $state->state_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('state')
                            <p class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Zip Code -->
                        <div>
                            <label for="zip"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Zip Code') }}</label>
                            <input type="text" id="zip" name="zip" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter zip code') }}" value="{{ old('zip', $members_zip) }}"
                                aria-describedby="zip-error">
                            @error('zip')
                            <p id="zip-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button
                            class="px-4 py-2 text-xs bg-gray-800 hover:bg-gray-900 text-white rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>

            <!-- Billing Address Tab -->
            <div id="billing-address" role="tabpanel" aria-labelledby="billing-address-tab">
                <form action="{{ route('distributors.updatebillingdetails') }}" method="POST" id="billinginfo"
                    enctype="multipart/form-data" novalidate="novalidate" class="validated-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                        <!-- Country -->
                        <div>
                            <label for="billing_country"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Country') }}</label>
                            <select name="country" id="billing_country"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                                <option value="">{{ __('Select a country') }}</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->country_master_id }}"
                                    {{ old('country', $members_country) == $country->country_master_id ? 'selected' : '' }}>
                                    {{ $country->country_master_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('country')
                            <p class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('City') }}</label>
                            <input type="text" id="city" name="city" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter city') }}" value="{{ old('city', $members_city) }}"
                                aria-describedby="billingcity-error">
                            @error('city')
                            <p id="billingcity-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Address -->
                        <div>
                            <label for="address"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Street Address') }}</label>
                            <input type="text" id="address" name="address" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter street address') }}"
                                value="{{ old('address', $members_address) }}" aria-describedby="billingaddress-error">
                            @error('address')
                            <p id="billingaddress-error"
                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Address 2 -->
                        <div>
                            <label for="address2"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Street Address 2') }}</label>
                            <input type="text" id="address2" name="address2"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter street address (optional)') }}"
                                value="{{ old('address2', $members_address2) }}">
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state_response"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('State') }}</label>
                            <select id="state_response" name="state"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800">
                                <option value="">{{ __('Select a state') }}</option>
                                @foreach ($states as $state)
                                <option value="{{ $state->state_id }}"
                                    {{ old('state', $members_state) == $state->state_id ? 'selected' : '' }}>
                                    {{ $state->state_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('state')
                            <p class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Zip Code -->
                        <div>
                            <label for="zip"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Zip Code') }}</label>
                            <input type="text" id="zip" name="zip" required
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter zip code') }}" value="{{ old('zip', $members_zip) }}"
                                aria-describedby="billingzip-error">
                            @error('zip')
                            <p id="billingzip-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="members_id" value="{{ $members_id }}">
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button
                            class="px-4 py-2 text-xs bg-gray-800 hover:bg-gray-900 text-white rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>

            <!-- My Sites Tab -->
            <div id="my-sites" role="tabpanel" aria-labelledby="my-sites-tab">
                <form action="{{ route('distributors.updatewebsitedetails') }}" method="POST" id="websiteinfo"
                    enctype="multipart/form-data" class="validated-form">
                    @csrf
                    <div class="mb-3 dark:text-white">
                        <label for="mobile"
                            class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Phone (shown to public)') }}</label>
                        <input type="text"
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                            aria-describedby="mobile-error" placeholder="{{ __('Enter Mobile Number') }}" name="mobile"
                            value="{{ old('mobile', $websiteDetails['mobile'] ?? '') }}">
                        <input type="hidden" name="id" value="{{ $members_id }}">
                        @error('mobile')
                        <p id="mobile-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 dark:text-white">
                        <label for="message"
                            class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Write something about yourself') }}</label>
                        <textarea
                            class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                            id="message" rows="5"
                            name="message">{{ old('message', $websiteDetails['message'] ?? '') }}</textarea>
                        @error('message')
                        <p id="message-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button
                            class="px-4 py-2 text-xs bg-gray-800 hover:bg-gray-900 text-white rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>

            <!-- Social Media Tab -->
            <div id="social-media" role="tabpanel" aria-labelledby="social-media-tab">
                <form action="{{ route('distributors.updatesocialdetails') }}" method="POST" id="socialmediainfo"
                    enctype="multipart/form-data" class="validated-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                        <div>
                            <label for="facebook"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Facebook') }}</label>
                            <input type="url" id="facebook" name="facebook"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter Facebook URL') }}"
                                value="{{ old('facebook', $socialMediaDetails['facebook'] ?? '') }}">
                            <input type="hidden" name="id" value="{{ $members_id }}">
                            @error('facebook')
                            <p id="facebook-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="twitter"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Twitter') }}</label>
                            <input type="url" id="twitter" name="twitter"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter Twitter URL') }}"
                                value="{{ old('twitter', $socialMediaDetails['twitter'] ?? '') }}">
                            @error('twitter')
                            <p id="twitter-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="youtube"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('YouTube') }}</label>
                            <input type="url" id="youtube" name="youtube"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter YouTube URL') }}"
                                value="{{ old('youtube', $socialMediaDetails['youtube'] ?? '') }}">
                            @error('youtube')
                            <p id="youtube-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="linkedin"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('LinkedIn') }}</label>
                            <input type="url" id="linkedin" name="linkedin"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter LinkedIn URL') }}"
                                value="{{ old('linkedin', $socialMediaDetails['linkedin'] ?? '') }}">
                            @error('linkedin')
                            <p id="linkedin-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="google"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Google') }}</label>
                            <input type="url" id="google" name="google"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter Google URL') }}"
                                value="{{ old('google', $socialMediaDetails['google'] ?? '') }}">
                            @error('google')
                            <p id="google-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="skype"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Skype') }}</label>
                            <input type="text" id="skype" name="skype"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter Skype ID') }}"
                                value="{{ old('skype', $socialMediaDetails['skype'] ?? '') }}">
                            @error('skype')
                            <p id="skype-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="pinterest"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Pinterest') }}</label>
                            <input type="url" id="pinterest" name="pinterest"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter Pinterest URL') }}"
                                value="{{ old('pinterest', $socialMediaDetails['pinterest'] ?? '') }}">
                            @error('pinterest')
                            <p id="pinterest-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tumblr"
                                class="block text-xs text-gray-600 dark:text-gray-300 mb-2">{{ __('Tumblr') }}</label>
                            <input type="url" id="tumblr" name="tumblr"
                                class="w-full px-4 py-2 border border-gray-300 text-xs text-gray-600 dark:text-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-800"
                                placeholder="{{ __('Enter Tumblr URL') }}"
                                value="{{ old('tumblr', $socialMediaDetails['tumblr'] ?? '') }}">
                            @error('tumblr')
                            <p id="tumblr-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button
                            class="px-4 py-2 text-xs bg-gray-800 hover:bg-gray-900 text-white rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form Validation
    const FORM_CONFIG = {
        REQUIRED_PATTERNS: {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^[0-9]{3}-[0-9]{2}-[0-9]{3}$/,
            mobile: /^[\+0-9\s\-]*$/, // Allow +, numbers, spaces, and hyphens
            facebook: /^(https?:\/\/)?(www\.)?(facebook|fb)\.com\/.+$/,
            twitter: /^(https?:\/\/)?(www\.)?(twitter|x)\.com\/.+$/,
            youtube: /^(https?:\/\/)?(www\.)?youtube\.com\/.+$/,
            linkedin: /^(https?:\/\/)?(www\.)?linkedin\.com\/.+$/,
            google: /^(https?:\/\/)?(www\.)?(plus\.google|google)\.com\/.+$/,
            pinterest: /^(https?:\/\/)?(www\.)?pinterest\.com\/.+$/,
            tumblr: /^(https?:\/\/)?(www\.)?tumblr\.com\/.+$/,
            skype: /^[\w\.]+$/,
        },
    };

    class FormHandler {
        constructor() {
            this.initializeElements();
            this.attachEventListeners();
        }

        initializeElements() {
            this.elements = {
                usercontactinfo: document.getElementById('usercontactinfo'),
                billinginfo: document.getElementById('billinginfo'),
                websiteinfo: document.getElementById('websiteinfo'),
                socialmediainfo: document.getElementById('socialmediainfo'),
                showMyPasswordDetails: document.getElementById('showMyPasswordDetails'),
                addcontactus1: document.getElementById('addcontactus1'),
                cmpmsg: document.getElementById('cmpmsg'),
                usernotes: document.getElementById('usernotes'),
            };
        }

        attachEventListeners() {
            const forms = [
                this.elements.usercontactinfo,
                this.elements.billinginfo,
                this.elements.websiteinfo,
                this.elements.socialmediainfo,
                this.elements.showMyPasswordDetails,
                this.elements.addcontactus1,
                this.elements.cmpmsg,
                this.elements.usernotes,
            ];

            forms.forEach(form => {
                if (form) {
                    form.addEventListener('submit', (e) => this.handleSubmit(e));
                }
            });

            document.querySelectorAll('input[required], select[required], textarea[required]').forEach((
                input) => {
                input.addEventListener('input', () => this.validateInput(input));
            });
        }

        validateInput(input) {
            const value = input.value.trim();
            const pattern = FORM_CONFIG.REQUIRED_PATTERNS[input.name];
            const errorElement = document.getElementById(input.getAttribute('aria-describedby'));

            let isValid = true;

            if (input.hasAttribute('required') && !value) {
                isValid = false;
                this.showError(input, errorElement, 'This field is required.');
            } else if (pattern && value && !pattern.test(value)) {
                isValid = false;
                this.showError(input, errorElement, `Invalid ${input.name} format.`);
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
            const form = e.target;
            const submitButton = form.querySelector('button[type="submit"]');
            const inputs = Array.from(form.querySelectorAll(
                'input[required], select[required], textarea[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
                // Disable button and show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = 'Submitting...';
                form.submit();
            } else {
                console.error('Form validation failed.');
            }
        }
    }

    // Initialize form handler on page load
    new FormHandler();
});
</script>
@endpush
