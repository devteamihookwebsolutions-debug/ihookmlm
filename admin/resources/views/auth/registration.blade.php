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
                     <!-- <div>Already have an account? <a href="{{ route('user.login') }}">Login</a></div> -->
                     <!-- <div>Already have an account ? <a href=""> Login</a></div> -->
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
                  <form   method="POST"  action="{{ route('register.post') }}" class="card-body flex flex-col gap-5 p-2 sm:p-2 md:p-6 lg:p-10" id="sign_up_form"
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
                              <div class="mb-5">
                                 <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-500">*</span>Your
                                    Password</label>
                                 <input type="password" id="password"  name = "password"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light" />
                                 <span class="text-red-500 text-sm  error-message" id="error_password"></span>
                                </div>
                              <div class="mb-5">
                                 <label for="confirm_password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><span class="text-red-500">*</span>Confirm
                                    Password</label>
                                 <input type="password" id="confirm_password" name = "confirm_password"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500 dark:shadow-sm-light" />
                                 <span class="text-red-500 text-sm  error-message" id="error_confirm_password"></span>
                                </div>
                              <div class="mb-5">
                                 <label for="repeat-password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pick A
                                    Replicated Website Name</label>
                                 <div class="flex rounded-lg shadow-sm">
                                    <span
                                       class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400">https://promlmicon.com</span>
                                    <input type="text"
                                       class="py-3 px-4 pe-11 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-gray-500 focus:ring-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                 </div>
                              </div>
                              <!--rep-box-->
                              <div class="mb-5">
                                 <div
                                    class="bg-gray-100 text-gray-800 text-xs font-medium p-5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">

                                    <div class="flex items-start mb-3">
                                       <img class="w-32 rounded-lg mr-4" src="../img/av-ico-2.png" alt="rep-img">
                                       <div class="flex flex-col justify-between">
                                          <div class="mb-2 text-sm text-gray-700">You are a guest of : <span
                                                class="text-base text-sm text-gray-600">89778932</span> </div>
                                          <div class="mb-2 text-sm text-gray-700">Phone : <span
                                                class="text-base text-sm text-gray-600">+1 652-265-2235</span> </div>
                                          <div class="mb-2 text-sm text-gray-700">Email : <span
                                                class="text-base text-sm text-gray-600">stella@gmail.com</span> </div>
                                          <div class="mb-2 text-sm text-gray-700">Website : <span
                                                class="text-base text-sm text-gray-600">promlmsoftware.com</span> </div>



                                          <div id="accordion-collapse" data-accordion="collapse">
                                             <div id="accordion-collapse-heading-2">
                                                <button type="button"
                                                   class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                                   data-accordion-target="#accordion-collapse-body-2"
                                                   aria-expanded="false" aria-controls="accordion-collapse-body-2">Not
                                                   Your Consultant? Click Here!</button>
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
                                                         <input type="text" id="spons-id"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                            placeholder="Your Sponsor ID">
                                                      </div>
                                                      <button data-element="submit" class="">
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
                                       <select id="date"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option>01</option>
                                          <option>02</option>
                                          <option>03</option>
                                          <option>04</option>
                                       </select>
                                    </div>
                                    <div class="month-in">
                                       <label for="month"
                                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Month</label>
                                       <select id="month"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option>01</option>
                                          <option>02</option>
                                          <option>03</option>
                                          <option>04</option>
                                       </select>
                                    </div>
                                    <div class="year-in">
                                       <label for="countries"
                                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year</label>
                                       <select id="countries"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option>1990</option>
                                          <option>1991</option>
                                          <option>1992</option>
                                          <option>1993</option>
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
                                          <input type="text" id="last_name"
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
                                          <!-- <input type="text" id="last_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" /> -->
                                             <select id="countries"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option></option>
                                          <option></option>
                                          <option></option>
                                          <option></option>
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
                                          <!-- <input type="text" id="last_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" /> -->
                                               <select id="countries"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option></option>
                                          <option></option>
                                          <option></option>
                                          <option></option>
                                       </select>
                                       </div>
                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                          <!-- <input type="text" id="last_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="" /> -->
                                              <select id="countries"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                          <option></option>
                                          <option></option>
                                          <option></option>
                                          <option></option>
                                       </select>
                                       </div>
                                       <div class="address-in">
                                          <label for="lastname"
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zipcode</label>
                                          <input type="text" id="last_name"
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
                                 <div
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2.5">
                                    Choose Package</div>
                                 <div class="text-base text-gray-900">Please choose your package. Total includes 1st
                                    Month Backoffice Fee</div>
                              </div>
                              <ul class="grid w-full gap-6 md:grid-cols-2">

                                 <li>
                                    <input type="radio" id="pack1" name="hosting" value="pack1" class="hidden peer"
                                       required />
                                    <label for="pack1"
                                       class="inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-gray-500 peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                       <div class="block">
                                          <div class="text-center">
                                             <img src="/assets/img/register-package/r1.png" alt="package-image"
                                                class="w-24 mx-auto mb-4">
                                             <div class="w-full text-lg font-semibold mb-2 text-gray-600">Package 1
                                             </div>
                                             <div class="w-full text-2xl font-bold mb-5 text-gray-900">$400.00</div>
                                             <div class="">
                                                <div class="w-full text-base text-gray-600 font-semibold mb-2">Purchase
                                                   Volume : <span
                                                      class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                                                      100</span></div>
                                                <div class="w-full text-base text-gray-600 font-semibold">Direct
                                                   Commission : <span
                                                      class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">$100</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </label>
                                 </li>

                                 <li>
                                    <input type="radio" id="pack2" name="hosting" value="pack2" class="hidden peer">
                                    <label for="pack2"
                                       class="inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-gray-500 peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                       <div class="block">
                                          <div class="text-center">
                                             <img src="../assets/img/register-package/r2.png" alt="package-image"
                                                class="w-24 mx-auto mb-4">
                                             <div class="w-full text-lg font-semibold mb-2 text-gray-600">Package 2
                                             </div>
                                             <div class="w-full text-2xl font-bold mb-5 text-gray-900">$800.00</div>
                                             <div class="">
                                                <div class="w-full text-base text-gray-600 font-semibold mb-2">Purchase
                                                   Volume : <span
                                                      class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                                                      400</span></div>
                                                <div class="w-full text-base text-gray-600 font-semibold">Direct
                                                   Commission : <span
                                                      class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">$300</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </label>
                                 </li>

                                 <li>
                                    <input type="radio" id="pack3" name="hosting" value="pack3" class="hidden peer">
                                    <label for="pack3"
                                       class="inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-gray-500 peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                       <div class="block">
                                          <div class="text-center">
                                             <img src="../assets/img/register-package/r3.png" alt="package-image"
                                                class="w-24 mx-auto mb-4">
                                             <div class="w-full text-lg font-semibold mb-2 text-gray-600">Package 3
                                             </div>
                                             <div class="w-full text-2xl font-bold mb-5 text-gray-900">$1200.00</div>
                                             <div class="">
                                                <div class="w-full text-base text-gray-600 font-semibold mb-2">Purchase
                                                   Volume : <span
                                                      class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                                                      800</span></div>
                                                <div class="w-full text-base text-gray-600 font-semibold">Direct
                                                   Commission : <span
                                                      class="bg-gray-800 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">$600</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </label>
                                 </li>

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
                                                   <td
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      1B Silver Lx Suite,
                                                   </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      City
                                                   </th>
                                                   <td
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      Newyork
                                                   </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      State/province/area
                                                   </th>
                                                   <td
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      AUX
                                                   </td>
                                                </tr>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      Zip code
                                                   </th>
                                                   <td
                                                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                      1008
                                                   </td>
                                                </tr>
                                                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                                                   <th scope="row" class="px-6 py-4">
                                                      Country
                                                   </th>
                                                   <td
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
                                             <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                Silver Pack
                                             </td>
                                          </tr>
                                          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                             <th scope="row" class="px-6 py-4">
                                                Package Price
                                             </th>
                                             <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-end">
                                                $100.00
                                             </td>
                                          </tr>
                                          <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                                             <th scope="row" class="px-6 py-4">
                                                Total (usd)
                                             </th>
                                             <td
                                                class="px-6 py-4 text-end font-bold tracking-tight text-gray-900 dark:text-white">
                                                $100.00
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="relative mb-10">
                                 <input type="text" id="coupon--code"
                                    class="block w-full p-4 text-sm text-gray-900 border border-gray-200 rounded-sm bg-white focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                    placeholder="Coupon Code" required />
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
                              <div class="  mb-10 ">

                                 <!--payment-options-->

                                 <!-- Dropdown -->
                                 <select id="options"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                    <option value="none">-- Select an option --</option>
                                    <option value="content1">Paypal</option>
                                    <option value="content2">Bankwire</option>
                                    <option value="content3">Bitpay</option>
                                    <option value="content4">Skrill</option>
                                    <option value="content5">Solid Trust Pay</option>
                                    <option value="content6">Cheque</option>
                                    <option value="content7">E-wallet</option>
                                    <option value="content8">E-Pin</option>
                                    <option value="content8">Admin Credits</option>
                                    <option value="content10">Authorize</option>
                                    <option value="content11">Coin Payment</option>
                                    <option value="content12">Blocklo</option>
                                    <option value="content13">Credit/Debit (Stripe)</option>
                                    <option value="content14">Chargebee</option>
                                    <option value="content15">Binance</option>
                                    <option value="content16">Paypal Pro</option>
                                 </select>

                                 <!--payment Div Containers -->
                                 <div id="content2" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account
                                             Name</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account
                                             Number</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Address</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Swift Code</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Route</label>
                                          <input type="text" id="first_name"
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
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">In
                                             Favour Of</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cheque
                                             Number</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                                             Name</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Branch
                                             Name</label>
                                          <input type="text" id="first_name"
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

                                 <div id="content8" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-pin</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
                                    </div>

                                 </div>

                                 <div id="content10" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                                             Number</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <div class="grid md:grid-cols-2 md:gap-6">
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry
                                                   MM/YY</label>
                                                <input type="text" id="first_name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Security
                                                   Code</label>
                                                <input type="text" id="first_name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                          </div>
                                       </div>

                                    </div>

                                 </div>

                                 <div id="content14" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                                             Number</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <div class="grid md:grid-cols-2 md:gap-6">
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry
                                                   MM/YY</label>
                                                <input type="text" id="first_name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Security
                                                   Code</label>
                                                <input type="text" id="first_name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                          </div>
                                       </div>

                                    </div>

                                 </div>

                                 <!-- payment Div Containers -->


                                 <div id="content16" class="hidden my-5">
                                    <div class="bg-white rounded-lg border p-6 mb-5">
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                                             Number</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <div class="grid md:grid-cols-2 md:gap-6">
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry
                                                   MM/YY</label>
                                                <input type="text" id="first_name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                             <div class="">
                                                <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Security
                                                   Code</label>
                                                <input type="text" id="first_name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                                   placeholder="">
                                             </div>
                                          </div>
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>

                                       <div class="mb-5">
                                          <label for=""
                                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip</label>
                                          <input type="text" id="first_name"
                                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                             placeholder="">
                                       </div>
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
      const dropdown = document.getElementById('options');
      const contents = document.querySelectorAll('[id^="content"]');

      dropdown.addEventListener('change', function () {
         // Hide all content divs
         contents.forEach(content => content.classList.add('hidden'));

         // Show the selected content div
         const selectedContent = document.getElementById(this.value);
         if (selectedContent) {
            selectedContent.classList.remove('hidden');
         }
      });
   </script>
   <!-- Script for payment dropdown -->









