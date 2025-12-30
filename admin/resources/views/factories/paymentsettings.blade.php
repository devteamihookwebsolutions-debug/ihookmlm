@extends('admin::components.common.main')

@section('content')

<style>
.otp-disabled {
    pointer-events: none;
    opacity: 0.6;
    filter: blur(0.6px);
    cursor: not-allowed;
}

</style>

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
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Settings

                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>

                        <a href="#"
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Personalization

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
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Payment Settings</span>
                    </div>
                </li>
            </ol>
    </div>

<!-- breadcrub navs end-->
<main class="flex-grow">

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
                         <span class="text-black dark:text-white">{{ __('Paypal') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-paypal" class="hidden" aria-labelledby="accordion-collapse-heading-paypal">
                    <form class="mx-auto validated-form" id="paymentPaypalForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                        @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[0]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="paymentsettings_name" id="paymentsettings_name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Paypal" value="Paypal" required aria-describedby="paymentsettingsname-error" >
                               <p id="paymentsettingsname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment setting name') }}.</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Paypal Email ID') }}:</label>
                            <input type="text" name="pppaymentsettings_accnum" id="pppaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pppaymentsettingsaccnum-error"  data-validate
                            data-error-id="pppaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[0]['paymentsettings_accnum']}}" >
                            <p id="pppaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Paypal Mode') }} :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[0]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[0]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_statuspaypal" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status') }}:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspaypal-1" {{ $payment_settings[0]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP') }}:</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpaypal" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpaypal-error" data-validate
                                  data-error-id="otpvalidpaypal-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpaypal-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap"  onclick="sendOTP(this, 'paypal')">{{ __('Send OTP to mail') }}

                               </button>

                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Bankwire') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBankwireForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[1]['paymentsettings_id']}}">
                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                       <div class="mb-4">
                          <label for="payment-name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment Gateway Name') }}</label>
                          <input type="text" name="payment_name" id="payment-name"
                             class="text-sm rounded-lg
                             focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                             dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                             dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                             cursor-not-allowed"
                             placeholder="Bankwire" value="Bankwire" required disabled aria-label="Payment Gateway Name">
                          <p class="text-red-500 text-sm mt-1 hidden" id="payment-name-error">{{ __('This field is required.') }}</p>
                       </div>
                       <div class="mb-4">
                          <label for="account-name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Account Name') }}</label>
                          <input type="text" name="bwpaymentsettings_accname" id="bwpaymentsettings_accname"
                             class="text-sm rounded-lg focus:ring-primary-600
                             focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500
                             dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Account Name" value="{{$payment_settings[1]['paymentsettings_accname']}}" required aria-label="bwpaymentsettingsaccname-error">
                          <p class="text-red-500 text-sm mt-1 hidden" id="bwpaymentsettingsaccname-error">{{ __('This field is required.') }}</p>
                       </div>
                       <div class="mb-4">
                          <label for="account-number" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Account Number') }}</label>
                          <input type="text" name="bwpaymentsettings_accnum" id="bwpaymentsettings_accnum"
                             class="text-sm rounded-lg focus:ring-primary-600
                             focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500
                             dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Account Number" value="{{ $payment_settings[1]['paymentsettings_accnum']}}" required aria-label="bwpaymentsettingsaccnum-error" data-validate
                             data-error-id="bwpaymentsettingsaccnum-error"
                             data-validation-type="text">
                          <p class="text-red-500 text-sm mt-1 hidden" id="bwpaymentsettingsaccnum-error">{{ __('This field is required.') }}</p>
                       </div>
                       <div class="mb-4">
                          <label for="bank-address" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Bank Address') }}</label>
                          <textarea id="bankwire_address" name="bankwire_address" rows="4"
                             class="block p-2.5 w-full text-sm text-black dark:text-white bg-neutral-50 rounded-lg
                             focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800
                             dark:placeholder-neutral-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                             placeholder="100 Broadway" required aria-label="bankwireaddress-error" data-validate
                             data-error-id="bankwireaddress-error"
                             data-validation-type="text">{{ $bankwire_payment_settings['bankwire_address']}}</textarea>
                          <p class="text-red-500 text-sm mt-1 hidden" id="bankwireaddress-error">{{ __('This field is required') }}.</p>
                       </div>
                       <div class="mb-4">
                          <label for="switch-code" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Bankwire Switch Code') }}</label>
                          <input type="text" name="bankwire_swift_code" id="bankwire_swift_code"
                             class="text-sm rounded-lg focus:ring-primary-600
                             focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500
                             dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Switch Code" value="32165478" required aria-label="bankwireswiftcode-error" data-validate
                             data-error-id="bankwireswiftcode-error"
                             data-validation-type="text" value="{{ $bankwire_payment_settings['bankwire_swift_code']}}">
                          <p class="text-red-500 text-sm mt-1 hidden" id="bankwireswiftcode-error">{{ __('This field is required.') }}</p>
                       </div>
                       <div class="mb-4">
                          <label for="bank-route" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Bank Route') }}</label>
                          <input type="text" name="bankwire_route" id="bankwire_route"
                             class="text-sm rounded-lg focus:ring-primary-600
                             focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500
                             dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Bank Route" value="321" required aria-label="bankroute-error" data-validate
                             data-error-id="bankroute-error"
                             data-validation-type="text" value="{{ $bankwire_payment_settings['bankwire_route']}}">
                          <p class="text-red-500 text-sm mt-1 hidden" id="bankroute-error">{{ __('This field is required.') }}</p>
                       </div>
                       <div class="mb-4">
                        <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status') }}:</label>
                        <label class="inline-flex items-center cursor-pointer">
                           <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[1]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                           <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                        </label>
                     </div>
                       <div class="mb-10">
                          <label for="otp" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP') }}</label>
                        <div class="flex items-center mx-auto">
                            <div class="relative w-full">
                               <input type="text" id="otpvalidbankwire" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidbankwire-error" data-validate
                               data-error-id="otpvalidbankwire-error"
                               data-validation-type="otp" >
                               <p id="otpvalidbankwire-error" class="absolute error-message mt-2 mb-5 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                            </div>
                            <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'bankwire');">
                            {{ __('Send OTP to mail') }}
                            </button>
                         </div>
                          <p class="text-red-500 text-sm mt-1 hidden" id="otp-error">{{ __('This field is required') }}.</p>
                       </div>
                       <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                        <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                        {{ __('Submit') }}
                        </button>
                        <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                        {{ __('Cancel') }}
                        </button>
                     </div>
                    </form>
                    </div>
                 </div>

                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-perfectmoney" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Perfect Money') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-perfectmoney" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentPerfectMoneyForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[2]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Perfect Money" value="Perfect Money" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Account Name') }}:</label>
                            <input type="text" name="pmpaymentsettings_accname" id="pmpaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pmpaymentsettingsaccname-error"  data-validate
                            data-error-id="pmpaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[2]['paymentsettings_accname']}}" >
                            <p id="pmpaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Account Number') }}:</label>
                            <input type="text" name="pmpaymentsettings_accnum" id="pmpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pmpaymentsettingsaccnum-error"  data-validate
                            data-error-id="pmpaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[2]['paymentsettings_accnum']}}" >
                            <p id="pmpaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account number.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="paymentsettings_statuspm" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status') }}:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspm" {{ $payment_settings[2]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP') }} :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpm" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpm-error" data-validate
                                  data-error-id="otpvalidpm-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpm-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'PerfectMoney');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-bitpay-bitcoin" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Bitpay Bitcoin') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-bitpay-bitcoin" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBitpayForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[3]['paymentsettings_id']}}">
                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Bitpay Bitcoin" value="Bitpay Bitcoin" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Key') }}:</label>
                            <input type="text" name="bipaymentsettings_accname" id="bipaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="bipaymentsettingsaccnum-error"  data-validate
                            data-error-id="bipaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[3]['paymentsettings_accnum']}}" >
                            <p id="bipaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment api key.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode') }} :</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[3]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[3]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>
                             </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_statuspaypal" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status') }}:</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspaypal-2" {{ $payment_settings[3]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>




                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP') }} :</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidbitpay" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidbitpay-error" data-validate
                                  data-error-id="otpvalidbitpay-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidbitpay-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'BitpayBitcoin');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-skrill" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Skrill') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-skrill" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentSkrillForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                    <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[4]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Skrill" value="Skrill" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Merchant Email ID:') }}</label>
                            <input type="text" name="skpaymentsettings_accnum" id="skpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="skpaymentsettingsaccnum-error"  data-validate
                            data-error-id="skpaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[4]['paymentsettings_accnum']}}" >
                            <p id="skpaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[4]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>


                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidskril" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidskril-error" data-validate
                                  data-error-id="otpvalidskril-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidskril-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Skrill');">
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
                         <span class="text-black dark:text-white">{{ __('Payeer') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-payeer" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentPayeerForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[5]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Payeer" value="Payeer" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Merchant ID:') }}</label>
                            <input type="text" name="payeerpaymentsettings_accname" id="payeerpaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="payeerpaymentsettingsaccname-error"  data-validate
                            data-error-id="payeerpaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[5]['paymentsettings_accname']}}" >
                            <p id="payeerpaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment merchant ID.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Merchant Key:') }}</label>
                            <input type="text" name="payeerpaymentsettings_accnum" id="payeerpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="payeerpaymentsettingsaccnum-error"  data-validate
                            data-error-id="payeerpaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[5]['paymentsettings_accnum']}}" >
                            <p id="payeerpaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment merchant key.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[5]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[5]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[5]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>


                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidpayeer" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpayeer-error" data-validate
                                  data-error-id="otpvalidpayeer-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidpayeer-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Payeer');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>

                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-solid-trust-pay" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Solid Trust Pay') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-solid-trust-pay" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentSTPForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[6]['paymentsettings_id']}}">
                        <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Solid Trust Pay" value="Solid Trust Pay" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Merchant Email ID:') }}</label>
                            <input type="text" name="stppaymentsettings_accnum" id="stppaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="stppaymentsettingsaccnum-error"  data-validate
                            data-error-id="stppaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[6]['paymentsettings_accnum']}}" >
                            <p id="stppaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment merchant email ID.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[6]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[6]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[6]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>


                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidstp" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidstp-error" data-validate
                                  data-error-id="otpvalidstp-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidstp-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'STP');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-cheque" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Cheque') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-cheque" class="hidden" aria-labelledby="accordion-collapse-heading-3">

                    <form class="mx-auto validated-form" id="paymentChequeForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf

                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[7]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Cheque" value="Cheque" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Paypal Email ID:') }}</label>
                            <input type="text" name="chequepaymentsettings_accname" id="chequepaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="chequepaymentsettingsaccname-error"  data-validate
                            data-error-id="chequepaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[7]['paymentsettings_accname']}}" >
                            <p id="chequepaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[7]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidcheque" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidcheque-error" data-validate
                                  data-error-id="otpvalidcheque-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidcheque-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Cheque');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>

                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-e-wallet" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('E-Wallet') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-e-wallet" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentEwalletForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[8]['paymentsettings_id']}}">
                    <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="E-Wallet" value="E-Wallet" required disabled>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidewallet" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidewallet-error" data-validate
                                  data-error-id="otpvalidewallet-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidewallet-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'E-Wallet');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-epin" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('E-Pin') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-epin" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentEpinForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[9]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="E-Pin" value="E-Pin" required disabled>
                         </div>
                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidepin" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidepin-error" data-validate
                                  data-error-id="otpvalidepin-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidepin-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'E-Pin');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-admin-credits" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Admin Credits') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                     <div id="accordion-collapse-body-admin-credits" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Admin Credits" value="Admin Credits" required disabled>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                            Submit
                            </button>
                            <button type="submit" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                            Cancel
                            </button>
                         </div>
                      </div>
                   </div>

                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-authorizenet" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Authorizenet') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-authorizenet" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentAuthorizenetForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[11]['paymentsettings_id']}}">
                        <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Authorizenet" value="Authorizenet" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Login ID:') }}</label>
                            <input type="text" name="aunetpaymentsettings_accname" id="aunetpaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="aunetpaymentsettingsaccname-error"  data-validate
                            data-error-id="aunetpaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[11]['paymentsettings_accname']}}" >
                            <p id="aunetpaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment login ID.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Transaction Key:') }}</label>
                            <input type="text" name="aunetpaymentsettings_accnum" id="aunetpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="aunetpaymentsettingsaccnum-error"  data-validate
                            data-error-id="aunetpaymentsettingsaccnum-error"
                            data-validation-type="text" value="{{ $payment_settings[11]['paymentsettings_accnum']}}" >
                            <p id="aunetpaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment transaction key.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[11]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[11]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[11]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>

                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidaunet" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidaunet-error" data-validate
                                  data-error-id="otpvalidaunet-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidaunet-error" class=" error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Authorizenet');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-paypal-pro" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Paypal Pro') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-paypal-pro" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentPaypalProForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[12]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Paypal Pro" value="Paypal Pro" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Username :') }}</label>
                            <input type="text" name="paypalpropaymentsettings_accname" id="paypalpropaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="paypalpropaymentsettingsaccname-error"  data-validate
                            data-error-id="paypalpropaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[12]['paymentsettings_accname']}}" >
                            <p id="paypalpropaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment API username.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Password :') }}</label>
                            <input type="text" name="paypalpropaymentsettings_accnum" id="paypalpropaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="paypalpropaymentsettingsaccnum-error"  data-validate
                            data-error-id="paypalpropaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[12]['paymentsettings_accnum']}}" >
                            <p id="paypalpropaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment API password.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Signature :') }}</label>
                            <input type="text" name="paypal_signature" id="paypal_signature" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="paypalsignature-error"  data-validate
                            data-error-id="paypalsignature-error"
                            data-validation-type="text"  value="{{ $payment_settings[12]['paymentsettings_accnum']}}" >
                            <p id="paypalsignature-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment API signature.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[12]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[12]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_statuspaypal" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_statuspaypal-3" {{ $payment_settings[12]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>




                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
              <input type="text" id="otpvalidpaypalpro" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidpaypalpro-error" data-validate
                                  data-error-id="otpvalidpaypalpro-error"
                                  data-validation-type="otp" >
                               <p id="otpvalidpaypalpro-error"
   class="error-message mt-2 text-sm hidden">{{ __('Please enter a valid OTP.') }}
