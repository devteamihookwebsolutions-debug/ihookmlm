<div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-col-4 gap-5">

    <!--Events-widget-->

    <div class="p-6 bg-white border border-neutral-200 rounded-lg shadow-sm dark:border-neutral-700 dark:bg-neutral-900 mb-6  ">
        <h3 class="text-lg font-semibold text-black dark:text-white mb-3">{{ __('Events') }}</h3>

        <ul role="list" class="divide-y divide-neutral-200 dark:divide-neutral-700">
            
            @if ($events && count($events) > 0)
                @foreach ($events as $event)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center min-w-0">
                            <img class="flex-shrink-0 w-24 rounded-[5px]" 
                                 src="{{$_ENV['CDNCLOUDEXTURL']}}/{{ $event['event_profile'] }}" 
                                 alt="{{ $event['event_title'] }} image">
                            <div class="ml-3">
                                <p class="font-medium text-black truncate dark:text-white">
                                    {{ $event['event_title'] }}
                                </p>
                                <div class="text-sm text-green-500 dark:text-green-400">
                                    <span class="text-black">{{ $event['event_date'] }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- <button type="button"
                            class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                           {{ __(' Know More') }}
                        </button> -->
                    </div>
                </li>
            @endforeach
            <li class="py-3 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center min-w-0">
                        </div>
                        <a href="{{$_ENV['FCPATH']}}/events">
                        <button type="button" class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                        {{ __(' Know More') }}
                        </button>
                        </a>
                    </div>
                </li>
            @else
            <li class="py-3 sm:py-4">
                <div class="text-center text-black dark:text-white">
                    <img src="/public/assets/img/no-event.svg" class="w-48 h-48 mx-auto" alt="No data found"> 
                </div>
            </li>
        @endif

        </ul>

    </div>

    <!--distributors-widget-->

    <div class="p-6 bg-white col-span-2 border border-neutral-200 rounded-lg shadow-sm dark:border-neutral-700 dark:bg-neutral-900 mb-6 ">
        <h3 class="text-lg font-semibold text-black dark:text-white mb-3">{{ __('Recently Joined Distributors') }}</h3>
        <div class="relative overflow-x-auto sm:rounded-lg h-96 overflow-auto">
        <table class="w-full text-sm text-left rtl:text-right text-black dark:text-white">
            <thead class="text-xs text-black uppercase bg-neutral-50 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                <tr>
                    <th scope="col" class="px-6 py-3">
                    {{ __('Name') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                    {{ __('Email') }} 
                    </th>
                    <th scope="col" class="px-6 py-3">
                    {{ __('DOJ') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                    {{ __('Country') }}
                    </th>
                    <!-- <th scope="col" class="px-6 py-3">
                    {{ __('Phone') }} 
                    </th> -->
                    <!-- <th scope="col" class="px-6 py-3">
                    {{ __('Plan') }}
                    </th> -->
                    <!-- <th scope="col" class="px-6 py-3">
                    {{ __('status') }}
                    </th> -->
                </tr>
            </thead>
            <tbody>
                @if (!$isEmpty)
                    @foreach ($recent_distributor as $distributor)
                        @if (!empty($distributor))
                        <tr class="bg-white border-b border-neutral-200 dark:bg-neutral-900 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-600 text-black dark:text-white">
                                <td class="p-4 flex items-center">
                                    <img class="w-10 h-10 rounded-full" src="{{ $distributor['members_image'] ?? '#' }}" alt="Distributor Image">
                                     <label class="mx-4 dark:text-white"> {{ $distributor['members_username'] ?? 'N/A' }}</label>
                                </td>
                                <td class="px-6 py-4 dark:text-neutral-100">{{ $distributor['members_email'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 dark:text-neutral-100">{{ $distributor['members_doj'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 dark:text-neutral-100">{{ $distributor['members_country'] ?? 'N/A' }}</td>
                                <!-- <td class="px-6 py-4 dark:text-neutral-100">{{ $distributor['members_phone'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 dark:text-neutral-100">{{ $distributor['package_name'] ?? 'N/A' }}</td> -->
                                <!-- <td class="px-6 py-4 dark:text-neutral-100">
                                    @if ($distributor['members_status'] == 1)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            Suspended
                                        </span>
                                    @endif
                                </td> -->
                                
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center py-4 text-black">
                        {{ __('No data found') }}
                        </td>
                    </tr>
                @endif


            </tbody>
        </table>
        </div>
    </div>

    <!--country-sales-widget-->

    <div class="p-6 bg-white border border-neutral-200 rounded-lg shadow-sm dark:border-neutral-700 dark:bg-neutral-900 mb-6">
        <div class="flex justify-between mb-3 items-center">
            <h3 class="text-lg font-semibold text-black dark:text-white">{{ __('Sales By Country') }}</h3>
            <!-- <div class="text-sm text-black dark:text-white"><a href="#">{{ __('View Report') }}</a></div> -->
        </div>

        <canvas id="worldMapChart" width="800" height="600" style="display: block;box-sizing: border-box;height: 305px;width: 315px;"></canvas>

    </div>

</div>

