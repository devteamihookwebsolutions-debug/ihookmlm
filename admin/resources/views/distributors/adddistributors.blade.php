@extends('admin::components.common.main')

    <!-- Main Content Area -->
    <main class="flex-1 p-6 ml-2 mt-10">

        <div class="flex mt-3 ml-10 justify-between items-center py-3 flex-wrap" aria-label="Breadcrumb">


            <div class="me-5 mb-5 lg:mb-0">
                <!-- <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Team>Add Distributor Plan</h2> -->
                <!-- Breadcrumb -->
            <nav class="mt-1 text-sm text-gray-600 dark:text-gray-300" aria-label="Breadcrumb">
                <a href="{{ route('admin.distributors.index') }}" class="hover:text-gray-800 dark:hover:text-white text-lg font-medium">
                Team
                </a>
                <span class="mx-2 text-gray-400">></span>

                <span class="text-gray-900 dark:text-gray-100 font-medium text-lg font-medium">
                    Add Distributor Plan
                </span>
            </nav>
         </div>

            <div class="flex items-center flex-wrap">
                <!--timer:starts-->
                <div id="clockdate" class="me-5">
                    <div class="clockdate-wrapper">
                        <div class="text-xl text-gray-900 font-bold dark:text-gray-100" id="clock">
                        </div>
                        <div id="date" class="text-sm text-gray-900 font-semibold dark:text-gray-100">
                        </div>
                    </div>
                </div>
                <!--timer:starts-->
                <button type="button" data-tooltip-target="tour"
                    class="text-gray-800 bg-yellow-600 hover:bg-gray-800 font-medium rounded-full text-sm p-3 me-3 text-center inline-flex items-center dark:bg-[#FF5D19] dark:hover:bg-blue-500 lg:mb-0 md:mb-0 sm:mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-100 dark:text-white ">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <div id="tour" role="tooltip"
                        class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Quick Tour
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </button>
                <button type="button" data-tooltip-target="report"
                    class="text-white bg-gray-900 hover:bg-gray-800 font-medium rounded-full text-sm p-3 text-center inline-flex items-center  dark:hover:bg-[#050708]/30 lg:mb-0 md:mb-0 sm:mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-100 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>
                    <div id="report" role="tooltip"
                        class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Reports
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </button>
            </div>

        </div>

        <!-- Content area -->
        <main class="flex-grow">
            <div class="mx-auto px-4 sm:px-6 lg:px-8 py-6">

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
                         <form id="stepper-form" action="{{ route('admin.adddistributors.create') }}" method="POST" enctype="multipart/form-data">
                          @csrf
   
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- Step 1 -->
                                <div id="step-1" class="step-content">
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User
                                            Name</label>
                                        <input type="text" id="txtusername" name="txtusername"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="txtusername-error">
                                        <p id="txtusername-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid username</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                        <input type="password" id="txtpassword" name="txtpassword"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="txtpassword-error">
                                        <p id="txtpassword-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid password</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                            Password</label>
                                        <input type="password" id="repassword" name="txtrepassword"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="repassword-error">
                                        <p id="repassword-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid password</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" id="members_email" name="members_email"
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
                                        <input type="text" id="txtfirstname" name="txtfirstname"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="txtfirstname-error">
                                        <p id="txtfirstname-error"
                                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                            Please enter a valid first name</p>
                                    </div>
                                    <div class="mb-4">
                                        <label for=""
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                            Name</label>
                                        <input type="text" id="txtlastname" name="txtlastname"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                            placeholder="" required aria-describedby="txtlastname-error">
                                        <p id="txtlastname-error"
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
                                                    <label for="txtaddress"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                                    <input type="text" id="txtaddress" name="txtaddress"
                                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light"
                                                        placeholder="" required aria-describedby="txtaddress-error">
                                                    <p id="txtaddress-error"
                                                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                        Please enter a address</p>
                                                </div>
                                                <div class="mb-5">
                                                    <label for="lastname"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                                                        Number</label>
                                                    <input id="phone"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 w-100"
                                                        type="tel" name="phone" required pattern="^\+?[1-9]\d{1,14}$"
                                                        placeholder="e.g. +1234567890" aria-describedby="phone-error" />

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

                                                        <select id="members_country" name="members_country"
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
                                                                <label for="members_city"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                                                <input type="text" id="members_city" name="members_city"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                                    placeholder="" required
                                                                    aria-describedby="memberscity-error">
                                                                <p id="memberscity-error"
                                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                                    Please enter a city</p>
                                                            </div>
                                                            <div class="address-in">
                                                                <label for="members_state"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State/province/area</label>
                                                                <!-- <select id="members_state" name="members_state"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                                    required aria-describedby="membersstate-error">
                                                                    <option value="">Select a State</option>
                                                                </select> -->
                                                                          <select id="members_state" name="members_state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 form-select">
                                          <option value="">-- Select State --</option>
                                          </select>
                               
                                                                <p id="membersstate-error"
                                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                                    Please enter a state</p>
                                                            </div>
                                                            <div class="address-in">
                                                                <label for="members_zip"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zipcode
                                                                </label>
                                                                <input type="text" id="members_zip" name="txtzipcode"
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

                                                <select name="matrix_id" id="matrix_id"
                                                    
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

                                                <div class="mb-5" id="view_packages" style="display:none;">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Packagename
                                                        :</label>
                                          @php
                                                $member_package = getAllPackage();
                                            @endphp

                                      
                                        <select name="view_packages" id="view_packages"
                                            
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



    </main>
    <!-- Main container:ends -->



    <!--phone-country-input-->
    <!-- <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script> -->
    <!--phone-country-input-->



