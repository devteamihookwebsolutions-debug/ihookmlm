<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
 <title>ihook-Register</title>
   <link rel="icon" href="../img/ilogo.png" />

   <script src="https://cdn.tailwindcss.com"></script>
   <!-- Include Flowbite -->
   <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

   <!-- custom-style -->
   <link href="../assets/css/custom-style.css" rel="stylesheet" />
   <!-- Google-font -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
      rel="stylesheet">
</head>

<body class="bg-center bg-no-repeat page-bg">
   <!-- Main container -->
   <div class="min-h-screen flex flex-col">
      <!--Content Area-->
      <main class=" flex items-center justify-center grow ">
         <div class="grid lg:grid-cols-2 grow ">

            <div
               class="flex justify-start p-2 sm:p-2 md:p-6 lg:p-10 order-1 lg:order-2 h-screen overflow-auto bg-white">

               <div class="w-full ">
                  <!--header-top-->
                  <div class="flex justify-between items-center gap-5 p-2 sm:p-2 md:p-6 lg:p-10">
                     <div>Already have an account ? <a href="{{ route('user.login') }}"> Login</a></div>
                     <div>
                        <div class="flex items-center md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse">
                           <button type="button" data-dropdown-toggle="language-dropdown-menu"
                              class="inline-flex items-center font-medium justify-center px-4 py-2 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                              <svg class="w-5 h-5 rounded-full me-3" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 viewBox="0 0 3900 3900">
                                 <path fill="#b22234" d="M0 0h7410v3900H0z" />
                                 <path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff"
                                    stroke-width="300" />
                                 <path fill="#3c3b6e" d="M0 0h2964v2100H0z" />
                                 <g fill="#fff">
                                    <g id="d">
                                       <g id="c">
                                          <g id="e">
                                             <g id="b">
                                                <path id="a"
                                                   d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z" />
                                                <use xlink:href="#a" y="420" />
                                                <use xlink:href="#a" y="840" />
                                                <use xlink:href="#a" y="1260" />
                                             </g>
                                             <use xlink:href="#a" y="1680" />
                                          </g>
                                          <use xlink:href="#b" x="247" y="210" />
                                       </g>
                                       <use xlink:href="#c" x="494" />
                                    </g>
                                    <use xlink:href="#d" x="988" />
                                    <use xlink:href="#c" x="1976" />
                                    <use xlink:href="#e" x="2470" />
                                 </g>
                              </svg>
                              English (US)
                           </button>
                           <!-- Dropdown -->
                           <div
                              class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                              id="language-dropdown-menu">
                              <ul class="py-2 font-medium" role="none">
                                 <li>
                                    <a href="#"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                       role="menuitem">
                                       <div class="inline-flex items-center">
                                          <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full me-2"
                                             xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-us"
                                             viewBox="0 0 512 512">
                                             <g fill-rule="evenodd">
                                                <g stroke-width="1pt">
                                                   <path fill="#bd3d44"
                                                      d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                                      transform="scale(3.9385)" />
                                                   <path fill="#fff"
                                                      d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                                      transform="scale(3.9385)" />
                                                </g>
                                                <path fill="#192f5d" d="M0 0h98.8v70H0z" transform="scale(3.9385)" />
                                                <path fill="#fff"
                                                   d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z"
                                                   transform="scale(3.9385)" />
                                             </g>
                                          </svg>
                                          English (US)
                                       </div>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                       role="menuitem">
                                       <div class="inline-flex items-center">
                                          <svg class="h-3.5 w-3.5 rounded-full me-2" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-de"
                                             viewBox="0 0 512 512">
                                             <path fill="#ffce00" d="M0 341.3h512V512H0z" />
                                             <path d="M0 0h512v170.7H0z" />
                                             <path fill="#d00" d="M0 170.7h512v170.6H0z" />
                                          </svg>
                                          Deutsch
                                       </div>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                       role="menuitem">
                                       <div class="inline-flex items-center">
                                          <svg class="h-3.5 w-3.5 rounded-full me-2" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-it"
                                             viewBox="0 0 512 512">
                                             <g fill-rule="evenodd" stroke-width="1pt">
                                                <path fill="#fff" d="M0 0h512v512H0z" />
                                                <path fill="#009246" d="M0 0h170.7v512H0z" />
                                                <path fill="#ce2b37" d="M341.3 0H512v512H341.3z" />
                                             </g>
                                          </svg>
                                          Italiano
                                       </div>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                       role="menuitem">
                                       <div class="inline-flex items-center">
                                          <svg class="h-3.5 w-3.5 rounded-full me-2" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" id="flag-icon-css-cn"
                                             viewBox="0 0 512 512">
                                             <defs>
                                                <path id="a" fill="#ffde00" d="M1-.3L-.7.8 0-1 .6.8-1-.3z" />
                                             </defs>
                                             <path fill="#de2910" d="M0 0h512v512H0z" />
                                             <use width="30" height="20" transform="matrix(76.8 0 0 76.8 128 128)"
                                                xlink:href="#a" />
                                             <use width="30" height="20"
                                                transform="rotate(-121 142.6 -47) scale(25.5827)" xlink:href="#a" />
                                             <use width="30" height="20" transform="rotate(-98.1 198 -82) scale(25.6)"
                                                xlink:href="#a" />
                                             <use width="30" height="20"
                                                transform="rotate(-74 272.4 -114) scale(25.6137)" xlink:href="#a" />
                                             <use width="30" height="20"
                                                transform="matrix(16 -19.968 19.968 16 256 230.4)" xlink:href="#a" />
                                          </svg>
                                          中文 (繁體)
                                       </div>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <button data-collapse-toggle="navbar-language" type="button"
                              class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                              aria-controls="navbar-language" aria-expanded="false">
                              <span class="sr-only">Open main menu</span>
                              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 17 14">
                                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                              </svg>
                           </button>
                        </div>
                     </div>
                  </div>
                  <!--form starts-->
                  <form  method="POST"  action="{{ route('user.register.post') }}" class="card-body flex flex-col gap-5 p-2 sm:p-2 md:p-6 lg:p-10" id="sign_up_form"
                   >
                     @csrf


                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="">
                        <!-- Progress Bar -->
                        <div class="mb-8">
                           <div class="grid w-full gap-4 md:grid-cols-2 grid-cols-1 lg:grid-cols-4 mb-5 text-center">
                              <span
                                 class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-gray-600 bg-gray-200"
                                 id="step1">
                                 General Information
                              </span>
                              <span
                                 class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-gray-600 bg-gray-200 opacity-50"
                                 id="step2">
                                 Personal Information
                              </span>
                              <span
                                 class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-gray-600 bg-gray-200 opacity-50"
                                 id="step3">
                                 Package Information
                              </span>
                              <span
                                 class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-gray-600 bg-gray-200 opacity-50"
                                 id="step4">
                                 Review & Submit
                              </span>
                           </div>
                           <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                              <div id="progress-bar"
                                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gray-900 w-1/4 transition-all duration-500 ease-in-out">
                              </div>
                           </div>
                        </div>
                        <!-- Form Steps -->
                        <form id="multi-step-form">
                           <!-- Step 1: Personal Information -->
                           <div id="step-1" class="step">
                              <div class="mb-10">
                                 <h3
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2.5">
                                    Welcome! Let's Get Started.
                                 </h3>
                                 <div class="text-base text-gray-700">
                                    We are pleased that you have decided to join us! Please fill in the requested
                                    information below as our system walks you through the process of enrolling. You will
                                    have the opportunity to select your enrollment products and begin your journey to
                                    personal success!
                                 </div>
                              </div>

                              <div class="mb-5">
                                <label for="username"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> <span class="text-red-500">*</span>User
                                    Name  </label>
                                 <input type="text" id="user_name"  name="user_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                    placeholder="" />
                                       <span class="text-red-500 text-sm error-message" id="error_user_name"></span>

                              </div>
                              <div class="mb-5">
                                 <label for="firstname"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-500">*</span>First
                                    Name</label>
                                 <input type="text" id="first_name"  name="first_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                    placeholder="" />
                                       <span class="text-red-500 text-sm  error-message" id="error_first_name"></span>
                              </div>
                              <div class="mb-5">
                                 <label for="lastname"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-500">*</span>Last
                                    Name</label>
                                 <input type="text" id="last_name"  name="last_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                    placeholder="" />
                                       <span class="text-red-500 text-sm  error-message" id="error_last_name"></span>
                              </div>
                              <div class="mb-5">
                                 <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-500">*</span>Your
                                    Email</label>
                                 <input type="email" id="email"  name="email"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light"
                                    placeholder="name@flowbite.com" />
                                       <span class="text-red-500 text-sm error-message" id="error_email"></span>
                              </div>

                                <!--  Password Field -->

                              <div class="mb-5 relative">
                                 <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    <span class="text-red-500">*</span>Your Password
                                 </label>

                                 <!-- Input and eye icon wrapper -->
                                 <div class="relative">
                                    <input type="password" id="password" name="password"
                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light" />

                                    <!-- Eye icon -->
                                    <button type="button"
                                       class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-blue-500 focus:outline-none"
                                       onclick="togglePassword('password', this)">
                                       <!-- Eye closed -->
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed" fill="none" viewBox="0 0 24 24"
                                       stroke="currentColor" stroke-width="2">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.317-3.568m3.342-2.191A9.964 9.964 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.961 9.961 0 01-1.046 2.158M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                       </svg>
                                       <!-- Eye open -->
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open hidden" fill="none" viewBox="0 0 24 24"
                                       stroke="currentColor" stroke-width="2">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                       </svg>
                                    </button>
                                 </div>

                                 <!-- Error Message -->
                                 <span class="text-red-500 text-sm mt-1 block error-message" id="error_password"></span>
                                 </div>



                           <!-- Confirm Password Field -->
                           <div class="mb-5 relative">
                           <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                              <span class="text-red-500">*</span>Confirm Password
                           </label>

                           <!-- Input and toggle eye icon wrapper -->
                           <div class="relative">
                              <input type="password" id="confirm_password" name="confirm_password"
                                 class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light" />

                              <!-- Toggle Password Button -->
                              <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-blue-500 focus:outline-none"
                                 onclick="togglePassword('confirm_password', this)">
                                 <!-- Eye Closed Icon -->
                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.317-3.568m3.342-2.191A9.964 9.964 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.961 9.961 0 01-1.046 2.158M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                 </svg>
                                 <!-- Eye Open Icon -->
                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open hidden" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                 </svg>
                              </button>
                           </div>

                           <!-- Error message -->
                           <span class="text-red-500 text-sm mt-1 block error-message" id="error_confirm_password"></span>
                           </div>


                              <!-- <div class="mb-5">
                                 <label for="repeat-password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pick A
                                    Replicated Website Name</label>
                                 <div class="flex rounded-lg shadow-sm">
                                    <span
                                       class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">https://promlmicon.com</span>
                                    <input type="text"
                                       class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                 </div>
                              </div> -->
                              <!--rep-box-->
                              <div class="mb-5">
                                 <div
                                    class="bg-gray-100 text-gray-800 text-xs font-medium p-5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">

                                    <div class="flex items-start mb-3">
                                       <img class="w-32 rounded-lg mr-4" src="../img/av-ico-2.png" alt="rep-img">
                                       <div class="flex flex-col justify-between">
                                          <div class="mb-2 text-sm text-gray-700">You are a guest of : <span
                                                class="text-base text-sm text-gray-600">{{ ucfirst($member->members_username) }}</span> </div>
                                          <!-- <div class="mb-2 text-sm text-gray-700">Phone : <span
                                                class="text-base text-sm text-gray-600">+1 652-265-2235</span> </div> -->
                                          <div class="mb-2 text-sm text-gray-700">Email : <span
                                                class="text-base text-sm text-gray-600">{{ strtolower($member->members_email) }}</span> </div>
                                          <!-- <div class="mb-2 text-sm text-gray-700">Website : <span
                                                class="text-base text-sm text-gray-600">promlmsoftware.com</span> </div> -->

                                          <input type="hidden" name="default_sponsor" value="{{ old('default_sponsor', $sponsorId) }}">
                                          <input type="hidden" id="sponsor_id" name="sponsor_id" value="">
                                          <input type="hidden" id="sponsor-name" name="sponsor_name" value="">
                                          <input type="hidden" id="sponsor-phone" name="sponsor_phone" value="">
                                          <input type="hidden" id="sponsor-email" name="sponsor_email" value="">

                                          <div id="accordion-collapse" data-accordion="collapse">
                                               <div id="accordion-collapse-heading-2">
                                                   <button type="button" id="accordionButton"
                                                   class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                                   data-accordion-target="#accordion-collapse-body-2"
                                                   aria-expanded="false" aria-controls="accordion-collapse-body-2">
                                                   Not Your Consultant? Click Here!
                                                   </button>
                                                </div>
                                             <div id="accordion-collapse-body-2" class="hidden mt-3"
                                                aria-labelledby="accordion-collapse-heading-2">
                                                <div data-style="clean" class="flex items-end mb-3">
                                                   <div
                                                      class="flex items-center w-full max-w-md mb-3 seva-fields formkit-fields">
                                                      <div class="relative w-full mr-3 formkit-field">
                                                         <div
                                                            class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                                         </div>
                                                          <input type="text" id="spons-id" name="spons-id"
                                                               aria-describedby="spons-id-error"
                                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                               placeholder="Your Sponsor Username">
                                                               <p id="spons-id-error" class="hidden text-red-500 text-xs mt-1">
                                                               This sponsor Username does not exist. Please choose another.
                                                               </p>
                                                               <p id="spons-success" class="hidden text-green-500 text-sm mt-2">
                                                                  Sponsor is valid!
                                                               </p>
                                                      </div>
                                                      <button data-element="submit" id="sponsorSubmit" class="">
                                                         <span
                                                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Submit</span>
                                                      </button>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                       </div>
                                    </div>

                                 </div>
                              </div>

                           </div>
                           <!-- Step 2: Account Details -->
                           <div id="step-2" class="step hidden">
                              <div class="mb-10">
                                 <h3
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2.5">
                                    Personal Infomation
                                 </h3>
                                 <div class="text-base text-gray-700">
                                    Tell us about yourself
                                 </div>
                              </div>
                                <div class="mb-5 border-b pb-10">
                                 <div class="text-base font-bold text-gray-900 mb-5">Birthday</div>
                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <!-- select inputs -->
                                    <div class="date-in">
                                       <label for="date"
                                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                                       <select id="date" name="date"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">

                                       </select>
                                    </div>
                                    <div class="month-in">
                                       <label for="month"
                                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Month</label>
                                       <select id="month" name="month"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option value="01">January</option>
                                          <option value="02">February</option>
                                          <option value="03">March</option>
                                          <option value="04">April</option>
                                          <option value="05">May</option>
                                          <option value="06">June</option>
                                          <option value="07">July</option>
                                          <option value="08">August</option>
                                          <option value="09">September</option>
                                          <option value="10">October</option>
                                          <option value="11">November</option>
                                          <option value="12">December</option>
                                       </select>
                                    </div>
                                    <div class="year-in">
                                       <label for="countries"
                                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year</label>
                                       <select id="year"  name="year"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">

                                       </select>
                                    </div>
                                 </div>
                              </div>

                              <div class="mb-5 border-b pb-10">
                                 <div class="text-base font-bold text-gray-900 mb-5">Address</div>
                                 <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                       <!-- address inputs -->
                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                          <input type="text" id="address" name="address"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" />
                                       </div>
                                    </div>
                                 </div>

                                 <div class="mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                       <!-- address inputs -->
                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                                          <!-- <input type="text" id="country" name="country"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" /> -->

                                             @php
                                                $countries = getAllCountries();
                                             @endphp

                                             <select id="country" name="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 form-select">
                                       <option value="">-- Select Country --</option>
                                          @foreach( $countries as $country)
                                             <option value="{{ $country->sortname }}">{{ $country->country_master_name }}</option>
                                          @endforeach
                                       </select>

                                       </div>
                                    </div>
                                 </div>

                                 <div class="">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                       <!-- address inputs -->

                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State/province/area</label>
                                          <!-- <input type="text" id="state" name="state"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" /> -->
                                         <select id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 form-select">
                                          <option value="">-- Select State --</option>
                                          </select>
                                       </div>


                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                          <input type="text" id="city" name="city"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" />

                                       </div>

                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zipcode</label>
                                          <input type="text" id="zipcode" name="zipcode"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="mb-5 pb-10">
                                 <div class="text-base font-bold text-gray-900 mb-5">Contact Number</div>
                                 <label for="lastname"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preferred
                                    Contact Number</label>
                                 <input id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 w-100"
                                    type="tel" name="phone" />
                              </div>
                           </div>

                           <!-- Step 3: Packages -->
                            <div id="step-3" class="step hidden">
                                <div class="mb-10">
                                    <div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2.5">
                                        Loading...
                                    </div>
                                    <div class="text-base text-gray-900 dark:text-white">
                                        Please wait...
                                    </div>
                                    <div id="package-error" class="text-red-500 text-sm mt-2 font-medium text-center w-full"></div>
                                </div>

                                <ul id="package-list" class="grid w-full gap-6 md:grid-cols-2">
                                </ul>
                            </div>

                           <!-- Step 4: review -->
                           <div id="step-4" class="step hidden">
                              <div class="mb-10">
                                 <div
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2.5">
                                    Let's Review</div>
                                 <div class="text-base text-gray-900">Please review your selections below for accuracy.
                                    Select your payment method in the section below, then press the Complete My
                                    Enrollment button to finalize.</div>
                              </div>
                              <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                                 <div class="billing-address">
                                    <!--billing info-->
                                    <div
                                       class="inline-flex items-center justify-between px-4 py-2 text-sm text-gray-900 mb-4 bg-blue-300 rounded-full dark:bg-yellow-800 dark:text-white hover:bg-yellow-400 dark:hover:bg-yellow-700"
                                       aria-label="Component requires Flowbite JavaScript">
                                       <span class="text-xs font-medium text-gray-900">Billing Address</span>
                                    </div>
                                    <div
                                       class=" mb-10 p-0 bg-white border border-gray-200 rounded-sm dark:bg-gray-800 dark:border-gray-700">
                                       <div class="relative overflow-x-auto">
                                          <table
                                             class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                             <tbody>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      Address
                                                   </th>
                                                   <td id="preview-address"
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      1B Silver Lx Suite,
                                                   </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      City
                                                   </th>
                                                   <td id="preview-city"
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      Newyork
                                                   </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      State/province/area
                                                   </th>
                                                   <td id="preview-state"
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      AUX
                                                   </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      Zip code
                                                   </th>
                                                   <td id="preview-zipcode"
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      1008
                                                   </td>
                                                </tr>
                                                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      Country
                                                   </th>
                                                   <td id="preview-country"
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      United States
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="shipping-address">
                                    <!--shipping info-->

                                 </div>
                              </div>
                              <!--Amount info-->
                              <div
                                 class="inline-flex items-center justify-between px-4 py-2 text-sm text-gray-900 mb-4 bg-blue-300 rounded-full dark:bg-yellow-800 dark:text-white hover:bg-yellow-400 dark:hover:bg-yellow-700"
                                 aria-label="Component requires Flowbite JavaScript">
                                 <span class="text-xs font-medium text-gray-900">Your Purchase</span>
                              </div>
                              <div
                                 class=" mb-3 p-0 bg-white border border-gray-200 rounded-sm dark:bg-gray-800 dark:border-gray-700">
                                 <div class="relative overflow-x-auto">
                                    <table
                                       class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                       <tbody>
                                          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                             <th scope="row" class="px-6 py-4">
                                                Package Name
                                             </th>
                                             <td id="preview-package-name"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                <!-- Silver Pack -->
                                             </td>
                                          </tr>
                                          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                             <th scope="row" class="px-6 py-4">
                                                Package Price
                                             </th>
                                             <td  id="preview-package-price"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                <!-- $100.00 -->
                                             </td>
                                          </tr>
                                          <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                                             <th scope="row" class="px-6 py-4">
                                                Total (usd)
                                             </th>
                                             <td id="preview-package-total"
                                                class="px-6 py-4 text-end font-bold tracking-tight text-gray-900 dark:text-white">
                                                <!-- $100.00 -->
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="relative mb-10">
                                 <input type="text" id="coupon-code" name="coupon-code"
                                    class="block w-full p-4 text-sm text-gray-900 border border-gray-200 rounded-sm bg-white focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                    placeholder="Coupon Code" />
                                 <button type="submit"
                                    class="text-white absolute end-2.5 bottom-2.5 bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-xs px-5 py-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Apply
                                    Code</button>
                              </div>
                              <!--payment info-->
                              <div
                                 class="inline-flex items-center justify-between px-4 py-2 text-sm text-gray-900 mb-4 bg-blue-300 rounded-full dark:bg-yellow-800 dark:text-white hover:bg-yellow-400 dark:hover:bg-yellow-700"
                                 aria-label="Component requires Flowbite JavaScript">
                                 <span class="text-xs font-medium text-gray-900">Payment Method</span>
                              </div>
                              <div class="mb-10 ">

                                 <!--payment-options-->
                                 <!-- Dropdown -->
                                 <select id="payment" name="payment"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">

                                <option value="">-- Select an option --</option>
                                   @foreach (getAllPayments() as $data)
                                       <option value="{{ $data->paymentsettings_id }}">{{ $data->paymentsettings_name }}</option>
                                    @endforeach
                                 </select>

                                 <!--payment Div Containers -->
                                 <div id="content2" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account
                                             Name</label>
                                          <input type="text" id="acc_number"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account
                                             Number</label>
                                          <input type="text" id="acc_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Address</label>
                                          <input type="text" id="bank_address"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Swift Code</label>
                                          <input type="text" id="bank_swift_code"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Route</label>
                                          <input type="text" id="bank_route"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
                                    </div>
                                 </div>

                                 <div id="content6" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                                          <input type="text" id="amount"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">In
                                             Favour Of</label>
                                          <input type="text" id="in_fav"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cheque
                                             Number</label>
                                          <input type="text" id="cheque_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Name</label>
                                          <input type="text" id="bank_name_new"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Branch
                                             Name</label>
                                          <input type="text" id="branch_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>

                                          <div class="relative">
                                             <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                   xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                   viewBox="0 0 20 20">
                                                   <path
                                                      d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
                                             </div>
                                             <input datepicker id="default-datepicker" type="text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Select date">
                                          </div>

                                       </div>
                                    </div>
                                 </div>

                                  <div id="epin-section" class="hidden my-6">
                                    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                                        <div class="mb-5">
                                            <label class="block mb-2 text-sm font-medium text-gray-900">E-pin Code</label>

                                            <div class="relative">
                                                <input type="text"
                                                    id="epin"
                                                    name="epin_code"
                                                    placeholder="Enter your E-pin code"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pr-12 transition-all duration-300">

                                                <!-- Status Icon (Tick / Cross / Spinner) -->
                                                <div class="absolute inset-y-0 right-3 flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 hidden" id="epin-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                                                        <path class="opacity-75" fill="none" stroke="currentColor" stroke-width="4" d="M4 12a8 8 0 018-8"></path>
                                                    </svg>
                                                    <svg class="w-5 h-5 text-green-500 hidden" id="epin-success" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <svg class="w-5 h-5 text-red-500 hidden" id="epin-error-icon" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Message Below Input -->
                                            <div id="epin-message" class="mt-2 text-sm font-medium"></div>
                                        </div>
                                    </div>
                                  </div>

                                 <div id="content10" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                          <input type="text" id="e_name "
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                                             Number</label>
                                          <input type="text" id="card_number"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <div class="grid md:grid-cols-2 md:gap-6">
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry
                                                   MM/YY</label>
                                                <input type="text" id="expiry"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Security
                                                   Code</label>
                                                <input type="text" id="securitycode"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                          </div>
                                       </div>

                                    </div>

                                 </div>

                                 <!-- payment Div Containers -->

                               <div id="content16" class="hidden my-5">
                                    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Credit/Debit Card Details</h3>

                                        <!-- Card Holder Name -->
                                        <div class="mb-5">
                                            <label for="authnet_card_holder" class="block mb-2 text-sm font-medium text-gray-900">
                                                Card Holder Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                id="authnet_card_holder"
                                                name="card_holder_name"
                                                value="{{ old('card_holder_name') }}"
                                                placeholder="John Doe"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                                autocomplete="cc-name">
                                            <span id="authnet_card_holder_error" class="hidden text-red-500 text-sm mt-1"></span>
                                            @error('card_holder_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Card Number -->
                                        <div class="mb-5">
                                            <label for="authnet_card_number" class="block mb-2 text-sm font-medium text-gray-900">
                                                Card Number <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                id="authnet_card_number"
                                                name="card_number"
                                                value="{{ old('card_number') }}"
                                                placeholder="4111 1111 1111 1111"
                                                maxlength="19"
                                                inputmode="numeric"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                                autocomplete="cc-number">
                                            <span id="authnet_card_number_error" class="hidden text-red-500 text-sm mt-1"></span>
                                            @error('card_number')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Expiry Date (Single Field) + CVV -->
                                        <div class="grid grid-cols-2 gap-4 mb-5">
                                            <!-- Expiry Date (MM/YY) -->
                                            <div>
                                                <label for="authnet_expiry" class="block mb-2 text-sm font-medium text-gray-900">
                                                    Expiry Date (MM/YY) <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text"
                                                    id="authnet_expiry"
                                                    name="expiry"
                                                    value="{{ old('expiry') }}"
                                                    placeholder="MM/YY"
                                                    maxlength="5"
                                                    inputmode="numeric"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                                    autocomplete="cc-exp">
                                                <span id="authnet_expiry_error" class="hidden text-red-500 text-sm mt-1"></span>
                                                @error('expiry')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- CVV -->
                                            <div>
                                                <label for="authnet_cvv" class="block mb-2 text-sm font-medium text-gray-900">
                                                    Security Code (CVV) <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text"
                                                    id="authnet_cvv"
                                                    name="cvv"
                                                    value="{{ old('cvv') }}"
                                                    placeholder="123"
                                                    maxlength="4"
                                                    inputmode="numeric"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                                <span id="authnet_cvv_error" class="hidden text-red-500 text-sm mt-1"></span>
                                                @error('cvv')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(session('error'))
                                            <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 border border-red-300 rounded-lg">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                 <!--payment-options-->
                              </div>

                              <div class="flex items-center mb-4">
                                 <input id="agreement-checkbox" type="checkbox" value=""
                                    class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                 <label for="default-checkbox" class="ms-2 text-sm text-gray-900 dark:text-gray-300">
                                    Click here to indicate that you have read and agree to the terms presented in the
                                    Terms and Conditions agreement</label>
                              </div>

                           </div>
                           <!-- Navigation Buttons -->

                           <div class="flex justify-between mt-8">
                              <button type="button" id="prevBtn"
                                 class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 hidden">Previous</button>
                              <button type="button" id="nextBtn"
                                 class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Next</button>
                              <button type="submit" id="submitBtn"
                                 class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 hidden">Submit</button>
                           </div>
                        </form>
                     </div>
                  </form>
                  <!--form ends-->
               </div>

            </div>

            <div
               class="order-2 lg:order-1 bg-center xxl:bg-center xl:bg-cover bg-no-repeat branded-bg h-screen sticky top-0 overflow-hidden"
               style="background-image: url('../img/registerf.jpg');">

               <div class="flex flex-col justify-between p-8 lg:p-16 gap-4 h-full">
                  <div class="flex flex-col">
                     <img src="../img/logo.png" alt="brand-logo" class="w-32 mb-5">
                  </div>

                  <div class="flex flex-col">
                     <div class="flex justify-between">
                        <div class="text-gray-800 text-sm">©ihookwebsolutions,2025</div>
                        <div class="footer-privacy-links flex justify-between align-center text-gray-800">
                           <a href="#" class="me-3  text-sm">Privacy</a>
                           <a href="#" class="me-3  text-sm">Legal</a>
                           <a href="#" class="me-3  text-sm">Contact</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
   </div>

   <!-- Script for payment dropdown -->
   <script>
   document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('options');
    const contents = document.querySelectorAll('[id^="content"]');

    if (dropdown) {
        dropdown.addEventListener('change', function () {
            // Hide all content divs
            contents.forEach(content => content.classList.add('hidden'));

            // Show the selected content div
            const selectedContent = document.getElementById(this.value);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }
        });
    } else {
        console.warn('Dropdown element with ID "options" not found.');
    }
});

   </script>


