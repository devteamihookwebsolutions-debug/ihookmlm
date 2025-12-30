@include('components.common.header')
@include('components.common.topbars')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
  <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
    <div class="me-5 mb-5 lg:mb-0">
      <h2 class="text-lg font-medium text-black mb-2  dark:text-white">{{ __('My Profile') }} </h2>
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
          <li class="inline-flex items-center">
            <a href="#"
              class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
              <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                  clip-rule="evenodd"></path>
              </svg>
              {{ __('Dashboard') }}
            </a>
          </li>
          <li aria-current="page">
            <div class="flex items-center">
              <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 9 4-4-4-4" />
              </svg>
              <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('My Profile') }}
              </span>
            </div>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<!-- Content area start-->
<main class="flex-grow">
  <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
    <!--Success and Failure Messge-->
    @include('components.common.info_message')
    <!--Success and Failure Messge-->

    <!--myprofile-->
    <!--Row-1-->
    <div
      class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-4 md:gap-x-0 md:gap-y-5 sm:gap-x-0 sm:gap-y-5 xl:gap-5 lg:gap-x-0 lg:gap-y-5">
      <!-- card -->
      <div
        class="bg-white rounded dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 xl:h-[800px] gap-5 ">

        <!--profile-details-->
        <div class="profile-details m-5">
          <div class="flex items-start">
            <div class="profile-pic">
              @if(session('members_image') == 'uploads/members/avatar.png')

              <img src="{{$_ENV['CDNCLOUDEXTURL']}}uploads/members/avatar.png" class="w-24 rounded-lg mr-5"
                alt="user photo">
              @else
              <img src="{{$_ENV['CDNCLOUDEXTURL']}}/{{session('members_image')}}" class="w-24 rounded-lg mr-5">
              @endif
            </div>
            <div class="profile-info">
              <h4 class="text-base font-semibold text-black mb-1 dark:text-white">{!!
                $member_details['members_username'] !!}</h4>
              <div class="text-sm mb-3 dark:text-white">{!! $member_details['members_email'] !!}</div>
              <div class="flex">
                <a href="{{$_ENV['FCPATH']}}/messagecenter">
                  <button type="button"
                    class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-xs px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700">{{ __('Messages') }}</button></a>
                <a href="{{$_ENV['FCPATH']}}/userlog"><button type="button"
                    class="text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-xs px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Activity') }}</button></a>
              </div>
            </div>
          </div>
        </div>
        <!--profile-details-->

        <div class="border-b border-neutral-300 my-5"></div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-2 gap-5 m-5">

          <div class="border border-neutral-300 rounded-lg p-6">

            <div class="widget-icon mb-3">
              <svg class="w-8 h-8 ring-2 ring-neutral-800 bg-yellow-200 rounded-full p-1 text-black dark:text-white "
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2">
                </path>
              </svg>
            </div>

            <div class="widget-data">
              <h3 class="text-sm text-black mb-2 dark:text-white">{{ __('My Earnings') }}</h3>
              <div class="text-2xl font-semibold dark:text-white"><span
                  class="text-sm top-n-4">{{$_SESSION['site_settings']['site_currency']}}</span><span
                  class="text-2xl">{!! $todayearnings !!}</span></div>
            </div>

          </div>

          <div class="border border-neutral-300 rounded-lg p-6">

            <div class="widget-icon mb-3">

              <svg class="w-8 h-8 ring-2 bg-yellow-200 ring-neutral-800 rounded-full p-1 text-black dark:text-white "
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z">
                </path>
              </svg>

            </div>
            <div class="widget-data">
              <h3 class="text-sm text-black mb-2 dark:text-white">{{ __('Orders') }}</h3>
              <div class="text-2xl font-semibold dark:text-white"><span class="text-2xl">{!! $totalorders !!}</span>
              </div>
            </div>

          </div>

        </div>

        <div class="border-b border-neutral-300 my-5"></div>

        <!--tabs-->
        <div class="mb-5 max-h-[400px] overflow-y-auto
                      [&::-webkit-scrollbar]:w-2
                      [&::-webkit-scrollbar-track]:bg-neutral-100
                      [&::-webkit-scrollbar-thumb]:bg-neutral-300
                      dark:[&::-webkit-scrollbar-track]:bg-neutral-700
                      dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
          <ul class="flex flex-col space-y-4 text-sm font-medium text-black dark:text-white md:me-4 mb-4 md:mb-0">
            <li>
              <button onclick="showTab('profile')" id="tab-profile"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                </svg>

                {{ __('Profile Overview') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('personal')" id="tab-personal"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                {{ __('Personal Info') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('account')" id="tab-account"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                    d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z" />
                </svg>

                {{ __('Account Information') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('password')" id="tab-password"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.5 11.5 11 13l4-3.5M12 20a16.405 16.405 0 0 1-5.092-5.804A16.694 16.694 0 0 1 5 6.666L12 4l7 2.667a16.695 16.695 0 0 1-1.908 7.529A16.406 16.406 0 0 1 12 20Z" />
                </svg>

                {{ __('Change Password') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('avatar')" id="tab-avatar"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.99 9H15M8.99 9H9m12 3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM7 13c0 1 .507 2.397 1.494 3.216a5.5 5.5 0 0 0 7.022 0C16.503 15.397 17 14 17 13c0 0-1.99 1-4.995 1S7 13 7 13Z" />
                </svg>

                {{ __('Change Avatar') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('transaction')" id="tab-transaction"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
                </svg>

                {{ __('Transaction Password') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('email')" id="tab-email"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 8v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8m18 0-8.029-4.46a2 2 0 0 0-1.942 0L3 8m18 0-9 6.5L3 8" />
                </svg>

                {{ __('Email Settings') }}
              </button>
            </li>
            <li>
              <button onclick="showTab('payment')" id="tab-payment"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                    d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>

                {{ __('Payment Information') }}
              </button>
            </li>

            <li>
              <button onclick="showTab('tax')" id="tab-tax"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-neutral-40" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z" />
                </svg>

                {{ __('Tax Information') }}
              </button>
            </li>

            <li>
              <a href="{{$_ENV['FCPATH']}}/earning"><button id="tab-statements"
                  class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                  <svg class="w-5 h-5 me-2 icon-color dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                  </svg>

                  {{ __('Statements') }}
                </button></a>
            </li>

            <li>
              <button onclick="showTab('address')" id="tab-address"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-white" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                </svg>

                {{ __('Address') }}
              </button>
            </li>

            <li>
              <a href="{{$_ENV['FCPATH']}}/activesubscription"><button id="tab-cancel_subscription"
                  class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">

                  <svg class="w-5 h-5 me-2 icon-color dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>

                  {{ __('Cancel Subscription') }}
                </button></a>
            </li>

            <li>
              <a href="{{$_ENV['FCPATH']}}/plannetwork"><button id="tab-upgrade"
                  class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                  <svg class="w-5 h-5 me-2 icon-color dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                      d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z" />
                  </svg>

                  {{ __('Upgrade') }}
                </button></a>
            </li>

            <li>
              <button onclick="showTab('sites')" id="tab-sites"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-5 h-5 me-2 icon-color dark:text-white">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                </svg>

                {{ __('My Website Info') }}
              </button>
            </li>

            <li>
              <button onclick="showTab('social')" id="tab-social"
                class="tab-btn inline-flex items-center text-black  bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 w-full">
                <svg class="w-5 h-5 me-2 icon-color dark:text-white" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 9H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h6m0-6v6m0-6 5.419-3.87A1 1 0 0 1 18 5.942v12.114a1 1 0 0 1-1.581.814L11 15m7 0a3 3 0 0 0 0-6M6 15h3v5H6v-5Z" />
                </svg>

                {{ __('Social Media') }}
              </button>
            </li>

          </ul>
        </div>

        <!--Tabs-->

      </div>

      <!-- card -->
      <div class="col-span-3">

        <!-- Tabs Content -->
        <!-- Tab Content -->
        <div class="w-full">
          <div id="profile" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-2 gap-5 m-5">

              <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">
                  {{ __('Downline Sales') }}</h3>
                <!--begin::m-widget5-->
                <div class="downlinesales">
                  {!! $directsales !!}
                </div>

                <!--end::m-widget5-->

              </div>

              <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">
                  {{ __('Notifications') }}</h3>
                <div class="text-2xl font-semibold">
                  <span class="text-2xl">{!! $new_notification !!}</span>
                </div>

              </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5">

              <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Members Log') }}</h3>

                <!--begin::Table-->

                <div class="relative overflow-x-auto">
                  <table
                    class="w-full text-sm text-left text-black dark:text-white border border-neutral-200 dark:border-neutral-700 shadow-md rounded-lg overflow-hidden">
                    <thead class="text-xs text-black uppercase bg-neutral-100 dark:bg-neutral-900 dark:text-white">
                      <tr>
                        <th scope="col" class="px-6 py-3">{{ __('User') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Activity') }}</th>
                        <th scope="col" class="px-6 py-3 text-right">{{ __('IP Address') }}</th>
                        <th scope="col" class="px-6 py-3 text-right">{{ __('Status') }}</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 bg-white dark:bg-neutral-900">
                      {!! $userlog !!}
                    </tbody>
                  </table>
                </div>

                <!--end::Table-->

              </div>

            </div>
          </div>

          <div id="personal" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
              <form class="mb-5" id="showMyProfileDetails" action="{{$_ENV['FCPATH']}}/savemyprofile" method="POST">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                  <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Personal Info') }}</h3>

                  {{-- <div
                      class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                      aria-label="">
                      <span class="text-xs font-medium text-black dark:text-white">{{ __('Customer Info') }}</span>
                </div> --}}

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                  <div class="">
                    <label for="members_firstname" class="block mb-2 text-sm font-medium text-black dark:text-white">
                      {{ __('Firstname') }}</label>
                    <input type="text" placeholder="Enter First Name" name="members_firstname"
                      value="{{$member_details['members_firstname']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                      required aria-describedby="membersfirstname-error">
                    <p id="membersfirstname-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid name.') }}</p>
                  </div>
                  <div class="">
                    <label for="members_lastname"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Lastname') }}</label>
                    <input type="text" placeholder="Enter Last Name" name="members_lastname"
                      value="{{$member_details['members_lastname']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                      required aria-describedby="memberslastname-error">
                    <p id="memberslastname-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid name.') }}</p>
                    /
                  </div>
                </div>

                <div class="mb-5 ">
                  <label for="members_company_name"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Company Name') }}</label>
                  <input type="text" placeholder="Enter Company Name" name="members_company_name"
                    value="{{$member_details['members_company_name']}}"
                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light "
                    required aria-describedby="memberscompanyname-error">
                  <p id="memberscompanyname-error"
                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid company name.') }}</p>

                </div>

                <div class="border-b border-neutral-300 my-5"></div>

                <div
                  class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                  aria-label="">
                  <span class="text-xs font-medium text-black dark:text-white">{{ __('Contact Info') }}</span>
                </div>

                <div class="mb-5 ">
                  <label for="members_phone"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Phone Number') }}
                  </label>
                  <input type="tel" name="members_phone" id="phone" value="{{$member_details['members_phone']}}"
                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light "
                    required aria-describedby="membersphone-error">
                  <p id="membersphone-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid phone number.') }}</p>
                </div>

                <div class="mb-5 ">
                  <label for="members_email"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Email ID') }}</label>
                  <input type="text" placeholder="Enter E-Mail" name="members_email"
                    value="{{$member_details['members_email']}}"
                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                    required aria-describedby="membersemail-error">
                  <p id="membersemail-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid email.') }}</p>
                </div>

                @if ($regform[13]['column_name'] == 'alternate_email' && $regform[13]['display'] == '1')

                <div class="mb-5 ">
                  <label for="members_email2"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Alternate Email') }}
                  </label>
                  <input type="text" placeholder="Enter E-Mail" name="members_email2"
                    value="{{$member_details['members_alternate_email']}}"
                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                    required aria-describedby="membersemail2-error">
                  <p id="membersemail2-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid alternate email.') }}</p>
                </div>
                @endif

                <div class="mb-5 ">
                  <label for="members_subdomain"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Company Site') }}</label>
                  <input type="text" placeholder="Enter Subdomain" name="members_subdomain"
                    value="{{$member_details['members_subdomain']}}"
                    class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                    required aria-describedby="memberssubdomain-error">
                  <p id="memberssubdomain-error"
                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid subdomain.') }}</p>
                </div>

                <div class=" border-b border-neutral-300 my-5"></div>

                <div class="card-footer">

                  <div class="flex justify-end">
                    <div class="form-submit">
                      <button type="button"
                        class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700"
                        onclick='window.location.reload();'>{{ __('Cancel') }}</button>
                      <button type="submit"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                    </div>
                  </div>

                </div>

            </div>
            </form>

          </div>
        </div>
        <div id="account" class="tab-content hidden">
          <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
            <form class="" action="{{$_ENV['FCPATH']}}/saveaccountinfo" method="POST" id="saveAccountInfo">
              <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Account Information') }}
                </h3>

                {{-- <div
                      class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                      aria-label="">
                      <span class="text-xs font-medium text-black dark:text-white">{{ __('Customer Info') }}</span>
              </div> --}}

              <div class="mb-5 ">
                <label for="members_username"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('User Name') }}</label>
                <input type="text" value="{{$member_details['members_username']}}" name="members_username" readonly
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required>
              </div>
              <div class="mb-5 ">
                <label for="members_email"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('emailid') }}</label>
                <input value="{{$member_details['members_email']}}" placeholder="Email" name="members_email" readonly
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required>
              </div>

              <div class="mb-5">
                <label for=""
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Language') }}</label>
                {!! $language !!}
              </div>

              <label for=""
                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Communication') }}</label>
              <ul
                class="items-center w-full text-sm font-medium text-black dark:text-white bg-white border border-neutral-200 rounded-lg sm:flex dark:bg-neutral-900 dark:border-neutral-800 ">
                <li class="w-full border-b border-neutral-200 sm:border-b-0 sm:border-r ">
                  <div class="flex items-center ps-3">
                    <input id="vue-checkbox-list" type="checkbox" name="members_communication_email"
                      @if(isset($notification[1]) && $notification[1]['notify_via']=='1' ) checked @endif
                      class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-700 dark:focus:ring-offset-neutral-700 focus:ring-2 dark:bg-neutral-600 dark:border-neutral-500">
                    <label for="vue-checkbox-list"
                      class="w-full py-3 ms-2 text-sm font-medium text-black dark:text-white">{{ __('Email') }}</label>
                  </div>
                </li>
                <li class="w-full ">
                  <div class="flex items-center ps-3">
                    <input id="laravel-checkbox-list" type="checkbox" name="members_communication_sms"
                      @if(isset($notification[2]) && $notification[2]['notify_via']=='2' ) checked @endif
                      class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-700 dark:focus:ring-offset-neutral-700 focus:ring-2 dark:bg-neutral-600 dark:border-neutral-500">
                    <label for="laravel-checkbox-list"
                      class="w-full py-3 ms-2 text-sm font-medium text-black dark:text-white">{{ __('SMS') }}</label>
                  </div>
                </li>
              </ul>

              <div class="border-b border-neutral-300 my-5"></div>

              <div
                class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                aria-label="">
                <span class="text-xs font-medium text-black dark:text-white">{{ __('Security') }}</span>
              </div>

              <div class="mb-5">

                <div class="flex flex-wrap">
                  <div class="flex items-center me-4">
                    <input id="red-radio" type="radio" name="members_two_fact"
                      @if($member_details['members_two_fact']=='1' ) checked @endif onclick="popupqr(1);"
                      class="w-4 h-4 text-red-600  focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                    <label for="red-radio"
                      class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Google Authenticator') }}</label>
                  </div>
                  <div class="flex items-center me-4">
                    <input id="green-radio" type="radio" name="members_two_fact"
                      @if($member_details['members_two_fact']=='2' ) checked @endif onclick="popupqr(2);"
                      class="w-4 h-4 text-green-600  focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                    <label for="green-radio"
                      class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Email Authenticator') }}</label>
                  </div>
                  <div class="flex items-center me-4">
                    <input checked id="purple-radio" type="radio" name="members_two_fact"
                      @if($member_details['members_two_fact']=='0' ) checked @endif onclick="popupqr(0);"
                      class="w-4 h-4 text-purple-600  focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                    <label for="purple-radio"
                      class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Disable Authenticator') }}</label>
                  </div>
                </div>

                <div
                  class="flex items-center p-2 mt-3 text-xs text-blue-800 border border-blue-300 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 dark:border-blue-800"
                  role="alert">
                  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                  </svg>
                  Login, Change Password/Mobile, Fund Transfer, Add/Edit Withdrawal Wallet Address require this
                  Two Factor Authentication.
                </div>

                <div class=" border-b border-neutral-300 my-5"></div>

                <div class="card-footer">

                  <div class="flex justify-end">
                    <div class="form-submit">
                      <button type="button"
                        class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700"
                        onclick='window.location.reload();'>{{ __('Cancel') }}</button>
                      <button type="submit"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                    </div>
                  </div>

                </div>

              </div>

          </div>
          </form>

        </div>
      </div>
      <div id="password" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
          <form id="showMyPasswordDetails" action="{{$_ENV['FCPATH']}}/savepassworddetail" method="POST">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
              <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Change Password') }}</h3>

              <div class="mb-5 ">
                <label for="currentpassword"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('current_password') }}</label>
                <input type="password" placeholder="Enter Current Password" name="currentpassword"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="currentpassword-error">
                <p id="currentpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please enter your current password.') }}</p>
              </div>
              <div class="mb-5 ">
                <label for="newpassword"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('new_password') }}</label>
                <input type="password" placeholder="Enter New Password" name="newpassword"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="newpassword-error">
                <p id="newpassword-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please enter a new password.') }}</p>
              </div>

              <div class="mb-5">
                <label for="retypenewpassword"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('retypenewpassword') }}</label>
                <input type="password" placeholder="Re-Type Password" name="retypenewpassword"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="retypenewpassword-error">
                <p id="retypenewpassword-error"
                  class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please re-type your new password.') }}</p>
              </div>

              <div class=" border-b border-neutral-300 my-5"></div>

              <div class="card-footer">

                <div class="flex justify-end">
                  <div class="form-submit">
                    <button type="button" onclick='window.location.reload();'
                      class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Cancel') }}</button>
                    <button type="submit"
                      class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                  </div>
                </div>

              </div>

            </div>
          </form>

        </div>
      </div>
      <div id="avatar" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">

          <div class="bg-white table  rounded-lg shadow-sm mb-5 dark:border-neutral-700 dark:bg-neutral-900">
            <h3 class="text-lg font-semibold text-black mb-0 rounded-t-lg dark:text-white  px-4 py-4 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">{{ __('Change Avatar') }}</h3>

            <form id="showMyAvatarDetails" action="{{$_ENV['FCPATH']}}/savememberimage" method="POST"
              enctype="multipart/form-data">
              <input type="hidden" id="active_tab" name="active_tab" value="m_user_profile_tab_4">
              <div class="text-center">
              <div class="content-center relative bg-white  dark:bg-neutral-900 rounded-lg m-auto px-2 pb-2 py-2 place-items-center items-center space-x-6 mt-6">
                <div class="m-auto relative table">
                  <img id='preview_img' class="h-40 w-40 rounded-full p-1"
                    src="{{$_ENV['CDNCLOUDEXTURL']}}/{{ $_SESSION['members_image'] }}" alt="Current profile photo"
                    name="members_image" id="cropedimage" />
                    <div class="m-auto absolute top-0 mt-6 end-0">
                  <label class="table m-auto">
                    <div class="choose_avatar">
                      <!-- <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"

                        type="button" onclick="showAvatarGallery();">{{ __('Allowed file format') }}</button> -->
                                              <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-full text-sm px-2 py-2 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700"
                        type="button" onclick="showAvatarGallery();">
                        <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28">
                                            </path>
                                        </svg>
                      </button>
                      </div>
                  </label>
                </div>
                </div>


                <!-- <span class="sr-only">Edit Profile</span> -->
                <div class="text-center pt-5 m-auto table">
                  <input type="file" name="members_image" id="members_image" onchange="loadFile(event)" class="border dark:border-neutral-700 border-neutral-100 block w-full text-sm text-slate-500 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                </div>
                </div>
              </div>
              <span class="text-xs dark:text-white px-4 pt-1 pb-1 m-auto table mb-4">
                {{ __('Allowed file format') }} png ,
                jpg , svg {{ __('Genealogy') }}</span>
              <input aria-label="label" type="hidden" name="members_image" value="{{ session('members_image') }}">

              <input type="hidden" name="members_image_cropped" id="members_image_cropped" value="">

              <!-- <div class=" border-b border-neutral-300 my-5"></div> -->

              <div class="card-footer mt-0 bg-neutral-50 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 rounded-b-lg p-3">

                <div class="flex justify-end">
                  <div class="form-submit">
                    <button type="button"
                      class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700"
                      onclick="window.location.reload();">{{ __('Cancel') }}</button>
                    <button type="submit"
                      class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:hover:bg-neutral-500 dark:focus:ring-neutral-700 dark:border-neutral-700">{{ __('Submit') }}</button>
                  </div>
                </div>

              </div>

            </form>

          </div>

        </div>
      </div>
      <div id="transaction" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
          <form id="showMyTransaccPass" action="{{$_ENV['FCPATH']}}/savetransaccpassdetail" method="POST">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
              <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Transaction Password') }}</h3>

              @if($member_details['members_transaction_password'] !== '')

              <div class="mb-5 form-group">
                <label for="currenttransactionpassword"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Current Transaction Password') }}</label>
                <input type="password" id="currenttransactionpassword" name="currenttransactionpassword"
                  value="{{$member_details['currenttransactionpassword']}}"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="currenttransactionpassword-error">
                <p id="currenttransactionpassword-error"
                  class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please enter your current transaction password.') }}</p>
                <a class="m-link top_size showForgotTransPassword" href="#m_user_profile_tab_10"
                  title="{{ __('Forgot Transaction Password') }}">{{ __('Forgot Transaction Password') }}?</a>
              </div>
              @endif

              <div class="mb-5 form-group">
                <label for="transactionpassword"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('New Transaction Password') }}</label>
                <input type="password" placeholder="Enter Transaction Password" name="transactionpassword"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="transactionpassword-error">
                <p id="transactionpassword-error"
                  class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please enter a new transaction password.') }}</p>
              </div>

              <div class="mb-5 form-group">
                <label for="retypetransactionpassword"
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Retype New Transaction Password') }}
                </label>
                <input type="password" placeholder="Enter Transaction Password" name="retypetransactionpassword"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="retypetransactionpassword-error">
                <p id="retypetransactionpassword-error"
                  class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please re-type your new transaction password.') }}</p>
              </div>

              <div class=" border-b border-neutral-300 my-5"></div>
              <div class="card-footer">
                <div class="flex justify-end">
                  <div class="form-submit">
                    <button type="button"
                      class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700"
                      onclick='window.location.reload();'>{{ __('Cancel') }}</button>
                    <button type="submit"
                      class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                  </div>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
      <div id="email" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
          <form action="{{$_ENV['FCPATH']}}/saveemailsetting" method="POST" id="saveEmailSetting">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
              <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Email Settings') }}</h3>
              <div
                class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                aria-label="">
                <span class="text-xs font-medium text-black dark:text-white">{{ __('Setup Email Notification:') }}</span>
              </div>

              <div class="mb-8">

                <div class="flex justify-start gap-5">
                  <div>
                    <label class="inline-flex items-center cursor-pointer">

                      <input type="checkbox" name="members_email_notification"
                        @if($notification['members_email_notification']=='1' ) checked @endif class="sr-only peer">
                      <div
                        class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-neutral-600">
                      </div>
                      <span
                        class="ms-3 text-sm font-medium text-black dark:text-white">{{ __('Email Notification:') }}</span>
                    </label>
                  </div>

                  <div class="ms-5">
                    <label class="inline-flex items-center cursor-pointer">

                      <input type="checkbox" name="members_personalemail_notification"
                        @if($notification['members_personalemail_notification']=='1' ) checked @endif
                        class="sr-only peer">
                      <div
                        class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-neutral-600">
                      </div>
                      <span
                        class="ms-3 text-sm font-medium text-black dark:text-white">{{ __('Send Copy To Personal Email') }}</span>
                    </label>
                  </div>
                </div>

              </div>

              <div
                class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                aria-label="">
                <span class="text-xs font-medium text-black dark:text-white">{{ __('Activity Related Emails:') }}</span>
              </div>

              <div class="mb-8">
                <label
                  class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('When To Email') }}</label>
                <div class="flex items-center mb-5">
                  <input id="default-checkbox" type="radio" name="mail_notify" value="1"
                    @if($notification['mail_notify']=='1' ) checked @endif
                    class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                  <label for="default-checkbox"
                    class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Send me notifications about my account activity') }}</label>
                </div>
                <div class="flex items-center">
                  <input id="checked-checkbox" type="radio" name="mail_notify" value="2"
                    @if($notification['mail_notify']=='2' ) checked @endif
                    class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                  <label for="checked-checkbox"
                    class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Only send me required admin announcement emails') }}</label>
                </div>

              </div>

              <div
                class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                aria-label="">
                <span class="text-xs font-medium text-black dark:text-white">{{ __('When To Escalate Emails') }}</span>
              </div>

              <div class="flex items-center mb-5">
                <input id="default-checkbox1" type="checkbox" value="1" name="all_notify"
                  @if($notification['all_notify']=='1' ) checked @endif
                  class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                <label for="default-checkbox1"
                  class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('My all activity') }}</label>
              </div>

              <div class="flex items-center mb-5">
                <input id="default-checkbox2" type="checkbox" value="1" name="register_notify"
                  @if($notification['register_notify']=='1' ) checked @endif
                  class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                <label for="default-checkbox2"
                  class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Activity on my downline register') }}</label>
              </div>

              <div class="flex items-center mb-5">
                <input id="default-checkbox3" type="checkbox" value="1" name="message_notify"
                  @if($notification['message_notify']=='1' ) checked @endif
                  class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                <label for="default-checkbox3"
                  class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Activity on my message') }}</label>
              </div>

              <div class="flex items-center mb-5">
                <input id="withdraw_notify" type="checkbox" value="1" name="withdraw_notify"
                  @if($notification['withdraw_notify']=='1' ) checked @endif
                  class="w-4 h-4 text-blue-600  rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-neutral-800 focus:ring-2 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                <label for="withdraw_notify"
                  class="ms-2 text-sm font-medium text-black dark:text-white">{{ __('Activity on my withdraw') }}</label>
              </div>

              <div class=" border-b border-neutral-300 my-5"></div>
              <div class="card-footer">
                <div class="flex justify-end">
                  <div class="form-submit">
                    <button type="button"
                      class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Cancel') }}</button>
                    <button type="submit"
                      class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                  </div>
                </div>
              </div>

            </div>
          </form>

        </div>
      </div>
      <div id="payment" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
          <form class="mb-5" id="updatecarddetails" action="{{$_ENV['FCPATH']}}/updatememberscard" method="POST">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
              <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-semibold text-black">{{ __('Payment Information') }}</h3>
                <img src="{{$_ENV['UI_ASSET_URL']}}/public/assets/img/payment_card.svg" alt="payment-infos" class="w-64">
              </div>

              <div class="">
                <div
                  class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                  aria-label="">
                  <span class="text-xs font-medium text-black dark:text-white">{{ __('Billing Address') }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                  @if($regform[0]['column_name'] == 'firstname' && $regform[0]['display'] == '1')

                  <div class="mb-5">
                    <label for=""
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Firstname') }}</label>
                    <input name="members_firstname" type="text" placeholder="Enter First Name"
                      value="{{$member_details['members_firstname']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                      required aria-describedby="membersfirstname-error">
                    <p id="membersfirstname-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid name.') }}</p>
                  </div>
                  @endif
                  @if($regform[1]['column_name'] == 'lastname' && $regform[1]['display'] == '1')
                  <div class="mb-5">
                    <label for=""
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Lastname') }}</label>
                    <input name="members_lastname" type="text" placeholder="Enter Last Name"
                      value="{{$member_details['members_lastname']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                      required aria-describedby="memberslastname-error">
                    <p id="memberslastname-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid name.') }}</p>
                  </div>
                  @endif
                </div>
                @if($regform[4]['column_name'] == 'add1' && $regform[4]['display'] == '1')

                <div class="mb-5">
                  <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                    <!-- address inputs -->
                    <div class="mb-5">
                      <label for="address"
                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Address') }}</label>
                      <input name="members_address" type="text" placeholder="Enter Address"
                        value="{{$member_details['members_address']}}"
                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                        required aria-describedby="membersaddress-error">
                      <p id="membersaddress-error"
                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid address.') }}</p>
                    </div>
                  </div>
                </div>
                @endif
                @if($regform[9]['column_name'] == 'country' && $regform[9]['display'] == '1')

                <div class="mb-5">
                  <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                    <!-- address inputs -->
                    <div class="mb-5">
                      <label for="country"
                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Country') }}</label>
                      <select aria-label="label"
                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                        id="members_country" name="members_country" required aria-describedby="memberscountry-error">
                        <option value="">{{ __('Select') }}</option>
                        {!! $country !!}
                      </select>
                      <p id="memberscountry-error"
                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please select a country.') }}</p>
                    </div>
                  </div>
                </div>
                @endif
                <div class="mb-5">
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- address inputs -->
                    @if($regform[3]['column_name'] == 'city' && $regform[3]['display'] == '1')

                    <div class="mb-5">
                      <label for="lastname"
                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('City') }}</label>
                      <input name="members_city" type="text" placeholder="Enter City"
                        value="{{$member_details['members_city']}}"
                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                        required aria-describedby="memberscity-error">
                      <p id="memberscity-error"
                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid city.') }}</p>
                    </div>
                    @endif
                    @if($regform[2]['column_name'] == 'state' && $regform[2]['display'] == '1')

                    <div class="">
                      <input type="hidden" name="members_hidden_state" id="members_hidden_state"
                        value="{{$member_details['members_state']}}">
                      <label for="state"
                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('State') }}</label>
                      <div class="relative">
                        <select aria-label="label"
                          class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                          id="members_state" name="members_state" required aria-describedby="membersstate-error">
                          <option value="">{{ __('Select') }}</option>
                        </select>
                        <p id="membersstate-error"
                          class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                          {{ __('Please select a state.') }}</p>
                        <!-- You can style this dropdown in a way to make it look like an input. -->
                      </div>
                    </div>

                    @endif
                    @if($regform[8]['column_name'] == 'zipcode' && $regform[8]['display'] == '1')

                    <div class="">
                      <label for="zipcode"
                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Zipcode') }}</label>
                      <input name="members_zip" type="text" placeholder="Zip code"
                        value="{{$member_details['members_zip']}}"
                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                        required aria-describedby="memberszip-error">
                      <p id="memberszip-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid zip code.') }}</p>
                    </div>
                    @endif
                    @if($regform[7]['display'] == '1')

                    <div class="mb-5">
                      <label for="phonenumber"
                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Phone Number') }}</label>
                      <input name="members_phone" type="text" placeholder="Phone"
                        value="{{$member_details['members_phone']}}"
                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                        required aria-describedby="membersphone-error">
                      <p id="membersphone-error"
                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid phone number.') }}</p>
                    </div>
                    @endif
                  </div>
                </div>
              </div>

              <div class="">
                <div
                  class="inline-flex items-center justify-between px-4 py-2 text-sm text-black dark:text-white mb-4 bg-yellow-300 rounded-full dark:bg-yellow-800 hover:bg-yellow-400 dark:hover:bg-yellow-700"
                  aria-label="">
                  <span class="text-xs font-medium text-black dark:text-white">{{ __('Card Inforamtion') }}</span>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                  <div class="mb-5">
                    <label for=""
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Name') }}</label>
                    <input type="text" id="name" name="name" value="{{$carddetails['card_name']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                      placeholder="" required aria-describedby="cardname-error">
                    <p id="cardname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter the name on the card.') }}</p>
                  </div>
                  <div class="mb-5">
                    <label for="cardnumber"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Number on card') }}</label>
                    <input type="text" id="cardnumber" name="cardnumber" value="{{$carddetails['card_number_hidden']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                      placeholder="" required aria-describedby="cardnumber-error">
                    <p id="cardnumber-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter the card number.') }}</p>
                    <input id="card-number" name="card-number" type="hidden" value="{{$carddetails['card_number']}}">
                  </div>

                  <div class="mb-5">
                    <div class="grid md:grid-cols-2 md:gap-6">
                      <div class="mb-5">
                        <label for=""
                          class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Valid Through') }}</label>
                        <input inputmode="numeric" id="expirationdate" name="card_month"
                          value="{{$carddetails['card_exp']}}"
                          class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                          placeholder="" required aria-describedby="cardexp-error">
                        <p id="cardexp-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                          {{ __('Please enter the card expiration date.') }}</p>
                      </div>
                      <div class="mb-5">
                        <label for=""
                          class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('CVV') }}</label>
                        <input pattern="[0-9]*" inputmode="numeric" maxlength="4" minlength="3" id="securitycode"
                          name="card_cvv" value="{{$carddetails['card_cvv']}}"
                          class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                          placeholder="" required aria-describedby="cardcvv-error">
                        <p id="cardcvv-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                          {{ __('Please enter the card CVV.') }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class=" border-b border-neutral-300 my-5"></div>
              <div class="card-footer">
                <div class="flex justify-end">
                  <div class="form-submit">
                    <button type="button" onclick='window.location.reload();'
                      class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Cancel') }}</button>
                    <button type="submit"
                      class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                  </div>
                </div>
              </div>

            </div>

        </div>
        </form>
      </div>

      <div id="tax" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">
          <form action="{{$_ENV['FCPATH']}}/savetaxinformation" id="saveTaxInformation" name="saveTaxInformation"
            method="POST" enctype="multipart/form-data">

            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
              <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Tax Information') }}</h3>

              <div class="mb-5">
                <label for=""
                  class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('ssn') }}</label>
                <input type="tel" maxlength="9" name="members_ssn_number" pattern="\d*" placeholder="xxx-xx-xxxx"
                  value="{{$member_details['members_ssn_number']}}"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="membersssn-error">
                <p id="membersssn-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please enter a valid SSN.') }}</p>
              </div>

              <div class="mb-5">
                <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('EIN') }}
                </label>
                <input type="tel" maxlength="9" name="members_ein_number" pattern="\d*" placeholder="xx-xxxxxxx"
                  value="{{$member_details['members_ein_number']}}"
                  class="shadow-sm bg-neutral-50 text-black dark:text-white text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900  border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 dark:shadow-sm-light ''"
                  required aria-describedby="membersein-error">
                <p id="membersein-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                  {{ __('Please enter a valid EIN.') }}</p>
              </div>

              <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-black dark:text-white"
                  for="file_input">{{ __('1099 Form') }}</label>
                <input
                  class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 ''"
                  aria-describedby="file_input_help" id="customFile" name="customFiletax" type="file" required>
                <p class="mt-1 text-sm text-black dark:text-white" id="file_input_help">
                  {{ __('Accepted Format : pdf,jpeg,jpg,png') }}</p>
              </div>

              <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-black dark:text-white"
                  for="file_input">{{ __('W8 Form') }}</label>
                <input
                  class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 ''"
                  aria-describedby="file_input_help" id="customFile" name="w8form" type="file" required>
                <p class="mt-1 text-sm text-black dark:text-white" id="file_input_help">
                  {{ __('Accepted Format : pdf,jpeg,jpg,png') }}</p>
              </div>
              <input type="hidden" name="customFileW8formhidden" value="{{$member_details['members_w8_form']}}">

              <div class=" border-b border-neutral-300 my-5"></div>
              <div class="card-footer">
                <div class="flex justify-end">
                  <div class="form-submit">
                    <button type="button" onclick='window.location.reload();'
                      class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Cancel') }}</button>
                    <button type="submit"
                      class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div id="statements" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 mb-5">

          <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
            <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Statements') }}</h3>

            <div class=" border-b border-neutral-300 my-5"></div>
            <div class="card-footer">
              <div class="flex justify-end">
                <div class="form-submit">
                  <button type="button"
                    class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Cancel') }}</button>
                  <button type="button"
                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save') }}</button>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
      <div id="address" class="tab-content hidden">
        <form class="mb-5" id="updateaddress" action="{{$_ENV['FCPATH']}}/updateaddress" method="POST">
          <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
            <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Address') }}</h3>

            <div class="address-form">
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-5">
                @if($regform[0]['column_name'] == 'firstname' && $regform[0]['display'] == '1')
                <div>
                  <label for=""
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('First Name') }}</label>
                  <input type="text"
                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                    placeholder="" required aria-describedby="membersfirstname-error">
                  <p id="membersfirstname-error"
                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid first name.') }}</p>
                </div>
                @endif
                @if($regform[1]['column_name'] == 'lastname' && $regform[1]['display'] == '1')
                <div>
                  <label for=""
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Lastname') }}</label>
                  <input type="text"
                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                    placeholder="" required aria-describedby="memberslastname-error">
                  <p id="memberslastname-error"
                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid last name.') }}</p>
                </div>
                @endif
              </div>

              @if($regform[4]['column_name'] == 'add1' && $regform[4]['display'] == '1')
              <div class="mb-5">
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                  <div class="mb-5">
                    <label for="lastname"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Address1') }}</label>
                    <input name="members_address" type="text" placeholder="Enter Address"
                      value="{{$member_details['members_address']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                      placeholder="" required aria-describedby="membersaddress-error">
                    <p id="membersaddress-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid address.') }}</p>
                  </div>
                </div>
              </div>
              @endif

              @if($regform[5]['column_name'] == 'add2' && $regform[5]['display'] == '1')
              <div class="mb-5">
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                  <div class="mb-5">
                    <label for="lastname"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Address2') }}</label>
                    <input name="members_address2" type="text" placeholder="Enter Address Two"
                      value="{{$member_details['members_address2']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                      placeholder="" required aria-describedby="membersaddress2-error">
                    <p id="membersaddress2-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid address.') }}</p>
                  </div>
                </div>
              </div>
              @endif

              @if($regform[9]['column_name'] == 'country' && $regform[9]['display'] == '1')
              <div class="mb-5">
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                  <div class="mb-5">
                    <label for="country"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Country') }}</label>
                    <select aria-label="label"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                      id="members_country_1" name="members_country" required aria-describedby="memberscountry-error">
                      <option value="">{{ __('Select') }}</option>
                      {!! $country !!}
                    </select>
                    <p id="memberscountry-error"
                      class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please select a country.') }}</p>
                  </div>
                </div>
              </div>
              @endif

              <div class="mb-5">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  @if($regform[3]['column_name'] == 'city' && $regform[3]['display'] == '1')
                  <div class="mb-5">
                    <label for="lastname"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('City') }}</label>
                    <input name="members_city" type="text" placeholder="Enter City"
                      value="{{$member_details['members_city']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500 ''"
                      required aria-describedby="memberscity-error">
                    <p id="memberscity-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid city.') }}</p>
                  </div>
                  @endif

                  @if($regform[2]['column_name'] == 'state' && $regform[2]['display'] == '1')
                  <div class="">
                    <input type="hidden" name="members_hidden_state" id="members_hidden_state"
                      value="{{$member_details['members_state']}}">
                    <label for="state"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('State') }}</label>
                    <div class="relative">
                      <select aria-label="label"
                        class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                        id="members_state_1" name="members_state" required aria-describedby="membersstate-error">
                        <option value="">{{ __('Select') }}</option>
                      </select>
                      <p id="membersstate-error"
                        class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please select a state.') }}</p>
                    </div>
                  </div>
                  @endif

                  @if($regform[8]['column_name'] == 'zipcode' && $regform[8]['display'] == '1')
                  <div class="">
                    <label for="zipcode"
                      class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Zipcode') }}</label>
                    <input name="members_zip" type="text" placeholder="Zip code"
                      value="{{$member_details['members_zip']}}"
                      class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                      required aria-describedby="memberszip-error">
                    <p id="memberszip-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                      {{ __('Please enter a valid zip code.') }}</p>
                  </div>
                  @endif
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="flex justify-end">
                <button type="button"
                  class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700"
                  onclick='window.location.reload();'>{{ __('Cancel') }}</button>
                <button type="submit"
                  class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save Changes') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div id="upgrade" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
          <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Upgrade') }}</h3>
          <div class=" border-b border-neutral-300 my-5"></div>
          <div class="card-footer">
            <div class="flex justify-end">
              <div class="form-submit">
                <button type="button"
                  class="text-black me-3 bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">{{ __('Cancel') }}</button>
                <button type="button"
                  class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Save') }}</button>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div id="sites" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
          <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('My Website Info') }}</h3>
          <form class="mb-5" id="websiteibo" action="{{$_ENV['FCPATH']}}/updatewebsitedetails" method="POST">
            {!! $mysite !!}
          </form>
        </div>
      </div>
      <div id="social" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
          <h3 class="text-lg font-semibold text-black mb-3 dark:text-white">{{ __('Social Media') }}</h3>
          <form class="mb-5" id="social" action="{{$_ENV['FCPATH']}}/updatesocialdetails" method="POST">
            {!! $socialmedia !!}
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>

  </div>
  <!--Row-1-->
  <!--myprofile-->

  </div>
</main>
<!-- Content area end-->

<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-3xl max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
      <!-- Modal header -->
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
        <h3 class="text-lg font-semibold text-black dark:text-white">{{ __('Avatar') }}</h3>
        <button type="button"
          class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
          onClick="closeModal('crud-modal')>
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">{{ __('Close modal') }}</span>
        </button>
      </div>
      <!-- Modal body -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 gap-4 p-10">
        <span id="showavatargallery"></span>
      </div>
    </div>
  </div>
</div>
<!-- Main modal -->

<!-- Footer -->
@include('components.common.footer')
@include('components.common.footer_scripts')

<!-- custom scripts start-->
@include('profile.components.myprofile_scripts')
<!-- custom scripts end-->

@include('components.common.footer_end')
