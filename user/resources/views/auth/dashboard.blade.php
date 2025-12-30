@extends('user::components.common.main')

     <!-- Main Content Area -->
    <main class="flex-1 p-6 ml-2 mt-10">
        <!-- bread crumb -->


        <!-- dash top contents  -->
        <div class="flex flex-grow">

            <div class="mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-3">


                <!-- bread crumb  -->

                <div class="flex mt-3 ml-10" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="#"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="#"
                                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Login</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span
                                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">DashBoard</span>
                            </div>
                        </li>
                    </ol>
                </div>

                <!-- dash top contents  -->
                <div class="flex flex-grow">
                    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-3">

                        <!--Row-2-starts-->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-5 mb-5">

                            <div class="col-span-full xl:col-auto">

                                <div class="bg-white rounded-full shadow px-8 py-6 mb-5 dark:bg-gray-500">
                                    <div class="flex items-center gap-5">
                                        <div class="widget-icon">
                                            <div class="ring ring-gray-900 dark:ring-gray-800 rounded-full p-4">
                                                <svg class="w-[32px] h-[32px] text-gray-800" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="widget-data">
                                            <h3 class="text-sm text-gray-600 dark:text-gray-800 mb-2">Weekly Income</h3>
                                            <div id="" class="text-2xl font-semibold dark:text-gray-800"><span
                                                    class="text-sm top-n-4 ">$</span><span
                                                    class="text-2xl">600</span>,<span class="text-base">00</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-full shadow px-8 py-6 dark:bg-gray-500">
                                    <div class="flex items-center gap-5">
                                        <div class="widget-icon">
                                            <div class="ring ring-gray-900 dark:ring-gray-800 rounded-full p-4">
                                                <svg class="w-[32px] h-[32px] text-gray-800" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="widget-data">
                                            <h3 class="text-sm text-gray-600 dark:text-gray-800 mb-2">Weekly Income</h3>
                                            <div id="" class="text-2xl font-semibold dark:text-gray-800"><span
                                                    class="text-sm top-n-4 ">$</span><span
                                                    class="text-2xl">600</span>,<span class="text-base">00</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-span-full xl:col-auto">

                                <div class="bg-white rounded-full shadow px-8 py-6 mb-5 dark:bg-gray-500 ">
                                    <div class="flex items-center gap-5">
                                        <div class="widget-icon">
                                            <div class="ring ring-gray-900 dark:ring-gray-800 rounded-full p-4">
                                                <svg class="w-[32px] h-[32px] text-gray-800" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="widget-data">
                                            <h3 class="text-sm text-gray-600 dark:text-gray-800 mb-2">Weekly Income</h3>
                                            <div id="" class="text-2xl font-semibold dark:text-gray-800"><span
                                                    class="text-sm top-n-4 ">$</span><span
                                                    class="text-2xl">600</span>,<span class="text-base">00</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-full shadow px-8 py-6 dark:bg-gray-500">
                                    <div class="flex items-center gap-5">
                                        <div class="widget-icon">
                                            <div class="ring ring-gray-900 dark:ring-gray-800 rounded-full p-4">
                                                <svg class="w-[32px] h-[32px] text-gray-800" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="widget-data">
                                            <h3 class="text-sm text-gray-600 dark:text-gray-800 mb-2">Weekly Income</h3>
                                            <div id="" class="text-2xl font-semibold dark:text-gray-800"><span
                                                    class="text-sm top-n-4 ">$</span><span
                                                    class="text-2xl">600</span>,<span class="text-base">00</span></div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <!-- rounded-widgets -->


                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow px-8 py-6 flex flex-col justify-between">
                                <div class="flex justify-between items-center">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">New Downlines</h3>
                                        <div id="" class="text-2xl font-semibold"><span
                                                class="text-sm top-n-4">$</span><span class="text-2xl">600</span>,<span
                                                class="text-base">00</span></div>
                                    </div>
                                    <div class="widget-icon">
                                        <div class="ring ring-gray-900 dark:ring-gray-500 rounded-full p-4">
                                            <svg class="w-[32px] h-[32px] text-gray-800 dark:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 12v4m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 0v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-bar">
                                    <div class="flex justify-between items-center">
                                        <div class="mb-1 text-base font-medium dark:text-white">Dark</div>
                                        <div class="mb-1 text-base font-medium dark:text-white">45%</div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                                        <div class="bg-gray-900 h-2.5 rounded-full dark:bg-gray-300" style="width: 45%">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--Row-2-ends-->
                        <!--Row-4-starts-->
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5">
                            <!--Order Status Report-->

                            <div
                                class="max-w-sm p-6 bg-white border border-gray-200 rounded-2xl shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <!-- Profile Section -->
                                <div class="flex items-center space-x-4">
                                    <!-- Profile Image -->
                                    <img class="w-16 h-16 rounded-full border-2 border-blue-500 shadow-sm"
                                        src="/img/av-ico-1.png" alt="User profile">

                                    <!-- Name and Rank -->
                                    <div>
                                        <h5 class="text-xl font-semibold text-gray-900 dark:text-white">John Doe</h5>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">🏆 Current
                                            Rank: #1</span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                    Top performer with consistent high rankings over the years.
                                </p>

                                <!-- Rank History Table -->
                                <div class="mt-4">
                                    <h6 class="mb-2 text-sm font-semibold text-gray-800 dark:text-gray-300">Rank History
                                    </h6>
                                    <div class="overflow-x-auto">
                                        <table
                                            class="w-full text-sm text-left text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-lg">
                                            <thead
                                                class="text-xs uppercase bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                <tr>
                                                    <th scope="col" class="px-3 py-2">Year</th>
                                                    <th scope="col" class="px-3 py-2">Rank</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                                                    <td class="px-3 py-2">2023</td>
                                                    <td class="px-3 py-2">#1</td>
                                                </tr>
                                                <tr
                                                    class="bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                                                    <td class="px-3 py-2">2022</td>
                                                    <td class="px-3 py-2">#3</td>
                                                </tr>
                                                <tr
                                                    class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                                                    <td class="px-3 py-2">2021</td>
                                                    <td class="px-3 py-2">#5</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-4">
                                    <a href="#"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                        View Profile
                                        <svg class="rtl:rotate-180 w-4 h-4 ms-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!--rewards-->
                            <div class="bg-white rounded-lg shadow p-6 mb-5 col-span-1 dark:bg-gray-800">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Sales Analysis
                                </h3>
                                <div class="flex justify-between items-center mb-5">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">Total Rewards</h3>
                                        <div id="" class="text-2xl font-semibold"><span
                                                class="text-sm top-n-4">$</span><span class="text-2xl">600</span>,<span
                                                class="text-base">00</span></div>
                                    </div>
                                    <button type="button"
                                        class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                        More</button>
                                </div>
                                <div class="flex justify-between items-center mb-5">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">Minimum Withdrawal Limit</h3>
                                        <div id="" class="text-2xl font-semibold"><span
                                                class="text-sm top-n-4">$</span><span class="text-2xl">600</span>,<span
                                                class="text-base">00</span></div>
                                    </div>
                                    <button type="button"
                                        class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                        More</button>
                                </div>
                                <div class="flex justify-between items-center mb-5">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">Available Rewards</h3>
                                        <div id="" class="text-2xl font-semibold"><span
                                                class="text-sm top-n-4">$</span><span class="text-2xl">600</span>,<span
                                                class="text-base">00</span></div>
                                    </div>
                                    <button type="button"
                                        class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                        More</button>
                                </div>
                            </div>
                            <!--sales-->
                            <div class="bg-white rounded-lg shadow p-6 mb-5 col-span-1 dark:bg-gray-800">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 dark:text-gray-200">Finance Summary
                                </h3>
                                <div class="flex justify-between items-center mb-5">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">Total Sales</h3>
                                        <div id="" class="text-2xl font-semibold"><span class="text-2xl">600</span>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                        More</button>
                                </div>
                                <div class="flex justify-between items-center mb-5">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">Sales Commission</h3>
                                        <div id="" class="text-2xl font-semibold"><span
                                                class="text-sm top-n-4">$</span><span class="text-2xl">600</span>,<span
                                                class="text-base">00</span></div>
                                    </div>
                                    <button type="button"
                                        class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                        More</button>
                                </div>
                                <div class="flex justify-between items-center mb-5">
                                    <div class="widget-data">
                                        <h3 class="text-sm text-gray-600 mb-2">Total Sales Amount</h3>
                                        <div id="" class="text-2xl font-semibold"><span
                                                class="text-sm top-n-4">$</span><span class="text-2xl">600</span>,<span
                                                class="text-base">00</span></div>
                                    </div>
                                    <button type="button"
                                        class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                        More</button>
                                </div>
                            </div>
                        </div>

                        <!--Row-4-ends-->
                        <!--Row-5-starts-->
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-4 gap-5">
                            <!--Events-widget-->
                            <div class="bg-white rounded-lg shadow p-6 mb-5 mt-5 dark:bg-gray-800">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 dark:text-gray-200">Invest & Events
                                </h3>
                                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <img class="flex-shrink-0 w-12" src="/img/etherium.png" alt="gold">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        Etherium
                                                    </p>

                                                </div>
                                            </div>
                                            <button type="button"
                                                class="text-white brand-color font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Upcoming</button>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <img class="flex-shrink-0 w-12" src="/img/dollar.png" alt="silver">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        Dollar
                                                    </p>

                                                </div>
                                            </div>
                                            <button type="button"
                                                class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                                More</button>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <img class="flex-shrink-0 w-12" src="/img/gold.png" alt="copper">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        Gold
                                                    </p>

                                                </div>
                                            </div>
                                            <button type="button"
                                                class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                                More</button>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <img class="flex-shrink-0 w-12" src="/img/silver.png" alt="silver">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        Silver
                                                    </p>

                                                </div>
                                            </div>
                                            <button type="button"
                                                class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                                More</button>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                <img class="flex-shrink-0 w-12" src="/img/copper.png" alt="copper">
                                                <div class="ml-3">
                                                    <p class="font-medium text-gray-900 truncate dark:text-white">
                                                        Copper
                                                    </p>

                                                </div>
                                            </div>
                                            <button type="button"
                                                class="text-white bg-gray-900 font-medium rounded-lg text-xs px-4 py-2 text-center dark:hover:bg-[#FF5D19]">Know
                                                More</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--distributors-widget-->
                            <div class="bg-white rounded-lg shadow p-6 mb-5 col-span-2 dark:bg-gray-800">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 dark:text-gray-200">Recently Joined
                                    Distributors</h3>
                                <table id="default-table">
                                    <thead>
                                        <tr>
                                            <th class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    Name
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                            <th data-type="date" data-format="YYYY/DD/MM" class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    Email
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                            <th class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    DOJ
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                            <th class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    Country
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                            <th class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    Phone
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                            <th class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    Plan
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                            <th class="dark:bg-yellow-700">
                                                <span class="flex items-center dark:text-white">
                                                    status
                                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                    </svg>
                                                </span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="">
                                                <div class="flex items-center gap-4">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-1.png" alt="">
                                                    <div
                                                        class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                        <tr>
                                            <td class="">
                                                <div class="flex items-center gap-4">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-3.png" alt="">
                                                    <div
                                                        class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <div>Brandon Mccullam jones</div>
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
                                        <tr>
                                            <td class="">
                                                <div class="flex items-center gap-4">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-1.png" alt="">
                                                    <div
                                                        class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                        <tr>
                                            <td class="">
                                                <div class="flex items-center gap-4">
                                                    <img class="w-10 h-10 rounded-full" src="/img/av-ico-2.png" alt="">
                                                    <div
                                                        class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                            <div class="bg-white rounded-lg shadow p-6 mb-5 dark:bg-gray-800">
                                <div class="flex justify-between mb-3 items-center mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Country</h3>
                                    <div class="text-sm text-gray-600 mb-2"><a href="#">View Report</a></div>
                                </div>
                                <!--country-chart-->

                                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                                    <li class="pb-3 sm:pb-4">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="/img/usa.png" alt="us image">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    United States
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    usemail@flowbite.com
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                $320
                                            </div>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="/img/usa.png" alt="Neil image">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    United States
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    uszemail@flowbite.com
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                $3467
                                            </div>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="/img/india.png" alt="Neil image">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    indianEX
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    email@flowbite.com
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                $67
                                            </div>
                                        </div>
                                    </li>
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="/img/rsa.png" alt="Neil image">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    Russia
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    Rusemail@flowbite.com
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                $2367
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="/img/rsa.png" alt="Neil image">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    RussianEx
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    Rxsaemail@flowbite.com
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                $367
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <!--Row-5-ends-->

                    </div>
                </div>

                <!-- fisrt commision chart list  -->

                <div class="max-w-7xl mx-auto px-4  grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                    <!-- 1️⃣ Commission Member List -->
                    <div class="bg-white rounded-lg shadow p-4 dark:bg-gray-800">
                        <h2 class="text-lg font-semibold mb-1">Commission Members</h2>
                        <ul class="space-y-3">
                            <li class="flex items-center space-x-3 ">
                                <img class="w-10 h-10 rounded-full" src="/img/av-ico-1.png" alt="member">
                                <span class="font-medium">John Doe</span>
                            </li>

                            <li class="flex items-center space-x-3">
                                <img class="w-10 h-10 rounded-full" src="/img/av-ico-2.png" alt="member">
                                <span class="font-medium">Sarah Smith</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <img class="w-10 h-10 rounded-full" src="/img/av-ico-3.png" alt="member">
                                <span class="font-medium">Michael Lee</span>
                            </li>
                        </ul>
                    </div>

                    <!-- 2️⃣ Graph -->
                    <div class="bg-white rounded-lg shadow p-4 dark:bg-gray-800">
                        <h2 class="text-lg font-semibold mb-4">Performance Graph</h2>
                        <canvas id="myChart" class="w-full h-64"></canvas>
                    </div>

                    <!-- 3️⃣ Ranking Card -->
                    <div class="bg-white rounded-lg shadow p-4 dark:bg-gray-800">
                        <h2 class="text-lg font-semibold mb-4">Top Rankings</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded dark:bg-gray-800">
                                <span>1. Alice</span>
                                <span class="font-semibold text-green-600">98%</span>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded dark:bg-gray-800">
                                <span>2. Bob</span>
                                <span class="font-semibold text-blue-600">89%</span>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded dark:bg-gray-800">
                                <span>3. Charlie</span>
                                <span class="font-semibold text-yellow-600">75%</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </main>
    <!-- Main container:ends -->