<script>

document.addEventListener("DOMContentLoaded", () => {
  const nextBtn = document.getElementById("nextBtn"),
        prevBtn = document.getElementById("prevBtn"),
        totalSteps = 4;

  let currentStep = 1;
let selectedPackage = null;

  // Helper to show error messages inline
  function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    let errorEl = field.nextElementSibling;

    if (!errorEl || !errorEl.classList.contains("error-message")) {
      errorEl = document.createElement("div");
      errorEl.className = "error-message text-red-600 text-sm mt-1";
      field.parentNode.insertBefore(errorEl, field.nextSibling);
    }
    errorEl.innerText = message;
  }


  const updateStepDisplay = () => {
    for (let i = 1; i <= totalSteps; i++) {
        const stepEl = document.getElementById(`step-${i}`);
        if (stepEl) stepEl.style.display = i === currentStep ? "block" : "none";

        const indicator = document.getElementById(`step${i}`);
        if (indicator) indicator.classList.toggle("opacity-50", i < currentStep);
    }

    prevBtn.classList.toggle("hidden", currentStep === 1);
    document.getElementById("progress-bar").style.width = `${(currentStep / totalSteps) * 100}%`;
    nextBtn.innerText = currentStep === totalSteps ? "Finish" : "Next";

    // Show package preview on Step 4
    if (currentStep === 4) {
        const nameEl = document.getElementById("preview-package-name");
        const priceEl = document.getElementById("preview-package-price");
        const totalEl = document.getElementById("preview-package-total");

        if (selectedPackage) {
            nameEl.innerText = selectedPackage.package_name || "-";
            priceEl.innerText = `$${parseFloat(selectedPackage.package_price).toFixed(2)}`;
            totalEl.innerText = `$${parseFloat(selectedPackage.package_price).toFixed(2)}`;
        } else {
            nameEl.innerText = "No package selected";
            priceEl.innerText = "-";
            totalEl.innerText = "-";
        }

        // === NEW: Payment method validation when entering Step 4 ===
        const paymentMethod = document.querySelector('input[name="payment"]:checked')?.value;

        // First, enable the button (in case previous errors cleared)
        nextBtn.disabled = false;
        nextBtn.classList.remove("opacity-50", "cursor-not-allowed");

        if (paymentMethod === "16") {
            const isCardValid = validateAuthorizeNetFields();

            if (!isCardValid) {
                nextBtn.disabled = true;
                nextBtn.classList.add("opacity-50", "cursor-not-allowed");
                nextBtn.title = "Please correct card details before proceeding";

                let generalError = document.getElementById("card-general-error");
                if (!generalError) {
                    generalError = document.createElement("div");
                    generalError.id = "card-general-error";
                    generalError.className = "text-red-600 text-sm font-medium mt-4 text-center";
                    document.querySelector("#content16").prepend(generalError);
                }
                generalError.textContent = "Please correct the highlighted card errors before finishing.";
            } else {
                const generalError = document.getElementById("card-general-error");
                if (generalError) generalError.textContent = "";

                nextBtn.disabled = false;
                nextBtn.classList.remove("opacity-50", "cursor-not-allowed");
                nextBtn.title = "";
            }
        } else {
            nextBtn.disabled = false;
            nextBtn.classList.remove("opacity-50", "cursor-not-allowed");

            const generalError = document.getElementById("card-general-error");
            if (generalError) generalError.textContent = "";
        }
    }
};

  const validateStep = async () => {
    document.querySelectorAll(".error-message").forEach(el => el.innerText = "");

if (currentStep === 1) {
  const userName = document.getElementById("user_name").value.trim(),
        firstName = document.getElementById("first_name").value.trim(),
        lastName = document.getElementById("last_name").value.trim(),
        email = document.getElementById("email").value.trim(),
        password = document.getElementById("password").value,
        confirmPassword = document.getElementById("confirm_password").value,
        emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  let hasError = false;

  // Username validation as email format
  if (!userName) {
    document.getElementById("error_user_name").innerText = "Please enter user name.";
    hasError = true;
  }

  // First name
  if (!firstName) {
    document.getElementById("error_first_name").innerText = "Please enter first name.";
    hasError = true;
  }

  // Last name
  if (!lastName) {
    document.getElementById("error_last_name").innerText = "Please enter last name.";
    hasError = true;
  }

  // Email
  if (!email) {
    document.getElementById("error_email").innerText = "Please enter email.";
    hasError = true;
  } else if (!emailRegex.test(email)) {
    document.getElementById("error_email").innerText = "Invalid email format.";
    hasError = true;
  }

  // Password
  if (!password) {
    document.getElementById("error_password").innerText = "Please enter password.";
    hasError = true;
  } else if (password.length < 8) {
    document.getElementById("error_password").innerText = "Password must be at least 8 characters.";
    hasError = true;
  }

  // Confirm password
  if (!confirmPassword) {
    document.getElementById("error_confirm_password").innerText = "Please enter confirm password.";
    hasError = true;
  } else if (password !== confirmPassword) {
    document.getElementById("error_confirm_password").innerText = "Passwords do not match.";
    hasError = true;
  }

  if (hasError) return false;

  // CSRF token
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Backend email check
  try {
    const resEmail = await fetch('registration/email_already_exists', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ email: email })
    });

    if (!resEmail.ok) throw new Error("Request failed");

    const { exists: emailExists } = await resEmail.json();

    if (emailExists === true) {
      document.getElementById("error_email").innerText = "Email already exists.";
      return false;
    }
  } catch (error) {
    console.error("Email check failed:", error);
    document.getElementById("error_email").innerText = "Error checking email.";
    return false;
  }

  // Backend username check
  try {
    const resUser = await fetch('registration/username_already_exists', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ username: userName })
    });

    if (!resUser.ok) throw new Error("Request failed");

    const { exists: userExists } = await resUser.json();

    if (userExists === true) {
      document.getElementById("error_user_name").innerText = "Username already exists.";
      return false;
    }
  } catch (error) {
    console.error("Username check failed:", error);
    document.getElementById("error_user_name").innerText = "Error checking username.";
    return false;
  }

  return true;
}


    if (currentStep === 2) {
      let hasError = false;

      // Validate each Step 2 field, show errors inline
      const date = document.getElementById("date").value;
      if (!date) {
        showError("date", "Please select a date.");
        hasError = true;
      }

      const month = document.getElementById("month").value;
      if (!month) {
        showError("month", "Please select a month.");
        hasError = true;
      }

      const year = document.getElementById("year").value;
      if (!year) {
        showError("year", "Please select a year.");
        hasError = true;
      }

      const address = document.getElementById("address").value.trim();
      if (!address) {
        showError("address", "Please enter your address.");
        hasError = true;
      }

      const country = document.getElementById("country").value;
      if (!country) {
        showError("country", "Please select a country.");
        hasError = true;
      }

      const state = document.getElementById("state").value;
      if (!state) {
        showError("state", "Please select a state.");
        hasError = true;
      }

      const city = document.getElementById("city").value.trim();
      if (!city) {
        showError("city", "Please enter your city.");
        hasError = true;
      }

      const zipcode = document.getElementById("zipcode").value.trim();
      if (!zipcode) {
        showError("zipcode", "Please enter your zipcode.");
        hasError = true;
      }

      const phone = document.getElementById("phone").value.trim();
      if (!phone) {
        showError("phone", "Please enter your phone number.");
        hasError = true;
      }

      return !hasError;
    }