</p>


                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'PaypalPro');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>


                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-advCash" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('AdvCash') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-advCash" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentAdvCashForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[13]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="AdvCash" value="AdvCash" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Merchants account number:') }}</label>
                            <input type="text" name="advpaymentsettings_accname" id="advpaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="advpaymentsettingsaccname-error"  data-validate
                            data-error-id="advpaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[13]['paymentsettings_accname']}}" >
                            <p id="advpaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account number.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('SCI Name:') }}</label>
                            <input type="text" name="advcash_sciname" id="advcash_sciname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="pppaymentsettingsaccnum-error"  data-validate
                            data-error-id="advcashsciname-error"
                            data-validation-type="text"  value="{{ $payment_settings[13]['paymentsettings_accnum']}}" >
                            <p id="pppaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment SCI name.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('SCI Password:') }}</label>
                            <input type="text" name="advcash_password" id="advcash_password" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required aria-describedby="advcashpassword-error"  data-validate
                            data-error-id="advcashpassword-error"
                            data-validation-type="text"  value="" >
                            <p id="advcashpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment SCI password.') }}</p>
                         </div>


                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[13]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>


                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidadvcash" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidadvcash-error" data-validate
                                  data-error-id="otpvalidadvcash-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidadvcash-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'AdvCash');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-coin-payment" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Coin Payment') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-coin-payment" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentCoinForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[14]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Coin Payment" value="Coin Payment" required disabled>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Merchant ID:') }}</label>
                            <input type="text" name="paymentsettings_accname" id="coinpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="coinpaymentsettingsaccname-error"  data-validate
                            data-error-id="coinpaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[14]['paymentsettings_accname']}}" >
                            <p id="coinpaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Debug mail:') }}</label>
                            <input type="text" name="paymentsettings_accnum" id="coinpaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="coinpaymentsettingsaccnum-error"  data-validate
                            data-error-id="coinpaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[14]['paymentsettings_accnum']}}" >
                            <p id="coinpaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid debug mail.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('IPN Secret:') }}</label>
                            <input type="text" name="ipn_secret" id="ipn_secret" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="ipnsecret-error"  data-validate
                            data-error-id="ipnsecret-error"
                            data-validation-type="text"  value="" >
                            <p id="ipnsecret-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid IPN Secret.') }}</p>
                         </div>



                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[14]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>




                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidcoin" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidcoin-error" data-validate
                                  data-error-id="otpvalidcoin-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidcoin-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'CoinPayment');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>

                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-blockIo" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('BlockIo') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-blockIo" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBlockIoForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[15]['paymentsettings_id']}}">
                        <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="BlockIo" value="BlockIo" required disabled>
                         </div>


                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('BlockIo API Key:') }}</label>
                            <input type="text" name="paymentsettings_accname" id="blockiopaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="blockiopaymentsettingsaccnum-error"  data-validate
                            data-error-id="blockiopaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[15]['paymentsettings_accname']}}" >
                            <p id="blockiopaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('BlockIo Pin:') }}</label>
                            <input type="text" name="blockio_pin" id="blockiopaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="blockiopaymentsettingsaccnum-error"  data-validate
                            data-error-id="blockiopaymentsettingsaccnum-error"
                            data-validation-type="text"  value="" >
                            <p id="pppaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account name.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('BlockIo Coin:') }}</label>

                            <select aria-label="label" name="blockio_coin_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" id="blockio_coin_mode" aria-invalid="false">
                                <option value="bitcoin" {{ $payment_settings[15]['paymentsettings_accnum'] === 'bitcoin' ? 'selected' : '' }}>{{ __('Bitcoin') }}</option>
                                <option value="dogecoin" {{ $payment_settings[15]['paymentsettings_accnum'] === 'dogecoin' ? 'selected' : '' }}>{{ __('Dogecoin') }}</option>
                                <option value="litecoin" {{ $payment_settings[15]['paymentsettings_accnum'] === 'litecoin' ? 'selected' : '' }}>{{ __('LiteCoin') }}</option>

                            </select>

                         </div>


                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[15]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[15]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[15]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>


                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidblockio" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidblockio-error" data-validate
                                  data-error-id="otpvalidblockio-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidblockio-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'BlockIoCoin');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>

                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-credit-debit" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Credit/Debit Card (Stripe)') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-credit-debit" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentStripeForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[16]['paymentsettings_id']}}">

                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Credit/Debit Card (Stripe)" value="Credit/Debit Card (Stripe)" required disabled>
                         </div>


                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Public Key:') }}</label>
                            <input type="text" name="paymentsettings_accname" id="stripepaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="stripepaymentsettingsaccname-error"  data-validate
                            data-error-id="stripepaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[16]['paymentsettings_accname']}}" >
                            <p id="stripepaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment public key.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Private Key:') }}</label>
                            <input type="text" name="paymentsettings_accnum" id="stripepaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="stripepaymentsettingsaccnum-error"  data-validate
                            data-error-id="stripepaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[16]['paymentsettings_accnum']}}" >
                            <p id="stripepaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account private key.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[16]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[16]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[16]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>




                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidstripe" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidstripe-error" data-validate
                                  data-error-id="otpvalidstripe-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidstripe-error" class=" error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Stripe');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-chargebee" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Chargebee') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-chargebee" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentChargeBeeForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id"value="{{ $payment_settings[17]['paymentsettings_id'] ?? '' }}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Chargebee" value="Chargebee" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('API Key:') }}</label>
                            <input type="text" name="paymentsettings_accname" id="chargebeepaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="chargebeepaymentsettingsaccname-error"  data-validate
                            data-error-id="chargebeepaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[17]['paymentsettings_accname']}}" >
                            <p id="chargebeepaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid API key.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Site:') }}</label>
                            <input type="text" name="paymentsettings_accnum" id="chargebeepaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="chargebeepaymentsettingsaccnum-error"  data-validate
                            data-error-id="chargebeepaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[17]['paymentsettings_accnum']}}" >
                            <p id="chargebeepaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account site.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[17]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[17]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[17]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>


                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                <input type="text"
                                    id="otpvalidchargebee"
                                    name="otpvalid"
                                    data-form="paymentChargeBeeForm"
                                    data-validate
                                    data-validation-type="otp"
                                    data-error-id="otpvalidchargebee-error"
                                    class="text-sm rounded-lg ..."
                                    required>

                                 <p id="otpvalidchargebee-error"
                                 class="absolute error-message mt-2 text-sm text-red-600 hidden">
                                 Please enter a valid OTP.
                              </p>

                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Chargebee');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                    </form>
                   </div>
                   <h2 id="accordion-collapse-heading-3">
                      <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-black border border-neutral-200 focus:ring-0 focus:ring-neutral-200 dark:focus:ring-neutral-800 dark:border-neutral-700 dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 gap-3" data-accordion-target="#accordion-collapse-body-binance" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                         <span class="text-black dark:text-white">{{ __('Binance') }}</span>
                         <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                         </svg>
                      </button>
                   </h2>
                   <div id="accordion-collapse-body-binance" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <form class="mx-auto validated-form" id="paymentBinanceForm" method="POST" novalidate action="{{ route('updatepaymentsettings') }}" enctype="multipart/form-data">
                     @csrf
                        <input aria-label="label" type="hidden" name="paymentsettings_id" value="{{ $payment_settings[18]['paymentsettings_id']}}">
                      <div class="p-5 border border-neutral-200 dark:border-neutral-700 dark:bg-neutral-900">
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Payment gateway Name') }}</label>
                            <input type="text" name="name" id="name"
                               class="text-sm rounded-lg
                               focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                               dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400
                               dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                               cursor-not-allowed"
                               placeholder="Binance" value="Binance" required disabled>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Public Key:') }}</label>
                            <input type="text" name="paymentsettings_accname" id="binancepaymentsettings_accname" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="binancepaymentsettingsaccname-error"  data-validate
                            data-error-id="binancepaymentsettingsaccname-error"
                            data-validation-type="text"  value="{{ $payment_settings[18]['paymentsettings_accname']}}" >
                            <p id="binancepaymentsettingsaccname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment public key.') }}</p>
                         </div>
                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Private Key:') }}</label>
                            <input type="text" name="paymentsettings_accnum" id="binancepaymentsettings_accnum" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="pay@paypal.com" required aria-describedby="binancepaymentsettingsaccnum-error"  data-validate
                            data-error-id="binancepaymentsettingsaccnum-error"
                            data-validation-type="text"  value="{{ $payment_settings[18]['paymentsettings_accnum']}}" >
                            <p id="binancepaymentsettingsaccnum-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid payment account private key.') }}</p>
                         </div>

                         <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Mode :') }}</label>
                            <select id="paymentsettings_mode" name="paymentsettings_mode" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                <option value="live" {{ $payment_settings[18]['paymentsettings_mode'] == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
                                <option value="sandbox" {{ $payment_settings[18]['paymentsettings_mode'] == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>

                            </select>
                         </div>
                         <div class="mb-4">
                            <label for="paymentsettings_status" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status:') }}</label>
                            <label class="inline-flex items-center cursor-pointer">
                               <input type="checkbox" value="1" class="sr-only peer" name="paymentsettings_status" id="paymentsettings_status" {{ $payment_settings[18]['paymentsettings_status'] == 'Active' ? 'checked' : '' }}>
                               <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-0 peer-focus:ring-neutral-300 dark:peer-focus:ring-neutral-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-600"></div>
                            </label>
                         </div>




                         <div class="mb-10">
                            <label for="name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('OTP :') }}</label>
                            <div class="flex items-center mx-auto">
                               <div class="relative w-full">
                                  <input type="text" id="otpvalidbinance" name="otpvalid" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-4 p-2.5  dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required aria-describedby="otpvalidbinance-error" data-validate
                                  data-error-id="otpvalidbinance-error"
                                  data-validation-type="otp" >
                                  <p id="otpvalidbinance-error" class="absolute error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Please enter a valid OTP.') }}</p>
                               </div>
                               <button type="button" class="otpbutton inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-neutral-700 rounded-lg border border-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-neutral-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-800 whitespace-nowrap" onclick="sendOTP(this,'Binance');">
                               {{ __('Send OTP to mail') }}
                               </button>
                            </div>
                         </div>
                         <div class="flex justify-end gap-2 pt-6 mt-6 border-t">
                            <button type="submit" class="text-white inline-flex items-center bg-neutral-800 focus:outline-none hover:bg-neutral-800 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white dark:border-neutral-900 dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 bg-neutral-700 hover:bg-neutral-700">
                            {{ __('Submit') }}
                            </button>
                            <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>
                            {{ __('Cancel') }}
                            </button>
                         </div>
                      </div>
                   </form>
               </div>
           </div>
                <!--customer-form-->
                <div class="flex flex-col">
                   <!--image-space-->
                   <img src="{{ asset('assets/img/illustrations/recruitment.svg') }}" alt="add-customer" class="w-full sticky top-0 overflow-hidden">
                   <!--image-space-->
                </div>
             </div>
          </div>
       </div>

 </main>

<!--chat-drawer:starts-->
<script>

function sendOTP(button, gateway) {
    // Get the button that was clicked
    const btn = button;

    // Disable & blur the button immediately
    btn.disabled = true;
    btn.classList.add("otp-disabled");
    btn.textContent = "Sending OTP...";

    fetch("{{ route('otpsent') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({ gateway: gateway }) // Optional: send which gateway was clicked
    })
    .then(response => response.text())
    .then(result => {
        // Re-enable button after success
        btn.disabled = false;
        btn.classList.remove("otp-disabled");
        btn.textContent = "Resend OTP";

        Swal.fire({
            title: 'Success',
            text: 'OTP sent to mail',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bg-white rounded-lg shadow-lg',
                title: 'text-xl font-semibold text-black',
                text: 'text-sm text-black',
                confirmButton: 'bg-neutral-700 text-white hover:bg-neutral-600 font-medium rounded-lg'
            }
        });
    })
    .catch(error => {
        console.error("Error:", error);
        // Re-enable button on error
        btn.disabled = false;
        btn.classList.remove("otp-disabled");
        btn.textContent = "Send OTP to mail";

        Swal.fire({
            title: 'Error',
            text: 'Error sending OTP',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bg-white rounded-lg shadow-lg',
                title: 'text-xl font-semibold text-black',
                text: 'text-sm text-black',
                confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-medium rounded-lg'
            }
        });
    });
}


async function validateInput(inputId, errorId, type = '') {
    const input = document.getElementById(inputId);
    const errorMessage = document.getElementById(errorId);

    if (input.value.trim() === "") {
        errorMessage.classList.remove("hidden");
        errorMessage.textContent = "This field is required";
        errorMessage.classList.add("text-red-500");
        input.classList.add("border-red-500");
        input.classList.remove("border-neutral-300");
        return false
    }

    if (type === "otp") {
        try {
            const response = await fetch("{{ route('validateotp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content")
                },
                body: JSON.stringify({ otpvalid: input.value.trim() })
            });

            const result = await response.json();

            if (result.data === true) {
                errorMessage.classList.remove("hidden");
                errorMessage.textContent = "OTP Verified ✔";
                errorMessage.classList.remove("text-red-500");
                errorMessage.classList.add("text-green-500");

                input.classList.remove("border-red-500");
                input.classList.add("border-green-500");
                return true;
            }

            errorMessage.classList.remove("hidden");
            errorMessage.textContent = "Invalid OTP ✖";
            errorMessage.classList.remove("text-green-500");
            errorMessage.classList.add("text-red-500");

            input.classList.remove("border-green-500");
            input.classList.add("border-red-500");
            return false;

        } catch (error) {
            errorMessage.classList.remove("hidden");
            errorMessage.textContent = "OTP validation failed";
            errorMessage.classList.remove("text-green-500");
            errorMessage.classList.add("text-red-500");

            input.classList.remove("border-green-500");
            input.classList.add("border-red-500");
            return false;
        }
    }

    errorMessage.classList.add("hidden");
    input.classList.remove("border-red-500");
    input.classList.add("border-neutral-300");
    return true;
}

