

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ihook-Admin Dashboard</title>
    <link rel="icon" href="../img/ilogo.png" />
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script> -->
  
     <link rel="stylesheet" href="{{ asset('css/tailwind.mins.css') }}">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" /> -->
  
     <link rel="stylesheet" href="{{ asset('css/flowbite.mins.css') }}">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
      -->
       <script src="{{ asset('js/flowbite.min.js') }}" ></script>
</head>

<body style="background-image: url('../img/login-bnr.jpg');background-size: cover;">

    <div class="mt-20"></div>

    <div class="max-w-sm mx-auto bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">

    
        <!-- Main content -->
        <div class="w-full md:w-3/4 p-6 md:p-10">

            <!-- Login Information Form -->
             <div class="flex justify-center">
                 <img src="../img/logo.png" class="w-30" /> 
                
             </div>
            <h3 class="text-lg font-semibold mb-6 text-center">Login Information</h3>
            <!-- <form class="grid grid-cols-1 gap-6"> -->

             <form  class="grid grid-cols-1 gap-6" method="POST" action="{{ route('admin.login.post') }}">
                @csrf
   
                @if (session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
                        Email <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"  name="admin_email" id="email" value="{{ old('admin_email') }}" placeholder="Enter Email"
                        class="w-full border text-sm rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500
                            @error('admin_email') is-invalid @enderror" >

                        @error('admin_email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                </div>


   <div class="relative">
    <label class="block mb-2 text-sm font-medium">
        Password <span class="text-red-500">*</span>
    </label>
    <input type="password" name="admin_password" id="admin_password"
        class="w-full border text-sm rounded-lg p-2.5 pr-10 focus:ring-blue-500 focus:border-blue-500 @error('admin_password') is-invalid @enderror"
        placeholder="Enter password">
    
    <!-- Toggle button for eye icon -->
    <button type="button" id="togglePassword" class="absolute right-2 top-9 text-gray-600 hover:text-gray-800">
        <!-- Initially eye-off icon -->
        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <!-- Eye off -->
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.05 10.05 0 011.187-2.56m3.105-3.105A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.272 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3l18 18" />
        </svg>
    </button>

    @error('admin_password')
    <p class="mt-2 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>


                     
                    <div class="flex justify-end ">
                        <a href=""
                                class="block text-sm font-medium text-blue-900 dark:text-white">
                                Forgot Password?</a>
                    </div>
                  
     

                <!-- Action buttons -->
                <!-- <div class="flex justify-between mt-4">
                    <a href="/contact"><button type="button"
                            class="px-6 py-2 bg-gray-700 text-white rounded-lg">Back</button></a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Next</button>
                  
                </div> -->

                  <div class="flex justify-center mt-4">
                    
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Submit</button>

                </div>

            </form>
        </div>
    </div>

</body>

</html>


<script>
 
 
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('admin_password');
    const eyeIcon = document.getElementById('eyeIcon');

    let isPasswordVisible = false;

    togglePassword.addEventListener('click', () => {
        isPasswordVisible = !isPasswordVisible;
        passwordInput.type = isPasswordVisible ? 'text' : 'password';

        if (isPasswordVisible) {
            // Eye open
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        } else {
            // Eye off
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.05 10.05 0 011.187-2.56m3.105-3.105A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.272 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3l18 18" />
            `;
        }
    });
</script>