if (currentStep === 3) {
    if (MEMBERS_PAID_ACCOUNT_TYPE === "1") {
        if (!selectedPackage || selectedPackage.package_id <= 0) {
            $('#package-error').text('Please select a package.').show();
            return false;
        }
    } else {
        if (!selectedPackage) {
            selectedPackage = {
                package_id: 0,
                package_price: 0,
                package_name: "One Time Registration",
                is_free_registration: true
            };
        }
    }
    return true;
}
    return true;
  };
  @php
    $members_paid_account_type = DB::table('ihook_matrix_configuration_table')
        ->where('matrix_key', 'members_paid_account_type')
        ->value('matrix_value') ?? '1';
@endphp

const MEMBERS_PAID_ACCOUNT_TYPE = "{{ $members_paid_account_type }}";

const loadPackages = () => {
    $.ajax({
        url: "{{ route('user.package') }}",
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            let html = '';
            let isOneTimeMode = data.length === 1 && data[0].is_free_registration === true;

            // Dynamic Title & Description
            let title = isOneTimeMode ? 'One Time Registration' : 'Choose Package';
            let description = isOneTimeMode
                ? 'Complete your registration with a one-time fee. No monthly charges.'
                : 'Please choose your package. Total includes 1st Month Backoffice Fee';

            $('#step-3 .mb-10').html(`
                <div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2.5">
                    ${title}
                </div>
                <div class="text-base text-gray-900 dark:text-white">
                    ${description}
                </div>
                <div id="package-error" class="text-red-500 text-sm mt-2 font-medium text-center w-full"></div>
            `);

            data.forEach((pkg) => {
                const isOneTime = pkg.is_free_registration === true;
                const radioId    = isOneTime ? 'onetime_package' : `package_${pkg.package_id}`;
                const radioValue = isOneTime ? '0' : pkg.package_id;
                const imgSrc     = pkg.package_image || '/assets/img/register-package/r2.png';

                let priceDisplay = '';
                if (isOneTime) {
                    priceDisplay = parseFloat(pkg.package_price) > 0 ? '$' + pkg.package_price : 'One Time Fee';
                } else {
                    priceDisplay = '$' + pkg.package_price;
                }

                html += `
                <li>
                  <input type="radio" id="${radioId}" name="Package" value="${radioValue}" class="hidden peer" required />
                  <label for="${radioId}" class="inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-gray-500 peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                      <div class="text-center">
                        <img src="${imgSrc}" alt="package-image" class="w-20 mx-auto mb-4">
                        <div class="w-full text-xs font-semibold mb-2 text-gray-600">${pkg.package_name}</div>
                        <div class="w-full text-sm font-bold mb-5 text-gray-900">${priceDisplay}</div>
                        <div>
                          <div class="w-full text-xs text-gray-600 font-semibold mb-2">Purchase Volume :
                            <span class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                              ${pkg.package_pv}
                            </span>
                          </div>
                         <div class="w-full text-xs text-gray-600 font-semibold">Direct Commission :
                            <span class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                                ${formatDirectCommission(pkg.package_direct_commission, pkg.package_direct_commission_method)}
                            </span>
                        </div>
                        </div>
                      </div>
                    </div>
                  </label>
                </li>`;
            });

            $('#package-list').html(html);

            if (isOneTimeMode) {
                $('#onetime_package').prop('checked', true);
                selectedPackage = data[0]; // Auto-set it
            }

            $('input[name="Package"]').on('change', function() {
                const selectedId = $(this).attr('id');
                const pkg = data.find(p =>
                    (p.is_free_registration && selectedId === 'onetime_package') ||
                    (!p.is_free_registration && selectedId === `package_${p.package_id}`)
                );

                if (pkg) {
                    selectedPackage = pkg;
                    $('#package-error').hide();
                }
            });

            if (isOneTimeMode) {
                $('#onetime_package').trigger('change');
            }
        },
        error: function() {
            $('#step-3 .mb-10').html(`
                <div class="text-red-600 text-xl font-semibold text-center py-16">
                    Failed to load packages. Please refresh.
                </div>
            `);
        }
    });
};


