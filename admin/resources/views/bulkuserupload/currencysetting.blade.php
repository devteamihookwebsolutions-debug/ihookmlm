@extends('admin::components.common.main')

@section('content')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __('Currency Format Configuration') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __('Settings') }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Personalization') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Currency Format Configuration') }}</span>
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
                <div class="flex p-4 mb-6 text-sm text-blue-800 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 border border-blue-300"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                        </path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>

                        <div>
                            <p class="mb-2">{{ __('Use this tool to deduct funds from your customers wallets when they do any illegal activities or unwanted transactions from C-Wallet or E-Wallet') }}

                            </p>


                        </div>
                    </div>
                </div>
                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                    <!-- card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">



                        <div>

                            <div class="p-4 rounded-lg" id="default-group" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">

                                    <!-- Left side: Form content -->

                                    <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5" bis_skin_checked="1">
                                        <form  id="addbulkuser" action="{{route('insertcurrency')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                                            {{ __('Currency Format Configuration') }}</h3>
                                            <!-- Display Selected Currency -->
                                            <div id="selected-currency"
                                                class="p-4 mb-5 bg-neutral-50 text-blue-800 text-xl font-semibold rounded-lg text-center">
                                                <span id="amount">Afghan Afghani (AFN)</span>
                                            </div>
                                            <!-- Currency Selection -->
                                            <div class="mb-5">
                                                <label for="currency"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Select currency') }}</label>
                                                <select name="currency" id="currency" onchange="formatCurrency();" required
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                                    {!! $allcurrency !!}
                                                </select>
                                            </div>
@php
    // Safe check
    $thousand_separator = $getcurrencyformat->thousand_seperator ?? '10';
    $decimal_separator  = $getcurrencyformat->decimal_seperator ?? '2';
@endphp

                                            <!-- Separator Format -->
                                            <div class="mb-5">
                                                <label for="separator"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Separator Format') }}</label>
                                                <!-- Separator Format -->
<select name="thousands_separator" id="thousands_separator" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" onchange="formatCurrency();">
<option value="10" @if($thousand_separator == '10') selected @endif>Western Europe</option>
<option value="20" @if($thousand_separator == '20') selected @endif>Eastern Europe</option>
<option value="30" @if($thousand_separator == '30') selected @endif>North America</option>
<option value="40" @if($thousand_separator == '40') selected @endif>South America</option>
<option value="50" @if($thousand_separator == '50') selected @endif>Asia</option>

</select>
                                            </div>

                                            <!-- Decimal Format -->
                                            <div class="mb-5">
                                                <label for="decimal"
                                                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Decimal Format') }}</label>
                                             <select name="decimal_separator" id="decimal_separator"  class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"onchange="formatCurrency();" required>
<option value="2" @if($decimal_separator == '2') selected @endif>Format 2</option>
<option value="3" @if($decimal_separator == '3') selected @endif>Format 3</option>
<option value="round" @if($decimal_separator == 'round') selected @endif>Round</option>
</select>
                                            </div>
                                            <div class="flex justify-end" bis_skin_checked="1">
                                    <button type="button" class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
 onclick="window.history.back();">{{ __('Cancel') }}</button>
                                    <button type="submit" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                                </div>
                                        </form>
                                    </div>


                                    <!-- Right side: Image -->
                                    <div class="flex flex-col justify-center items-center">
                                        <!--image-space-->
                                        <img src="{{ asset('assets/img/illustrations/bulk-upload-user.svg') }}"
                                            alt="enroll" class="w-3/4 sticky top-0 overflow-hidden">
                                        <!--image-space-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- card -->

                    </div>
                    <!--Row-1-->

                </div>
        </main>



<script>

window.addEventListener('load', function() {
    formatCurrency();
});

function formatCurrency() {

    var amountInput = 10000000;

    var currencyFormat = document.getElementById("currency").value;
    var thousandsSeparatorChoice = document.getElementById("thousands_separator").value;
    var decimalSeparatorChoice   = document.getElementById("decimal_separator").value;

    // Get user-selected custom format
    var userThousand = getThousandsSeparator(thousandsSeparatorChoice);
    var userDecimal  = getDecimalSeparator(thousandsSeparatorChoice);

    if (!amountInput || isNaN(amountInput)) {
        document.getElementById("amount").innerHTML = "";
        return;
    }

    // System default formatting based on currency
    var systemFormat = getCurrencySeparators(currencyFormat);

    // If system does not override → use user selection
    var thousandSeparator = systemFormat.thousand || userThousand;
    var decimalSeparator  = systemFormat.decimal  || userDecimal;

    var minimumFractionDigits, maximumFractionDigits;

    switch (decimalSeparatorChoice) {
        case "2":
            minimumFractionDigits = 2;
            maximumFractionDigits = 2;
            break;
        case "3":
            minimumFractionDigits = 3;
            maximumFractionDigits = 3;
            break;
        case "round":
            minimumFractionDigits = 0;
            maximumFractionDigits = 0;
            break;
        default:
            minimumFractionDigits = 2;
            maximumFractionDigits = 2;
    }

    var options = {
        style: 'currency',
        currency: currencyFormat,
        minimumFractionDigits: minimumFractionDigits,
        maximumFractionDigits: maximumFractionDigits
    };

    var numberFormat = new Intl.NumberFormat('en-US', options);
    var parts = numberFormat.formatToParts(amountInput);

    var formattedAmount = parts.map(part => {
        switch (part.type) {
            case 'group':
                return thousandSeparator;
            case 'decimal':
                return decimalSeparator;
            default:
                return part.value;
        }
    }).join('');

    document.getElementById("amount").innerHTML = formattedAmount;
}


// ------------------------------------------------------------
// Currency Default Thousand & Decimal Separators
// ------------------------------------------------------------

function getCurrencySeparators(currency) {

    // Currencies using comma for thousand and dot for decimal
    const commaThousand = [
        "USD","EUR","CAD","AUD","INR","AFN","JPY","GBP","CHF","CNY","SGD","HKD"
    ];

    // Currencies using dot for thousand and comma for decimal
    const dotThousand = [
        "BRL","CLP","COP","ARS","DKK","NOK","SEK","PLN","CZK"
    ];

    if (commaThousand.includes(currency)) {
        return { thousand: ",", decimal: "." };
    }

    if (dotThousand.includes(currency)) {
        return { thousand: ".", decimal: "," };
    }

    // Default
    return { thousand: ",", decimal: "." };
}


// ------------------------------------------------------------
// Dropdown-Based Thousand Separator
// ------------------------------------------------------------

function getThousandsSeparator(val){
    switch (val) {
        case "10": return ",";
        case "20": return ",";
        case "30": return ".";
        case "40": return ",";
        case "50": return ".";
        default:   return ",";
    }
}


// ------------------------------------------------------------
// Dropdown-Based Decimal Separator
// ------------------------------------------------------------

function getDecimalSeparator(val){
    switch (val) {
        case "10": return ".";
        case "20": return " ";
        case "30": return ",";
        case "40": return ".";
        case "50": return ",";
        default:   return ".";
    }
}

</script>



@endsection
