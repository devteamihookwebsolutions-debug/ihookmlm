@extends('admin::components.common.main')

@section('content')
<!-- Main Content Area -->
        <!-- breadcrumb  -->
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
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Wallet

              </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Deduct Bonus</span>
                    </div>
                </li>
            </ol>
      </div>


        <main class="flex-grow">
            <div class="container mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
                                <!--Success and Failure Messge-->
                        @include('components.common.info_message')
                        <!--Success and Failure Messge-->
                <div class="flex p-4 mb-6 text-xs text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-300"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-3 h-3 me-3 mt-[2px]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                        </path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <div>
                            <p class="mb-2">
                            Use this tool to deduct funds from your customers wallets when they do any illegal activities or unwanted transactions from C-Wallet or E-Wallet</p>
                        </div>
                    </div>
                </div>

                <div class="container mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">

                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                        <!-- card -->
                        <div
                            class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                            <div>

                                <div class="p-4 rounded-lg" id="default-group" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">

                                        <!-- Left side: Form content -->

                                        <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5">
                                            <form name="Sendbonus" id="Sendbonus" method="POST"
                                               action="{{ route('admin.updateDetect') }}"
                                                novalidate="novalidate">
                                                    @csrf
                                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-5">
                                                  Deduct Bonus</h3>
                                                <div class="mb-5">
                                                    <label for="searchbox"
                                                        class="block mb-3 text-xs text-gray-600 dark:text-white">Username</label>
                                                    <div id="search-combobox" class="relative" data-hs-combo-box="">
                                                        <div class="relative">
                                                            <input type="text" id="username" name="username"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                                placeholder="Search..." aria-expanded="false"
                                                                data-hs-combo-box-input=""
                                                                onkeyup="filterSuggestions(this.value)">
                                                        </div>
                                                        <input type="hidden" name="user_list[]" id="user_list">
                                                        <div id="suggestion-box"
                                                            class="absolute z-50 w-full max-h-72 mt-1 bg-white border border-gray-300 rounded-lg shadow-md overflow-y-auto hidden"
                                                            style="max-height: 200px; overflow-y: auto;">
                                                            {!! $member !!}
                                                        </div>
                                                        <div id="username-error"
                                                            class="text-sm text-red-600 mt-2 hidden">Username does not
                                                            exist</div>
                                                    </div>
                                                </div>
                                                <div class="mb-5">
                                                    <label for=""
                                                        class="block mb-3 text-xs text-gray-600 dark:text-white">Amount</label>
                                                    <input type="text" id="withamt" name="amount"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        placeholder="">
                                                </div>
                                                <div class="mb-5">
                                                    <label for="lastname"
                                                        class="block mb-3 text-xs text-gray-600 dark:text-white">Wallet
                                                        Type
                                                    </label>
                                                    <select id="wallet_type" name="wallet_type"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                        <option value="">-- Select type --</option>
                                                        <option value="1">C-Wallet</option>
                                                        <option value="2">E-Wallet</option>
                                                    </select>
                                                </div>
                                                <div class="mb-5">
                                                    <label for=""
                                                        class="block mb-3 text-xs text-gray-600 dark:text-white">Memo</label>
                                                    <textarea name="memo" id="memo" rows="4"
                                                        class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                                        placeholder="Write your content here..."></textarea>

                                                </div>



                                                <div class="flex justify-end">
                                                    <button type="button" onclick="window.history.back();"
                                                        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-900 border dark:border-gray-800 dark:text-gray-300 text-xs hover:bg-gray-300 dark:hover:bg-gray-800">Cancel</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- card -->

                        </div>
                        <!--Row-1-->

                    </div>
                    <!-- card -->
                </div>
                <!--Row-1-->
            </div>
        </main>

