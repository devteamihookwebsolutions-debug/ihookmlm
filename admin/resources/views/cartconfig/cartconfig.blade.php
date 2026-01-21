@extends('admin::components.common.main')
@section('content')

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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Settings</a>
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
                class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Cart</a>
    </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Cart Configuration</span>
            </div>
        </li>
    </ol>
</div>

<main class="flex-grow">
    <div>

        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <div class="bg-neutral-800 rounded-lg p-6 mb-5">
                <div class="flex justify-between flex-wrap items-center gap-5">
                    <div class="banner-heading">
                        <h3 class="text-3xl text-neutral-100 mb-4 fon">{{ __('Shopping Cart') }}</h3>

                    </div>
                    <svg class="w-auto max-w-[16rem] h-40 text-black dark:text-white" aria-hidden="true" width="477" height="450" viewBox="0 0 477 450" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="225" cy="225" r="225" transform="rotate(-180 225 225)" fill="#d6e2fb"/>
                        <rect width="26.1339" height="81.6659" rx="6" transform="matrix(1 0 -0.25342 0.967356 225.321 43)" fill="#F9FAFB"/>
                        <rect width="26.1339" height="96.1383" rx="6" transform="matrix(1 0 -0.25342 0.967356 268.989 29)" fill="#F9FAFB"/>
                        <rect width="26.1339" height="116.813" rx="6" transform="matrix(1 0 -0.25342 0.967356 314.229 8.99997)" fill="#F9FAFB"/>
                        <rect width="210.762" height="167" rx="6" transform="matrix(1 0 -0.25342 0.967356 243.321 94)" fill="#c8d8fa"/>
                        <rect width="210.762" height="167" rx="6" transform="matrix(1 0 -0.25342 0.967356 243.321 94)" fill="url(#paint0_linear_275_945)"/>
                        <rect width="210.762" height="167" rx="6" transform="matrix(1 0 -0.25342 0.967356 233.321 84)" fill="#c8d8fa"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M431.772 130.994L401.762 245.548H191L201.986 203.613C221.636 192.54 243.253 181.771 250.438 182.801C256.075 183.609 259.047 185.6 261.781 187.431C265.592 189.984 268.944 192.229 278.41 190.54C285.744 189.231 299.083 178.97 313.044 168.231C330.04 155.158 347.957 141.375 357.081 142.172C364.622 142.83 367.082 146.774 369.365 150.435C372.115 154.843 374.608 158.841 385.407 156.199C393.419 154.238 400.826 148.941 408.217 143.656C415.869 138.183 423.504 132.723 431.772 130.994Z" fill="url(#paint1_linear_275_945)"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M201.678 204.786L202.292 202.443C206.983 199.807 211.776 197.195 216.451 194.761C223.837 190.916 230.954 187.503 236.918 185.145C239.9 183.966 242.618 183.042 244.95 182.461C247.264 181.884 249.288 181.623 250.83 181.844C256.669 182.681 259.786 184.772 262.529 186.611C263.059 186.967 263.575 187.313 264.095 187.639C265.692 188.643 267.322 189.465 269.509 189.876C271.697 190.288 274.503 190.298 278.469 189.59C280.302 189.263 282.645 188.294 285.437 186.762C288.213 185.24 291.353 183.208 294.752 180.83C300.221 177.005 306.285 172.34 312.505 167.556L312.507 167.554C314.027 166.385 315.556 165.209 317.088 164.036C324.863 158.084 332.707 152.222 339.661 147.939C343.14 145.797 346.432 144.027 349.407 142.837C352.374 141.65 355.108 141.007 357.422 141.209C365.372 141.903 368.004 146.132 370.289 149.804C370.522 150.179 370.752 150.547 370.983 150.906C372.238 152.854 373.511 154.468 375.583 155.353C377.635 156.229 380.598 156.438 385.391 155.265C390.131 154.105 394.694 151.717 399.255 148.792C402.103 146.966 404.875 144.983 407.679 142.977C409.411 141.738 411.156 140.49 412.938 139.265C418.997 135.1 425.283 131.357 432.032 130.002L431.512 131.989C425.452 133.311 419.691 136.722 413.865 140.727C412.182 141.884 410.476 143.104 408.756 144.333L408.755 144.334C405.895 146.379 402.997 148.451 400.105 150.305C395.427 153.305 390.566 155.874 385.423 157.133C380.332 158.379 376.89 158.225 374.374 157.151C371.879 156.086 370.422 154.163 369.145 152.181C368.908 151.813 368.675 151.441 368.443 151.07L368.442 151.068C366.16 147.418 363.872 143.758 356.741 143.136C354.9 142.975 352.568 143.48 349.785 144.593C347.012 145.702 343.872 147.383 340.467 149.48C333.653 153.676 325.917 159.453 318.134 165.411C316.617 166.573 315.097 167.742 313.583 168.907C307.359 173.694 301.226 178.412 295.698 182.279C292.259 184.685 289.023 186.783 286.118 188.376C283.229 189.96 280.584 191.091 278.352 191.49C274.188 192.233 271.118 192.243 268.646 191.778C266.172 191.313 264.355 190.382 262.678 189.329C262.121 188.979 261.579 188.617 261.033 188.252L261.033 188.252C258.308 186.429 255.482 184.538 250.045 183.759C248.889 183.593 247.196 183.777 244.993 184.326C242.808 184.87 240.207 185.751 237.287 186.905C231.448 189.214 224.426 192.578 217.078 196.403C211.993 199.051 206.764 201.912 201.678 204.786Z" fill="#F9FAFB"/>
                        <rect width="46" height="6" rx="3" transform="matrix(1 0 -0.25342 0.967356 240.787 93.6736)" fill="#F9FAFB"/>
                        <rect width="28" height="6" rx="3" transform="matrix(1 0 -0.25342 0.967356 237.746 105.282)" fill="#F9FAFB"/>
                        <rect width="46" height="6" rx="3" transform="matrix(1 0 -0.25342 0.967356 350.055 230.071)" fill="#F9FAFB"/>
                        <path d="M166.198 102.611C171.399 98.153 173.628 99.639 172.885 93.695C174.09 91.7968 175.6 87.0002 172 83.0002C168.4 79.0002 162.669 79 160.254 79.5C158.836 77.1666 154.4 72.5 148 72.5C141.6 72.5 137 79.5001 135.5 83.0002C131.167 83.6668 121.6 86.2 118 91C114.4 95.8 116.5 102.333 118 105C115.5 108.376 111 116.401 113 121.5C115 126.599 120.833 131.291 123.5 133C122.582 139.167 124.697 153 140.5 159C156.303 165 158.085 145.833 157 135.5L149.109 127.873L160.254 124.901L166.198 102.611Z" fill="#111928"/>
                        <path d="M137.763 157.878C146.085 152.529 151.632 142.275 153.366 137.817L166.74 148.962L167.483 180.168L134.791 180.911L137.763 157.878Z" fill="#FDBA8C"/>
                        <path d="M137.763 157.878C146.085 152.529 151.632 142.275 153.366 137.817L166.74 148.962L167.483 180.168L134.791 180.911L137.763 157.878Z" fill="url(#paint2_linear_275_945)"/>
                        <path d="M141.389 122.76C148.224 136.26 165.795 154.488 178.323 148.501C183.317 146.114 183.803 136.959 182.245 126.067C182.013 124.444 185.908 125.776 185.594 124.093C185.164 121.794 180.493 116.461 179.945 114.123C178.319 107.177 176.263 100.244 174.324 94.438C173.377 91.603 170.078 90.3173 167.943 92.4089C161.621 98.6012 159.833 108.494 159.419 110.787C158.918 113.555 158.545 117.203 155.904 117.583C155.17 117.688 154.091 117.049 152.901 116.045C149.452 113.133 144.039 113.263 141.708 117.128C140.67 118.849 140.481 120.967 141.389 122.76Z" fill="#FDBA8C"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M177.74 134.067C176.612 133.965 175.418 133.665 173.595 133.16C173.121 133.029 172.631 133.307 172.5 133.78C172.369 134.253 172.647 134.743 173.12 134.875C174.927 135.375 176.269 135.72 177.58 135.839C178.915 135.96 180.18 135.843 181.858 135.484C182.338 135.381 182.644 134.909 182.541 134.428C182.439 133.948 181.966 133.642 181.486 133.745C179.92 134.08 178.843 134.167 177.74 134.067Z" fill="#111928"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M146.112 123.62C145.438 122.5 145.348 121.306 145.481 120.043C145.532 119.555 145.178 119.117 144.689 119.066C144.201 119.015 143.763 119.369 143.712 119.858C143.559 121.317 143.635 122.954 144.589 124.537C145.537 126.113 147.274 127.503 150.163 128.653C150.619 128.835 151.136 128.612 151.318 128.156C151.5 127.7 151.277 127.183 150.821 127.001C148.146 125.936 146.792 124.748 146.112 123.62Z" fill="#111928"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M237.2 449.675C233.161 449.891 229.093 450 225 450C182.146 450 142.091 438.02 108 417.225V364H222L237.2 449.675Z" fill="#2563eb"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M237.2 449.675C233.161 449.891 229.093 450 225 450C182.146 450 142.091 438.02 108 417.225V364H222L237.2 449.675Z" fill="url(#paint3_linear_275_945)"/>
                        <path d="M217 379.5C213.5 385.5 200.3 398.6 175.5 403L178.5 444" stroke="#c8d8fa" stroke-width="2"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M159.203 112.021L149.711 114.346C150.853 114.672 151.951 115.243 152.901 116.045C153.578 116.616 154.219 117.069 154.781 117.334L171 118L170.5 114L169.5 109.5L159.203 112.021Z" fill="#111928"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M173.105 103.469C174.866 102.96 179.648 102 182 102L181 104.5L179.55 104.319C184.43 116.09 187.482 125.286 187 128.5C186.333 129 182 131 180 131C177.938 131 175 130 172.5 126.5C170 123 166 107.5 169.5 105C170.523 104.269 171.799 103.783 173.105 103.469Z" fill="#111928"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M173.105 103.469C174.866 102.96 179.648 102 182 102L181 104.5L179.55 104.319C184.43 116.09 187.482 125.286 187 128.5C186.333 129 182 131 180 131C177.938 131 175 130 172.5 126.5C170 123 166 107.5 169.5 105C170.523 104.269 171.799 103.783 173.105 103.469Z" fill="url(#paint4_linear_275_945)"/>
                        <path d="M174.5 104C176.635 102.474 179.877 102.016 182.182 101.958C183.3 101.93 184.277 102.648 184.685 103.689C188.739 114.04 189.373 122.353 189.123 126.28C189.073 127.066 188.65 127.773 187.975 128.18C187.15 128.677 186.046 129.238 185 129.5C183 130 180 129 177.5 125.5C175 122 171 106.5 174.5 104Z" fill="#111928"/>
                        <path d="M174.5 104C176.635 102.474 179.877 102.016 182.182 101.958C183.3 101.93 184.277 102.648 184.685 103.689C188.739 114.04 189.373 122.353 189.123 126.28C189.073 127.066 188.65 127.773 187.975 128.18C187.15 128.677 186.046 129.238 185 129.5C183 130 180 129 177.5 125.5C175 122 171 106.5 174.5 104Z" fill="url(#paint5_linear_275_945)"/>
                        <path d="M297.5 295.5C285.5 297.1 266.833 287.167 259 282L283 256.5C297.667 229 329.8 170.9 341 158.5C355 143 358.5 142 358 144C357.6 145.6 350.833 154.333 347.5 158.5C367 157.5 355 173.5 350 178C346 181.6 341.333 190.167 339.5 194C330.5 227.167 309.5 293.9 297.5 295.5Z" fill="#FDBA8C"/>
                        <path d="M297.5 295.5C285.5 297.1 266.833 287.167 259 282L283 256.5C297.667 229 329.8 170.9 341 158.5C355 143 358.5 142 358 144C357.6 145.6 350.833 154.333 347.5 158.5C367 157.5 355 173.5 350 178C346 181.6 341.333 190.167 339.5 194C330.5 227.167 309.5 293.9 297.5 295.5Z" fill="url(#paint6_linear_275_945)"/>
                        <path d="M258.048 301.339L226.5 274.5V366H98.5C99.1667 341.167 100.9 282 102.5 244C104.1 206 121.167 183.167 129.5 176.5C141.5 179.3 159.167 177.667 166.5 176.5C174.333 177.667 193.4 181.2 207 186C220.6 190.8 263.333 235 283 256.5L261.136 300.703C260.559 301.869 259.039 302.183 258.048 301.339Z" fill="#F9FAFB"/>
                        <path d="M258.048 301.339L226.5 274.5V366H98.5C99.1667 341.167 100.9 282 102.5 244C104.1 206 121.167 183.167 129.5 176.5C141.5 179.3 159.167 177.667 166.5 176.5C174.333 177.667 193.4 181.2 207 186C220.6 190.8 263.333 235 283 256.5L261.136 300.703C260.559 301.869 259.039 302.183 258.048 301.339Z" fill="url(#paint7_linear_275_945)" fill-opacity="0.7"/>
                        <path d="M151 181.5C139.8 181.1 130.333 179.667 127 178.5L130.5 175C132 175.333 137.6 176.2 148 177C158.4 177.8 166.333 176 169 175L172.5 177.5C170 179.333 162.2 181.9 151 181.5Z" fill="#c8d8fa"/>
                        <path d="M159.5 366L175.5 228L226.5 274.718V366H159.5Z" fill="url(#paint8_linear_275_945)" fill-opacity="0.7"/>
                        <path d="M100 355H224.5" stroke="#c8d8fa" stroke-width="2"/>
                        <defs>
                        <linearGradient id="paint0_linear_275_945" x1="30.4496" y1="131.286" x2="264.711" y2="-30.8192" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2563eb"/>
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint1_linear_275_945" x1="351.697" y1="12.8992" x2="351.697" y2="267.314" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F9FAFB"/>
                        <stop offset="1" stop-color="#F9FAFB" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint2_linear_275_945" x1="177.885" y1="125.929" x2="154.852" y2="169.766" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#7F270F"/>
                        <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint3_linear_275_945" x1="172.6" y1="297.5" x2="172.6" y2="450" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#111928"/>
                        <stop offset="1" stop-color="#111928" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint4_linear_275_945" x1="186" y1="136" x2="179.311" y2="120.367" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2563eb"/>
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint5_linear_275_945" x1="179.5" y1="92.5" x2="182" y2="122" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2563eb"/>
                        <stop offset="1" stop-color="#2563eb" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint6_linear_275_945" x1="176.5" y1="321.5" x2="310.349" y2="255.409" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#7F270F"/>
                        <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint7_linear_275_945" x1="144.5" y1="416.5" x2="114.813" y2="282.581" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#c8d8fa"/>
                        <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                        </linearGradient>
                        <linearGradient id="paint8_linear_275_945" x1="242" y1="275" x2="195.5" y2="286" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#c8d8fa"/>
                        <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                        </linearGradient>
                        </defs>
                        </svg>
                </div>

            </div>



            <!-- card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <!--alert-box-->

                <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 dark:border-blue-800"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                        </path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">{{ __('Instruction') }}</span><br>1 :
                        {{ __('Once cart is set we cant modify') }}

                    </div>
                </div>
                <div class="max-w-7xl mx-auto mt-8">
                    <!-- Stepper Header -->
                    <div class="flex items-center justify-center flex-wrap space-x-4 mb-8">
                        <!-- Step 1 -->
                        <div id="step-header-1" class="flex items-center">
                            <div
                                class="lg:w-8 lg:h-8 w-6 h-6 flex justify-center items-center rounded-full font-bold">
                                1
                            </div>
                            <span
                                class="ml-2 text-gray-600 lg:text-lg text-xs dark:text-gray-300">{{ __('Cart Selection') }}</span>
                        </div>

                        <!-- Slash for mobile and tablet -->
                        <span class="block lg:hidden mx-2 text-black">/</span>

                        <!-- Line for desktop -->
                        <div class="hidden lg:block h-px w-8 bg-neutral-300"></div>

                        <!-- Step 2 -->
                        <div id="step-header-2" class="flex items-center">
                            <div
                                class="lg:w-8 lg:h-8 w-6 h-6 flex justify-center items-center rounded-full font-bold">
                                2
                            </div>
                            <span
                                class="ml-2 text-gray-600 lg:text-lg text-xs dark:text-gray-300">{{ __('Cart Settings') }}</span>
                        </div>

                        <!-- Slash for mobile and tablet -->
                        <span class="block lg:hidden mx-2 text-black">/</span>

                        <!-- Line for desktop -->
                        <div class="hidden lg:block h-px w-8 bg-neutral-300"></div>

                        <!-- Step 3 -->
                        <div id="step-header-3" class="flex items-center">
                            <div
                                class="lg:w-8 lg:h-8 w-6 h-6 flex justify-center items-center rounded-full font-bold ">
                                3
                            </div>
                            <span
                                class="ml-2 text-gray-600 lg:text-lg text-xs dark:text-gray-300">{{ __('API Access') }}</span>
                        </div>

                        <!-- Slash for mobile and tablet -->
                        <span class="block lg:hidden mx-2 text-black">/</span>

                        <!-- Line for desktop -->
                        <div class="hidden lg:block h-px w-8 bg-neutral-300"></div>

                        <!-- Step 4 -->
                        <div id="step-header-4" class="flex items-center">
                            <div
                                class="lg:w-8 lg:h-8 w-6 h-6 flex justify-center items-center rounded-full font-bold ">
                                4
                            </div>
                            <span
                                class="ml-2 text-gray-600 lg:text-lg text-xs dark:text-gray-300">{{ __('Modules') }}</span>
                        </div>

                        <!-- Slash for mobile and tablet -->
                        <span class="block lg:hidden mx-2 text-black">/</span>

                        <!-- Line for desktop -->
                        <div class="hidden lg:block h-px w-8 bg-neutral-300"></div>

                        <!-- Step 5 -->
                        <div id="step-header-5" class="flex items-center">
                            <div
                                class="lg:w-8 lg:h-8 w-6 h-6 flex justify-center items-center rounded-full font-bold ">
                                5
                            </div>
                            <span
                                class="ml-2 text-gray-600 lg:text-lg text-xs dark:text-gray-300">{{ __('Complete') }}</span>
                        </div>
                    </div>

                    <!-- Stepper Content -->
                    <div id="wholecartdata">
                        <!-- Step 1 Content -->
                        <div id="step1-content" class="step-content flex align-center justify-center">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 p-6 mt-2 lg:mt-20">
                                <!-- WooCommerce -->
                                <div id="cart_id1"
                                    class="relative group border border-neutral-200 rounded-xl shadow-lg hover:shadow-xl overflow-hidden transition-shadow duration-300 h-32">
                                    <div class="flex justify-center items-center p-10">
                                        <img src="/assets/img/cartconfig/woocommerce_logo.png"
                                            alt="WooCommerce Logo" class="w-full h-9 object-contain  ">
                                    </div>

                                    <figcaption
                                        class="absolute inset-0 bg-neutral-900 bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"

                                            onclick="setcartconfig(1);">
                                            {{ __('Select') }}
                                        </button>
                                    </figcaption>
                                </div>


                                <!-- Shopify -->
                                <div id="cart_id2"
                                    class="relative group border border-neutral-200 rounded-xl shadow-lg hover:shadow-xl overflow-hidden transition-shadow duration-300 h-32">
                                    <div class="flex justify-center items-center p-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608 173.7"
                                            role="img" height="40">
                                            <title> {{ __('Shopify') }}</title>
                                            <path fill="#95BF47"
                                                d="M130.7 32.9c-.1-.9-.9-1.3-1.5-1.4-.6-.1-12.6-.2-12.6-.2s-10.1-9.8-11.1-10.8-2.9-.7-3.7-.5c0 0-1.9.6-5.1 1.6-.5-1.7-1.3-3.8-2.4-5.9-3.6-6.9-8.8-10.5-15.2-10.5-.4 0-.9 0-1.3.1-.2-.2-.4-.4-.6-.7-2.8-3-6.3-4.4-10.5-4.3-8.2.2-16.3 6.1-23 16.7-4.7 7.4-8.2 16.7-9.2 23.9-9.4 2.9-16 4.9-16.1 5-4.7 1.5-4.9 1.6-5.5 6.1C12.4 55.3 0 151.4 0 151.4l104.1 18 45.1-11.2S130.8 33.7 130.7 32.9zm-39.2-9.7c-2.4.7-5.1 1.6-8.1 2.5-.1-4.1-.6-9.9-2.5-14.9 6.3 1.2 9.3 8.2 10.6 12.4zM78 27.4c-5.5 1.7-11.4 3.5-17.4 5.4 1.7-6.4 4.9-12.8 8.8-17 1.5-1.6 3.5-3.3 5.9-4.3 2.3 4.7 2.7 11.4 2.7 15.9zM66.8 5.8c1.9 0 3.5.4 4.9 1.3-2.2 1.1-4.4 2.8-6.4 5-5.2 5.6-9.2 14.2-10.8 22.6-5 1.5-9.8 3-14.3 4.4 3-13.2 14-32.9 26.6-33.3z">
                                            </path>
                                            <path fill="#5E8E3E"
                                                d="M129.2 31.5c-.6-.1-12.6-.2-12.6-.2s-10.1-9.8-11.1-10.8c-.4-.4-.9-.6-1.4-.6v149.5l45.1-11.2S130.8 33.8 130.7 32.9c-.2-.9-.9-1.3-1.5-1.4z">
                                            </path>
                                            <path fill="#FFF"
                                                d="M79.1 54.7l-5.2 19.6s-5.8-2.7-12.8-2.2c-10.2.6-10.3 7-10.2 8.7.6 8.8 23.6 10.7 24.9 31.2 1 16.2-8.6 27.2-22.4 28.1-16.6 1-25.7-8.7-25.7-8.7l3.5-14.9s9.2 6.9 16.5 6.5c4.8-.3 6.5-4.2 6.3-7-.7-11.4-19.5-10.8-20.7-29.5-1-15.8 9.4-31.8 32.3-33.3 9-.8 13.5 1.5 13.5 1.5z">
                                            </path>
                                            <path fill="#000"
                                                d="M210.3 96.5c-5.2-2.8-7.9-5.2-7.9-8.5 0-4.2 3.7-6.9 9.6-6.9 6.8 0 12.8 2.8 12.8 2.8l4.8-14.6s-4.4-3.4-17.3-3.4c-18 0-30.5 10.3-30.5 24.8 0 8.2 5.8 14.5 13.6 19 6.3 3.6 8.5 6.1 8.5 9.9 0 3.9-3.1 7-9 7-8.7 0-16.9-4.5-16.9-4.5l-5.1 14.6s7.6 5.1 20.3 5.1c18.5 0 31.8-9.1 31.8-25.5.1-8.9-6.6-15.2-14.7-19.8zm73.8-30.8c-9.1 0-16.3 4.3-21.8 10.9l-.3-.1 7.9-41.4h-20.6l-20 105.3h20.6l6.9-36c2.7-13.6 9.7-22 16.3-22 4.6 0 6.4 3.1 6.4 7.6 0 2.8-.3 6.3-.9 9.1l-7.8 41.2h20.6l8.1-42.6c.9-4.5 1.5-9.9 1.5-13.4 0-11.5-6.2-18.6-16.9-18.6zm63.5 0c-24.8 0-41.2 22.4-41.2 47.4 0 16 9.9 28.8 28.4 28.8 24.3 0 40.8-21.8 40.8-47.4-.1-14.7-8.8-28.8-28-28.8zm-10.2 60.4c-7 0-10-6-10-13.4 0-11.8 6.1-31.1 17.3-31.1 7.3 0 9.7 6.3 9.7 12.4 0 12.7-6.1 32.1-17 32.1zm90.8-60.4c-13.9 0-21.8 12.2-21.8 12.2h-.3l1.2-11.1h-18.2c-.9 7.5-2.5 18.8-4.2 27.3l-14.3 75.4h20.6l5.7-30.5h.4s4.2 2.7 12.1 2.7c24.2 0 40-24.8 40-49.9.1-13.7-6.1-26.1-21.2-26.1zm-19.7 60.7c-5.4 0-8.5-3-8.5-3l3.4-19.3c2.4-12.8 9.1-21.4 16.3-21.4 6.3 0 8.2 5.8 8.2 11.4 0 13.3-7.9 32.3-19.4 32.3zm70.4-90.2c-6.6 0-11.8 5.2-11.8 12 0 6.1 3.9 10.3 9.7 10.3h.3c6.4 0 12-4.3 12.1-12 0-6-4-10.3-10.3-10.3zm-28.8 104.2h20.6l14-73h-20.8zm87-73.2h-14.3l.7-3.4c1.2-7 5.4-13.3 12.2-13.3 3.7 0 6.6 1 6.6 1l4-16.1s-3.6-1.8-11.2-1.8c-7.3 0-14.6 2.1-20.2 6.9-7 6-10.3 14.6-12 23.3l-.6 3.4h-9.6l-3 15.5h9.6l-10.9 57.7H509l10.9-57.7h14.2l3-15.5zm49.6.2s-12.9 32.5-18.7 50.2h-.3c-.4-5.7-5.1-50.2-5.1-50.2H541l12.4 67.1c.3 1.5.1 2.4-.4 3.4-2.4 4.6-6.4 9.1-11.2 12.4-3.9 2.8-8.2 4.6-11.7 5.8l5.7 17.5c4.2-.9 12.8-4.3 20.2-11.2 9.4-8.8 18.1-22.4 27-40.9l25.2-54.1h-21.5z">
                                            </path>
                                        </svg>
                                    </div>

                                    <figcaption
                                        class="absolute inset-0 bg-neutral-900 bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"

                                            onclick="setcartconfig(2);">
                                            {{ __('Select') }}
                                        </button>
                                    </figcaption>
                                </div>

                                <!-- CS-Cart -->
                                <div id="cart_id3"
                                    class="relative group border border-neutral-200 rounded-xl shadow-lg hover:shadow-xl overflow-hidden transition-shadow duration-300 h-32">
                                    <div class="flex justify-center items-center p-10">
                                        <img src="data:image/jpeg;base64,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"
                                            alt="CS-Cart Logo" class="w-full h-9 object-contain ">
                                    </div>
                                    <figcaption
                                        class="absolute inset-0 bg-neutral-900 bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"

                                            onclick="setcartconfig(3);">
                                            {{ __('Select') }}
                                        </button>
                                    </figcaption>
                                </div>
                            </div>
                        </div>
                        <span id="selectedCartError"
                            class="align-center justify-center text-sm text-red-600 dark:text-red-500 hidden"></span>


                        <!-- Step 2: Cart Configuration -->
                        <div id="step2-content" class="hidden step-content mt-2 lg:mt-20">
                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                                <!-- Cart Configuration Forms -->
                                <div id="woocommerce-form" class="hidden cart-settings-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('WooCommerce Cart Configuration') }}
                                    </h3>
                                    <form class="mx-auto validated-form mb-5" method="POST" id="woocommerce_sec1"
                                        novalidate>
                                        <div class="grid grid-cols-3 gap-5">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="shop-name"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Host') }}</label>
                                                <input type="text" name="hostname" id="hostname"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['hostname'] ?? '' }}" autocomplete="off"
                                                    aria-describedby="hostname-error">
                                                <span id="hostname-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <input type="hidden" name="cart_id" id="cart_id"
                                                value="{{ $cartconfigs['woousername'] ?? '' }}">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Username') }}</label>
                                                <input type="text" name="woousername" id="woousername"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                 value="{{ $cartconfigs['woousername'] ?? '' }}" autocomplete="off"
                                                    aria-describedby="woousername-error">
                                                <span id="woousername-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-secret-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Password') }}</label>
                                                <input type="text" name="woopassword" id="woopassword"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['woopassword'] ?? ''}}" autocomplete="off"
                                                    aria-describedby="woopassword-error">
                                                <span id="woopassword-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('DB Name') }}</label>
                                                <input type="text" name="woodbname" id="woodbname"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['woodbname'] ?? ''}}" autocomplete="off"
                                                    aria-describedby="woodbname-error">
                                                <span id="woodbname-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Prefix') }}</label>
                                                <input type="text" name="wooprefix" id="wooprefix"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['wooprefix'] ?? ''}}" autocomplete="off"
                                                    aria-describedby="wooprefix-error">
                                                <span id="wooprefix-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="shopify-form" class="hidden cart-settings-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('Shopify Cart Configuration') }}
                                    </h3>
                                    <form class="mx-auto validated-form mb-5" method="POST" id="shopify_sec1"
                                        novalidate>
                                        <div class="grid grid-cols-3 gap-5">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="shop-name"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Shop Name') }}</label>
                                                <input type="text" name="shop_name" id="shop_name"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['shop_name'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="shop_name-error">
                                                <span id="shop_name-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Key') }}</label>
                                                <input type="text" name="api_key" id="api_key"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['api_key'] ?? '' }}" autocomplete="off" required
                                                    aria-describedby="api_key-error">
                                                <span id="api_key-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-secret-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Secret Key') }}</label>
                                                <input type="text" name="api_secret_key" id="api_secret_key"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['api_secret_key'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="api_secret_key-error">
                                                <span id="api_secret_key-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-secret-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Access Token') }}</label>
                                                <input type="text" name="access_token" id="access_token"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['access_token'] ?? '' }}" autocomplete="off"
                                                    required aria-describedby="access_token-error">
                                                <span id="access_token-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="flex justify-end">
                                        <div class="form-submit">
                                            <button type="button" id="testsyconnection"
                                                class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Test Connection') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="cscart-form" class="hidden cart-settings-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('CS-Cart Cart Configuration') }}
                                    </h3>
                                    <form class="mx-auto validated-form mb-5" method="POST" id="cscart_sec"
                                        novalidate>
                                        <div class="grid grid-cols-3 gap-5">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="shop-name"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Host') }}</label>
                                                <input type="text" name="cshostname" id="cshostname"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['cshostname'] ?? '' }}" autocomplete="off"
                                                    required aria-describedby="cshostname-error">
                                                <span id="cshostname-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Username') }}</label>
                                                <input type="text" name="csusername" id="csusername"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['csusername'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="csusername-error">
                                                <span id="csusername-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-secret-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Password') }}</label>
                                                <input type="text" name="cspassword" id="cspassword"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['cspassword'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="cspassword-error">
                                                <span id="cspassword-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('DB Name') }}</label>
                                                <input type="text" name="csdbname" id="csdbname"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['csdbname'] ?? '' }}" autocomplete="off"
                                                    required aria-describedby="csdbname-error">
                                                <span id="csdbname-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="api-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Prefix') }}</label>
                                                <input type="text" name="csprefix" id="csprefix"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['csprefix'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="csprefix-error">
                                                <span id="csprefix-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--Right-Image-->
                                <div class="flex flex-col justify-center">
                                    <!--image-space-->
                                    <img src="/assets/img/cartconfig/19.png" alt="img"
                                        class="w-full">
                                    <!--image-space-->
                                </div>
                            </div>
                        </div>


                        <!-- Step 3: API Access -->
                        <div id="step3-content" class="hidden step-content mt-2 lg:mt-20">
                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                                <!-- API Access Forms -->
                                <div id="woocommerce-api-form" class="hidden api-access-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('WooCommerce API Access') }}
                                    </h3>
                                    <form class="mx-auto validated-form mb-5" method="POST" id="woocommerce_sec2"
                                        novalidate>
                                        <div class="grid grid-cols-3 gap-5">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="woocommerce-path"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Woocommerce Path') }}</label>
                                                <input type="text" name="woocommerce_path" id="woocommerce_path"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['woocommerce_path'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="woocommerce_path-error">
                                                <span id="woocommerce_path-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="woocommerce-secret"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Woocommerce Secret') }}</label>
                                                <input type="text" name="woocommerce_secret"
                                                    id="woocommerce_secret"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['woocommerce_secret'] ?? '' }}"
                                                    autocomplete="off" required
                                                    aria-describedby="woocommerce_secret-error">
                                                <span id="woocommerce_secret-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="woocommerce-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Woocommerce Key') }}</label>
                                                <input type="text" name="woocommerce_key" id="woocommerce_key"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['woocommerce_key'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="woocommerce_key-error">
                                                <span id="woocommerce_key-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="flex justify-end">
                                        <div class="form-submit">
                                            <button type="button" id="testwooconnection"
                                                class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Test Connection') }}</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="shopify-api-form" class="hidden api-access-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('Shopify API Access') }}
                                    </h3>
                                    <div class="helptext text-center mt-3 p-5 ">
                                        <p class="mt-4 text-black sm:text-lg">
                                            {{ __('Once you configure, you will be redirected to the Shopify installation page. Now click') }}
                                            <span class="text-blue-600 font-bold">"{{ __('Next') }}"</span>.
                                        </p>
                                    </div>

                                </div>
                                <div id="cscart-api-form" class="hidden api-access-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('CS-Cart API Access') }}
                                    </h3>
                                    <form class="mx-auto validated-form mb-5" method="POST" id="cscart_sec1"
                                        novalidate>
                                        <div class="grid grid-cols-3 gap-5">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="woocommerce-path"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('CS-cart Path') }}</label>
                                                <input type="text" name="cscart_path" id="cscart_path"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['cscart_path'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="cscart_path-error">
                                                <span id="cscart_path-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="woocommerce-secret"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('CS-cart Admin Mail-ID') }}</label>
                                                <input type="text" name="cscart_mail" id="cscart_mail"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['cscart_mail'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="cscart_mail-error">
                                                <span id="cscart_mail-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="woocommerce-key"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Secret Key') }}</label>
                                                <input type="text" name="cscart_api" id="cscart_api"
                                                    class="shadow-sm bg-neutral-50 text-black dark:text-white sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $cartconfigs['cscart_api'] ?? ''}}" autocomplete="off"
                                                    required aria-describedby="cscart_api-error">
                                                <span id="cscart_api-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--Right-Image-->
                                <div class="flex flex-col justify-center">
                                    <!--image-space-->
                                    <img src="/assets/img/cartconfig/cart_setting.svg"
                                        alt="enroll" class="w-full">
                                    <!--image-space-->
                                </div>
                            </div>
                        </div>
                        <!-- Step 4: Modules -->
                        <div id="step4-content" class="hidden step-content mt-2 lg:mt-20">
                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                                <!-- API Access Forms -->
                                <div id="woocommerce-modules-form" class="hidden modules-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('WooCommerce Modules') }}
                                    </h3>
                                    <form class="mx-auto validated-form" method="POST" id="options_modules-1"
                                        novalidate>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-2xl ">
                                                <tbody>
                                                    <tr class="">
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Products') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="wordpress_product_check" name="wordpress_product_check"
                                                                    value="1"
                                                                    @if (($cartconfigs['product_check'] ?? '') == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Orders') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="wordpress_orders_check" name="wordpress_orders_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['orders_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Autoship') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="wordpress_autoship_check" name="wordpress_autoship_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['autoship_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Discount') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="wordpress_discount_check" name="wordpress_discount_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['discount_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Product Level Commission') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="wordpress_product_level_check"
                                                                    name="wordpress_product_level_check" value="1"
                                                                    @if ($cartconfigs['product_level_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>

                                <div id="shopify-modules-form" class="hidden modules-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('Shopify Modules') }}
                                    </h3>
                                    <form class="mx-auto validated-form" method="POST" id="options_modules-2"
                                        novalidate>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-2xl ">
                                                <tbody>
                                                    <tr class="">
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Products') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="shopify_product_check" name="shopify_product_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['product_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Orders') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="shopify_orders_check" name="shopify_orders_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['orders_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Autoship') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="shopify_autoship_check" name="shopify_autoship_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['autoship_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Discount') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="shopify_discount_check" name="shopify_discount_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['discount_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Product Level Commission') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="shopify_product_level_check"
                                                                    name="shopify_product_level_check" value="1"
                                                                    @if ($cartconfigs['product_level_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div id="cscart-modules-form" class="hidden modules-form">
                                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                        {{ __('CS-Cart Modules') }}
                                    </h3>
                                    <form class="mx-auto validated-form" method="POST" id="options_modules-3"
                                        novalidate>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-2xl ">
                                                <tbody>
                                                    <tr class="">
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Products') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="cart_product_check" name="cart_product_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['product_check'] ?? '' == '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Orders') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="cart_orders_check" name="cart_orders_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['orders_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Autoship') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="cart_autoship_check" name="cart_autoship_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['autoship_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Discount') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="cart_discount_check" name="cart_discount_check"
                                                                    value="1"
                                                                    @if ($cartconfigs['discount_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 text-black dark:text-white text-sm font-medium dark:text-neutral-200">
                                                            {{ __('Product Level Commission') }}</td>
                                                        <td class="px-6 py-4 text-right">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input class="sr-only peer" type="checkbox"
                                                                    id="cart_product_level_check"
                                                                    name="cart_product_level_check" value="1"
                                                                    @if ($cartconfigs['product_level_check'] ?? ''== '1') checked @endif>
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <!-- <div class="flex justify-end">
                                                <div class="form-submit">
                                                    <button type="button" onclick="testConnection()"
                                                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Test
                                                        Connection</button>
                                                </div>
                                            </div> -->
                                </div>
                                <!--Right-Image-->
                                <div class="flex flex-col justify-center">
                                    <!--image-space-->
                                    <img src="/assets/img/cartconfig/config-plan.svg"
                                        alt="enroll" class="w-full">
                                    <!--image-space-->
                                </div>
                            </div>
                        </div>

                        <!-- Step 5 HTML Structure -->
                        <div id="step5-content" class="hidden step-content mt-2 lg:mt-20">
                            <div class="text-center">
                                <!-- Icon -->
                                <div
                                    class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div id="step5-success-message" class="flex justify-center items-center h-full">
                                    <!-- Success message will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8">
                        <button id="prevBtn" class="px-4 py-2 bg-neutral-300 text-black rounded disabled:opacity-50"
                            onclick="changeStep(-1)" disabled>
                            {{ __('Back') }}
                        </button>
                        <button id="nextBtn" class="px-4 py-2 bg-black text-white rounded dark:bg-neutral-900"
                            onclick="changeStep(1)">
                            {{ __('Next') }}
                        </button>

                        <button id="submitBtn" class="px-4 py-2 bg-black text-white rounded hidden dark:bg-neutral-900">
                            {{ __('Submit') }}
                        </button>
                    </div>




                    <!-- card -->

                </div>
                <!--Row-1-->

            </div>
</main>

<!-- custom scripts start-->
@include('cartconfig.cartscript')
<!-- custom scripts end-->
 @endsection


