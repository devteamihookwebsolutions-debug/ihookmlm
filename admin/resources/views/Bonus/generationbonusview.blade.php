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
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Generation Bonus</span>
            </div>
        </li>
    </ol>
</div>


<main class="flex-grow">
    <div class="">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <!-- Card -->
            <div
                class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200">
                <div>
                    <div class="p-4 rounded-lg">
                        <!-- Card Header -->
                        <div class="flex justify-end items-center">
                            <ul class="flex space-x-2">
                                <li>
                                    <a aria-label="link" href="/admin/generationbonus/addgen"
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
                                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SNo')}}</th>
                                            <th>{{ __('Plans')}}</th>
                                            <th>{{ __('Generation Bonus Name')}}</th>
                                            <th>{{ __('Wallet')}}</th>
                                            <th>{{ __('Status')}}</th>
                                            <th>{{ __('Action')}}</th>
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
        title: 'Do you want to delete?',
        text: "Generation Bonus",
        icon: 'warning',
        width: 400,
        padding: '2.5rem',
        showCancelButton: true,
        confirmButtonText: 'Yes, sure',
        cancelButtonText: 'Cancel it',
        customClass: {
            popup: 'bg-white rounded-lg shadow-lg',
            title: 'text-xl font-semibold text-black',
            text: 'text-sm text-black',
            confirmButton: 'bg-black text-white hover:bg-gray-800 font-semibold py-2 px-4 rounded-lg',
            cancelButton: 'bg-gray-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form and submit as DELETE
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/generationbonus/${id}`;
            form.style.display = 'none';

            // Laravel expects _method=DELETE for spoofing
            const methodInput = document.createElement('input');
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            // CSRF token
            const tokenInput = document.createElement('input');
            tokenInput.name = '_token';
            tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(tokenInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