function formatDirectCommission(amount, method) {
    if (!amount || parseFloat(amount) <= 0) {
        return '0';
    }

    let cleanAmount = parseFloat(amount).toFixed(2).replace(/\.?0+$/, '');

    let type = (method || '').toString().trim().toLowerCase();

    if (type === '1' || type === '%' || type === 'percentage') {
        return cleanAmount + '%';
    }

    return '$' + cleanAmount;
}



$(document).ready(function() {
    loadPackages();
});

  nextBtn.addEventListener("click", async () => {
    if (await validateStep()) {
      if (currentStep < totalSteps) {
        currentStep++;
        updateStepDisplay();
      } else {
        // Submit form or do final actions
        document.getElementById("sign_up_form").submit();
      }
    }
  });

  prevBtn.addEventListener("click", () => {
    if (currentStep > 1) {
      currentStep--;
      updateStepDisplay();
    }
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
   <!--phone-country-input-->

<!-- date start -->
<script>
  const dateSelect = document.getElementById('date');

  for (let day = 1; day <= 31; day++) {
    const option = document.createElement('option');
    // Pad single digits with a leading zero
    option.value = option.textContent = day.toString().padStart(2, '0');
    dateSelect.appendChild(option);
  }
</script>
<!-- date end -->

<!-- year start -->
<script>
  const startYear = 1990;
  const endYear = 2040;
  const select = document.getElementById("year");

  for (let year = startYear; year <= endYear; year++) {
    const option = document.createElement("option");
    option.value = year;
    option.textContent = year;
    select.appendChild(option);
  }
</script>
<!-- year end  -->
 <!-- state dropdown start-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#country').on('change', function () {
            var Country_sortname = this.value;
            $("#state").html('');

            $.ajax({
                url: "{{ route('user.fetchState') }}",
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



<script>
  function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const eyeClosedIcon = button.querySelector('.eye-closed');
    const eyeOpenIcon = button.querySelector('.eye-open');

    if (input.type === "password") {
      input.type = "text";
      eyeClosedIcon.classList.add('hidden');
      eyeOpenIcon.classList.remove('hidden');
    } else {
      input.type = "password";
      eyeClosedIcon.classList.remove('hidden');
      eyeOpenIcon.classList.add('hidden');
    }
  }

</script>
<!-- Display details -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const countrySelect = document.getElementById('country');
    const stateSelect = document.getElementById('state');
    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const zipcodeInput = document.getElementById('zipcode');

    const preview = {
      address: document.querySelector('#preview-address'),
      city: document.querySelector('#preview-city'),
      state: document.querySelector('#preview-state'),
      zipcode: document.querySelector('#preview-zipcode'),
      country: document.querySelector('#preview-country')
    };

    // Utility to update preview fields
    function updatePreview() {
      preview.address.textContent = addressInput.value;
      preview.city.textContent = cityInput.value;
      preview.zipcode.textContent = zipcodeInput.value;
      preview.country.textContent = countrySelect.options[countrySelect.selectedIndex]?.text || '';

      // Show state name for selected code
      const selectedStateOption = stateSelect.options[stateSelect.selectedIndex];
      preview.state.textContent = selectedStateOption?.text || '';
    }

    // Fetch states when country changes
    countrySelect.addEventListener('change', () => {
      const countryCode = countrySelect.value;
      stateSelect.innerHTML = '<option value="">-- Select State --</option>';
      if (!countryCode) {
        updatePreview();
        return;
      }

            fetch(`registration/get_states/${countryCode}`, {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
         }
         })
         .then(res => res.json())
         .then(data => {
         data.forEach(state => {
            const option = document.createElement('option');
            option.value = state.code;
            option.textContent = state.name;
            stateSelect.appendChild(option);
         });
         updatePreview();
         });
    });

    // Update preview on input changes
    [addressInput, cityInput, zipcodeInput, stateSelect, countrySelect].forEach(el => {
      el.addEventListener('input', updatePreview);
      el.addEventListener('change', updatePreview);
    });

    // Initialize preview on page load
    updatePreview();
  });
