<div class="xl:col-span-3">
    <!-- Profile Details -->
    <div class="profile-details md:w-56 w-auto h-fit bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
            <!-- Profile Image -->
            <div class="flex items-center gap-5 border-b p-3 dark:border-gray-700">
                <img src="{{ $members_image && $members_image != 'Uploads/members/avatar.png' ? asset($members_image) : asset('assets/img/avatar/no-rank.png') }}"
                    alt="{{ $errval['members_username'] }}"
                    class="w-24 h-24 rounded-full object-cover">
                <div>
                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300">
                        {{ $rank['rank_value'] ?? __('No Rank') }}</h3>
                </div>
            </div>
            <!-- Profile Details End -->

            <!-- Dropdown Menu -->
            <div class="flex items-center justify-center p-3">
                <button id="accountDefaultButton" data-dropdown-toggle="accountdropdown"
                    class="w-auto text-xs bg-gray-800 dark:bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-gray-900 dark:hover:bg-blue-600 transition flex items-center justify-between"
                    type="button">
                    {{ __('Account Settings') }}
                    <svg class="w-2.5 h-2.5 ml-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4"></path>
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="accountdropdown"
                    class="z-50 overflow-hidden hidden w-auto bg-white rounded-lg shadow dark:bg-gray-800 border dark:border-gray-700"
                    aria-hidden="true" data-popper-placement="bottom">
                    <ul class="divide-y divide-gray-100 text-xs text-gray-700 dark:text-gray-300 dark:divide-gray-700" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#" data-modal-target="generalsettings-modal"
                                data-modal-toggle="generalsettings-modal"
                                class="block w-full text-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ __('General Settings') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" data-modal-target="changepassword-modal"
                                data-modal-toggle="changepassword-modal"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ __('Change Password') }}
                            </a>
                        </li>
                       <li>
                        <a href="#"
                            onclick="changeStatus('{{ $sub1 }}'); return false;"
                            class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                @if ($errval['members_status'] == 1)
                                    {{ __('Suspend') }}
                                @else
                                    {{ __('Activate') }}
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="#" data-modal-target="contact-modal" data-modal-toggle="contact-modal"
                                class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ __('Contact') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mt-5">
                <button type="button" onclick="welcomeletter();"
                    class="w-full text-center text-xs text-left px-4 py-2 bg-gray-800 dark:bg-blue-500 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-blue-600 transition">
                    {{ __('Resend Welcome Letter') }}
                </button>
                <button type="button" onclick="window.open('{{ $block1details['replicated_url'] }}', '_blank')"
                    class="w-full text-center text-xs text-left px-4 py-2 bg-gray-800 dark:bg-blue-500 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-blue-600 transition">
                    {{ __('Launch Website') }}
                </button>
                <button type="button" onclick="autoLogin('{{ $sub1 }}');"
                    class="w-full text-center text-xs text-left px-4 py-2 bg-gray-800 dark:bg-blue-500 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-blue-600 transition">
                    {{ __('Sign-in to Dashboard') }}
                </button>
                <button type="button" data-modal-target="composemailtouser-modal" data-modal-toggle="composemailtouser-modal"
                    class="w-full text-center text-xs text-left px-4 py-2 bg-gray-800 dark:bg-blue-500 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-blue-600 transition">
                    {{ __('Compose E-mail') }}
                </button>
            </div>
    </div>
</div>