<script>
   document.addEventListener("DOMContentLoaded", () => {
  const nextBtn = document.getElementById("nextBtn"),
        prevBtn = document.getElementById("prevBtn"),
        totalSteps = 4;

  let currentStep = 1;

  const updateStepDisplay = () => {
    for (let i = 1; i <= totalSteps; i++) {
      document.getElementById(`step-${i}`).style.display = i === currentStep ? "block" : "none";
      const indicator = document.getElementById(`step${i}`);
      indicator.classList.toggle("opacity-50", i < currentStep);
    }

    prevBtn.classList.toggle("hidden", currentStep === 1);
    document.getElementById("progress-bar").style.width = `${(currentStep / totalSteps) * 100}%`;
    nextBtn.innerText = currentStep === totalSteps ? "Finish" : "Next";
  };

  const validateStep = async () => {
    // Clear previous error messages
    document.querySelectorAll(".error-message").forEach(el => el.innerText = "");

    // Only validate step 1
    if (currentStep !== 1) return true;

    const userName = document.getElementById("user_name").value.trim(),
          firstName = document.getElementById("first_name").value.trim(),
          lastName = document.getElementById("last_name").value.trim(),
          email = document.getElementById("email").value.trim(),
          password = document.getElementById("password").value,
          confirmPassword = document.getElementById("confirm_password").value,
          emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    let hasError = false;

    // Frontend validations
    if (!userName) {
      document.getElementById("error_user_name").innerText = "Please enter user name.";
      hasError = true;
    }

    if (!firstName) {
      document.getElementById("error_first_name").innerText = "Please enter first name.";
      hasError = true;
    }

    if (!lastName) {
      document.getElementById("error_last_name").innerText = "Please enter last name.";
      hasError = true;
    }

    if (!email) {
      document.getElementById("error_email").innerText = "Please enter email.";
      hasError = true;
    } else if (!emailRegex.test(email)) {
      document.getElementById("error_email").innerText = "Invalid email format.";
      hasError = true;
    }

    if (!password) {
      document.getElementById("error_password").innerText = "Please enter password.";
      hasError = true;
    }

    if (!confirmPassword) {
      document.getElementById("error_confirm_password").innerText = "Please confirm password.";
      hasError = true;
    } else if (password !== confirmPassword) {
      document.getElementById("error_confirm_password").innerText = "Passwords do not match.";
      hasError = true;
    }

    if (hasError) return false;

    // Backend email check
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
      const res = await fetch('registration/email-already-exists', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ email: email })
      });

      if (!res.ok) throw new Error("Request failed");

      const { exists } = await res.json();

      console.log("Exists:", exists); // Debug

      if (exists === true) {
        document.getElementById("error_email").innerText = "Email already exists.";
        return false;
      }
    } catch (error) {
      console.error("Email check failed:", error);
      document.getElementById("error_email").innerText = "Error checking email.";
      return false;
    }

    return true;
  };

  // Next Button
  nextBtn.addEventListener("click", async () => {
    if (!(await validateStep())) return;

    if (currentStep < totalSteps) {
      currentStep++;
      updateStepDisplay();
    } else {
      document.getElementById("sign_up_form").submit();
    }
  });

  // Previous Button
  prevBtn.addEventListener("click", () => {
    if (currentStep > 1) {
      currentStep--;
      updateStepDisplay();
    }
  });

  updateStepDisplay(); // Initialize form on load
});

