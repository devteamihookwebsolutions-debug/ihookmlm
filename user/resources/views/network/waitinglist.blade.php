@include('components.common.header')
<!-- custom styles start-->
<!-- custom styles end-->
@include('components.common.topbars')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2  dark:text-white">{{ __('Waiting Room') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{$_ENV['FCPATH']}}/dashboard"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"></path>
                            </svg>
                            {{ __('My Teams') }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Waiting Room') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>                
    </div>
</div>
<!-- breadcrub navs end-->



        <main class="flex-grow">
            <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->

                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5 mb-5">
                    <!-- Example cards -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                      <div class="w-full mx-auto p-4">
                    
                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>

                                <th>{{ __('S.No') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Register on') }}</th>
                                <th>{{ __('First Name') }}</th>
                                <th>{{ __('Last Name') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                            {!! $user_list !!}
                            </tbody>
                        </table>
                        
                        </div>
                    </div>                                               

                    </div>
                   
                </div>

              


            </div>
        </main>

<!-- Content area end-->

<!-- Footer -->
@include('components.common.footer')

@include('components.common.footer_scripts')

<!-- custom scripts start-->
@include('components.common.datatable_script')
<!-- custom scripts end-->

<!-- custom scripts end-->
@include('components.common.footer_end')