@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->


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
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Withdrawal</span>
                    </div>
                </li>
            </ol>
    </div>
<!-- breadcrub navs end-->
<!-- Content area -->
<main class="flex-grow">
    <div class="">
        <!--Success and Failure Messge-->
       @include('components.common.info_message')
       <!--Success and Failure Messge-->

        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 dark:text-white border border-gray-200">

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="default-styled-tab"
                        data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-blue-600 dark:text-blue-500 border-blue-600 dark:border-blue-500"
                        data-tabs-inactive-classes="text-gray-500 dark:text-gray-400 border-transparent"
                        role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab"
                                data-tabs-target="#default-group" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">{{ __('Pending') }}
                            </button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg"
                                id="dashboard-styled-tab" data-tabs-target="#personal-group" type="button" role="tab"
                                aria-controls="dashboard" aria-selected="false">{{ __('Paid') }}</button>
                        </li>

                    </ul>
                </div>

                <div id="default-styled-tab-content">

                    <div class="hidden p-4 rounded-lg " id="default-group" role="tabpanel"
                        aria-labelledby="profile-tab">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5">

                            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 dark:text-white border border-gray-200">
                              <div class="w-full mx-auto p-4">
                                <!-- Data Table -->
                                <div class="overflow-x-auto">
                                    <table id="data-table" class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('wallet') }}</th>
                                            <th>{{ __('account_type') }}</th>
                                            <th>{{ __('account_details') }}</th>
                                            <th>{{ __('request_date') }}</th>
                                            <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                    {!! $withdraw !!}
                                </tbody>
                                </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden p-4 rounded-lg " id="personal-group" role="tabpanel"
                        aria-labelledby="dashboard-tab">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5">



                            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 dark:text-white border border-gray-200">
                                <div class="w-full mx-auto p-4">
                                  <!-- Data Table -->
                                  <div class="overflow-x-auto">
                                      <table id="data-table2" class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('wallet') }}</th>
                                            <th>{{ __('account_type') }}</th>
                                            <th>{{ __('account_details') }}</th>
                                            <th>{{ __('request_date') }}</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                    {!! $completedwithdraw !!}
                                </tbody>
                                  </table>

                                  </div>
                              </div>

                              </div>



                        </div>

                    </div>




                </div>

                <!-- card -->

            </div>
            <!--Row-1-->

        </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


const table2 = new simpleDatatables.DataTable("#data-table2", {
    tableRender: (_data, table, type) => {
        if (type === "print") {
            return table
        }
        const tHead = table.childNodes[0]
        const filterHeaders = {
            nodeName: "TR",
            attributes: {
                class:"search-filtering-row text-black dark:text-white bg-white dark:bg-gray-900"
            }
        }
        tHead.childNodes.push(filterHeaders)
        return table
    }
});
</script>
<script>
function changeWithdrawalSettings(id, mid) {
    Swal.fire({
        title: "{{ __('Do you want to accept the withdrawal?') }}",
        text: "",
        icon: "warning",
        width: "20rem",
        heightAuto: false,
        padding: "1.25rem",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "{{ __('Yes') }}",
        cancelButtonText: "{{ __('Cancel') }}",
        customClass: {
            confirmButton: "bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded",
            cancelButton: "bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded",
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Use Laravel route helper
           const url = "{{ route('admin.payouts.changeWithdrawalStatus', ['id' => ':id', 'mid' => ':mid']) }}";

            fetch(url.replace(':id', id).replace(':mid', mid), {
                method: 'GET',
            })
            .then(response => response.json())
            .then(result => {
                Swal.fire(
                    "Done",
                    "Withdrawal request accepted",
                    "success"
                );
              window.location = "{{ route('admin.withdrawal') }}";

            })
            .catch(error => {
                Swal.fire(
                    "Error",
                    `Request failed: ${error.message}`,
                    "error"
                );
            });
        } else {
            Swal.fire(
                "{{ __('Cancelled') }}",
                "{{ __('Withdrawal request not accepted') }}",
                "error"
            );
        }
    });
    return false;
}

function cancelWithdrawalSettings(id, mid) {
    Swal.fire({
        title: "{{ __('Do you want to cancel the withdrawal?') }}",
        text: "{{ __('withdrawal') }}",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            popup: 'bg-white rounded-lg shadow-lg',
            title: 'text-xl font-semibold text-black',
            text: 'text-sm text-black',
            confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
            cancelButton: 'bg-gray-500 text-white hover:bg-gray-600 font-semibold py-2 px-4 rounded-lg',
        }
    }).then((result) => {
        if (result.isConfirmed) {

            const url = "{{ route('admin.payouts.cancelWithdrawalStatus', ['id' => ':id', 'mid' => ':mid']) }}"
                .replace(':id', id)
                .replace(':mid', mid);

            fetch(url, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(result => {

                if (result.success) {
                    Swal.fire("Done", "Withdrawal cancelled successfully", "success")
                        .then(() => {
                            window.location = "{{ route('admin.withdrawal') }}";
                        });
                } else {
                    Swal.fire("Error", result.message, "error");
                }

            })
            .catch(error => {
                Swal.fire("Error", error.message, "error");
            });

        } else {
            Swal.fire("{{ __('Cancelled') }}", "", "error");
        }
    });

    return false;
}

</script>

 @include('components.common.datatable_script')
<!-- custom scripts end-->
@endsection
