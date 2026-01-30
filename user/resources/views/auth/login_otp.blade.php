<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ihook-User Forgot Password</title>
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

            <div class="flex justify-center">
                <img src="../img/logo.png" class="w-30" />
            </div>

            <h3 class="text-lg font-semibold mb-6 text-center">
                Verify OTP
            </h3>

            <form method="POST" action="{{ route('user.verify.login.otp') }}" 
                class="grid grid-cols-1 gap-6" id="otpForm">
                @csrf

                {{-- Messages --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Hidden Email --}}
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- OTP Input --}}
                <input type="text" id="otpInput" name="otp" placeholder="Enter 6-digit OTP" maxlength="6" class="border p-2 rounded text-center tracking-widest" required>


                {{-- Verify Button --}}
                <div class="flex justify-center mt-4">
                    <button type="submit" id="verifyBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                        Verify OTP
                    </button>
                </div>

                <div id="messageBox" class="text-center mt-2 hidden p-2 rounded"></div>
                
            </form>

        </div>
    </div>




</body>