<!-- General Settings Modal -->
<div id="generalsettings-modal" tabindex="-1"
    class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('General Settings') }}
                </h3>
                <button type="button" data-modal-hide="generalsettings-modal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>

            <div class="p-4 md:p-5 space-y-6">
                <!-- Last Login -->
                <div>
                    <label class="block mb-2 text-xs font-medium text-black dark:text-white">
                        {{ __('Last Login') }}
                    </label>
                    <p class="text-xs text-gray-700 dark:text-gray-300">
                        {{ $userdetails['lastlogin'] }}
                    </p>
                </div>

                <!-- Date of Join -->
                <div>
                    <label class="block mb-2 text-xs font-medium text-black dark:text-white">
                        {{ __('Date of Join') }}
                    </label>
                    <p class="text-xs text-gray-700 dark:text-gray-300">
                        {{ $members_doj }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end pb-4 px-3">
                <button data-modal-hide="generalsettings-modal" type="button"
                    class="px-5 py-2.5 me-2 mb-2 rounded bg-gray-300 text-black dark:bg-gray-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changepassword-modal" tabindex="-1"
    class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 flex"
    aria-modal="true" role="dialog">
    <div class="relative p-4 w-full max-w-xl max-h-full top-10">
        <div class="relative  bg-white rounded-2xl shadow-lg dark:bg-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('New Password Details') }}
                </h3>
                <button type="button" data-modal-hide="changepassword-modal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
            <form id="showMyPasswordDetails" name="showMyPasswordDetails" action="{{ route('distributors.savepassworddetail') }}" method="POST" class="validated-form">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div class="mb-5">
                        <label for="currentpassword" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Current password') }}</label>
                        <input type="password" id="currentpassword" name="currentpassword"
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="currentpassword-error">
                        @error('currentpassword')
                            <p id="currentpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="members_id" value="{{ $sub1 }}">
                    <div class="mb-5">
                        <label for="newpassword" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('New Password') }}</label>
                        <input type="password" id="newpassword" name="newpassword" required
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="newpassword-error">
                        @error('newpassword')
                            <p id="newpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="retypenewpassword" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Retype New Password') }}</label>
                        <input type="password" id="retypenewpassword" name="newpassword_confirmation" required
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="newpassword_confirmation-error">
                        @error('newpassword_confirmation')
                            <p id="newpassword_confirmation-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="notify" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Notify user by email') }}</label>
                        <select aria-label="Notify" name="notify" id="notify"
                            class="text-xs rounded-lg block w-full p-2 text-gray-600 dark:text-gray-300 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                            <option value="1">{{ __('YES') }}</option>
                            <option value="2">{{ __('NO') }}</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end py-6 p-4 md:p-5">
                    <button data-modal-hide="changepassword-modal" type="button"
                        class="text-black dark:text-white border bg-gray-200 rounded-lg text-xs px-4 py-2 me-2 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">{{ __('Cancel') }}</button>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-gray-800 hover:bg-gray-900 rounded-lg text-xs px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div id="contact-modal" tabindex="-1"
    class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Contact') }}
                </h3>
                <button type="button" data-modal-hide="contact-modal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
            <form name="addcontactus1" id="addcontactus1" action="{{ route('distributors.contactus', $sub1) }}" method="POST" class="validated-form">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div class="mb-5">
                        <label for="subjectcontacttt" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Subject') }}</label>
                        <input type="text" id="subjectcontacttt" name="subject" required
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="subject-error">
                        @error('subject')
                            <p id="subject-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="members_id" value="{{ $sub1 }}">
                    <div class="mb-5">
                        <label for="message" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Message') }}</label>
                        <textarea id="message" name="message" rows="4" required
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="message-error" placeholder="{{ __('Write your thoughts here...') }}"></textarea>
                        @error('message')
                            <p id="message-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end py-6 p-4 md:p-5">
                    <button data-modal-hide="contact-modal" type="button"
                        class="text-black dark:text-white bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-900 dark:hover:bg-gray-800 dark:hover:border-gray-600 dark:focus:ring-gray-700">{{ __('Cancel') }}</button>
                    <button type="submit"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-gray-800 text-white dark:bg-gray-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Compose Email Modal -->
<div id="composemailtouser-modal" tabindex="-1"
    class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Compose') }}
                </h3>
                <button type="button" data-modal-hide="composemailtouser-modal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
<form action="{{ route('distributors.composenew', ['id' => $members_id]) }}" method="GET">
  @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div class="mb-5">
                        <label for="searchbox" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Username') }}</label>
                        <input type="text" id="searchbox" value="{{ $errval['members_username'] }}" readonly
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="username-error">
                    </div>
                    <input type="hidden" name="compmember_id" id="compmember_id" value="{{ $sub1 }}">
                    <div class="mb-5">
                        <label for="compsubject" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Subject') }}</label>
                        <input type="text" name="compsubject" id="compsubject" required
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="compsubject-error">
                        @error('compsubject')
                            <p id="compsubject-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="validat" value="1">
                    <input type="hidden" name="user_id" value="{{ $sub1 }}">
                    <div class="mb-5">
                        <label for="message" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Message') }}</label>
                        <textarea id="message" name="message" rows="4" required
                            class="text-xs rounded-lg block w-full p-2 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600"
                            aria-describedby="compmessage-error" placeholder="{{ __('Write your thoughts here...') }}"></textarea>
                        @error('message')
                            <p id="compmessage-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="messagefile" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Attach') }}</label>
                        <input id="messagefile" name="messagefile" type="file" accept="image/*"
                            class="block w-full text-sm text-black rounded-lg cursor-pointer bg-gray-50 dark:text-white focus:outline-none dark:bg-gray-900 border border-gray-200 dark:border-gray-800 dark:placeholder-gray-400"
                            onchange="previewImage(event)">
                        @error('messagefile')
                            <p id="messagefile-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="preview_container" class="mt-5">
                        <label for="description" class="block mb-3 text-xs  text-gray-600 dark:text-gray-300">{{ __('Preview') }}</label>
                        <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-900 dark:border-gray-700">
                            <div class="flex flex-col items-center p-10">
                                <img class="w-48 h-48 mb-3 rounded-xl shadow-2xl object-cover" name="image_preview"
                                    id="image_preview" src="{{ asset('assets/img/avatar/no-rank.png') }}"
                                    alt="{{ __('No Image Available') }}">
                            </div>
                        </div>
                        <p class="text-xs mt-2 dark:text-white">
                            {{ __('Allowed file format: png, jpg, svg (88 px X 50 px)') }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-end py-6 p-4 md:p-5">
                    <button data-modal-hide="composemailtouser-modal" type="button"
                        class="text-black dark:text-white bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-900 dark:hover:bg-gray-800 dark:hover:border-gray-600 dark:focus:ring-gray-700">{{ __('Cancel') }}</button>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-gray-900 focus:outline-none hover:bg-gray-900 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-gray-900 dark:text-white dark:border-gray-900 dark:hover:bg-gray-900 dark:hover:border-gray-900 dark:focus:ring-gray-700">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('memberarea.components.memberdetail_script')
