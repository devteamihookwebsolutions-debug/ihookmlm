@extends('admin::components.common.main')
  @section('content')
    <!-- Main Content Area -->
                        <main class="flex-grow">
                            <div class="">
                                <!-- Timer -->
                                <div class="mt-5 items-center justify-end mb-10">
                                    <div class="flex items-center flex-wrap justify-end">
                                        <!--timer:starts-->
                                        <div id="clockdate" class="me-5">
                                            <div class="clockdate-wrapper">
                                                <div class="text-xl text-gray-900 font-bold dark:text-gray-100"
                                                    id="clock">
                                                </div>
                                                <div id="date"
                                                    class="text-sm text-gray-900 font-semibold dark:text-gray-100">
                                                </div>
                                            </div>
                                        </div>
                                        <!--timer:starts-->
                                        <button type="button" data-tooltip-target="tour"
                                            class="text-gray-800 bg-yellow-600 hover:bg-yellow-700 font-medium rounded-full text-sm p-3 me-3 text-center inline-flex items-center dark:bg-orange-500 dark:hover:bg-orange-600 lg:mb-0 md:mb-0 sm:mb-5">
                                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-5 h-5 text-gray-100 dark:text-white ">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                            </svg>
                                            <div id="tour" role="tooltip"
                                                class="absolute z-50 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Quick Tour
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </button>
                                        <button type="button" data-tooltip-target="report"
                                            class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-full text-xs p-3 text-center inline-flex items-center dark:bg-blue-500  dark:hover:bg-blue-600 lg:mb-0 md:mb-0 sm:mb-5">
                                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-5 h-5 text-gray-100 dark:text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                                            </svg>
                                            <div id="report" role="tooltip"
                                                class="absolute z-50 invisible inline-block px-3 py-2 text-xs text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Reports
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <!--Row-1-->
                                <div class="border dark:border-gray-800 p-4 rounded-xl mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5 mb-10 mt-3">
                                        <!-- promo-banner -->
                                        <div
                                            class="bg-gray-100 dark:bg-gray-900 rounded-xl shadow p-6 border dark:border-gray-800">
                                            <div class="flex justify-between flex-wrap items-center gap-5">
                                                <div class="">
                                                    <span
                                                        class="text-sm font-bold text-yellow-700 dark:text-blue-500">Hello
                                                        Admin,</span>
                                                    <p class="text-xs text-gray-600 mb-4 dark:text-gray-500">“Transform
                                                        your sales approach with
                                                        ihook,<br /> simplify
                                                        your workflow, and
                                                        achieve greater outcomes.”
                                                    </p>
                                                    <button type="button"
                                                        class="text-white mx-auto bg-yellow-700 dark:bg-blue-500  hover:bg-yellow-600 rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-blue-600">
                                                        Discover More
                                                    </button>
                                                </div>
                                                <img src="/img/banner-rgt.png" alt="promo-item"
                                                    class="block dark:hidden w-80">
                                                <img src="/img/promo-bnr-dark.png" alt="promo-item"
                                                    class="hidden dark:block w-80">

                                            </div>
                                        </div>

                                    </div>

                                    <!-- round btns -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-5">

                                        <div class="">
                                            <div
                                                class="flex justify-between items-center bg-white rounded-full p-5 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                                                <div class="ml-3">
                                                    <h3 class="text-xs font-medium text-gray-800 dark:text-white">
                                                        Joinings</h3>
                                                    <span
                                                        class="text-xs text-gray-600 dark:text-gray-400">$600.00</span>
                                                </div>
                                                <div class="">
                                                    <div
                                                        class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-2">
                                                        <svg class="w-7 h-7 text-gray-800 dark:text-blue-500"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div
                                                class="flex justify-between items-center bg-white rounded-full p-5 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                                                <div class="ml-3">
                                                    <h3 class="text-xs font-medium text-gray-800 dark:text-white">
                                                        E-Wallet</h3>
                                                    <span
                                                        class="text-xs text-gray-600 dark:text-gray-400">$600.00</span>
                                                </div>
                                                <div class="">
                                                    <div
                                                        class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-2">
                                                        <svg class="w-7 h-7 text-gray-800 dark:text-blue-500"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M17 8H5m12 0a1 1 0 0 1 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1Z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div
                                                class="flex justify-between items-center bg-white rounded-full p-5 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                                                <div class="ml-3">
                                                    <h3 class="text-xs font-medium text-gray-800 dark:text-white">Income
                                                    </h3>
                                                    <span
                                                        class="text-xs text-gray-600 dark:text-gray-400">$600.00</span>
                                                </div>
                                                <div class="">
                                                    <div
                                                        class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-2">
                                                        <svg class="w-7 h-7 text-gray-800 dark:text-blue-500"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div
                                                class="flex justify-between items-center bg-white rounded-full p-5 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                                                <div class="ml-3">
                                                    <h3 class="text-xs font-medium text-gray-800 dark:text-white">Paid
                                                    </h3>
                                                    <span
                                                        class="text-xs text-gray-600 dark:text-gray-400">$600.00</span>
                                                </div>
                                                <div class="">
                                                    <div
                                                        class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-2">
                                                        <svg class="w-7 h-7 text-gray-800 dark:text-blue-500"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!--Row-2-->
                                <div class="border dark:border-gray-800 p-6 mb-5 rounded-xl">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-3 gap-5">
                                        <!--Events-widget-->
                                        <div
                                            class="bg-white rounded-lg p-6 mb-5 dark:bg-gray-900 border dark:border-gray-800 ">
                                            <h3 class="text-xs font-semibold text-gray-800 mb-3 dark:text-gray-300">
                                                Invest & Events</h3>
                                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center min-w-0">
                                                            <img class="flex-shrink-0 w-10" src="/img/etherium.png"
                                                                alt="gold">
                                                            <div class="ml-3">
                                                                <p
                                                                    class="text-xs text-gray-600 truncate dark:text-gray-400">
                                                                    Etherium
                                                                </p>

                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="text-blue-500  text-xs text-center ">Upcoming...</button>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center min-w-0">
                                                            <img class="flex-shrink-0 w-10" src="/img/dollar.png"
                                                                alt="silver">
                                                            <div class="ml-3">
                                                                <p
                                                                    class="text-xs text-gray-600 truncate dark:text-gray-400">
                                                                    Dollar
                                                                </p>

                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="text-blue-500 text-center text-xs underline">Know
                                                            More</button>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center min-w-0">
                                                            <img class="flex-shrink-0 w-10" src="/img/gold.png"
                                                                alt="copper">
                                                            <div class="ml-3">
                                                                <p
                                                                    class="text-xs text-gray-600 truncate dark:text-gray-400">
                                                                    Gold
                                                                </p>

                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="text-blue-500 text-center text-xs underline">Know
                                                            More</button>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center min-w-0">
                                                            <img class="flex-shrink-0 w-10" src="/img/silver.png"
                                                                alt="silver">
                                                            <div class="ml-3">
                                                                <p
                                                                    class="text-xs text-gray-600 truncate dark:text-gray-400">
                                                                    Silver
                                                                </p>

                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="text-blue-500 text-center text-xs underline">Know
                                                            More</button>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center min-w-0">
                                                            <img class="flex-shrink-0 w-10" src="/img/copper.png"
                                                                alt="copper">
                                                            <div class="ml-3">
                                                                <p
                                                                    class="text-xs text-gray-600 truncate dark:text-gray-400">
                                                                    Copper
                                                                </p>

                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="text-blue-500 text-center text-xs underline">Know
                                                            More</button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--distributors-widget-->
                                        <div
                                            class="bg-white rounded-lg p-6 dark:bg-gray-900 border dark:border-gray-800">
                                            <h3 class="text-xs font-semibold text-gray-800 mb-3 dark:text-gray-300">
                                                Recently Joined
                                                Distributors</h3>
                                            <table id="default-table">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <span class="flex items-center uppercase">
                                                                Name
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                        <th data-type="date" data-format="YYYY/DD/MM">
                                                            <span class="flex items-center uppercase">
                                                                Email
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                        <th>
                                                            <span class="flex items-center uppercase">
                                                                DOJ
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                        <th>
                                                            <span class="flex items-center uppercase">
                                                                Country
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                        <th>
                                                            <span class="flex items-center uppercase">
                                                                Phone
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                        <th>
                                                            <span class="flex items-center uppercase">
                                                                Plan
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                        <th>
                                                            <span class="flex items-center uppercase">
                                                                status
                                                                <svg class="w-4 h-4 ms-1" aria-hidden="true" width="24"
                                                                    height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                                </svg>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        class="text-xs text-gray-600 whitespace-nowrap dark:text-gray-400">
                                                        <td class="">
                                                            <div class="flex items-center gap-4">
                                                                <img class="w-10 h-10 rounded-full"
                                                                    src="/img/av-ico-1.png" alt="">
                                                                <div class="">
                                                                    <div>Jese Leos</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>jese@malinator.com</td>
                                                        <td>2021/25/09</td>
                                                        <td>United States</td>
                                                        <td>+112345678911</td>
                                                        <td>Gold</td>
                                                        <td><span
                                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Suspend</span>
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="text-xs text-gray-600 whitespace-nowrap dark:text-gray-400">
                                                        <td class="">
                                                            <div class="flex items-center gap-4">
                                                                <img class="w-10 h-10 rounded-full"
                                                                    src="/img/av-ico-3.png" alt="">
                                                                <div class="">
                                                                    <div>Brandon jones</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>jese@malinator.com</td>
                                                        <td>2021/25/09</td>
                                                        <td>United States</td>
                                                        <td>+112345678911</td>
                                                        <td>Gold</td>
                                                        <td><span
                                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Active</span>
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="text-xs text-gray-600 whitespace-nowrap dark:text-gray-400">
                                                        <td class="">
                                                            <div class="flex items-center gap-4">
                                                                <img class="w-10 h-10 rounded-full"
                                                                    src="/img/av-ico-2.png" alt="">
                                                                <div class="">
                                                                    <div>Jese Leos</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>jese@malinator.com</td>
                                                        <td>2021/25/09</td>
                                                        <td>United States</td>
                                                        <td>+112345678911</td>
                                                        <td>Gold</td>
                                                        <td><span
                                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Suspend</span>
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="text-xs text-gray-600 whitespace-nowrap dark:text-gray-400">
                                                        <td class="">
                                                            <div class="flex items-center gap-4">
                                                                <img class="w-10 h-10 rounded-full"
                                                                    src="/img/av-ico-1.png" alt="">
                                                                <div class="">
                                                                    <div>Jese Leos</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>jese@malinator.com</td>
                                                        <td>2021/25/09</td>
                                                        <td>United States</td>
                                                        <td>+112345678911</td>
                                                        <td>Gold</td>
                                                        <td><span
                                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Suspend</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--country-sales-widget-->
                                        <div
                                            class="bg-white rounded-lg p-6 dark:bg-gray-900 border dark:border-gray-800">
                                            <h3 class="text-xs font-semibold text-gray-800 mb-5 dark:text-gray-300">
                                                Country</h3>
                                            <!--country-chart-->

                                            <ul class=" divide-y divide-gray-200 dark:divide-gray-700">
                                                <li class="pb-3 sm:pb-4">
                                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                        <div class="shrink-0">
                                                            <img class="w-8 h-8 rounded-full" src="/img/usa.png"
                                                                alt="us image">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                                                United States
                                                            </p>
                                                            <p class="text-xs text-gray-500  dark:text-gray-500">
                                                                usemail@example.com
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300">
                                                            $320
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                        <div class="shrink-0">
                                                            <img class="w-8 h-8 rounded-full" src="/img/usa.png"
                                                                alt="Neil image">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                                                United States
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                                uszemail@example.com
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300">
                                                            $3467
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                        <div class="shrink-0">
                                                            <img class="w-8 h-8 rounded-full" src="/img/india.png"
                                                                alt="Neil image">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                                                indianEX
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                                uszemail@example.com
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300">
                                                            $67
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="py-3 sm:py-4">
                                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                        <div class="shrink-0">
                                                            <img class="w-8 h-8 rounded-full" src="/img/rsa.png"
                                                                alt="Neil image">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                                                RussiaEX
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                                uszemail@example.com
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300">
                                                            $2367
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pt-3 pb-0 sm:pt-4">
                                                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                        <div class="shrink-0">
                                                            <img class="w-8 h-8 rounded-full" src="/img/rsa.png"
                                                                alt="Neil image">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                                                RussiaEX
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                                uszemail@example.com
                                                            </p>
                                                        </div>
                                                        <div
                                                            class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-300">
                                                            $376
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row-3  -->
                                <div class="border dark:border-gray-800 p-6  rounded-xl mb-5">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                        <!--Commission Member List -->
                                        <div
                                            class="bg-white rounded-lg p-6 dark:bg-gray-900 border dark:border-gray-800">
                                            <h2 class="text-xs font-semibold mb-5 text-gray-800 dark:text-gray-300">
                                                Commission Members</h2>
                                            <ul class="space-y-3">
                                                <li class="flex items-center space-x-3">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-1.png"
                                                        alt="member">
                                                    <span class="text-xs text-gray-600 dark:text-gray-400">John
                                                        Doe</span>
                                                </li>
                                                <li class="flex items-center space-x-3">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-2.png"
                                                        alt="member">
                                                    <span class="text-xs text-gray-600 dark:text-gray-400">Sarah
                                                        Smith</span>
                                                </li>
                                                <li class="flex items-center space-x-3">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-3.png"
                                                        alt="member">
                                                    <span class="text-xs text-gray-600 dark:text-gray-400">Michael
                                                        Lee</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <!--Graph -->
                                        <div
                                            class="bg-white rounded-lg p-6 dark:bg-gray-900 border dark:border-gray-800">
                                            <h3 class="text-xs font-semibold mb-4 text-gray-800 dark:text-gray-300">
                                                Performance Graph</h3>
                                            <canvas id="myChart" class="w-full h-64"></canvas>
                                        </div>

                                        <!--Ranking Card -->
                                        <div
                                            class="bg-white rounded-lg p-6 dark:bg-gray-900 border dark:border-gray-800">
                                            <h2 class="text-xs font-semibold mb-4 text-gray-800 dark:text-gray-300">Top
                                                Rankings</h2>
                                            <div class="space-y-3">
                                                <div
                                                    class="flex text-xs text-gray-600 dark:text-gray-300 items-center justify-between p-2 bg-gray-100 dark:bg-gray-800 border dark:border-gray-700 rounded">
                                                    <span>1. Alice</span>
                                                    <span class="font-semibold text-green-600">98%</span>
                                                </div>
                                                <div
                                                    class="flex text-xs text-gray-600 dark:text-gray-300 items-center justify-between p-2 bg-gray-100 dark:bg-gray-800 border dark:border-gray-700 rounded">
                                                    <span>2. Bob</span>
                                                    <span class="font-semibold text-blue-600">89%</span>
                                                </div>
                                                <div
                                                    class="flex text-xs text-gray-600 dark:text-gray-300 items-center justify-between p-2 bg-gray-100 dark:bg-gray-800 border dark:border-gray-700 rounded">
                                                    <span>3. Charlie</span>
                                                    <span class="font-semibold text-yellow-600">75%</span>
                                                </div>
                                                <div
                                                    class="flex text-xs text-gray-600 dark:text-gray-300 items-center justify-between p-2 bg-gray-100 dark:bg-gray-800 border dark:border-gray-700 rounded">
                                                    <span>4. Roshan</span>
                                                    <span class="font-semibold text-red-600">25%</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
              
                 
            </main>
    <!-- Main container:ends -->
  @endsection
