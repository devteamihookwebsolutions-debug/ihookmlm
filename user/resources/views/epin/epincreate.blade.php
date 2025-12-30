@extends('user::components.common.main')
@section('content')

<!-- Breadcrumb same as before -->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto ">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __('Generate E-Pin') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-2 h-2 text-neutral-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Generate E-Pin') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<main class="flex-grow">
    @include('admin::components.common.info_message')

    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-5">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                    <!-- Form -->
                    <div class="customer-form">
                        <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">{{ __('Generate E-Pin') }}</h3>
                        <form name="epinrequest" id="epinrequest" method="POST" action="/user/epinrequest/validatecreate" class="mb-5">
                            @csrf

                            <!-- Wallet Type Toggle -->
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Type') }}</label>
                                <div class="flex items-center space-x-3">
                                    <span class="text-black font-medium dark:text-white">{{ __('Cash Wallet') }}</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" name="wallet_type" id="wallet_type" onchange="updateWalletBalance()">
                                        <div class="w-12 h-6 bg-gray-700 rounded-full peer peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6"></div>
                                    </label>
                                    <span id="toggleText" class="text-black font-medium dark:text-white">{{ __('E-Wallet') }}</span>
                                </div>
                            </div>

                            <!-- Hidden formatted balances (with symbol) -->
                            <input type="hidden" id="formatted_cwallet" value="{{ \Admin\App\Helpers\CurrencyHelper::format($cwallet_balance) }}">
                            <input type="hidden" id="formatted_ewallet" value="{{ \Admin\App\Helpers\CurrencyHelper::format($ewallet_balance) }}">

                            <!-- Balance Display - NO BOLD -->
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-white">
                                    {{ __('Your Current Balance') }}
                                    <span id="wallet_label" class="text-xs text-gray-500">(Cash Wallet)</span>
                                </label>

                                <input
                                    id="balance"
                                    class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-800 dark:border-neutral-600"
                                    value="{{ \Admin\App\Helpers\CurrencyHelper::format($cwallet_balance) }}"
                                    disabled
                                >
                            </div>
                            <!-- Epin Type -->
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Epin type') }}</label>
                                <div class="input-group">{!! $epintype !!}</div>
                            </div>

                            <!-- Amount -->
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Amount') }}</label>
                               <input type="text" name="epin_amount" id="epin_amount"
                                    class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5"
                                    readonly>
                            </div>

                            <!-- Count -->
                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Epin Count') }}</label>
                                <input type="number" name="epin_count" id="epin_count" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5" min="1" required>
                            </div>

                            <!-- Transaction Password -->
                            <div class="mb-5 relative">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Transaction Password') }}</label>
                                <div class="relative">
                                    <input type="password" name="transaction_password" id="transaction_password"
                                        class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg block w-full p-2.5 pr-12"
                                        placeholder="Enter transaction password" autocomplete="off" required>
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-black">
                                        <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                        <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="password-feedback" class="mt-2 text-sm font-medium"></div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" id="submitBtn"
                                    class="px-6 py-3 bg-neutral-800 text-white rounded-lg hover:bg-neutral-900 transition font-semibold shadow-md hover:scale-105">
                                    {{ __('Generate E-pin') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="flex flex-col">
                        <img src="/assets/img/E-pin/secure.svg" alt="Secure" class="w-full">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>

    /* Success icon fix */
    .swal2-success-ring {
        border-color: #28a745 !important;
    }
    .swal2-success-line-tip,
    .swal2-success-line-long {
        background-color: #28a745 !important;
    }

    /* Error icon fix */
    .swal2-error {
        border-color: #dc3545 !important;
    }
    .swal2-x-mark-line-left,
    .swal2-x-mark-line-right {
        background-color: #dc3545 !important;
    }

</style>

<script>
// Toggle Password Visibility
function togglePassword() {
    const input = document.getElementById('transaction_password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    } else {
        input.type = 'password';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    }
}

// Password Live Check
let isPasswordCorrect = false;
document.getElementById('transaction_password').addEventListener('input', function () {
    const password = this.value.trim();
    const feedback = document.getElementById('password-feedback');
    if (!password) {
        feedback.innerHTML = '';
        isPasswordCorrect = false;
        return;
    }
    feedback.innerHTML = '<span class="text-blue-600">Checking...</span>';

    fetch('{{ route("user.epinrequest.verify-transaction-password") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ transaction_password: password })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            feedback.innerHTML = '<span class="text-green-600 font-bold">Correct password!</span>';
            isPasswordCorrect = true;
        } else {
            feedback.innerHTML = '<span class="text-red-600 font-bold">Incorrect password!</span>';
            isPasswordCorrect = false;
        }
    });
});

