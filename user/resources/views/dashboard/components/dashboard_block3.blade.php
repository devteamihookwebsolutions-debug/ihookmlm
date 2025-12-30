   <!-- Row 3 -->
   <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
    <div class="bg-[url('/public/assets/img/banner-2.png')] bg-cover  bg-top bg-no-repeat dark:bg-neutral-900 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
       <div class="flex justify-between items-center gap-3 mb-5">
          <h3 class="text-lg text-neutral-100 dark:text-white font-semibold">{{ __('Events') }}</h3>
          <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
             class="text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm p-1 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700"
             type="button">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                   d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
             </svg>
          </button>
          <!-- Dropdown menu -->
          <div id="dropdown"
             class="z-10 hidden bg-white  divide-y divide-neutral-100 rounded-lg shadow-sm w-44 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
         <ul class="py-2 text-sm text-black dark:text-neutral-200" aria-labelledby="dropdownDefaultButton">
                <li>
                   <a href="#"
                      class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600 dark:hover:text-white">Upcoming</a>
                </li>
                <li>
                   <a href="#"
                      class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600 dark:hover:text-white">Completed</a>
                </li>
             </ul>
          </div>
       </div>


       @if ($events && count($events) > 0)
       @foreach ($events as $event)
       <div class="event-details mb-4">
          <div
             class="p-3 rounded-lg border border-neutral-200 dark:border-neutral-500 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
             <div class="flex justify-between items-center">

                <div class="icon-desc flex flex-wrap gap-2">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="size-6 text-neutral-100 dark:text-white">
                      <path stroke-linecap="round" stroke-linejoin="round"
                         d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                   </svg>
                   <div class="grid grid-cols-1 gap-1">
                      <div class="text-neutral-100 dark:text-white text-md font-semibold ">
                         <a href="/admin/events/details/{{ $event['event_id'] }}" >{{ $event['event_title'] }}</a>
                      </div>
                      <div class="grid grid-cols-2">
                         <p class="text-neutral-100 dark:text-white">{{ $event['event_date'] }}</p>

                      </div>
                   </div>
                </div>

             </div>
          </div>
       </div>
       @endforeach
       @else
       <div class="text-center text-black dark:text-white">
          <img src="/public/assets/img/no-event.svg" class="w-48 h-48 mx-auto" alt="No data found">
       </div>
       @endif

    </div>
    <div class="bg-white dark:bg-neutral-900 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
       <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('Sales Overview') }}</h3>
       <div
          class="widget-data border rounded-lg border-cyan-300 p-3 mb-3 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
          <div class="flex justify-between flex-wrap">
             <div class="flex flex-col">
                <h3 class="text-sm text-black dark:text-white mb-2 ">{{ __('Total Sales') }}</h3>
                <div id="" class="text-lg font-semibold text-black dark:text-neutral-100"><span
                      class="text-2xl">{{ $salesoverview['shop_sales_count_overall'] }}</span></div>
             </div>
             <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="h-14 w-14 rounded-xl bg-cyan-50 p-4 text-cyan-600">
                   <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
             </div>
          </div>
       </div>
       <div
          class="widget-data border rounded-lg border-yellow-300 p-3 mb-3 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
          <div class="flex justify-between flex-wrap">
             <div class="flex flex-col">
                <h3 class="text-sm text-black dark:text-white mb-2 ">{{ __('Sales last 7 days') }}</h3>
                <div id="" class="text-lg font-semibold text-black dark:text-neutral-100"><span
                      class="text-2xl">{{ $salesoverview['shop_sales_count_last_7_days'] }}</span></div>
             </div>
             <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="h-14 w-14 rounded-xl bg-yellow-50 p-4 text-yellow-600">
                   <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
             </div>
          </div>
       </div>
       <div
          class="widget-data border rounded-lg border-purple-300 p-3 mb-3 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
          <div class="flex justify-between flex-wrap">
             <div class="flex flex-col">
                <h3 class="text-sm text-black dark:text-white mb-2 ">{{ __('Total Sales Amount') }}</h3>
                <div id="" class="text-lg font-semibold text-black dark:text-neutral-100"><span
                      class="text-2xl">{{['site_settings']['site_currency']}}{{ $salesoverview['total_sales_value'] }}</span></div>
             </div>
             <a href="/admin/shoporder"><div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="h-14 w-14 rounded-xl bg-purple-50 p-4 text-purple-600">
                   <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
             </div></a>
          </div>
       </div>
    </div>
    <div class="bg-white dark:bg-neutral-900 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
       <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('Rewards Overview') }}</h3>
       <div
          class="widget-data border rounded-lg border-blue-300 p-3 mb-3 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
          <div class="flex justify-between flex-wrap">
             <div class="flex flex-col">
                <h3 class="text-sm text-black dark:text-white mb-2 ">{{ __('Total Rewards') }}</h3>
                <div id="" class="text-lg font-semibold text-black dark:text-neutral-100"><span
                      class="text-2xl">{{['site_settings']['site_currency']}}{{$commissionoverview['overall_exclusive']}}</span></div>
             </div>
             <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="h-14 w-14 rounded-xl bg-blue-50 p-4 text-blue-600">
                   <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z">
                   </path>
                </svg>
             </div>
          </div>
       </div>
       <div
          class="widget-data border rounded-lg border-green-300 p-3 mb-3 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
          <div class="flex justify-between flex-wrap">
             <div class="flex flex-col">
                <h3 class="text-sm text-black dark:text-white mb-2 ">{{ __('Minimum Withdrawal Limit') }}</h3>
                <div id="" class="text-lg font-semibold text-black dark:text-neutral-100"><span
                      class="text-2xl">{['site_settings']['site_currency']}}{{$commissionoverview['no_withdraw_allowed']}}</span></div>
             </div>
             <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="h-14 w-14 rounded-xl bg-green-50  p-4 text-green-600">
                   <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                   </path>
                </svg>
             </div>
          </div>
       </div>
       <div
          class="widget-data border rounded-lg border-red-300 p-3 mb-3 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
          <div class="flex justify-between flex-wrap">
             <div class="flex flex-col">
                <h3 class="text-sm text-black dark:text-white mb-2 ">{{ __('Available Rewards') }}</h3>
                <div id="" class="text-lg font-semibold text-black dark:text-neutral-100"><span
                      class="text-2xl">{['site_settings']['site_currency']}}{{$commissionoverview['overall_inclusive']}}</span></div>
             </div>
             <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="h-14 w-14 rounded-xl bg-rose-50 dark:bg-red-900 p-4 text-rose-600">
                   <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3.75v16.5M2.25 12h19.5M6.375 17.25a4.875 4.875 0 0 0 4.875-4.875V12m6.375 5.25a4.875 4.875 0 0 1-4.875-4.875V12m-9 8.25h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v13.5a1.5 1.5 0 0 0 1.5 1.5Zm12.621-9.44c-1.409 1.41-4.242 1.061-4.242 1.061s-.349-2.833 1.06-4.242a2.25 2.25 0 0 1 3.182 3.182ZM10.773 7.63c1.409 1.409 1.06 4.242 1.06 4.242S9 12.22 7.592 10.811a2.25 2.25 0 1 1 3.182-3.182Z">
                   </path>
                </svg>
             </div>
          </div>
       </div>
    </div>
    <div class="bg-white dark:bg-neutral-900 rounded-lg shadow p-6 2 border border-neutral-200 dark:border-neutral-700">
       <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('Sales By Country') }}</h3>
       <div id="world-map-container" class="h-[300px] w-full rounded-lg"></div>
    </div>
 </div>
 <!-- Row 3 -->
