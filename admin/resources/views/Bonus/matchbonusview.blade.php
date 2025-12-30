@extends('admin::components.common.main')
@section('content')
<!-- Breadcrumb -->
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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Compansation</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Matching Bonus</span>
            </div>
        </li>
    </ol>
</div>


<main class="flex-grow">
    <div class="">
        <!-- Success and Failure Message -->
        @include('components.common.info_message')
        <!-- Success and Failure Message -->
        <!-- Row-1 -->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 border dark:border-gray-800">
                <div>
                    <div class="p-4 rounded-lg">
                        <!-- Card Header -->
                        <div class="flex justify-end items-center">
                            <ul class="flex space-x-2">
                                <li>
                                    <a aria-label="link" href="/admin/matchbonus/add"
                                        class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                                        <span>{{ __('Add') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="w-full mx-auto p-4">
                            <!-- Data Table -->
                            <div class="overflow-x-auto">
                                <!-- Table -->
                                <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SNo') }}</th>
                                            <th>{{ __('Plans') }}</th>
                                            <th>{{ __('Matching Bonus Name') }}</th>
                                            <th>{{ __('Commission Based on') }}</th>
                                            <th>{{ __('Commission Sent Type') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! $showmatch !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('components.common.datatable_script')

<script>
function confirmDelete2(id) {
    Swal.fire({
        title: '{{ __("Do you want to delete ?") }}',
        text: "{{ __('Matching Bonus') }}",
        icon: 'warning',
        width: 400,
        heightAuto: false,
        padding: '2.5rem',
        customClass: {
            popup: 'bg-white rounded-lg shadow-lg',
            title: 'text-xl font-semibold text-black',
            text: 'text-sm text-black',
            confirmButton: 'bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg',
            cancelButton: 'bg-neutral-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
        },
        showCancelButton: true,
        confirmButtonColor: null,
        cancelButtonColor: '#d33',
        confirmButtonText: '{{ __("Yes, I am sure!") }}',
        cancelButtonText: "{{ __('Cancel') }}",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("/admin/matchbonus/delete", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // Add CSRF token
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("{{ __('Deleted') }}", "{{ __('Match Bonus deleted successfully') }}",
                            "success");
                        window.location.href = "/admin/matchbonus";
                    } else {
                        Swal.fire("{{ __('Error') }}", data.message || "{{ __('An error occurred') }}",
                            "error");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire("{{ __('Error') }}", "{{ __('An error occurred') }}", "error");
                });
        } else {
            Swal.fire("{{ __('Cancelled') }}", "{{ __('Your record is safe') }}", "info");
        }
    });
}
</script>
@endsection
