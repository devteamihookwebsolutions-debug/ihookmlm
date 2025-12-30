@extends('admin::components.common.main')

@section('content')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __("Enable & Disable Feature") }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
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
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __("Personalization") }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __("Enable & Disable Feature") }}</span>
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


       <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
    <div>
        <div class="p-4 rounded-lg">
            <div class="flex items-center">
                <div>
                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">{{ __("Enable & Disable Feature") }}</h3>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5">
                    <form name="securitysettingsform" id="securitysettingsform" action="{{route('enablefeatureupdate')}}" method="post">
                     @csrf
                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("QR CODE") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="qrcode" id="qrcode" value="1" class="sr-only peer" @if($feature['qrcode'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Count Down") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="countdown" id="countdown" value="1" class="sr-only peer"  @if($feature['countdown'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="@if($feature['countdown'] != '1') hidden @endif"  id="countdowntype_div">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Countdown Type") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Package") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="countdowntype" id="countdowntype" value="1" class="sr-only peer"  @if($feature['countdowntype'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("One-Time") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class=" flex align-center gap-2 lg:gap-10 mb-4 mt-2  @if($feature['countdowntype'] != '1') hidden @endif" id="countdowndays_div">
                        <label for="" class="text-sm font-medium text-black dark:text-white mt-3 w-48">{{ __("Countdown Days") }}</label>
                        <input type="number" name="countdowndays" id="countdowndays" value="{{$feature['countdowndays']}}" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Holding Tank") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="holding" id="holding" value="1" class="sr-only peer"  @if($feature['holding'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class=" flex align-center gap-2 lg:gap-10 mb-4 mt-2  @if($feature['holding'] != '1') hidden @endif" id="holdingdays_div">
                        <label for="" class="text-sm font-medium text-black dark:text-white mt-3 w-48">{{ __("Holding Days") }}</label>
                        <input type="number" name="holdingdays" id="holdingdays" value="{{$feature['holdingdays']}}" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Share") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="share" id="share" value="1" class="sr-only peer"  @if($feature['share'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Default Leg") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="default_leg" id="default_leg" value="1" class="sr-only peer"  @if($feature['default_leg'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Time widget") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="time_widget" id="time_widget" value="1" class="sr-only peer"  @if($feature['time_widget'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Referral Link and Replicated URL") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="refferal_link" id="refferal_link" value="1" class="sr-only peer"  @if($feature['refferal_link'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Remember me?") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="remember_me" id="remember_me" value="1" class="sr-only peer"  @if($feature['remember_me'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>



                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Stay On Last URL") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="last_url" id="last_url" value="1" class="sr-only peer"  @if($feature['last_url'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Benefits") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="benefits" id="benefits" value="1" class="sr-only peer"  @if($feature['benefits'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Mass Payout") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="mass_payout" id="mass_payout" value="1" class="sr-only peer"  @if($feature['mass_payout'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("WordPress Order") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="wordpress_order" id="wordpress_order" value="1" class="sr-only peer"  @if($feature['wordpress_order'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Binary Default Placement") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="binary_placement" id="binary_placement" value="1" class="sr-only peer"  @if($feature['binary_placement'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Time Out") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="time_out" id="time_out" value="1" class="sr-only peer"  @if($feature['time_out'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Sendgrid Distributors") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="sendgrid_distributors" id="sendgrid_distributors" value="1" class="sr-only peer"  @if($feature['sendgrid_distributors'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class=" flex align-center gap-2 lg:gap-10 mb-4 mt-2  @if($feature['sendgrid_distributors'] != '1') hidden @endif" id="sendgrid_thingid_div">
                        <label for="" class="text-sm font-medium text-black dark:text-white mt-3 w-48">{{ __("Sendgrid thing ID") }}</label>
                        <input type="number" name="sendgrid_thingid" id="sendgrid_thingid" value="{{$feature['sendgrid_distributors_desc']}}" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                        </div>

                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __("Sendgrid Leadcontacts") }}</td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("Off") }}</span>
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="sendgrid_leadcontacts" id="sendgrid_leadcontacts" value="1" class="sr-only peer"  @if($feature['sendgrid_leadcontacts'] == '1') checked @endif>
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <span class="text-sm font-medium text-black dark:text-white">{{ __("On") }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class=" flex align-center gap-2 lg:gap-10 mb-4 mt-2 @if($feature['sendgrid_leadcontacts'] != '1') hidden @endif" id="sendgrid_leadthingid_div">
                        <label for="" class="text-sm font-medium text-black dark:text-white mt-3 w-48">{{ __("Sendgrid Lead thing ID") }}</label>
                        <input type="number" name="sendgrid_leadthingid" id="sendgrid_leadthingid" value="{{$feature['sendgrid_leadcontacts_desc']}}" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                        </div>


                        <div class=" flex align-center gap-2 lg:gap-10 mb-4 mt-2">
                        <label for="" class="text-sm font-medium text-black dark:text-white mt-3 w-48">{{ __("Get PV File Path") }}</label>
                        <input type="text" name="pv_file_path" id="pv_file_path" value="{{$feature['pv_file_path_description']}}" class="text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="window.history.back();" class=" text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900  dark:hover:bg-neutral-800 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 ">{{ __('Cancel') }}</button>
                            <button type="submit"
                                class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __("Submit") }}</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>
    </div>
 </main>

<!-- custom scripts start-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('sendgrid_leadcontacts');
    const targetDiv = document.getElementById('sendgrid_leadthingid_div');

    // Add event listener for checkbox change
    checkbox.addEventListener('change', function () {
        if (!checkbox.checked) {
            // Add 'hidden' class if unchecked
            targetDiv.classList.add('hidden');
        } else {
            // Remove 'hidden' class if checked
            targetDiv.classList.remove('hidden');
        }
    });

    const checkbox2 = document.getElementById('sendgrid_distributors');
    const targetDiv2 = document.getElementById('sendgrid_thingid_div');

    // Add event listener for checkbox change
    checkbox2.addEventListener('change', function () {
        if (!checkbox2.checked) {
            // Add 'hidden' class if unchecked
            targetDiv2.classList.add('hidden');
        } else {
            // Remove 'hidden' class if checked
            targetDiv2.classList.remove('hidden');
        }
    });

    const checkbox3 = document.getElementById('holding');
    const targetDiv3 = document.getElementById('holdingdays_div');

    // Add event listener for checkbox change
    checkbox3.addEventListener('change', function () {
        if (!checkbox3.checked) {
            // Add 'hidden' class if unchecked
            targetDiv3.classList.add('hidden');
        } else {
            // Remove 'hidden' class if checked
            targetDiv3.classList.remove('hidden');
        }
    });

    const checkbox4 = document.getElementById('countdown');
    const checkbox5 = document.getElementById('countdowntype');
    const targetDiv4 = document.getElementById('countdowntype_div');
    const targetDiv5 = document.getElementById('countdowndays_div');

    // Add event listener for checkbox change
    checkbox4.addEventListener('change', function () {
        if (!checkbox4.checked) {
            targetDiv4.classList.add('hidden');
            targetDiv5.classList.add('hidden');
        } else {
            targetDiv4.classList.remove('hidden');
        }
    });

        // Add event listener for checkbox change
        checkbox5.addEventListener('change', function () {
        if (!checkbox5.checked) {
            targetDiv5.classList.add('hidden');
        } else {
            targetDiv5.classList.remove('hidden');
        }
    });


});
</script>

@endsection