</script>

<script>
const accordionButton = document.getElementById('accordionButton');
const accordionBody = document.getElementById('accordion-collapse-body-2');
const sponsIdInput = document.getElementById('spons-id');
const errorMessage = document.getElementById('spons-id-error');
const sponsorSubmit = document.getElementById('sponsorSubmit');
const nextBtn = document.getElementById('nextBtn');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const successMessage = document.getElementById('spons-success');

// ----------------- ACCORDION TOGGLE -----------------
accordionButton.addEventListener('click', function () {
    accordionBody.classList.toggle('hidden');
    const isExpanded = !accordionBody.classList.contains('hidden');
    this.setAttribute('aria-expanded', isExpanded);
});

// ----------------- SPONSOR SUBMIT -----------------
sponsorSubmit.addEventListener('click', async function (event) {
    event.preventDefault();

    const sponsorId = sponsIdInput.value.trim();
    if (sponsorId === '') {
        sponsIdInput.classList.add('border-red-500');
        errorMessage.textContent = "Please enter a Sponsor Username.";
        errorMessage.classList.remove('hidden');
        successMessage.classList.add('hidden');
        nextBtn.classList.add('hidden');
        return;
    }

    // Remove previous errors
    sponsIdInput.classList.remove('border-red-500');
    errorMessage.classList.add('hidden');
    successMessage.classList.add('hidden');

    try {
        const response = await fetch(`{{ route('user.setSponsorDetails') }}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ reg_sponsor_id: sponsorId }),
        });

        const responseText = await response.text();
        if (!responseText.trim()) throw new Error("Empty response from server.");

        let data;
        try {
            data = JSON.parse(responseText);
        } catch {
            throw new Error("Server returned invalid JSON.");
        }

        if (!response.ok || data.error) {
            sponsIdInput.classList.add("border-red-500");
            errorMessage.textContent = data.error || "This sponsor ID does not exist. Please choose another.";
            errorMessage.classList.remove("hidden");
            nextBtn.classList.add('hidden');
            successMessage.classList.add('hidden');
        } else {
            // Fill sponsor details in hidden fields
            document.getElementById('sponsor_id').value = data.sponsor_id;
            document.getElementById('sponsor-name').value = data.sponsor_username;
            document.getElementById('sponsor-phone').value = data.sponsor_phone;
            document.getElementById('sponsor-email').value = data.sponsor_email;

            // Show success message
            successMessage.textContent = "Sponsor is valid!";
            successMessage.classList.remove('hidden');

            // Keep the accordion open (do NOT hide it)
            // Remove error highlight
            sponsIdInput.classList.remove("border-red-500");
            errorMessage.classList.add("hidden");
            nextBtn.classList.remove('hidden');

            // Optional: hide success message after 3 seconds
            setTimeout(() => {
                successMessage.classList.add('hidden');
            }, 3000);
        }

    } catch (error) {
        console.error("Error checking sponsor ID:", error);
        sponsIdInput.classList.add("border-red-500");
        errorMessage.textContent = "An error occurred. Please try again.";
        errorMessage.classList.remove('hidden');
        nextBtn.classList.add('hidden');
        successMessage.classList.add('hidden');
    }
});

sponsIdInput.addEventListener('input', () => {
    successMessage.classList.add('hidden');
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentSelect = document.getElementById('payment');
    const epinSection = document.getElementById('epin-section');
    const epinInput = document.getElementById('epin');
    const messageDiv = document.getElementById('epin-message');
    const spinner = document.getElementById('epin-spinner');
    const successIcon = document.getElementById('epin-success');
    const errorIcon = document.getElementById('epin-error-icon');

    const EPIN_PAYMENT_ID = 14;

    let verifyTimeout;

    paymentSelect.addEventListener('change', function () {
        if (this.value == EPIN_PAYMENT_ID) {
            epinSection.classList.remove('hidden');
            epinInput.focus();
            resetEpinField();
        } else {
            epinSection.classList.add('hidden');
            resetEpinField();
        }
    });

    epinInput.addEventListener('input', function () {
        clearTimeout(verifyTimeout);
        const code = this.value.trim();

        if (code.length < 4) {
            hideAllIcons();
            messageDiv.textContent = '';
            epinInput.dataset.valid = 'false';
            return;
        }

        // Show loading
        showLoading();

        verifyTimeout = setTimeout(() => {
            verifyEpin(code);
        }, 600);
    });


    function verifyEpin(code) {
        fetch("{{ route('user.verifyEpin') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ epin_code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccess(`Valid E-pin! Amount: $${data.amount}`);
                epinInput.dataset.valid = 'true';
            } else {
                showError(data.message || 'Invalid E-pin code');
                epinInput.dataset.valid = 'false';
            }
        })
        .catch(() => {
            showError('Connection error. Try again.');
            epinInput.dataset.valid = 'false';
        });
    }

    function showLoading() {
        epinInput.style.borderColor = '#9CA3AF';
        hideAllIcons();
        spinner.classList.remove('hidden');
        messageDiv.textContent = 'Checking...';
        messageDiv.className = 'mt-2 text-sm text-gray-500';
    }

    function showSuccess(msg) {
        hideAllIcons();
        successIcon.classList.remove('hidden');
        epinInput.style.borderColor = '#10B981';
        messageDiv.innerHTML = `<span class="text-green-600 font-medium">${msg}</span>`;
        epinInput.dataset.valid = 'true';
    }

    function showError(msg) {
        hideAllIcons();
        errorIcon.classList.remove('hidden');
        epinInput.style.borderColor = '#EF4444';
        messageDiv.innerHTML = `<span class="text-red-600">${msg}</span>`;
        epinInput.dataset.valid = 'false';
    }

    function hideAllIcons() {
        spinner.classList.add('hidden');
        successIcon.classList.add('hidden');
        errorIcon.classList.add('hidden');
    }

    function resetEpinField() {
        epinInput.value = '';
        epinInput.style.borderColor = '#D1D5DB';
        hideAllIcons();
        messageDiv.textContent = '';
        epinInput.dataset.valid = 'false';
    }

    const form = document.getElementById('sign_up_form');
    form.addEventListener('submit', function(e) {
        if (paymentSelect.value == EPIN_PAYMENT_ID && epinInput.dataset.valid !== 'true') {
            e.preventDefault();
            showError('Please enter a valid E-pin before submitting.');
            epinInput.focus();
        }
    });
});
</script>

<script>
// Luhn Algorithm for card number validation
function luhnCheck(cardNumber) {
    const digits = cardNumber.replace(/\D/g, '').split('').map(Number);
    let sum = 0;
    let isEven = false;
    for (let i = digits.length - 1; i >= 0; i--) {
        let digit = digits[i];
        if (isEven) {
            digit *= 2;
            if (digit > 9) digit -= 9;
        }
        sum += digit;
        isEven = !isEven;
    }
    return sum % 10 === 0;
}

// Show error message below field
function showAuthNetError(fieldId, message) {
    const field = document.getElementById(fieldId);
    let errorEl = document.getElementById(fieldId + '_error');

    if (!errorEl) {
        errorEl = document.createElement('span');
        errorEl.id = fieldId + '_error';
        errorEl.className = 'hidden text-red-500 text-sm mt-1 block';
        field.parentNode.appendChild(errorEl);
    }

    errorEl.textContent = message;
    errorEl.classList.remove('hidden');
    field.classList.add('border-red-500', 'focus:border-red-500');
    field.classList.remove('border-gray-300', 'focus:border-blue-500');
}

// Clear error message
function clearAuthNetError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorEl = document.getElementById(fieldId + '_error');
    if (errorEl) {
        errorEl.textContent = '';
        errorEl.classList.add('hidden');
    }
    field.classList.remove('border-red-500', 'focus:border-red-500');
    field.classList.add('border-gray-300', 'focus:border-blue-500');
}

// Main validation function (called on input/blur and submit)
function validateAuthorizeNetFields() {
    let isValid = true;

    // 1. Card Holder Name
    const holder = document.getElementById('authnet_card_holder')?.value.trim() || '';
    if (!holder) {
        showAuthNetError('authnet_card_holder', 'Card holder name is required');
        isValid = false;
    } else if (!/^[a-zA-Z\s]{2,100}$/.test(holder)) {
        showAuthNetError('authnet_card_holder', 'Only letters and spaces allowed (2-100 characters)');
        isValid = false;
    } else {
        clearAuthNetError('authnet_card_holder');
    }

  // 2. Card Number - Correct version (allows spaces)
const cardInput = document.getElementById('authnet_card_number');
let rawCardNum = cardInput?.value.replace(/\D/g, '') || '';  // Remove spaces and non-digits

if (!rawCardNum) {
    showAuthNetError('authnet_card_number', 'Card number is required');
    isValid = false;
} else if (rawCardNum.length < 13 || rawCardNum.length > 19) {
    showAuthNetError('authnet_card_number', 'Card number must be between 13 and 19 digits');
    isValid = false;
} else if (!luhnCheck(rawCardNum)) {
    showAuthNetError('authnet_card_number', 'Invalid card number (failed Luhn check)');
    isValid = false;
} else {
    clearAuthNetError('authnet_card_number');
}

    const expiryInput = document.getElementById('authnet_expiry');
    let expiryVal = expiryInput?.value.trim() || '';
    const expiryRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;

    if (!expiryVal) {
        showAuthNetError('authnet_expiry', 'Expiry date is required');
        isValid = false;
    } else if (!expiryRegex.test(expiryVal)) {
        showAuthNetError('authnet_expiry', 'Invalid format. Use MM/YY (e.g., 12/27)');
        isValid = false;
    } else {
        clearAuthNetError('authnet_expiry');

        const [, month, yearShort] = expiryVal.match(expiryRegex);
        const monthNum = parseInt(month);
        const fullYear = 2000 + parseInt(yearShort);

        // Check if month is valid
        if (monthNum < 1 || monthNum > 12) {
            showAuthNetError('authnet_expiry', 'Invalid month (01-12)');
            isValid = false;
        } else {
            // Check if card is expired
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const expDate = new Date(fullYear, monthNum); // Last day of expiry month is allowed

            if (expDate < today) {
                showAuthNetError('authnet_expiry', 'Card has expired');
                isValid = false;
            }
        }
    }

    // 4. CVV
    const cvv = document.getElementById('authnet_cvv')?.value.trim() || '';
    if (!cvv) {
        showAuthNetError('authnet_cvv', 'CVV is required');
        isValid = false;
    } else if (!/^\d{3,4}$/.test(cvv)) {
        showAuthNetError('authnet_cvv', 'CVV must be 3 or 4 digits');
        isValid = false;
    } else {
        clearAuthNetError('authnet_cvv');
    }

    return isValid;
}

// DOM Loaded
document.addEventListener('DOMContentLoaded', function () {
    const fields = ['authnet_card_number', 'authnet_cvv', 'authnet_expiry'];
    const realTimeFields = ['authnet_card_holder', 'authnet_card_number', 'authnet_expiry', 'authnet_cvv'];

    fields.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('input', function (e) {
                if (id === 'authnet_expiry') {
                    e.target.value = e.target.value.replace(/[^0-9\/]/g, '');
                } else {
                    e.target.value = e.target.value.replace(/\D/g, '');
                }
            });
        }
    });

const cardInputField = document.getElementById('authnet_card_number');
if (cardInputField) {
    cardInputField.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Only digits
        value = value.substring(0, 19); // Max 19 digits

        // Add space every 4 digits
        if (value.length > 0) {
            value = value.match(/.{1,4}/g)?.join(' ') || value;
        }

        e.target.value = value;
        validateAuthorizeNetFields();
    });
}

    // Auto-format Expiry: MM/YY
    const expiryInput = document.getElementById('authnet_expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length >= 2) {
                val = val.slice(0, 2) + '/' + val.slice(2, 4);
            }
            e.target.value = val.slice(0, 5);
            validateAuthorizeNetFields();
        });
    }

    realTimeFields.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('input', validateAuthorizeNetFields);
            field.addEventListener('blur', validateAuthorizeNetFields);
        }
    });

    // Final form submission check
    document.getElementById('sign_up_form').addEventListener('submit', function (e) {
        const paymentMethod = document.getElementById('payment').value;

        if (paymentMethod === '16') {
            if (!validateAuthorizeNetFields()) {
                e.preventDefault();

                // Scroll to first error
                const firstErrorField = document.querySelector('#content16 .border-red-500');
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }

                alert('Please fix the errors in your card details before submitting.');
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentSelect = document.getElementById('payment');
    const contents = document.querySelectorAll('[id^="content"]');

    function showPaymentSection() {
        contents.forEach(content => content.classList.add('hidden'));
        let selected = paymentSelect.value;
        @if(old('payment'))
            selected = "{{ old('payment') }}";
            paymentSelect.value = selected;
        @endif

        if (selected) {
            const target = document.getElementById('content' + selected);
            if (target) {
                target.classList.remove('hidden');
                if (selected === '16') {
                    setTimeout(() => {
                        document.getElementById('authnet_card_holder')?.focus();
                    }, 100);
                }
            }
        }
    }
    paymentSelect.addEventListener('change', showPaymentSection);

    showPaymentSection();
});
</script>

  <script src="https://cdn.tailwindcss.com"></script>

   <!--Flowbite-js-->
   <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
