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

            <form method="POST" action="{{ route('user.forgot.password.verify') }}"
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

                <!-- {{-- Timer --}}
                <div class="text-center text-sm text-gray-600">
                    OTP expires in
                    <span id="timer" class="font-semibold text-red-600">01:00</span>
                </div> -->

                {{-- Verify Button --}}
                <div class="flex justify-center mt-4">
                    <button type="submit"
                            id="verifyBtn"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                        Verify OTP
                    </button>
                </div>

                <div id="messageBox" class="text-center mt-2 hidden p-2 rounded"></div>

                {{-- Resend OTP --}}
                <div class="flex justify-center mt-2 hidden" id="resendBox">
                    <button type="button"
                            id="resendBtn"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg">
                        Resend OTP
                    </button>
                </div>

            </form>

        </div>
    </div>




</body>
<script>
// document.addEventListener("DOMContentLoaded", function() {
//     const otpInput = document.getElementById("otpInput");
//     const verifyBtn = document.getElementById("verifyBtn");
//     const timerEl = document.getElementById("timer");
//     const resendBox = document.getElementById("resendBox");

//     let duration = 60; // 60 seconds
//     let timeRemaining = duration;

//     const interval = setInterval(() => {
//         let minutes = Math.floor(timeRemaining / 60);
//         let seconds = timeRemaining % 60;

//         // Format timer as 01:00, 00:59...
//         timerEl.textContent = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;

//         if(timeRemaining <= 0){
//             clearInterval(interval);
//             timerEl.textContent = "Expired";
//             otpInput.disabled = true;
//             verifyBtn.disabled = true;
//             verifyBtn.classList.add('opacity-50', 'cursor-not-allowed');
//             resendBox.classList.remove("hidden"); // show resend button
//         }

//         timeRemaining--;
//     }, 1000);

//     // Resend OTP button (optional)
//     document.getElementById("resendBtn")?.addEventListener("click", function() {
//         const btn = this;
//         btn.disabled = true;
//         btn.innerText = "Sending...";

//         fetch("{{ route('admin.otp.resend') }}", {
//             method: "POST",
//             headers: {
//                 "X-CSRF-TOKEN": "{{ csrf_token() }}",
//                 "Content-Type": "application/json"
//             },
//             body: JSON.stringify({ email: "{{ $email }}" })
//         })
//         .then(res => res.json())
//         .then(data => {
//             btn.disabled = false;
//             btn.innerText = "Resend OTP";

//             // Reset timer
//             timeRemaining = 60;
//             otpInput.disabled = false;
//             verifyBtn.disabled = false;
//             verifyBtn.classList.remove('opacity-50','cursor-not-allowed');
//             resendBox.classList.add("hidden");
//         });
//     });
// });
</script>
