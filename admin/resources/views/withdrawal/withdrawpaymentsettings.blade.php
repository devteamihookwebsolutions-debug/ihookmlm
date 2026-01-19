@extends('admin::components.common.main')

@section('content')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">
            {{ __('Payout') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                  <li class="inline-flex items-center">
                     <a href="{{$_ENV['BCPATH']}}/adminhome" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                         <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                         <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
                         </svg>
                             {{ __('Home') }}
                         </a>
                     </li>
                     <li aria-current="page">
                         <div class="flex items-center">
                             <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                     stroke-width="2" d="m1 9 4-4-4-4" />
                             </svg>
                             <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Settings') }}</span>
                         </div>
                     </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Payment') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Payout') }}</span>
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
        @include('components.common.info_message')
       <!--Row-1-->
       <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
          <!-- card -->
          <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
             <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">
                <!--customer-form-->
                <div id="accordion-collapse" data-accordion="collapse">
                   <h2 id="accordion-collapse-heading-paypal">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-b-0 border-neutral-200 rounded-t-xl focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-paypal" aria-controls="accordion-collapse-body-paypal">
                         <span class="text-black dark:text-white">Paypal - Instant payment available</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-paypal" class="hidden" aria-labelledby="accordion-collapse-heading-paypal">
                    <form class="mx-auto validated-form" id="paymentPaypalForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[0]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Paypal" required disabled>
                        </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Paypal Email ID:</label>
                            <input type="text" name="pppaymentsettings_accname" id="pppaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pppaymentsettings_accname-error"  data-validate
                            data-error-id="pppaymentsettings_accname-error"
                            data-validation-type="text"value="{{ $preFill[$payment_settings[0]['paymentsettings_id']]['pppaymentsettings_accname'] ?? $payment_settings[0]['paymentsettings_accname'] ?? '' }}" >
                            <p id="pppaymentsettings_accname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account name.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Client ID:</label>
                            <input type="text" name="pppaymentsettings_accnum" id="pppaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pppaymentsettings_accnum-error"  data-validate
                            data-error-id="pppaymentsettings_accnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[0]['paymentsettings_accnum']}}" >
                            <p id="paypal_client-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid ID.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Secret ID:</label>
                            <input type="text" name="paypal_client_secret" id="paypal_client_secret" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="paypal_client_secret-error"  data-validate
                            data-error-id="paypal_client_secret-error"
                            data-validation-type="text"value="{{ $preFill[$payment_settings[0]['paymentsettings_id']]['fields']['paypal_client_secret'] ?? '' }}">
                            <p id="paypal_client_secret-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid ID.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Mode :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[0]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="sandbox" {{ $payment_settings[0]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>Sandbox</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspaypal" {{ $payment_settings[0]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statuspaypal" {{ $payment_settings[0]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpaypal" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpaypal-error" data-validate
                                  data-error-id="otpvalidpaypal-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpaypal-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Bankwire</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBankwireForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[1]['paymentsettings_id']}}">
                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Bankwire" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusbankwire" {{ $payment_settings[1]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidbankwire" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidbankwire-error" data-validate
                                  data-error-id="otpvalidbankwire-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidbankwire-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                       <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                        <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                        Submit
                        </button>
                        <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                        Cancel
                        </button>
                     </div>
                    </form>
                    </div>
                 </div>

                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-perfectmoney" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Perfect Money - Instant payment available</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-perfectmoney" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentPerfectMoneyForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[2]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                      <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Perfect Money" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Account Number:</label>
                            <input type="text" name="pmpaymentsettings_accnum" id="pmpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pmpaymentsettings_accnum-error"  data-validate
                            data-error-id="pmpaymentsettings_accnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[2]['paymentsettings_accnum']}}" >
                            <p id="pmpaymentsettings_accnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Account Password:</label>
                            <input type="text" name="pm_accountpassword" id="pm_accountpassword" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pm_accountpassword-error"  data-validate
                            data-error-id="pm_accountpassword-error"
                            data-validation-type="text"  value="{{ $preFill[$payment_settings->firstWhere(fn($s) => strtolower(trim($s->paymentsettings_default_name ?? $s->paymentsettings_name ?? '')) === 'perfectmoney' || strtolower(trim($s->paymentsettings_default_name ?? $s->paymentsettings_name ?? '')) === 'perfect money')?->paymentsettings_id]['fields']['pm_accountpassword'] ?? '' }}">
                            <p id="pm_accountpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Wallet ID:</label>
                            <input type="text" name="pmpaymentsettings_accname" id="pmpaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pmpaymentsettings_accname-error"  data-validate
                            data-error-id="pmpaymentsettings_accname-error"
                            data-validation-type="text"  value="{{ $payment_settings[2]['paymentsettings_accname']}}" >
                            <p id="paymentsettings_accname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Mode :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[2]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="sandbox" {{ $payment_settings[2]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>Sandbox</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusperfectmoney" {{ $payment_settings[2]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statusperfectmoney" {{ $payment_settings[2]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidperfectmoney" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidperfectmoney-error" data-validate
                                  data-error-id="otpvalidperfectmoney-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidperfectmoney-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-bitpay-bitcoin" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Bitpay Bitcoin</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-bitpay-bitcoin" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBitpayForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[3]['paymentsettings_id']}}">
                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Bitpay Bitcoin" required disabled>
                         </div>

                      <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusbitcoin" {{ $payment_settings[3]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidbitcoin" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidbitcoin-error" data-validate
                                  data-error-id="otpvalidbitcoin-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidbitcoin-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-skrill" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Skrill</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-skrill" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentSkrillForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[4]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                      <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Skrill" required disabled>
                         </div>

                      <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusskrill" {{ $payment_settings[4]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidskrill" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidskrill-error" data-validate
                                  data-error-id="otpvalidskrill-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidskrill-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-payeer" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Payeer</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-payeer" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentPayeerForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[5]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                      <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Payeer" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Account Number:</label>
                            <input type="text" name="pm_accountno" id="pm_accountno" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pmpaymentsettingsaccnum-error"  data-validate
                            data-error-id="pmpaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[5]['paymentsettings_id'] ]['fields']['pm_accountno'] ?? '' }}">
                            <p id="pmpaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">APT ID:</label>
                            <input type="text" name="payeer_api_id" id="payeer_api_id" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="payeer_api_id-error"  data-validate
                            data-error-id="payeer_api_id-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[5]['paymentsettings_id'] ]['fields']['payeer_api_id'] ?? '' }}">
                            <p id="payeer_api_id-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Key:</label>
                            <input type="text" name="payeer_api_key" id="payeer_api_key" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="payeer_api_key-error"  data-validate
                            data-error-id="payeer_api_key-error"
                            data-validation-type="text" value="{{ $preFill[ $payment_settings[5]['paymentsettings_id'] ]['fields']['payeer_api_key'] ?? '' }}">
                            <p id="payeer_api_key-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Mode :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[5]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="sandbox" {{ $payment_settings[5]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>Sandbox</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspayeer" {{ $payment_settings[5]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statuspayeer" {{ $payment_settings[5]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpayeer" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpayeer-error" data-validate
                                  data-error-id="otpvalidpayeer-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpayeer-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>

                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-solid-trust-pay" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Solid Trust Pay</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-solid-trust-pay" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentSTPForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[6]['paymentsettings_id']}}">
                        <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Solid Trust Pay" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statussolidtrustpay" {{ $payment_settings[6]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidsolidtrustpay" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidsolidtrustpay-error" data-validate
                                  data-error-id="otpvalidsolidtrustpay-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidsolidtrustpay-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-web-money" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Web Money</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-web-money" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentWebmoneyForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[7]['paymentsettings_id']}}">
                        <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Web Money" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuswebmoney" {{ $payment_settings[7]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidwebmoney" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidwebmoney-error" data-validate
                                  data-error-id="otpvalidwebmoney-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidwebmoney-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-cheque" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Cheque</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-cheque" class="hidden" aria-labelledby="accordion-collapse-heading-3">

                    <form class="mx-auto validated-form" id="paymentChequeForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                        @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[8]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Cheque" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuscheque" {{ $payment_settings[8]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidcheque" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidcheque-error" data-validate
                                  data-error-id="otpvalidcheque-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidcheque-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>

                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-authorizenet" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Authorizenet</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-authorizenet" class="hidden" aria-labelledby="accordion-collapse-heading-3">

                    <form class="mx-auto validated-form" id="paymentAuthorizenetForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                        @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[12]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Authorizenet" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusauthorizenet" {{ $payment_settings[12]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidauthorizenet" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidauthorizenet-error" data-validate
                                  data-error-id="otpvalidauthorizenet-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidauthorizenet-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>

                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-paypal-pro" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Paypal Pro</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-paypal-pro" class="hidden" aria-labelledby="accordion-collapse-heading-3">

                    <form class="mx-auto validated-form" id="paymentPaypalProForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                        @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[13]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Paypal Pro" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspaypalpro" {{ $payment_settings[13]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpaypalpro" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpaypalpro-error" data-validate
                                  data-error-id="otpvalidpaypalpro-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpaypalpro-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>

                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>

                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-advCash" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">AdvCash - Instant payment available</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-advCash" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentAdvCashForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[14]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="AdvCash" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Email:</label>
                            <input type="text" name="adv_email" id="adv_email" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="adv_email-error"  data-validate
                            data-error-id="adv_email-error"
                            data-validation-type="text"
                            value="{{ $preFill[ $payment_settings[14]['paymentsettings_id'] ]['fields']['adv_email'] }}">

                            <p id="adv_email-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid Email.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">API Username:</label>
                            <input type="text" name="adv_api_name" id="adv_api_name" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="adv_api_name-error"  data-validate
                            data-error-id="adv_api_name-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[14]['paymentsettings_id'] ]['fields']['adv_api_name'] }}">
                            <p id="adv_api_name-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid Username.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">API Password:</label>
                            <input type="text" name="adv_api_password" id="adv_api_password" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="adv_api_password-error"  data-validate
                            data-error-id="adv_api_password-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[14]['paymentsettings_id'] ]['fields']['adv_api_password'] }}">
                            <p id="adv_api_password-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account number.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Mode :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[14]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="sandbox" {{ $payment_settings[14]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>Sandbox</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusadvcash" {{ $payment_settings[14]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statusadvcash" {{ $payment_settings[14]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidadvcash" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidadvcash-error" data-validate
                                  data-error-id="otpvalidadvcash-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidadvcash-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-coin-payment" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Coin Payment - Instant payment available</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-coin-payment" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentCoinForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[15]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Coin Payment" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Public Key:</label>
                            <input type="text" name="public_key" id="public_key" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="public_key-error"  data-validate
                            data-error-id="public_key-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[15]['paymentsettings_id'] ]['fields']['public_key'] }}">
                            <p id="public_key-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid Key.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Private Key:</label>
                            <input type="text" name="private_key" id="private_key" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="private_key-error"  data-validate
                            data-error-id="private_key-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[15]['paymentsettings_id'] ]['fields']['private_key'] }}">
                            <p id="private_key-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid Key.</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Mode :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[15]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="sandbox" {{ $payment_settings[15]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>Sandbox</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuscoinpayment" {{ $payment_settings[15]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statuscoinpayment" {{ $payment_settings[15]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidcoinpayment" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidcoinpayment-error" data-validate
                                  data-error-id="otpvalidcoinpayment-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidcoinpayment-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>

                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-blockIo" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">BlockIo</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-blockIo" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBlockIoForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[16]['paymentsettings_id']}}">
                        <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="BlockIo" required disabled>
                         </div>


                      <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusblockio" {{ $payment_settings[16]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidblockio" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidblockio-error" data-validate
                                  data-error-id="otpvalidblockio-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidblockio-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                       <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                        <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                        Submit
                        </button>
                        <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                        Cancel
                        </button>
                     </div>
                    </form>
                    </div>
                 </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-credit-debit" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Stripe - Instant payment available</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-credit-debit" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentStripeForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[17]['paymentsettings_id']}}">

                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Stripe" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Private Key:</label>
                            <input type="text" name="private_key" id="private_key" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="private_key-error"  data-validate
                            data-error-id="private_key-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[17]['paymentsettings_id'] ]['fields']['private_key'] }}">
                            <p id="private_key-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid Key.</p>
                         </div>

                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statusstripe" {{ $payment_settings[17]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statusstripe" {{ $payment_settings[17]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidstripe" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidstripe-error" data-validate
                                  data-error-id="otpvalidstripe-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidstripe-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-chargebee" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Chargebee</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-chargebee" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentChargeBeeForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[18]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Chargebee" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuschargebee" {{ $payment_settings[18]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidchargebee" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidchargebee-error" data-validate
                                  data-error-id="otpvalidchargebee-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidchargebee-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                       <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                        <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                        Submit
                        </button>
                        <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                        Cancel
                        </button>
                     </div>
                    </form>
                    </div>
                 </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-payquicker" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">Payquicker - Instant payment available</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-payquicker" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentPayquickerForm" method="POST" novalidate action="{{$_ENV['BCPATH']}}/withdrawpaymentsettings/withdrawupdate" enctype="multipart/form-data">
                    @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[19]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Payment gateway Name</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed" value="Payquicker" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Email ID:</label>
                            <input type="text" name="pppaymentsettings_accnum" id="pppaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pppaymentsettingsaccnum-error"  data-validate
                            data-error-id="pppaymentsettingsaccnum-error"
                            data-validation-type="text"value="{{ $preFill[ $payment_settings[19]['paymentsettings_id'] ]['fields']['pppaymentsettings_accnum'] ?? '' }}">
                            <p id="pppaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid payment account name.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Client ID:</label>
                            <input type="text" name="paypal_client" id="paypal_client" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="paypal_client-error"  data-validate
                            data-error-id="paypal_client-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[19]['paymentsettings_id'] ]['fields']['paypal_client'] }}">
                            <p id="paypal_client-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid ID.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Secret ID:</label>
                            <input type="text" name="paypal_client_secret" id="paypal_client_secret" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="paypal_client_secret-error"  data-validate
                            data-error-id="paypal_client_secret-error"
                            data-validation-type="text"  value="{{ $preFill[ $payment_settings[19]['paymentsettings_id'] ]['fields']['paypal_client_secret'] }}">
                            <p id="paypal_client_secret-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid ID.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">Mode :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[19]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="sandbox" {{ $payment_settings[19]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>Sandbox</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Status:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspayquicker" {{ $payment_settings[19]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-4">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">Instant Withdraw Status :</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="instantpayout_status" id="instantpayout_statuspayquicker" {{ $payment_settings[19]['instantpayout_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">OTP :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpayquicker" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpayquicker-error" data-validate
                                  data-error-id="otpvalidpayquicker-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpayquicker-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid OTP.</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP();">
                               Send OTP to mail
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            Submit
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            Cancel
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                </div>
               <!--customer-form-->
               <div class="flex flex-col">
                   <!--image-space-->
                   <img src="/assets/img/illustrations/recruitment.svg" alt="add-customer" class="w-full sticky top-0 overflow-hidden">
                   <!--image-space-->
                </div>
          </div>
       </div>
    </div>
 </main>

<script>
let otpTimers = {};
let verifying = false;

async function sendOTP(button) {
    if (verifying) return;

    button.disabled = true;
    button.innerHTML = '<span class="animate-pulse">Sending...</span>';

    try {
        const response = await fetch("{{ route('admin.withdraw-payments.send-otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                title: 'OTP Sent',
                text: data.message || 'Check your email (valid for 60 seconds)',
                icon: 'success',
                timer: 2500,
                showConfirmButton: false
            });

            startOtpCountdown(button);
        } else {
            Swal.fire({
                title: 'Failed',
                text: data.message || 'Could not send OTP',
                icon: 'error'
            });
        }
    } catch (err) {
        console.error(err);
        Swal.fire('Error', 'Network error. Try again.', 'error');
    } finally {
        button.disabled = false;
        button.textContent = 'Send OTP';
    }
}


function startOtpCountdown(button) {
    const container = button.closest('.space-y-3, .flex, .mb-6');
    let timerEl = container.querySelector('.otp-timer');

    if (!timerEl) {
        timerEl = document.createElement('div');
        timerEl.className = 'otp-timer text-sm text-blue-600 mt-1';
        container.appendChild(timerEl);
    }

    let seconds = 60;
    timerEl.textContent = `Resend available in ${seconds}s`;

    const interval = setInterval(() => {
        seconds--;
        timerEl.textContent = seconds > 0 ? `Resend available in ${seconds}s` : '';

        if (seconds <= 0) {
            button.disabled = false;
            button.textContent = 'Send OTP';
            clearInterval(interval);
        }
    }, 1000);

    const formId = button.closest('form')?.id || 'global';
    if (otpTimers[formId]) clearInterval(otpTimers[formId]);
    otpTimers[formId] = interval;
}

async function verifyOtp(input) {
    if (verifying) return;
    if (input.value.length !== 6) return;

    verifying = true;

    const messageEl = document.getElementById(input.getAttribute('data-error-id'));

    // Reset classes
    input.classList.remove('border-red-500', 'border-green-500', 'bg-green-50/50');
    input.classList.add('border-yellow-500');

    if (messageEl) {
        messageEl.classList.remove('text-green-600', 'text-red-600', 'hidden');
        messageEl.classList.add('text-yellow-600');
        messageEl.textContent = 'Verifying...';
    }

    try {
        const response = await fetch("{{ route('admin.withdraw-payments.verify-otp') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({ otp: input.value.trim() })
        });

        const data = await response.json();

        if (data.success) {
            input.classList.remove('border-yellow-500', 'border-red-500');
            input.classList.add('border-green-500', 'bg-green-50/50');

            if (messageEl) {
                messageEl.classList.remove('text-yellow-600', 'text-red-600');
                messageEl.classList.add('text-green-600');
                messageEl.textContent = '✓ OTP verified successfully';
            }

            input.closest('form').dataset.otpVerified = 'true';
        } else {
            input.classList.remove('border-yellow-500');
            input.classList.add('border-red-500');

            if (messageEl) {
                messageEl.classList.remove('text-yellow-600', 'text-green-600');
                messageEl.classList.add('text-red-600');
                messageEl.textContent = data.message || 'Invalid OTP';
            }

            input.closest('form').dataset.otpVerified = 'false';
        }
    } catch (err) {
        console.error(err);

        input.classList.remove('border-yellow-500');
        input.classList.add('border-red-500');

        if (messageEl) {
            messageEl.classList.remove('text-yellow-600', 'text-green-600');
            messageEl.classList.add('text-red-600');
            messageEl.textContent = 'Something went wrong – please try again';
        }
    } finally {
        verifying = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Send OTP buttons
    document.querySelectorAll('.otpbutton').forEach(btn => {
        btn.addEventListener('click', () => sendOTP(btn));
    });

    // OTP input – real-time validation + paste support
    document.querySelectorAll('input[data-validation-type="otp"]').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');

            if (this.value.length === 6) {
                verifyOtp(this);
            } else {
                this.classList.remove('border-green-500', 'border-red-500', 'border-yellow-500', 'bg-green-50/50');
                const msg = document.getElementById(this.getAttribute('data-error-id'));
                if (msg) {
                    msg.textContent = '';
                    msg.classList.add('hidden');
                }
            }
        });

        // Paste handling
        input.addEventListener('paste', function () {
            setTimeout(() => {
                if (this.value.length === 6) {
                    verifyOtp(this);
                }
            }, 100);
        });
    });

    // Form submit protection
    document.querySelectorAll('form.validated-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (this.dataset.otpVerified !== 'true') {
                e.preventDefault();
                Swal.fire({
                    title: 'OTP Required',
                    text: 'Please enter and verify a valid OTP before submitting.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                     customClass: {
                        popup: 'bg-white rounded-lg shadow-lg',
                        title: 'text-xl font-semibold text-black',
                        text: 'text-sm text-black',
                        confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-medium rounded-lg'
                    }
                });
            }
        });
    });
});
</script>
@endsection