// let isOtpVerified = false; // Add this outside the function

// async function validateInput(inputId, errorId, type = '') {
//     const input = document.getElementById(inputId);
//     const errorMessage = document.getElementById(errorId);

//     // If OTP is already verified, don't reset it unless value changes
//     if (type === "otp" && isOtpVerified && input.value.trim() === "") {
//         return true;
//     }

//     if (type === "otp") {
//         // Reset only if not already verified
//         if (!isOtpVerified) {
//             errorMessage.classList.add("hidden");
//             errorMessage.classList.remove("text-green-500", "text-red-500");
//             input.classList.remove("border-green-500", "border-red-500");
//             input.classList.add("border-neutral-300");
//         }

//         if (input.value.trim() === "") {
//             return true;
//         }

//         try {
//             const response = await fetch("{{ route('validateotp') }}", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                     "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
//                 },
//                 body: JSON.stringify({ otpvalid: input.value.trim() })
//             });

//             const result = await response.json();

//             if (result.data === true) {
//                 errorMessage.classList.remove("hidden");
//                 errorMessage.textContent = "OTP Verified ✔";
//                 errorMessage.classList.add("text-green-500");

//                 input.classList.add("border-green-500");
//                 isOtpVerified = true; // Mark as verified
//                 return true;
//             } else {
//                 errorMessage.classList.remove("hidden");
//                 errorMessage.textContent = "Invalid OTP ✖";
//                 errorMessage.classList.add("text-red-500");
//                 input.classList.add("border-red-500");
//                 isOtpVerified = false;
//                 return false;
//             }
//         } catch (error) {
//             errorMessage.classList.remove("hidden");
//             errorMessage.textContent = "OTP validation failed";
//             errorMessage.classList.add("text-red-500");
//             input.classList.add("border-red-500");
//             isOtpVerified = false;
//             return false;
//         }
//     }