<script>
    let typingTimeout;

    function filterSuggestions(query) {
        console.log(query);
        const suggestionBox = document.getElementById("suggestion-box");
        const items = suggestionBox.querySelectorAll("div[data-value]");

        if (query.trim() === "") {
            suggestionBox.classList.add("hidden");
            return;
        }

        let hasVisible = false;

        items.forEach((item) => {
            if (item.dataset.value.toLowerCase().includes(query.toLowerCase())) {
                item.classList.remove("hidden");
                hasVisible = true;
            } else {
                item.classList.add("hidden");
            }
        });

        if (hasVisible) {
            suggestionBox.classList.remove("hidden");
        } else {
            suggestionBox.classList.add("hidden");
        }

        // Clear the previous timeout to avoid unnecessary requests
        clearTimeout(typingTimeout);

        // Set a timeout to check the username after a small delay (500ms)
        typingTimeout = setTimeout(() => {
            checkUsernameExists(query);
        }, 500);
    }


   // Function to check if the username exists
    // async function checkUsernameExists(username) {
    //     // console.log("Checking username:", username);
    //     try {
    //         const token = document.querySelector('meta[name="csrf-token"]').content;

    //         const response = await fetch("{{ route('admin.usernamecheck') }}", {
    //             method: "POST",
    //             headers: {
    //                 "Content-Type": "application/json",
    //                 "Accept": "application/json", // Important for JSON response
    //                 "X-CSRF-TOKEN": token          // Laravel requires this
    //             },
    //             body: JSON.stringify({ username })
    //         });

    //         if (!response.ok) {
    //             console.error("Response not OK:", response.status);
    //             throw new Error(`HTTP error! Status: ${response.status}`);
    //         }

    //         const data = await response.json();
    //         console.log("Response:", data);
    //     } catch (error) {
    //         console.error("Fetch error:", error);
    //     }
    // }

async function checkUsernameExists(username) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const response = await fetch("{{ route('admin.usernamecheck') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({ username })
        });

        if (!response.ok) {
            console.error("Response not OK:", response.status);
            return false;
        }

        const data = await response.json();
        console.log("Response:", data);

        // return boolean explicitly
        if (data.status === 'success' || data.exists === true) {
            return true;
        } else {
            return false;
        }

    } catch (error) {
        console.error("Fetch error:", error);
        return false;
    }
}

    function selectSuggestion(value) {
        console.log(value);
        const input = document.querySelector("[data-hs-combo-box-input]");
        input.value = value;

        const user_list = document.getElementById("user_list");
        user_list.value = value;

        // Hide the suggestion box
        const suggestionBox = document.getElementById("suggestion-box");
        suggestionBox.classList.add("hidden");

        // Also hide the error message when a valid username is selected
        const errorDiv = document.getElementById("username-error");
        errorDiv.classList.add("hidden");
    }

</script>
<!---Validation for form-->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        // alert('hiii');
        const form = document.getElementById("Sendbonus");

        form.addEventListener("submit", async function (event) {
            event.preventDefault();
            let isValid = true;
            clearErrors();

            console.log('test1 = >'+isValid)

            const searchbox = document.getElementById("username");
            if (searchbox.value.trim() === "") {
                showError(searchbox, "Username is required.");
                isValid = false;
            }

            console.log('test2 = >'+isValid)

            // Check if username exists
            const usernameExists = await checkUsernameExists(searchbox.value.trim());
            console.log('usernameExists = >'+usernameExists)
            if (!usernameExists) {
                isValid = false;
            }

            console.log('test3 = >'+isValid)


            const amount = document.getElementById("withamt");
            if (amount.value.trim() === "" || isNaN(amount.value) || Number(amount.value) < 1) {
                showError(amount, "Please enter a valid amount (minimum 1).");
                isValid = false;
            }


            console.log('test4 = >'+isValid)

            const walletType = document.getElementById("wallet_type");
            if (walletType.value.trim() === "") {
                showError(walletType, "Please select a wallet type.");
                isValid = false;
            }

            console.log('test5 = >'+isValid)

            const memo = document.getElementById("memo");
            if (memo.value.trim() === "" || memo.value.length < 5) {
                showError(memo, "Memo must be at least 5 characters long.");
                isValid = false;
            }

            console.log('test6 = >'+isValid)

            if (isValid) {
                form.submit();
            }
        });

    function showError(element, message) {
        let errorContainer = document.createElement("span");
        errorContainer.className = "error-message text-red-500 text-sm mt-1 block";
        errorContainer.innerText = message;
        element.parentNode.appendChild(errorContainer);
    }

    function clearErrors() {
        document.querySelectorAll(".error-message").forEach(error => error.remove());
    }
});
</script>
@endsection
