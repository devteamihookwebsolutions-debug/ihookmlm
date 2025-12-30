@extends('user::components.common.main')

@section('content')
<!-- breadcrub navs start-->
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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Reports</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Downline Sales Report</span>
                                    </div>
                                </li>
                            </ol>
                        </div>



        <main class="flex-grow">
            <div class="">

                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5 mb-5">
                    <!-- Example cards -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 border">


                      <div class="w-full mx-auto p-4">
                        <!-- Filter Section -->
                        <div class="mb-4">
                            <!-- Start Date -->
                            <form id="myForm" action="{{route('user.downlinesales.filter')}}" method="POST" class="flex flex-wrap items-center gap-4">
                                @csrf
                                <div>
                                    <label for="start-date" class="text-xs text-gray-600 mb-3 dark:text-gray-300">{{ __('Start Date') }}</label>
                                    <input type="date" id="start-date" name="start-date" class="block w-full bg-white border text-gray-600 text-xs dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 rounded-lg" value="{{ $start_date }}">
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="end-date" class="text-xs text-gray-600 mb-3 dark:text-gray-300">{{ __('End Date') }}</label>
                                    <input type="date" id="end-date" name="end-date" class="block w-full bg-white border text-gray-600 text-xs dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 rounded-lg" value = "{{ $end_date }}">
                                </div>

                                <input type="hidden" id="matrix_id" name="matrix_id" value="1">


                                <!-- Filter Button -->
                                <div class="mt-6">
                                    <button type="submit" id="filter-button" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">{{ __('Filter') }}</button>
                                </div>

                                 <!-- Reset Button -->
                                <div class="mt-6">
                                   <a href="{{route('user.downlinesales.filter')}}"><button type="button"class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">{{ __('Reset') }}</button></a>
                                </div>
                            </form>
                     <div class="text-right font-semibold sales-value dark:text-white">
                            <p>
                                {{ __('Total Downline Sales') }} :
                                {{ $site_currency }}
                                <span id="total_sum_level">0.00</span>
                            </p>
                    </div>


                           <!-- <div class="border border-neutral-300 p-4 rounded-md" id="level_details"></div> -->
                            <button class="border border-blue-500 text-blue-500 hover:bg-neutral-500 hover:text-white font-medium rounded-md px-4 py-2 transition duration-200"
                                id="nextlevel" style="display: block;" onclick="sendData();">
                                {{ __('Next') }} {{ __('level') }}
                            </button>


                        </div>
                        <!-- Filter Section End -->

                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Username') }}</th>
                                    <th>{{ __('rank') }}</th>
                                    <th>{{ __('Sponsor') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                {!! $userlist !!}
                            </tbody>
                        </table>

                        </div>
                    </div>
                    <input type="hidden" id="levelcount" value="1">

                    </div>

                </div>




            </div>
        </main>



<!-- Content area end-->
<!-- custom scripts start-->
@include('user::components.common.datatable_scripts')


<!-- custom scripts end-->
@endsection