//     return true;
// }
// // Attach event listeners to all inputs dynamically
document.querySelectorAll("[data-validate]").forEach(input => {
    input.addEventListener("input", function() {
        const errorId = this.getAttribute("data-error-id");
        const validationType = this.getAttribute("data-validation-type");
        validateInput(this.id, errorId, validationType);
    });
});


function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) {
        console.warn(`Form with ID ${formId} not found`);
        return;
    }

    form.addEventListener("submit", async function(event) {
        event.preventDefault();

        console.log(`Validating form: ${formId}`);

        let isFormValid = true;

        const inputs = form.querySelectorAll("[data-validate]");
        for (const input of inputs) {
            const errorId = input.getAttribute("data-error-id");
            const validationType = input.getAttribute("data-validation-type");
            const isValid = await validateInput(input.id, errorId, validationType);

            if (!isValid) {
                isFormValid = false;
                // Do NOT break — let all fields show their errors
            }
        }

        if (isFormValid) {
            console.log("All fields valid. Submitting form...");
            form.submit(); // This will now submit the form
        } else {
            console.log("Form validation failed.");

        }
    });
}


// Call the validation function for both forms
validateForm("paymentPaypalForm");
validateForm("paymentBankwireForm");
validateForm("paymentPerfectMoneyForm");
validateForm("paymentBitpayForm");
validateForm("paymentSkrillForm");
validateForm("paymentPayeerForm");
validateForm("paymentSTPForm");
validateForm("paymentChequeForm");
validateForm('paymentAuthorizenetForm');
validateForm("paymentPaypalProForm");
validateForm("paymentAdvCashForm");
validateForm("paymentCoinForm");
validateForm("paymentBlockIoForm");
validateForm("paymentStripeForm");
validateForm("paymentChargeBeeForm");
validateForm("paymentBinanceForm");
</script>
@endsection