// Main Form Submit with Ajax + Full Reset + Reload
document.getElementById('epinrequest').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Incorrect password POPUP
    if (!isPasswordCorrect) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Please enter the correct transaction password.',
            background: '#fff',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#d33',
            customClass: {
                popup: 'bg-white text-black',
                confirmButton: 'bg-red-500 text-white font-semibold py-2 px-4 rounded-lg'
            }
        });
        return;
    }

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin inline w-5 h-5 mr-2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Generating...';

    const formData = new FormData(this);

    try {
        const res = await fetch('/user/epinrequest/validatecreate', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        });

        const data = await res.json();

        // SUCCESS POPUP
        if (res.ok && data.success) {
            Swal.fire({
                title: 'Success!',
                icon: 'success',
                html: `<strong>${data.total_pins} E-Pins Generated!</strong><br>Amount Deducted: ${data.deducted_amount}`,
                background: '#fff',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                customClass: {
                    popup: 'bg-white text-black',
                    confirmButton: 'bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg'
                }
            }).then(() => location.reload());
        }

        else {
            const msg = data.errors ? Object.values(data.errors).flat().join('<br>') : data.message;

            Swal.fire({
                title: 'Failed!',
                html: msg,
                icon: 'error',     // <-- Icon fixed
                background: '#fff',
                confirmButtonText: 'Close',
                confirmButtonColor: '#d33',
                customClass: {
                    popup: 'bg-white text-black',
                    confirmButton: 'bg-red-500 text-white font-semibold py-2 px-4 rounded-lg'
                }
            });
        }

    } catch (err) {
        Swal.fire({
            title: 'Error',
            text: 'Network error. Please try again.',
            icon: 'error',     // <-- Icon fixed
            background: '#fff',
            confirmButtonColor: '#d33'
        });
    }

    finally {
        btn.disabled = false;
        btn.innerHTML = 'Generate E-pin';
    }
});
</script>

<script type="text/javascript">
function showPackageAmount(id) {
    if (!id) {
        document.getElementById("epin_amount").value = '';
        document.getElementById("epin_amount_package").value = '';
        document.getElementById("epin_amount").readOnly = false;
        return;
    }

    var myarr = id.split(",");
    var packageId = myarr[0];
    var tid = myarr[1];

    // Special case: E-Wallet Topup → allow manual entry
    if (packageId === '100000000000001') {
        document.getElementById("epin_amount").readOnly = false;
        document.getElementById("epin_amount").value = '';
        document.getElementById("epin_amount_package").value = '';
        document.getElementById("epin_amount").focus();
        return;
    }

    fetch('{{ $_ENV['FCPATH'] }}/epin/getpackageamount/' + packageId + '/' + tid)
        .then(response => response.text())
        .then(resp => {
            var amount = resp.trim();
            if (amount && amount !== '0') {
                document.getElementById("epin_amount").readOnly = true;
                document.getElementById("epin_amount").value = amount;
                document.getElementById("epin_amount_package").value = amount;
            } else {
                document.getElementById("epin_amount").readOnly = false;
                document.getElementById("epin_amount").value = '';
                document.getElementById("epin_amount_package").value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById("epin_amount").readOnly = false;
        });
}
</script>
<script type="text/javascript">
    function updateWalletBalance() {
        const walletSwitch = document.getElementById('wallet_type');
        const balanceField = document.getElementById('balance');
        const walletLabel = document.getElementById('wallet_label');
        const toggleText = document.getElementById('toggleText');

        if (walletSwitch.checked) {
            // E-Wallet selected
            balanceField.value = document.getElementById('formatted_ewallet').value;
            walletLabel.textContent = '(E-Wallet)';
            toggleText.textContent = 'E-Wallet';
        } else {
            // Cash Wallet selected
            balanceField.value = document.getElementById('formatted_cwallet').value;
            walletLabel.textContent = '(Cash Wallet)';
            toggleText.textContent = 'E-Wallet';
        }
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', updateWalletBalance);
    // Run when toggle changes
    document.getElementById('wallet_type').addEventListener('change', updateWalletBalance);
</script>
@endsection
