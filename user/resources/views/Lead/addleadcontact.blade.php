@extends('user::components.common.main')

@section('content')
    <!-- Breadcrumb -->
    <div class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="user-d-board.html"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                    <div class="relative w-5 h-5 flex items-center justify-center">

                        <!-- Animated Border ONLY -->
                        <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                            animate-ping opacity-60"></span>

                        <!-- Static Icon -->
                        <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10"
                            aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                    </div>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                        aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m10 16 4-4-4-4" />
                    </svg>

                    <a href="#"
                        class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">My Teams</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                        aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m10 16 4-4-4-4" />
                    </svg>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Leads Contacts</span>
                </div>
            </li>
        </ol>
    </div>



    <main class="flex-grow">
        <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
            <!--Success and Failure Messge-->
            @include('components.common.info_message')

            <!--Row-1-->
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                <!-- card -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                        <!--customer-form-->
                        <div class="customer-form">
                            <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">{{ __('Add Contacts') }}
                            </h3>
                            <form class="mx-auto validated-form" action="{{ route('user.lead.store') }}" method="POST">
                                @csrf
                                <div class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                                    aria-label="Component requires Flowbite JavaScript">
                                    <span class="text-xs font-medium text-black dark:text-white">{{ __('Contact Information') }}</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                                    <div class="">
                                        <label for="fname"
                                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('First Name') }}</label>
                                        <input type="text" id="fname" name="fname"
                                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                            placeholder="" required aria-describedby="fname-error">
                                        <p id="fname-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                    </div>
                                    <div class="">
                                        <label for="lname"
                                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Last Name') }}</label>
                                        <input type="text" id="lname" name="lname"
                                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                            required aria-describedby="lname-error">
                                        <p id="lname-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="phonenumber"
                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Phone Number') }}</label>
                                    <input id="phonenumber"
                                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 w-100"
                                        type="tel" name="phonenumber" placeholder="(999)-999-9999" required
                                        aria-describedby="phonenumber-error">
                                    <p id="phonenumber-error"
                                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                </div>

                                <div class="mb-5 border-b pb-10">
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Email') }}</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light"
                                        placeholder="name@flowbite.com" required aria-describedby="email-error">
                                    <p id="email-error"
                                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>                                      

                                </div>

                                <div class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                                    aria-label="Component requires Flowbite JavaScript">
                                    <span class="text-xs font-medium text-black dark:text-white">{{ __('Address Details') }}</span>
                                </div>

                            
                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <!-- address inputs -->
                                        <div class="address-in">
                                            <label for="address"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Address') }}</label>
                                            <input type="text" id="address" name="address"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="address-error">
                                            <p id="address-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <!-- address inputs -->
                                        <div class="address-in">
                                            <label for="country"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white"></label>
                                            <select id="country" name="country"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" required aria-describedby="country-error">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->sortname }}">
                                                        {{ $country->country_master_name }}
                                                    </option>
                                                @endforeach
                                                
                                            </select>
                                            {{--  <input type="text" id="country" name="country"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="country-error">  --}}
                                            <p id="country-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5 border-b pb-10">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <!-- address inputs -->
                                        <div class="address-in">
                                            <label for="city"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('City') }}</label>
                                            <input type="text" id="city" name="city"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="city-error">
                                            <p id="city-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                        <div class="address-in">
                                            <label for="state"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('State') }}</label>
                                            <select aria-label="label"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                id="state" name="state" required aria-describedby="state-error">
                                                <option value="">{{ __('Select') }}</option>
                                            </select>

                                            {{--  <input type="text" id="state" name="state"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="state-error">  --}}
                                            <p id="state-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                        <div class="address-in">
                                            <label for="zipcode"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Zip code') }}</label>
                                            <input type="text" id="zipcode" name="zipcode"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="zipcode-error">
                                            <p id="zipcode-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                                    aria-label="Component requires Flowbite JavaScript">
                                    <span class="text-xs font-medium text-black dark:text-white">{{ __('Other Details') }}</span>
                                </div>

                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <div class="">
                                            <label for="task"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Task') }}</label>
                                            <input type="text" id="task" name="task"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="task-error">
                                            <p id="task-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <div class="">
                                            <label for=""
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Birthday') }}</label>
                                            <div class="relative ">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                    <svg class="w-4 h-4 text-black dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                    </svg>
                                                </div>
                                                <input datepicker id="default-datepicker" type="text" name="birthday"
                                                    class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Select date" required aria-describedby="fname-error">
                                                <p id="fname-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <div class="">
                                            <label for="socialmedia"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Social Network') }}</label>
                                            <input type="text" id="socialmedia" name="socialmedia"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="" required aria-describedby="socialmedia-error">
                                            <p id="socialmedia-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <div class="">
                                            <label for="tag"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Tag') }}</label>
                                            <textarea id="tag" rows="2" name="tag"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="Write your thoughts here..." required aria-describedby="tag-error"></textarea>
                                            <p id="tag-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                        <input type="hidden" name="checkvalidate" id="checkvalidate" value="1">
                                        <div class="">
                                            <label for="note"
                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Notes') }}</label>
                                            <textarea id="note" rows="4" name="note"
                                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                placeholder="Write your thoughts here..." required aria-describedby="note-error"></textarea>
                                            <p id="note-error"
                                                class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            </p>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <div class="form-submit">
                                        <button type="sumit"
                                            class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
                                        >{{ __('Submit') }}</button>
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



<!-- custom scripts start-->
@include('user::components.common.datatable_scripts')
<script>
    document.getElementById('country').addEventListener('change', function () {
        let countryCode = this.value; 

        fetch(`/user/get-states/${countryCode}`)
            .then(res => res.json())
            .then(data => {
                let state = document.getElementById('state');
                state.innerHTML = '<option value="">Select State</option>';

                data.forEach(item => {
                    state.innerHTML += `
                        <option value="${item.state_code}">
                            ${item.state_name}
                        </option>
                    `;
                });
            });
    });

    

</script>



<!-- custom scripts end-->
@endsection