</script>

   <!--stepper-script-->
   

   <!--stepper-script-->
   <!-- <script>
      let currentStep = 1;
      const form = document.getElementById('multi-step-form');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const submitBtn = document.getElementById('submitBtn');
      const progressBar = document.getElementById('progress-bar');

      function showStep(step) {
         document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
         document.getElementById(`step-${step}`).classList.remove('hidden');

         progressBar.style.width = `${(step / 4) * 100}%`;
         for (let i = 1; i <= 4; i++) {
            const stepIndicator = document.getElementById(`step${i}`);
            if (i <= step) {
               stepIndicator.classList.remove('opacity-50');
            } else {
               stepIndicator.classList.add('opacity-50');
            }
         }

         prevBtn.classList.toggle('hidden', step === 1);
         nextBtn.classList.toggle('hidden', step === 4);
         submitBtn.classList.toggle('hidden', step !== 4);
      }

      function validateStep(step) {
         const currentStepElement = document.getElementById(`step-${step}`);
         const inputs = currentStepElement.querySelectorAll('input[required], select[required]');
         let isValid = true;

         inputs.forEach(input => {
            if (!input.value) {
               isValid = false;
               input.classList.add('border-red-500');
            } else {
               input.classList.remove('border-red-500');
            }
         });

         // if (step === 2) {
         //     const password = document.getElementById('password');
         //     const confirmPassword = document.getElementById('confirmPassword');
         //     if (password.value !== confirmPassword.value) {
         //         isValid = false;
         //         confirmPassword.classList.add('border-red-500');
         //         alert("Passwords do not match");
         //     }
         // }

         return isValid;
      }

      nextBtn.addEventListener('click', () => {
         if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
         }
      });

      prevBtn.addEventListener('click', () => {
         currentStep--;
         showStep(currentStep);
      });

      form.addEventListener('submit', (e) => {
         e.preventDefault();
         if (validateStep(currentStep)) {
            alert('Form submitted successfully!');
            // Here you would typically send the form data to a server
         }
      });

      showStep(currentStep);
   </script> -->
   <!--stepper-script-->

   <!--phone-country-input-->
   <script>
      const phoneInputField = document.querySelector("#phone");
      const phoneInput = window.intlTelInput(phoneInputField, {
         utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });
   </script>
   <!--phone-country-input-->




   <!--Flowbite-js-->
   <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>