<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const planSelect = document.getElementById('matrix_id');
    const sponsorDiv = document.getElementById('sponsor_id');
    const packageDiv = document.getElementById('view_packages');

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
                    circle.classList.remove("bg-gray-700", "bg-gray-300");
                    circle.classList.add("bg-gray-500");
                } else if (i === currentStep) {
                    // Active
                    circle.classList.remove("bg-gray-300", "bg-gray-500");
                    circle.classList.add("bg-gray-700");
                } else {
                    // Upcoming
                    circle.classList.remove("bg-gray-700", "bg-gray-500");
                    circle.classList.add("bg-gray-300");
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
    const username = document.getElementById("txtusername").value.trim();
    const firstName = document.getElementById("txtfirstname").value.trim();
    const lastName = document.getElementById("txtlastname").value.trim();
    const email = document.getElementById("members_email").value.trim();
    const password = document.getElementById("txtpassword").value;
    const confirmPassword = document.getElementById("repassword").value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    let hasError = false;

    // Frontend validation
    if (!username) { 
        document.getElementById("txtusername-error").innerText = "Please enter username"; 
        document.getElementById("txtusername-error").classList.remove("hidden");
        hasError = true; 
    }
    if (!firstName) { 
        document.getElementById("txtfirstname-error").innerText = "Please enter first name"; 
        document.getElementById("txtfirstname-error").classList.remove("hidden");
        hasError = true; 
    }
    if (!lastName) { 
        document.getElementById("txtlastname-error").innerText = "Please enter last name"; 
        document.getElementById("txtlastname-error").classList.remove("hidden");
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
    if (!password) { 
        document.getElementById("txtpassword-error").innerText = "Please enter password"; 
        document.getElementById("txtpassword-error").classList.remove("hidden");
        hasError = true; 
    }
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
        fetch('adddistributors/email_already_exists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ email: email })
        }),
        fetch('adddistributors/username_already_exists', {
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
        document.getElementById("txtusername-error").innerText = "Username already exists";
        document.getElementById("txtusername-error").classList.remove("hidden");
        hasError = true;
    }

    if (hasError) return false; // prevent moving to next step

} catch (err) {
    console.error(err);
    alert("Error checking email or username");
    return false;
}

}

        if (currentStep === 2) {
            const address = document.getElementById("txtaddress").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const country = document.getElementById("members_country").value.trim();
            const city = document.getElementById("members_city").value.trim();
            const state = document.getElementById("members_state").value.trim();
            const zip = document.getElementById("members_zip").value.trim();

            if (!address) { 
                document.getElementById("txtaddress-error").innerText = "Please enter address"; 
                document.getElementById("txtaddress-error").classList.remove("hidden"); hasError = true; 
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
                document.getElementById("membersstate-error").innerText = "Please select state"; 
                document.getElementById("membersstate-error").classList.remove("hidden"); hasError = true; 
            }
            if (!zip) { 
                document.getElementById("memberszip-error").innerText = "Please enter zipcode"; 
                document.getElementById("memberszip-error").classList.remove("hidden"); hasError = true; 
            }

            if (hasError) return false;
        }

        if (currentStep === 3) {
            const plan = document.getElementById("matrix_id").value;
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

//      //Final form submission (AJAX)
//  form.addEventListener('submit', (e) => {
//          e.preventDefault();
//          if (validateStep(currentStep)) {
//             alert('Form submitted successfully!');
//             // Here you would typically send the form data to a server
//          }
//       });

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

 <!-- state dropdown start-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // alert("jksdf");
        $('#members_country').on('change', function () {
            var Country_sortname = this.value;
            $("#members_state").html('');

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
                    $('#members_state').html('<option value="">-- Select State --</option>');
                    $.each(result.states, function (key, value) {
                        $('#members_state').append('<option value="' + value.state_id + '">' + value.state_name + '</option>');
                        
                    });
                }
            });
        });
    });
</script>
 <!-- state dropdown end -->

    <script src="js/flowbite.min.js"></script>

