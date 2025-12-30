@extends('admin::components.common.main')

@section('content')
    <!-- Main Content Area -->


            <!-- Breadcrumb -->
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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Team</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Distributor</span>
                                    </div>
                                </li>
                            </ol>
                        </div>
        <!-- Content area -->
        <main class="flex-grow">
            <div class="">

                <!--alert-box-->

                <!-- card -->
                <div class="bg-white p-6 rounded-lg dark:bg-gray-800">
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1  xl:grid-cols-2 gap-5">


                        <div class="">
                            <!-- Stepper Header -->
                            <div class="flex justify-between mb-6">
                                <div class="flex flex-col items-center">
                                    <div id="step-1-circle"
                                        class="w-10 h-10 rounded-full flex items-center justify-center text-white bg-gray-700 dark:bg-blue-500">
                                        1</div>
                                    <p class="text-sm mt-2 text-center">Add Account</p>
                                </div>
                                <div class="w-1/3 h-1 bg-gray-300 my-4"></div>
                                <div class="flex flex-col items-center">
                                    <div id="step-2-circle"
                                        class="w-10 h-10 rounded-full flex items-center justify-center text-white bg-gray-300">
                                        2</div>
                                    <p class="text-sm mt-2 text-center">Enter Details</p>
                                </div>
                                <div class="w-1/3 h-1 bg-gray-300 my-4"></div>
                                <div class="flex flex-col items-center">
                                    <div id="step-3-circle"
                                        class="w-10 h-10 rounded-full flex items-center justify-center text-white bg-gray-300">
                                        3</div>
                                    <p class="text-sm mt-2 text-center">Select Plan</p>
                                </div>
                            </div>

                            <!-- Form Content -->
                         <form id="stepper-form" action="{{ route('admin.addUser.create') }}" method="POST" enctype="multipart/form-data">
                          @csrf

                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- Step 1 -->
                                <div id="step-1" class="step-content">
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                                            Name</label>
                                        <input type="text" id="user_name" name="user_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="user_name-error">
                                        <p id="user_name-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid username</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="password-error">
                                        <p id="password-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid password</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                            Password</label>
                                        <input type="password" id="repassword" name="repassword"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="repassword-error">
                                        <p id="repassword-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid password</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="membersemail-error">
                                        <p id="membersemail-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid email</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            First Name</label>
                                        <input type="text" id="first_name" name="first_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="first_name-error">
                                        <p id="first_name-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid first name</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                            Name</label>
                                        <input type="text" id="last_name" name="last_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="last_name-error">
                                        <p id="last_name-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid last name</p>
                                    </div>

                                </div>

                                <!-- Step 2 -->
                                <div id="step-2" class="hidden step-content">
                                    <div class="">

                                        <!-- Dynamic Divs -->
                                        <div class="mt-4">
                                                <div class="mb-5">
                                                    <label for="address"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                                    <input type="text" id="address" name="address"
                                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light"
                                                        placeholder="" required aria-describedby="address-error">
                                                    <p id="address-error"
                                                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                        Please enter a address</p>
                                                </div>
                                                <div class="mb-5">
                                                    <label for="lastname"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                                                        Number</label>
                                                    <!-- <input id="phone"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 w-100"
                                                        type="tel" name="phone" required pattern="^\+?[1-9]\d{1,14}$"
                                                        placeholder="e.g. +1234567890" aria-describedby="phone-error" /> -->
                           <input id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 w-100"
                                    type="tel" name="phone" />
                                                    <!-- Error message -->
                                                    <p id="phone-error"
                                                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                        Please enter a valid phone number.</p>
                                                </div>

                                                <div class="">
                                                    <div class="mb-5">
                                                        <label for="name"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country
                                                            :</label>
                                    @php
                                        $countries = getAllCountries();
                                    @endphp

                                                        <select id="country" name="country"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                            required aria-describedby="country-error">
                                            <option value="">-- Select Country --</option>
                                          @foreach( $countries as $country)
                                             <option value="{{ $country->sortname }}">{{ $country->country_master_name }}</option>
                                          @endforeach
                                                        </select>
                                                        <p id="country-error"
                                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                            Please enter your country.</p>
                                                    </div>
                                                    <div class="">
                                                        <div
                                                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                                            <!-- address inputs -->
                                                            <div class="address-in">
                                                                <label for="city"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                                                <input type="text" id="city" name="city"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                                    placeholder="" required
                                                                    aria-describedby="memberscity-error">
                                                                <p id="memberscity-error"
                                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                                    Please enter a city</p>
                                                            </div>
                                                            <div class="address-in">
                                                                <label for="state"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State/province/area</label>
                                                                <!-- <select id="state" name="state"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                                    required aria-describedby="membersstate-error">
                                                                    <option value="">Select a State</option>
                                                                </select> -->
                                                                          <select id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 form-select">
                                          <option value="">-- Select State --</option>
                                          </select>

                                                                <p id="state-error"
                                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                                    Please enter a state</p>
                                                            </div>
                                                            <div class="address-in">
                                                                <label for="members_zip"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zipcode
                                                                </label>
                                                                <input type="text" id="members_zip" name="zipcode"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                                    placeholder="" required
                                                                    aria-describedby="memberszip-error">
                                                                <p id="memberszip-error"
                                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                                    Please enter a zipcode</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div id="step-3" class="hidden step-content">

                                    <div class="mb-5">

                                        <div class="mb-5">
                                            <label for="name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plan
                                                :</label>
                                                @php
                                                    $matrixList = getAllmatrixs();
                                                @endphp

                                                <select name="plans" id="plans"

                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 mt-3"
                                                        required aria-describedby="matrixid-error">
                                                    <option value="">-- Select Matrix --</option>

                                                    @foreach($matrixList as $matrix)
                                                        <option value="{{ $matrix->matrix_type_id }}">{{ $matrix->matrix_type_name }}</option>
                                                    @endforeach
                                                </select>

                                        </div>

                                        <!-- Main modal -->

                                    </div>
                                    <div class="mb-5">

                                        <div class="mb-5" id="sponsor_id" style="display:none;">
                                            <label for="name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sponsorname
                                                :</label>
                                            @php
                                                $member_user = getAllMember();
                                            @endphp

                                        <select name="sponsor_id" id="sponsor_id"

                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 mt-3"
                                                required aria-describedby="matrixid-error">
                                            <option value="">-- Select --</option>

                                            @foreach($member_user as $member)
                                                <option value="{{ $member->members_id}}">{{ $member->members_username }}</option>
                                            @endforeach
                                        </select>

                                            <span id="viewsponsor"></span>
                                                </div>

                                                <div class="mb-5" id="Package" style="display:none;">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Packagename
                                                        :</label>
                                          @php
                                                $member_package = getAllPackage();
                                            @endphp


                                        <select name="Package" id="Package"

                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 mt-3"
                                                required aria-describedby="matrixid-error">
                                            <option value="">-- Select --</option>
                                            @foreach($member_package as $member)
                                                <option value="{{ $member->package_id}}">{{ $member->package_name }}</option>
                                            @endforeach

                                        </select>
                                                    <span id="viewpackage"></span>
                                                </div>


                                    </div>

                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between mt-5 border-t pt-5">
                                    <button type="button" id="prev-btn"
                                        class="hidden text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Previous</button>
                                    <button type="button" id="next-btn"
                                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-800 dark:hover:bg-blue-600 dark:focus:ring-gray-700 dark:border-gray-700">Next</button>
                                </div>
                        </form>
                    </div>


                        <div class="flex flex-col">
                            <!--image-space-->
                            <img src="/img/plan.png" alt="add-customer"
                                class="w-full sticky top-0 overflow-hidden">
                            <!--image-space-->
                        </div>

                    </div>
                </div>

                <!-- card -->
            </div>
        </main>

