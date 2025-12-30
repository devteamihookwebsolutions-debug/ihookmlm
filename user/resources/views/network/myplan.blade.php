@include('components.common.header')
@include('components.common.topbars')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2  dark:text-white">{{ __('My Plan') }}</h2>
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
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->

<!-- Content area -->

<!-- Content area -->
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
    <!--Success and Failure Messge-->
    @include('components.common.info_message')
    <!--Success and Failure Messge-->
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
                <span class="font-medium">Info alert!</span>This tool will guide you to setup plan upgrade
            </div>
        </div>

        <!-- card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-400 border border-neutral-200" bis_skin_checked="1">

            <div class="flex justify-between flex-wrap items-center mb-5" bis_skin_checked="1">
                <div class="mt-4 flex items-center justify-start gap-4" bis_skin_checked="1">

                    <button type="button"
                        class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:hover:bg-[#FF5D19]"
                        onclick="window.location.href='{{$_ENV['FCPATH']}}/recruituser/recruit';">{{ __('Recruit New User') }}</button><button id="genealogyDefaultButton" data-dropdown-toggle="genealogydropdown"
                        class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700 text-center inline-flex items-center"
                        type="button">
                        {{ __('Genealogy Plan') }}
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="genealogydropdown"
                        class="z-10 bg-white divide-y divide-neutral-100 rounded-lg shadow w-44 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 hidden"
                        aria-hidden="true" data-popper-placement="bottom"
                        style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(640px, 894px);"
                        bis_skin_checked="1">
                        <ul class="py-2 text-sm text-black dark:text-neutral-200"
                            aria-labelledby="dropdownDefaultButton">

                            {!! $allgenealogy !!}
                        </ul>
                    </div>

                </div>

                <div class="right-content flex justify-between items-center gap-2 flex-wrap" bis_skin_checked="1">

                    <div class="active-plan-input me-3" bis_skin_checked="1">
                        <label for="countries"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Active Plan') }}</label>
                        <select id="activematrix"
                            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            name="activematrix" onchange="activeMatrix()">
                            <option selected="">Choose</option>
                            {!! $show_my_network_active_list !!}
                         </select>

                    </div>

                    <div class="inactive-plan-input" bis_skin_checked="1">
                        <label for="countries"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">
                            {{ __('Inactive Plan') }}</label>
                        <select id="inactivematrix"
                            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            name="inactivematrix" onchange="joinMatrix()">
                            <option selected="">Choose</option>
                            {!! $show_my_network_inactive_details !!}
                        </select>

                    </div>

                </div>
            </div>

            <div class="border-b border-neutral-300 my-5" bis_skin_checked="1"></div>

            {!! $show_my_network_active_details !!}
        </div>
            <!--Row-1-->

        </div>




        <div id="matrixinformation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-neutral-200">
                        <h3 class="text-xl font-semibold text-black dark:text-white">
                            {{ __('Matrix Information') }}
                        </h3>
                        <button type="button" class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                        onclick="hideModal('matrixinformation-modal')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4" id="view_matrix_details">

                    </div>

                </div>
            </div>
        </div>


        <!-- card -->
    </div>
</main>

<!-- Content area end-->

<!-- Footer -->
@include('components.common.footer')
@include('components.common.footer_scripts')

<script>
    function activeMatrix() {
        var selected = document.getElementById("activematrix").value;
        if (selected != '') {
            var member_id = "{{$_SESSION['default']['customer_id']}}";
            window.location = "/user/network/view/matrix/" + member_id + "/" + selected
        }
    }

    function joinMatrix() {
        var selected = document.getElementById("inactivematrix").value;
        if (selected != '') {
            var id = "{{$_SESSION['default']['customer_id']}}";
            window.location = "{{$_ENV['FCPATH']}}/joinnetwork/join/" + id + "/" + selected
        }
    }
    async function showMatrixMoreInformation(id) {
        const url = '{{$_ENV['FCPATH']}}/network/matrixmoreinfo';
        const data = new URLSearchParams({
            matrix_id: id
        });
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data,
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const resp = await response.text();

            // Set the target element for the modal
            const targetEl = document.getElementById('matrixinformation-modal');

            // You can define optional settings here (e.g., animation, auto hide, etc.)
            const options = {
                backdrop: true,    // Controls whether the modal has a backdrop
                keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
                focus: true        // Controls whether the modal will be focused when opened
            };

            // Initialize the modal with Flowbite's Modal constructor
            const modal = new Modal(targetEl, options);
            modal.show();


            document.getElementById('view_matrix_details').innerHTML = resp;
        } catch (error) {
            console.log('Error fetching matrix details:', error);
        }
    }
     // Function to close modal
     const hideModal = (modalId) => {
        const targetEl = document.getElementById(modalId);

        // Define optional settings here (e.g., animation, auto hide, etc.)
        const options = {
            backdrop: true,    // Controls whether the modal has a backdrop
            keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
            focus: true        // Controls whether the modal will be focused when opened
        };

        // Initialize the modal with Flowbite's Modal constructor
        const modalInstance = new Modal(targetEl, options);
        modalInstance.hide();
    };
    function upgardeMatrixSubcription(id, sid, pid) {
        window.location = "{{$_ENV['FCPATH']}}/package/upgrade/" + id + '/' + pid
    }
    function subscriptionreminder(id, matrix_id, package_id) {
        if (id == 1) {
            Swal.fire({
                title: "Cancel your Stripe subscription before upgrading",
                text: "",
                icon: "warning",
                width: 400,
                heightAuto: false,
                padding: '2.5rem',
                showCancelButton: false,
                confirmButtonText: "OK",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                }
            });

        } else if (id == 2) {
            Swal.fire({
                title: "Cancel your Chargebee subscription before upgrading",
                text: "",
                icon: "warning",
                width: 400,
                heightAuto: false,
                padding: '2.5rem',
                showCancelButton: false,
                confirmButtonText: "OK",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                }
            });

        }
        else if (id == 3) {
            Swal.fire({
                title: "Confirmation",
                text: "Cancel your Authorize.Net subscription before upgrading.",
                icon: "warning",
                width: 400,
                heightAuto: false,
                padding: '2.5rem',
                showCancelButton: true,
                confirmButtonText: "Yes, sure",
                cancelButtonText: "Cancel it",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    confirmButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
                    cancelButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{$_ENV['FCPATH']}}/authorizenetcancelhook/cancel/${matrix_id}`, {
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(res => {
                        if (res.success == 1) {
                            window.location.href = `{{$_ENV['FCPATH']}}/package/upgrade/${matrix_id}/${package_id}`;
                        }
                    })
                    .catch(error => console.error("Error:", error));
                } else {
                    Swal.fire('Your record is safe', '', 'info');
                }
            });

        }
    }
</script>

<!-- custom scripts end-->

@include('components.common.footer_end')
