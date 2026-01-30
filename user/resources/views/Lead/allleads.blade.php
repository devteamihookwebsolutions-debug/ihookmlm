@extends('user::components.common.main')

@section('content')
    <!-- Breadcrumb -->
    <div class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="user-d-board.html"
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
                        class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Leads</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                        aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m10 16 4-4-4-4" />
                    </svg>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Leads Contacts</span>
                </div>
            </li>
        </ol>
    </div>


    
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5 mb-5">
            <!-- Example cards -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <!-- Card Header -->
                <div class="flex justify-end items-center">
                    <ul class="flex space-x-2">
                        <!-- <li>
                            <a aria-label="link" href="{{ $_ENV['FCPATH'] }}/addleadcontacts/add"
                                class="px-4 py-2 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                                <span>{{ __('Add') }}</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div class="w-full mx-auto p-4">
                    <!-- Data Table -->
                    <div class="overflow-x-auto">
                        <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th>{{ __('SNo') }}</th>
                                    <th>{{ __('First name') }}</th>
                                    <th>{{ __('Last name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('phone') }}</th>
                                    <th>{{ __('Source') }}</th>
                                    <th>{{ __('Created On') }}</th>
                                    <th>{{ __('Csv Username') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @forelse($allLeads as $index => $lead)
                                <tr class="hover:bg-neutral-50">

                                    <!-- SNo -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ $index + 1 }}
                                    </td>

                                    <!-- First Name -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ $lead->leads_first_name }}
                                    </td>

                                    <!-- Last Name -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ $lead->leads_last_name }}
                                    </td>

                                    <!-- Email -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ $lead->leads_email }}
                                    </td>

                                    <!-- Phone -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ $lead->leads_phonenumber }}
                                    </td>

                                    <!-- Source -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ $lead->leads_social ?? '-' }}
                                    </td>

                                    <!-- Created On -->
                                    <td class="px-3 py-2 text-sm">
                                        {{ \Carbon\Carbon::parse($lead->created_on)->format('d-m-Y H:i') }}
                                    </td>

                                    <!-- CSV Username (Sponsor Name) -->
                                    <td class="px-3 py-2 text-sm font-medium text-neutral-800">
                                        {{ $userName->members_username ?? '' }} 
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500">
                                        No leads found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



    @endsection