@endsection

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const planSelect = document.getElementById('plans');
    const sponsorDiv = document.getElementById('sponsor_id');
    const packageDiv = document.getElementById('Package');

    planSelect.addEventListener('change', function() {
        if (this.value) {
            // Show sponsor and package when a plan is selected
            sponsorDiv.style.display = 'block';
            packageDiv.style.display = 'block';

            // Optional: Fetch package dynamically via AJAX
            // Example: show package based on selected plan
            // document.getElementById('viewpackage').innerHTML = 'Package for plan ID ' + this.value;
        } else {
            sponsorDiv.style.display = 'none';
            packageDiv.style.display = 'none';
            document.getElementById('viewpackage').innerHTML = '';
        }
    });
});
</script>

<script>
 document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("stepper-form");
    const nextBtn = document.getElementById("next-btn");
    const prevBtn = document.getElementById("prev-btn");
    const totalSteps = 3;
    let currentStep = 1;
     const formId = 'stepper-form'; // your form ID

    const updateStepDisplay = () => {
        for (let i = 1; i <= totalSteps; i++) {
            // Show/hide step content
            const stepContent = document.getElementById(`step-${i}`);
            if (stepContent) stepContent.style.display = i === currentStep ? "block" : "none";

            // Update step circle
            const circle = document.getElementById(`step-${i}-circle`);
            if (circle) {
                if (i < currentStep) {
                    // Completed
                    // circle.classList.remove("bg-gray-700", "bg-gray-300");
                    // circle.classList.add("bg-gray-500");
                     circle.classList.remove("bg-blue-600", "bg-blue-600");
                circle.classList.add("bg-blue-600");
                circle.innerHTML = "✓"; 
                } else if (i === currentStep) {
                    // Active
                    // circle.classList.remove("bg-gray-300", "bg-gray-500");
                    // circle.classList.add("bg-gray-700");
                     circle.classList.remove("bg-blue-600", "bg-blue-600");
                circle.classList.add("bg-blue-600");
                circle.innerHTML = i;
                } else {
                    // Upcoming
                    // circle.classList.remove("bg-gray-700", "bg-gray-500");
                    // circle.classList.add("bg-gray-300");
                     circle.classList.remove("bg-blue-600", "bg-blue-600");
                circle.classList.add("bg-blue-600");
                circle.innerHTML = i;
                }
            }
        }

        // Toggle Previous button
        prevBtn.classList.toggle("hidden", currentStep === 1);

        // Update Next button text
        nextBtn.innerText = currentStep === totalSteps ? "Submit" : "Next";
    };
    const clearErrors = () => {
        document.querySelectorAll(".error-message").forEach(el => {
            el.classList.add("hidden");
            el.innerText = "";
        });
    };


    const validateStep = async () => {
        clearErrors();
        let hasError = false;

    if (currentStep === 1) {
    const username = document.getElementById("user_name").value.trim();
    const firstName = document.getElementById("first_name").value.trim();
    const lastName = document.getElementById("last_name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("repassword").value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\-=/]).{8,}$/;
    let hasError = false;

    // Frontend validation
    if (!username) {
        document.getElementById("user_name-error").innerText = "Please enter username";
        document.getElementById("user_name-error").classList.remove("hidden");
        hasError = true;
    }
    if (!firstName) {
        document.getElementById("first_name-error").innerText = "Please enter first name";
        document.getElementById("first_name-error").classList.remove("hidden");
        hasError = true;
    }
    if (!lastName) {
        document.getElementById("last_name-error").innerText = "Please enter last name";
        document.getElementById("last_name-error").classList.remove("hidden");
        hasError = true;
    }
    if (!email) {
        document.getElementById("membersemail-error").innerText = "Please enter email";
        document.getElementById("membersemail-error").classList.remove("hidden");
        hasError = true;
    } else if (!emailRegex.test(email)) {
        document.getElementById("membersemail-error").innerText = "Invalid email";
        document.getElementById("membersemail-error").classList.remove("hidden");
        hasError = true;
    }
   // Password
    if (!password) {
        document.getElementById("password-error").innerText = "Please enter password";
        document.getElementById("password-error").classList.remove("hidden");
        hasError = true;
    } else if (!passwordRegex.test(password)) {
        document.getElementById("password-error").innerText =
            "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
        document.getElementById("password-error").classList.remove("hidden");
        hasError = true;
    }

    // Confirm password
    if (!confirmPassword) {
        document.getElementById("repassword-error").innerText = "Please confirm password";
        document.getElementById("repassword-error").classList.remove("hidden");
        hasError = true;
    } else if (password !== confirmPassword) {
        document.getElementById("repassword-error").innerText = "Passwords do not match";
        document.getElementById("repassword-error").classList.remove("hidden");
        hasError = true;
    }


    if (hasError) return false;

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

try {
    // Run both requests in parallel
const [resEmail, resUsername] = await Promise.all([
    fetch('/admin/adddistributors/email_already_exists', { // leading /
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: email })
    }),
    fetch('/admin/adddistributors/username_already_exists', { // leading /
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ username: username })
    })
]);
    const { exists: emailExists } = await resEmail.json();
    const { exists: usernameExists } = await resUsername.json();

    let hasError = false;

    if (emailExists) {
        document.getElementById("membersemail-error").innerText = "Email already exists";
        document.getElementById("membersemail-error").classList.remove("hidden");
        hasError = true;
    }

    if (usernameExists) {
        document.getElementById("user_name-error").innerText = "Username already exists";
        document.getElementById("user_name-error").classList.remove("hidden");
        hasError = true;
    }

    if (hasError) return false; // prevent moving to next step

} catch (err) {
    console.error("Fetch error:", err);

    // Check if response was JSON with validation errors
    if (err.response) {
        err.response.json().then(data => {
            if (data.errors) {
                if (data.errors.email) {
                    document.getElementById("membersemail-error").innerText = data.errors.email[0];
                    document.getElementById("membersemail-error").classList.remove("hidden");
                }
                if (data.errors.username) {
                    document.getElementById("user_name-error").innerText = data.errors.username[0];
                    document.getElementById("user_name-error").classList.remove("hidden");
                }
            }
        });
    } else {
        alert("Network or server error occurred. Check console for details.");
    }

    return false;
}

}

        if (currentStep === 2) {
            const address = document.getElementById("address").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const country = document.getElementById("country").value.trim();
            const city = document.getElementById("city").value.trim();
            const state = document.getElementById("state").value.trim();
            const zip = document.getElementById("members_zip").value.trim();

            if (!address) {
                document.getElementById("address-error").innerText = "Please enter address";
                document.getElementById("address-error").classList.remove("hidden"); hasError = true;
            }
            if (!phone) {
                document.getElementById("phone-error").innerText = "Please enter phone";
                document.getElementById("phone-error").classList.remove("hidden"); hasError = true;
            }
            if (!country) {
                document.getElementById("country-error").innerText = "Please select country";
                document.getElementById("country-error").classList.remove("hidden"); hasError = true;
            }
            if (!city) {
                document.getElementById("memberscity-error").innerText = "Please enter city";
                document.getElementById("memberscity-error").classList.remove("hidden"); hasError = true;
            }
            if (!state) {
                document.getElementById("state-error").innerText = "Please select state";
                document.getElementById("state-error").classList.remove("hidden"); hasError = true;
            }
            if (!zip) {
                document.getElementById("memberszip-error").innerText = "Please enter zipcode";
                document.getElementById("memberszip-error").classList.remove("hidden"); hasError = true;
            }

            if (hasError) return false;
        }

        if (currentStep === 3) {
            const plan = document.getElementById("plans").value;
            if (!plan) {
                document.getElementById("matrixid-error").innerText = "Please select a plan";
                document.getElementById("matrixid-error").classList.remove("hidden");
                return false;
            }
        }

        return true;
    };

    nextBtn.addEventListener("click", async () => {
        const valid = await validateStep();
        if (!valid) return;

        if (currentStep < totalSteps) {
            currentStep++;
            updateStepDisplay();
        } else {
            // Final submit using getElementById
            document.getElementById(formId).submit();
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    });

  // === Form submit listener ===
    document.getElementById(formId).addEventListener("submit", async (e) => {
        e.preventDefault();
        const valid = await validateStep();
        if (!valid) return;

        // Submit using getElementById
        document.getElementById(formId).submit();
    });
    updateStepDisplay();

});
</script>
   <script>
      const phoneInputField = document.querySelector("#phone");
      const phoneInput = window.intlTelInput(phoneInputField, {
         utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });
   </script>
 <!-- state dropdown start-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // alert("jksdf");
        $('#country').on('change', function () {
            var Country_sortname = this.value;
            $("#state").html('');

            $.ajax({
                url: "{{ route('admin.fetchState') }}",
                type: "POST",
                data: {
                    sortname: Country_sortname,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                  console.log(result);
                    $('#state').html('<option value="">-- Select State --</option>');
                    $.each(result.states, function (key, value) {
                        $('#state').append('<option value="' + value.state_id + '">' + value.state_name + '</option>');

                    });
                }
            });
        });
    });
</script>

 <!-- state dropdown end -->



