@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">Terminology</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                     <div class="flex items-center">
                         <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2" d="m1 9 4-4-4-4" />
                         </svg>
                         <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">Settings</span>
                     </div>
                 </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">Personalization</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">Terminology</span>
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
               <!--Row-1-->
                <!--Success and Failure Messge-->
                @include('components.common.info_message')
                <!--Success and Failure Messge-->
               <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                  <!-- card -->
                  <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                  <div class="flex justify-end" bis_skin_checked="1">
                <select class="text-sm font-medium text-black dark:text-white border-neutral-300  bg-white dark:bg-neutral-900 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-neutral-500 dark:focus:ring-neutral-700" name="lang_list" onchange="selectLang(this.value);" required>
                {!! $language !!}
                </select>
                </div>
                     <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-black hover:text-black dark:text-white dark:hover:text-black border-neutral-600 dark:border-neutral-500" data-tabs-inactive-classes="text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300" role="tablist">
                           <li class="me-2" role="presentation">
                              <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#default-group" type="button" role="tab" aria-controls="profile" aria-selected="false">User Dashboard Menus</button>
                           </li>
                           <li class="me-2" role="presentation">
                              <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-black hover:border-neutral-300 dark:hover:text-neutral-300" id="dashboard-styled-tab" data-tabs-target="#personal-group" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Commission Type</button>
                           </li>
                           <li class="me-2" role="presentation">
                              <button class="inline-block p-4 border-b-2 rounded-t-lg" id="success-styled-tab" data-tabs-target="#success-tab" type="button" role="tab" aria-controls="success" aria-selected="false">Success And Error
                              Messages</button>
                           </li>
                        </ul>
                     </div>
                     <div id="default-styled-tab-content">
                        <div class="hidden p-4 rounded-lg " id="default-group" role="tabpanel" aria-labelledby="profile-tab">
                           <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                              <!--customer-form-->
                              <form action="{{ route('terminologysettings.update', $selected_lang) }}"
                                    method="POST"
                                    class="profile_form_new"
                                    id="usercontatcinfo">
                                 @csrf

		                     <input type="hidden" name="type" value="0">
                              <div id="accordion-collapse" data-accordion="collapse">
                                 <h2 id="accordion-collapse-heading-paypal">
                                    <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-b-0 border-neutral-200 rounded-t-xl focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-paypal" aria-controls="accordion-collapse-body-paypal">
                                       <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                          <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                             <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
                                          </svg>
                                          Dashboard
                                       </span>
                                       <input type="text" name="CUS_DASHBOARD" id="CUS_DASHBOARD" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_DASHBOARD']}}" required="">
                                       <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       </svg>
                                    </button>
                                 </h2>
                                 <div id="accordion-collapse-body-paypal" class="hidden" aria-labelledby="accordion-collapse-heading-paypal">
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                                       </svg>
                                       My Organization
                                    </span>
                                    <input type="text" name="CUS_MY_ORGANIZATION_MENU" id="CUS_MY_ORGANIZATION_MENU" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2"  value="{{$menus['CUS_MY_ORGANIZATION_MENU']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_MY_ORGANIZATION" class="block mb-2 text-sm font-medium text-black dark:text-white">My Organization</label>
                                          <input type="text" name="CUS_MY_ORGANIZATION" id="CUS_MY_ORGANIZATION"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_MY_ORGANIZATION']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_ENROLL_DISTRIBUTORS" class="block mb-2 text-sm font-medium text-black dark:text-white">Enroll a Distributors:</label>
                                          <input type="text" name="CUS_ENROLL_DISTRIBUTORS" id="CUS_ENROLL_DISTRIBUTORS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_ENROLL_DISTRIBUTORS']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_ENROLL_CUSTOMERS" class="block mb-2 text-sm font-medium text-black dark:text-white">Enroll a Customers:</label>
                                          <input type="text" name="CUS_ENROLL_CUSTOMERS" id="CUS_ENROLL_CUSTOMERS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_ENROLL_CUSTOMERS']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_SIGNUP_LEAD" class="block mb-2 text-sm font-medium text-black dark:text-white">Signup a Lead:</label>
                                          <input type="text" name="CUS_SIGNUP_LEAD" id="CUS_SIGNUP_LEAD" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_SIGNUP_LEAD']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_CUSTOMER_MANAGEMENT" class="block mb-2 text-sm font-medium text-black dark:text-white">Customer Management :</label>
                                          <input type="text" name="CUS_CUSTOMER_MANAGEMENT" id="CUS_CUSTOMER_MANAGEMENT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_CUSTOMER_MANAGEMENT']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_DISTRIBUTOR_MANAGEMENT" class="block mb-2 text-sm font-medium text-black dark:text-white">Distributor Management :</label>
                                          <input type="text" name="CUS_DISTRIBUTOR_MANAGEMENT" id="CUS_DISTRIBUTOR_MANAGEMENT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_DISTRIBUTOR_MANAGEMENT']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_CUSTOMER_GROUPS" class="block mb-2 text-sm font-medium text-black dark:text-white">Customer Groups :</label>
                                          <input type="text" name="CUS_CUSTOMER_GROUPS" id="CUS_CUSTOMER_GROUPS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_CUSTOMER_GROUPS']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_DISTRIBUTOR_GROUPS" class="block mb-2 text-sm font-medium text-black dark:text-white">Distributor Groups    :</label>
                                          <input type="text" name="CUS_DISTRIBUTOR_GROUPS" id="CUS_DISTRIBUTOR_GROUPS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_DISTRIBUTOR_GROUPS']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_TREE_VIEW" class="block mb-2 text-sm font-medium text-black dark:text-white">Tree View :</label>
                                          <input type="text" name="CUS_TREE_VIEW" id="CUS_TREE_VIEW" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_TREE_VIEW']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_ADVANCED_GENEALOGY" class="block mb-2 text-sm font-medium text-black dark:text-white">Advanced Genealogy :</label>
                                          <input type="text" name="CUS_ADVANCED_GENEALOGY" id="CUS_ADVANCED_GENEALOGY" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_ADVANCED_GENEALOGY']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_UNILEVEL_GENEALOGY" class="block mb-2 text-sm font-medium text-black dark:text-white">Unilevel Genealogy :</label>
                                          <input type="text" name="CUS_UNILEVEL_GENEALOGY" id="CUS_UNILEVEL_GENEALOGY" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_UNILEVEL_GENEALOGY']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_DOWNLINE_CUSTOMER_RETAIL_REPORT" class="block mb-2 text-sm font-medium text-black dark:text-white">Downline Customer Retail Report :</label>
                                          <input type="text" name="CUS_DOWNLINE_CUSTOMER_RETAIL_REPORT" id="CUS_DOWNLINE_CUSTOMER_RETAIL_REPORT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_DOWNLINE_CUSTOMER_RETAIL_REPORT']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_DOWNLINE_AUTOSHIP_REPORT" class="block mb-2 text-sm font-medium text-black dark:text-white">Downline Autoship Report :</label>
                                          <input type="text" name="CUS_DOWNLINE_AUTOSHIP_REPORT" id="CUS_DOWNLINE_AUTOSHIP_REPORT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_DOWNLINE_AUTOSHIP_REPORT']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_HOLDINGTANK" class="block mb-2 text-sm font-medium text-black dark:text-white">Holding Tank :</label>
                                          <input type="text" name="CUS_HOLDINGTANK" id="CUS_HOLDINGTANK" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_HOLDINGTANK']}}" required="">
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_WAITING_ROOM" class="block mb-2 text-sm font-medium text-black dark:text-white">Waiting Room :</label>
                                          <input type="text" name="CUS_WAITING_ROOM" id="CUS_WAITING_ROOM" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$menus['CUS_WAITING_ROOM']}}" required="">
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-perfectmoney" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black dark:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M14 7h-4v3a1 1 0 0 1-2 0V7H6a1 1 0 0 0-.997.923l-.917 11.924A2 2 0 0 0 6.08 22h11.84a2 2 0 0 0 1.994-2.153l-.917-11.924A1 1 0 0 0 18 7h-2v3a1 1 0 1 1-2 0V7Zm-2-3a2 2 0 0 0-2 2v1H8V6a4 4 0 0 1 8 0v1h-2V6a2 2 0 0 0-2-2Z" clip-rule="evenodd"/>
                                       </svg>
                                       Orders
                                    </span>
                                    <input type="text" name="CUS_ORDERS" id="CUS_ORDERS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_ORDERS']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-perfectmoney" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_ORDER_SUMMARY" class="block mb-2 text-sm font-medium text-black dark:text-white">Order Summary</label>
                                          <input type="text" name="CUS_ORDER_SUMMARY" id="CUS_ORDER_SUMMARY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_ORDER_SUMMARY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_ADD_ORDER" class="block mb-2 text-sm font-medium text-black dark:text-white">Add Order</label>
                                          <input type="text" name="CUS_ADD_ORDER" id="CUS_ADD_ORDER"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_ADD_ORDER']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_ALLORDERS" class="block mb-2 text-sm font-medium text-black dark:text-white">All Orders</label>
                                          <input type="text" name="CUS_ALLORDERS" id="CUS_ALLORDERS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_ALLORDERS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_PERSONAL_ORDERS" class="block mb-2 text-sm font-medium text-black dark:text-white">Personal Orders</label>
                                          <input type="text" name="CUS_PERSONAL_ORDERS" id="CUS_PERSONAL_ORDERS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_PERSONAL_ORDERS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_RETAIL_CUSTOMER_ORDERS" class="block mb-2 text-sm font-medium text-black dark:text-white">Retail Customer Orders</label>
                                          <input type="text" name="CUS_RETAIL_CUSTOMER_ORDERS" id="CUS_RETAIL_CUSTOMER_ORDERS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_RETAIL_CUSTOMER_ORDERS']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-bitpay-bitcoin" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                                       </svg>
                                       Lead
                                    </span>
                                    <input type="text" name="CUS_LEAD" id="CUS_LEAD" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_LEAD']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-bitpay-bitcoin" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_LEAD_CAPTURE_PAGE" class="block mb-2 text-sm font-medium text-black dark:text-white">Leads / Replicated</label>
                                          <input type="text" name="CUS_LEAD_CAPTURE_PAGE" id="CUS_LEAD_CAPTURE_PAGE"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_LEAD_CAPTURE_PAGE']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_LEAD_CAMPAIGN_MESSAGES" class="block mb-2 text-sm font-medium text-black dark:text-white">Leads Contacts</label>
                                          <input type="text" name="CUS_LEAD_CAMPAIGN_MESSAGES" id="CUS_LEAD_CAMPAIGN_MESSAGES"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_LEAD_CAMPAIGN_MESSAGES']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_CAMPAINGS_MESSAGES" class="block mb-2 text-sm font-medium text-black dark:text-white">Compaigns & Messages</label>
                                          <input type="text" name="CUS_CAMPAINGS_MESSAGES" id="CUS_CAMPAINGS_MESSAGES"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_CAMPAINGS_MESSAGES']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_BULK_UPLOAD" class="block mb-2 text-sm font-medium text-black dark:text-white">Bulk Upload</label>
                                          <input type="text" name="CUS_BULK_UPLOAD" id="CUS_BULK_UPLOAD"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_BULK_UPLOAD']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-skrill" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
                                       </svg>
                                       Customers
                                    </span>
                                    <input type="text" name="CUS_CUSTOMERS_MENU" id="CUS_CUSTOMERS_MENU" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_CUSTOMERS_MENU']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-skrill" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_CUSTOMERS" class="block mb-2 text-sm font-medium text-black dark:text-white">Customers</label>
                                          <input type="text" name="CUS_CUSTOMERS" id="CUS_CUSTOMERS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_CUSTOMERS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_CUSTOMERS_ORDERS" class="block mb-2 text-sm font-medium text-black dark:text-white">Orders</label>
                                          <input type="text" name="CUS_CUSTOMERS_ORDERS" id="CUS_CUSTOMERS_ORDERS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_CUSTOMERS_ORDERS']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-payeer" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M17.44 3a1 1 0 0 1 .707.293l2.56 2.56a1 1 0 0 1 0 1.414L18.194 9.78 14.22 5.806l2.513-2.513A1 1 0 0 1 17.44 3Zm-4.634 4.22-9.513 9.513a1 1 0 0 0 0 1.414l2.56 2.56a1 1 0 0 0 1.414 0l9.513-9.513-3.974-3.974ZM6 6a1 1 0 0 1 1 1v1h1a1 1 0 0 1 0 2H7v1a1 1 0 1 1-2 0v-1H4a1 1 0 0 1 0-2h1V7a1 1 0 0 1 1-1Zm9 9a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1v-1a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                          <path d="M19 13h-2v2h2v-2ZM13 3h-2v2h2V3Zm-2 2H9v2h2V5ZM9 3H7v2h2V3Zm12 8h-2v2h2v-2Zm0 4h-2v2h2v-2Z"/>
                                       </svg>
                                       Tools
                                    </span>
                                    <input type="text" name="CUS_TOOLS" id="CUS_TOOLS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_TOOLS']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-payeer" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_PROMOTE_SOCIAL" class="block mb-2 text-sm font-medium text-black dark:text-white">Showcase</label>
                                          <input type="text" name="CUS_PROMOTE_SOCIAL" id="CUS_PROMOTE_SOCIAL"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_PROMOTE_SOCIAL']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_PREMIUM_ELEARNING" class="block mb-2 text-sm font-medium text-black dark:text-white">Premium E-Learning</label>
                                          <input type="text" name="CUS_PREMIUM_ELEARNING" id="CUS_PREMIUM_ELEARNING"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_PREMIUM_ELEARNING']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_REPLICATE_SITE" class="block mb-2 text-sm font-medium text-black dark:text-white">Shop Replicate Site</label>
                                          <input type="text" name="CUS_REPLICATE_SITE" id="CUS_REPLICATE_SITE"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_REPLICATE_SITE']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_SMSBLAST" class="block mb-2 text-sm font-medium text-black dark:text-white">SMS Blast</label>
                                          <input type="text" name="CUS_SMSBLAST" id="CUS_SMSBLAST"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_SMSBLAST']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_ELEARNING" class="block mb-2 text-sm font-medium text-black dark:text-white">E-Learning</label>
                                          <input type="text" name="CUS_ELEARNING" id="CUS_ELEARNING"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_ELEARNING']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_LIVEEVENTS" class="block mb-2 text-sm font-medium text-black dark:text-white">Live Events</label>
                                          <input type="text" name="CUS_LIVEEVENTS" id="CUS_LIVEEVENTS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_LIVEEVENTS']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-solid-trust-pay" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                                       </svg>
                                       Reports
                                    </span>
                                    <input type="text" name="CUS_REPORTS" id="CUS_REPORTS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_REPORTS']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-solid-trust-pay" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_EWALLET_HISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white">E Wallet History</label>
                                          <input type="text" name="CUS_EWALLET_HISTORY" id="CUS_EWALLET_HISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_EWALLET_HISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_CASHWALLET_HISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white">Cash Wallet History</label>
                                          <input type="text" name="CUS_CASHWALLET_HISTORY" id="CUS_CASHWALLET_HISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_CASHWALLET_HISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_WITHDRAWAL_HISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white">Withdrawal History</label>
                                          <input type="text" name="CUS_WITHDRAWAL_HISTORY" id="CUS_WITHDRAWAL_HISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_WITHDRAWAL_HISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_MY_TRANSACTION_HISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white">My Transactions History</label>
                                          <input type="text" name="CUS_MY_TRANSACTION_HISTORY" id="CUS_MY_TRANSACTION_HISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_MY_TRANSACTION_HISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_MY_PV_DETAILS" class="block mb-2 text-sm font-medium text-black dark:text-white"> My PV Details</label>
                                          <input type="text" name="CUS_MY_PV_DETAILS" id="CUS_MY_PV_DETAILS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_MY_PV_DETAILS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_PRODUCT_ORDER_REPORT" class="block mb-2 text-sm font-medium text-black dark:text-white"> Product Order Report</label>
                                          <input type="text" name="CUS_PRODUCT_ORDER_REPORT" id="CUS_PRODUCT_ORDER_REPORT"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_PRODUCT_ORDER_REPORT']}}" required>
                                       </div>
                                       <!-- <div class="mb-4">
                                          <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Withdrawal History</label>
                                          <input type="text" name="name" id="name"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="History" required>
                                       </div> -->
                                       <div class="mb-4">
                                          <label for="CUS_PACKAGE_HISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white"> Package History</label>
                                          <input type="text" name="CUS_PACKAGE_HISTORY" id="CUS_PACKAGE_HISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_PACKAGE_HISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_AUTOSHIPHISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white"> Autoship History</label>
                                          <input type="text" name="CUS_AUTOSHIPHISTORY" id="CUS_AUTOSHIPHISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_AUTOSHIPHISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_DOWNLINE_SALES_REPORTS" class="block mb-2 text-sm font-medium text-black dark:text-white">  Downline Sales Report</label>
                                          <input type="text" name="CUS_DOWNLINE_SALES_REPORTS" id="CUS_DOWNLINE_SALES_REPORTS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_DOWNLINE_SALES_REPORTS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_BINARY_COMMISSION" class="block mb-2 text-sm font-medium text-black dark:text-white"> Binary Commission</label>
                                          <input type="text" name="CUS_BINARY_COMMISSION" id="CUS_BINARY_COMMISSION"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_BINARY_COMMISSION']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-cheque" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.495.93A.5.5 0 0 0 6.5 13c0 1.19.644 2.438 1.618 3.375C9.099 17.319 10.469 18 12 18c1.531 0 2.9-.681 3.882-1.625.974-.937 1.618-2.184 1.618-3.375a.5.5 0 0 0-.995-.07.764.764 0 0 1-.156.096c-.214.106-.554.208-1.006.295-.896.173-2.111.262-3.343.262-1.232 0-2.447-.09-3.343-.262-.452-.087-.792-.19-1.005-.295a.762.762 0 0 1-.157-.096ZM8.99 8a1 1 0 0 0 0 2H9a1 1 0 1 0 0-2h-.01Zm6 0a1 1 0 1 0 0 2H15a1 1 0 1 0 0-2h-.01Z" clip-rule="evenodd"/>
                                       </svg>
                                       Party Plan
                                    </span>
                                    <input type="text" name="CUS_PARTYPLAN" id="CUS_PARTYPLAN" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_PARTYPLAN']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-cheque" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_HOSTPARTY" class="block mb-2 text-sm font-medium text-black dark:text-white">Host Party</label>
                                          <input type="text" name="CUS_HOSTPARTY" id="CUS_HOSTPARTY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_HOSTPARTY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_VIEWPORTALPARTY" class="block mb-2 text-sm font-medium text-black dark:text-white">View Portal Party</label>
                                          <input type="text" name="CUS_VIEWPORTALPARTY" id="CUS_VIEWPORTALPARTY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_VIEWPORTALPARTY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_PARTYREPORTS" class="block mb-2 text-sm font-medium text-black dark:text-white">Party Reports</label>
                                          <input type="text" name="CUS_PARTYREPORTS" id="CUS_PARTYREPORTS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_PARTYREPORTS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_SHOWPARTYBUILDER" class="block mb-2 text-sm font-medium text-black dark:text-white">Show Party Builder</label>
                                          <input type="text" name="CUS_SHOWPARTYBUILDER" id="CUS_SHOWPARTYBUILDER"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_SHOWPARTYBUILDER']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-e-wallet" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M11.644 3.066a1 1 0 0 1 .712 0l7 2.666A1 1 0 0 1 20 6.68a17.694 17.694 0 0 1-2.023 7.98 17.406 17.406 0 0 1-5.402 6.158 1 1 0 0 1-1.15 0 17.405 17.405 0 0 1-5.403-6.157A17.695 17.695 0 0 1 4 6.68a1 1 0 0 1 .644-.949l7-2.666Zm4.014 7.187a1 1 0 0 0-1.316-1.506l-3.296 2.884-.839-.838a1 1 0 0 0-1.414 1.414l1.5 1.5a1 1 0 0 0 1.366.046l4-3.5Z" clip-rule="evenodd"/>
                                       </svg>
                                       E-Pin
                                    </span>
                                    <input type="text" name="CUS_EPIN" id="CUS_EPIN" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_EPIN']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-e-wallet" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_GENERATE_EPIN" class="block mb-2 text-sm font-medium text-black dark:text-white">Generate E-Pin</label>
                                          <input type="text" name="CUS_GENERATE_EPIN" id="CUS_GENERATE_EPIN"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_GENERATE_EPIN']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_MYEPIN" class="block mb-2 text-sm font-medium text-black dark:text-white">My E-Pins</label>
                                          <input type="text" name="CUS_MYEPIN" id="CUS_MYEPIN"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_MYEPIN']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-epin" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd"/>
                                       </svg>
                                       Store
                                    </span>
                                    <input type="text" name="CUS_STORE" id="CUS_STORE" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_STORE']}}" required="">
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                 </button>
                                 <div id="accordion-collapse-body-epin" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                                       <div class="mb-4">
                                          <label for="CUS_WORDPRESS_PRODUCTS" class="block mb-2 text-sm font-medium text-black dark:text-white">Wordpress Products</label>
                                          <input type="text" name="CUS_WORDPRESS_PRODUCTS" id="CUS_WORDPRESS_PRODUCTS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_WORDPRESS_PRODUCTS']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_WORDPRESS_ORDER_HISTORY" class="block mb-2 text-sm font-medium text-black dark:text-white">Wordpress Order History </label>
                                          <input type="text" name="CUS_WORDPRESS_ORDER_HISTORY" id="CUS_WORDPRESS_ORDER_HISTORY"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_WORDPRESS_ORDER_HISTORY']}}" required>
                                       </div>
                                       <div class="mb-4">
                                          <label for="CUS_DOWNLINE_REPORTS" class="block mb-2 text-sm font-medium text-black dark:text-white">Downline Reports </label>
                                          <input type="text" name="CUS_DOWNLINE_REPORTS" id="CUS_DOWNLINE_REPORTS"
                                             class="text-sm rounded-lg
                                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                                             "
                                             value="{{$menus['CUS_DOWNLINE_REPORTS']}}" required>
                                       </div>
                                    </div>
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-admin-credits" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-6.616l-2.88 2.592C8.537 20.461 7 19.776 7 18.477V17H5a2 2 0 0 1-2-2V6Zm4 2a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2H7Zm8 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2Zm-8 3a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm5 0a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" clip-rule="evenodd"/>
                                       </svg>
                                       Messages
                                    </span>
                                    <input type="text" name="CUS_MESSAGES" id="CUS_MESSAGES" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_MESSAGES']}}" required="">
                                    <span class="w-3 h-3">
                                    </span>
                                 </button>
                                 <div id="accordion-collapse-body-admin-credits" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-authorizenet" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path d="M4 5a2 2 0 0 0-2 2v2.5a1 1 0 0 0 1 1 1.5 1.5 0 1 1 0 3 1 1 0 0 0-1 1V17a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2.5a1 1 0 0 0-1-1 1.5 1.5 0 1 1 0-3 1 1 0 0 0 1-1V7a2 2 0 0 0-2-2H4Z"/>
                                       </svg>
                                       Tickets
                                    </span>
                                    <input type="text" name="CUS_TICKETS" id="CUS_TICKETS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_TICKETS']}}" required="">
                                    <span class="w-3 h-3">
                                    </span>
                                 </button>
                                 <div id="accordion-collapse-body-authorizenet" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-paypal-pro" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                                       </svg>
                                       Events
                                    </span>
                                    <input type="text" name="CUS_EVENTTS" id="CUS_EVENTTS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_EVENTTS']}}" required="">
                                    <span class="w-3 h-3">
                                    </span>
                                 </button>
                                 <div id="accordion-collapse-body-paypal-pro" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-advCash" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path d="M7.833 2c-.507 0-.98.216-1.318.576A1.92 1.92 0 0 0 6 3.89V21a1 1 0 0 0 1.625.78L12 18.28l4.375 3.5A1 1 0 0 0 18 21V3.889c0-.481-.178-.954-.515-1.313A1.808 1.808 0 0 0 16.167 2H7.833Z"/>
                                       </svg>
                                       Resources
                                    </span>
                                    <input type="text" name="CUS_RESOURCES" id="CUS_RESOURCES" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_RESOURCES']}}" required="">
                                    <span class="w-3 h-3">
                                    </span>
                                 </button>
                                 <div id="accordion-collapse-body-advCash" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                 </div>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-coin-payment" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                    <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                       <svg class="w-5 h-5 text-black transition duration-75  group-hover:text-black dark:text-white dark:group-hover:text-white mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                          <path fill-rule="evenodd" d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z" clip-rule="evenodd"/>
                                          <path fill-rule="evenodd" d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z" clip-rule="evenodd"/>
                                          <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                                       </svg>
                                       Mass Payout
                                    </span>
                                    <input type="text" name="CUS_MASS_PAYOUT" id="CUS_MASS_PAYOUT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$menus['CUS_MASS_PAYOUT']}}" required="">
                                    <span class="w-3 h-3">
                                    </span>
                                 </button>
                                 <div id="accordion-collapse-body-coin-payment" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                 </div>
                             <div class="flex justify-end mt-4" bis_skin_checked="1">
                                <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
 onclick="window.history.back()">Cancel</button>
                                <button type="submit" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Submit</button>
                             </div>

                             </form>

                              </div>
                              <!--customer-form-->
                              <div class="flex flex-col">
                                 <!--image-space-->
                                 <img src="{{ asset('assets/img/illustrations/recruitment.svg') }}"
                                    alt="add-customer"
                                    class="w-full sticky top-0 overflow-hidden">

                                 <!--image-space-->
                              </div>
                           </div>
                        </div>
                        <div class="hidden p-4 rounded-lg " id="personal-group" role="tabpanel" aria-labelledby="dashboard-tab">
                           <!--personal-group-->
                           <!--select-group-button-->
                           <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                              <!--customer-form-->
                              <div>
                              <form action="{{ route('terminologysettings.update', $selected_lang) }}"
                                    method="POST"
                                    class="profile_form_new"
                                    id="usercontatcinfo">
                                 @csrf
                                 @csrf
		                        <input type="hidden" name="type" value="1">
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-b-0 border-neutral-200 rounded-t-xl focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-paypal" aria-controls="accordion-collapse-body-paypal">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Level Commission
                                 </span>
                                 <input type="text" name="CUS_LEVEL_COMMISSION" id="CUS_LEVEL_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_LEVEL_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Direct Commission
                                 </span>
                                 <input type="text" name="CUS_DIRECT_COMMISSION" id="CUS_DIRECT_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_DIRECT_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Xup Commission
                                 </span>
                                 <input type="text" name="CUS_XUP_COMMISSION" id="CUS_XUP_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_XUP_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Withdraw Pending
                                 </span>
                                 <input type="text" name="CUS_WITHDRAW_PENDING" id="CUS_WITHDRAW_PENDING" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_WITHDRAW_PENDING']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Withdrawal
                                 </span>
                                 <input type="text" name="CUS_WITHDRAWAL" id="CUS_WITHDRAWAL" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_WITHDRAWAL']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Binary Commission
                                 </span>
                                 <input type="text" name="CUS_BINARY_COMMISSION" id="CUS_BINARY_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_BINARY_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Cycle Commission
                                 </span>
                                 <input type="text" name="CUS_CYCLE_COMMISSION" id="CUS_CYCLE_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_CYCLE_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Product Level Commission
                                 </span>
                                 <input type="text" name="CUS_PRODUCT_LEVEL_COMMISSION" id="CUS_PRODUCT_LEVEL_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_PRODUCT_LEVEL_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Ewallet Deducts
                                 </span>
                                 <input type="text" name="CUS_EWALLET_DEDUCTS" id="CUS_EWALLET_DEDUCTS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_EWALLET_DEDUCTS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Ewallet Credits
                                 </span>
                                 <input type="text" name="CUS_EWALLET_CREDITS" id="CUS_EWALLET_CREDITS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_EWALLET_CREDITS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Admin Bonus
                                 </span>
                                 <input type="text" name="CUS_ADMIN_BONUS" id="CUS_ADMIN_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_ADMIN_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Admin Deduct
                                 </span>
                                 <input type="text" name="CUS_ADMIN_DEDUCT" id="CUS_ADMIN_DEDUCT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_ADMIN_DEDUCT']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 PV
                                 </span>
                                 <input type="text" name="CUS_PV" id="CUS_PV" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_PV']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Epin Purchase Deduct
                                 </span>
                                 <input type="text" name="CUS_EPIN_PURCHASE_DEDUCT" id="CUS_EPIN_PURCHASE_DEDUCT" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_EPIN_PURCHASE_DEDUCT']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Fund Transferred
                                 </span>
                                 <input type="text" name="CUS_FUND_TRANSFERRED" id="CUS_FUND_TRANSFERRED" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_FUND_TRANSFERRED']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Fund Received
                                 </span>
                                 <input type="text" name="CUS_FUND_RECEIVED" id="CUS_FUND_RECEIVED" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_FUND_RECEIVED']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Rank Bonus
                                 </span>
                                 <input type="text" name="CUS_RANK_BONUS" id="CUS_RANK_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_RANK_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Joining Commission
                                 </span>
                                 <input type="text" name="CUS_JOINING_COMMISSION" id="CUS_JOINING_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_JOINING_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Entry Bonus
                                 </span>
                                 <input type="text" name="CUS_ENTRY_BONUS" id="CUS_ENTRY_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_ENTRY_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Exit Bonus
                                 </span>
                                 <input type="text" name="CUS_EXIT_BONUS" id="CUS_EXIT_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_EXIT_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Custom Bonus
                                 </span>
                                 <input type="text" name="CUS_CUSTOM_BONUS" id="CUS_CUSTOM_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_CUSTOM_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Stairwell Commission
                                 </span>
                                 <input type="text" name="CUS_STAIRWELL_COMMISSION" id="CUS_STAIRWELL_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_STAIRWELL_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Qualification Bonus
                                 </span>
                                 <input type="text" name="CUS_QUALIFICATION_BONUS" id="CUS_QUALIFICATION_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_QUALIFICATION_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Direct Bonus
                                 </span>
                                 <input type="text" name="CUS_DIRECT_BONUS" id="CUS_DIRECT_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_DIRECT_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Network Bonus
                                 </span>
                                 <input type="text" name="CUS_NETWORK_BONUS" id="CUS_NETWORK_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_NETWORK_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Matching Bonus
                                 </span>
                                 <input type="text" name="CUS_MATCHING_BONUS" id="CUS_MATCHING_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_MATCHING_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Withdraw Completed
                                 </span>
                                 <input type="text" name="CUS_WITHDRAW_COMPLETED" id="CUS_WITHDRAW_COMPLETED" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_WITHDRAW_COMPLETED']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Daily Binary Commission
                                 </span>
                                 <input type="text" name="CUS_DAILY_BINARY_COMMISSION" id="CUS_DAILY_BINARY_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_DAILY_BINARY_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Weekly Binary Commission
                                 </span>
                                 <input type="text" name="CUS_WEEKLY_BINARY_COMMISSION" id="CUS_WEEKLY_BINARY_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_WEEKLY_BINARY_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Monthly Binary Commission
                                 </span>
                                 <input type="text" name="CUS_MONTHLY_BINARY_COMMISSION" id="CUS_MONTHLY_BINARY_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_MONTHLY_BINARY_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Stairstep
                                 </span>
                                 <input type="text" name="CUS_STAIRSTEP" id="CUS_STAIRSTEP" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_STAIRSTEP']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Generation Bonus
                                 </span>
                                 <input type="text" name="CUS_GENERATION_BONUS" id="CUS_GENERATION_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_GENERATION_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Customer Acquisition Bonus
                                 </span>
                                 <input type="text" name="CUS_CUSTOMER_ACQUISITION_BONUS" id="CUS_CUSTOMER_ACQUISITION_BONUS" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_CUSTOMER_ACQUISITION_BONUS']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Customer Retail Commission
                                 </span>
                                 <input type="text" name="CUS_CUSTOMER_RETAIL_COMMISSION" id="CUS_CUSTOMER_RETAIL_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_CUSTOMER_RETAIL_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Membership Commission
                                 </span>
                                 <input type="text" name="CUS_MEMBERSHIP_COMMISSION" id="CUS_MEMBERSHIP_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_MEMBERSHIP_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white>
                                 Split Commission
                                 </span>
                                 <input type="text" name="CUS_SPLIT_COMMISSION" id="CUS_SPLIT_COMMISSION" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_SPLIT_COMMISSION']}}" required="">
                                 </button>
                                 <button type="button" class="flex flex-wrap items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3">
                                 <span class="text-black flex gap-2 min-w-[200px] text-sm dark:text-white">
                                 Pool
                                 </span>
                                 <input type="text" name="CUS_POOL" id="CUS_POOL" class="bg-neutral-50 text-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 w-1/2" value="{{$commissions['CUS_POOL']}}" required="">
                                 </button>
                                 <div class="flex justify-end mt-4" bis_skin_checked="1">
                                <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
 onclick="window.history.back()">Cancel</button>
                                <button type="submit" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Submit</button>
                             </div>
                                </form>
                              </div>
                              <!--customer-form-->
                              <div class="flex flex-col">
                                 <!--image-space-->
                                <img src="{{ asset('assets/img/illustrations/recruitment.svg') }}"
                                 alt="add-customer"
                                 class="w-full sticky top-0 overflow-hidden">

                                 <!--image-space-->
                              </div>
                           </div>
                        </div>
                        <div class="hidden p-4 rounded-lg " id="success-tab" role="tabpanel" aria-labelledby="success-tab">
                           <!--personal-group-->
                           <!--select-group-button-->
                           <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                              <!--customer-form-->
                              <div>
<form action="{{ route('terminologysettings.update', $selected_lang) }}"
      method="POST"
      class="profile_form_new"
      id="usercontatcinfo">
    @csrf
                                 @csrf
                                <input type="hidden" name="type" value="2">
                                {!! $messages !!}
                                <div class="flex justify-end mt-4" bis_skin_checked="1">
                                <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
 onclick="window.history.back()">Cancel</button>
                                <button type="submit" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Submit</button>
                             </div>
                              </div>
                              <!--customer-form-->
                              <div class="flex flex-col">
                                 <!--image-space-->
                                <img src="{{ asset('assets/img/illustrations/recruitment.svg') }}"
                                 alt="add-customer"
                                 class="w-full sticky top-0 overflow-hidden">

                                 <!--image-space-->
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

@include('components.common.datatable_script')
<!-- custom scripts end-->

       <script>
    function selectLang(val) {
        // Use the named route and replace :lang with selected value
        let url = "{{ route('terminologysettings', ['lang' => ':lang']) }}";
        url = url.replace(':lang', val);
        window.location.href = url;
    }


    </script>
@endsection
