<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ihook greets</title>
    <link rel="icon" href="/img/ilogo.png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/flowbite.min.css" />
    <meta content="" name="description" />
    <meta content="@" name="twitter:site" />
    <meta content="@" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="" name="twitter:title" />
    <meta content="" name="twitter:description" />
    <meta content="" name="twitter:image" />
    <meta content="#" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="" property="og:site_name" />
    <meta content="" property="og:title" />
    <meta content="" property="og:description" />
    <meta content="follow, index" name="robots" />
    <link href="#" rel="canonical" />
    <!--Include prism-js-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
    <!-- Include custom-style -->
    <link href="css/custom.css" rel="stylesheet" />
    <!--Include apex-charts-->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.2/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <style>
        .scr {
            overflow-y: scroll;
        }
    </style>


    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100">


    <div class="min-h-screen flex flex-col justify-center">
        <!-- Content area -->
        <main class="">
            <div class="mx-auto px-4 sm:px-6 lg:px-8 py-6 ">

                <!-- card -->
                <div
                    class="bg-white rounded-lg shadow p-6 max-w-6xl mx-auto lg:h-full md:h-full sm:h-full flex flex-col justify-between">


                    <div class="reg-header">
                        <!--brand-logo-->
                        <div class="brand-logo">
                            <img src="/img/logo.png" alt="logo" class="mb-10 w-32 mx-auto">
                        </div>
                        <!--brand-logo-->

                    </div>


                    <div class="reg-middle">


                        <div class="lg p-6 sm:p-8">
                            <div class="text-center">
                                <!-- Icon -->
                                <div
                                    class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <!-- Title -->
                                <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">Thank You!</h1>
                                <!-- Message -->
                                <p class="mt-4 text-gray-600 sm:text-lg">
                                    We appreciate your effort! Your submission has been received successfully.
                                </p>
                                <!-- Button -->
                                <a href="{{ route('user.login') }}"
                                    class="mt-6 px-10 inline-block bg-gray-900 text-white px-6 py-3 rounded-full hover:bg-gray-700 transition">
                                   Login
                                </a>
                            </div>
                        </div>


                    </div>





                </div>

                <!-- card -->
            </div>
        </main>

    </div>


</body>

</html>