@include('components.common.header')
<!-- custom styles end-->
@include('components.common.topbars')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white mb-2">{{ __('Add Distributors') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="{{$_ENV['BCPATH']}}/adminhome" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __('E-Store') }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Discount Group') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('View Users') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Add Distributors') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>                
    </div>
</div>
<!-- breadcrub navs end-->

<!-- Content area -->

<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
       @include('components.common.info_message')
       <!--Success and Failure Messge-->
       <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 "
>
       <form method="post" action="{{$_ENV['BCPATH']}}/wordpressdiscountgroup/usersaddgroup" name="showaddgroupusers" id="showaddgroupusers">
       <div class="flex justify-end">
        <button class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
 type="button" onclick="addUsers();">Add</button>
        </div>
          <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 p-2">
             <!-- card -->
             <div class="w-full mx-auto p-4">
                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Username') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('DOJ') }}</th>
                                        <th>{{ __('Status') }}</th>   
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                            {!! $user_manage !!}
                            </tbody>
                        </table>
                        
                        </div>
                    </div>   
            
            
          </div>
          <!-- card -->
        </form> 
       </div>
       <!--Row-1-->
    </div>
 </main>
@include('components.common.footer')

 
@include('components.common.footer_scripts')

@include('components.common.footer_end')