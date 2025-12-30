<div class="flex-1" id="summary" role="tabpanel" aria-labelledby="summary-tab">
    <!-- Tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Account Details Table -->
        <div class="mt-5 md:mt-0 bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
            <h3 class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-3">
                {{ __('Account Details') }}
            </h3>

            <ul class="text-xs divide-y divide-gray-200 dark:divide-gray-700">
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400"> {{ __('Member
                        ID') }}</span><span class="text-gray-800 dark:text-gray-300">{!!
                        $errval['members_id'] ?? '-' !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{ __('Member
                        Type') }}</span><span class="text-gray-800 dark:text-gray-300">{!!
                        $userdetails['members_type_name'] ?? '-' !!}</span>
                </li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{ __('Status')
                        }}</span><span class="text-red-800 dark:text-red-600">{!! $status
                        !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{
                        __('Username') }}</span><span class="text-gray-800 dark:text-gray-300">{!!
                        $errval['members_username'] ?? '-' !!}</span>
                </li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{
                        __('Sitename') }}</span>
                    @if($members_subdomain && $members_subdomain !== '-')
                    <a href="http: //{{ $members_subdomain
                        }}.ihookwebsolutions.com" class="text-blue-500 hover:underline" target="_blank">
                        {{ $members_subdomain }}</a>
                    @else
                    <span class="text-gray-500">{{ __('Not set') }}</span>
                    @endif
                </li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Last Login') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $userdetails['lastlogin'] ?? '-' !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Date of Join') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $members_doj !!}</span>
                </li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('IP Address') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $errval['members_ip_address'] ?? '-' !!}</span>
                </li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">
                        {{ __('Member From') }}</span><span class="text-gray-800 dark:text-gray-300">{!!
                        $userdetails['members_from'] ?? '-' !!}</span>
                </li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">
                        {{ __('Ein') }}</span>
                    <span class="text-gray-800 dark:text-gray-300">{!! $members_ssn_number !!}</span>
                </li>
            </ul>
        </div>

        <!-- Contact Table -->
        <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
            <h3 class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-3">{{ __('Contact') }}</h3>
            <ul class="text-xs divide-y divide-gray-200 dark:divide-gray-700">
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{
                                                            __('Firstname') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!!
                        $members_firstname !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{
                                                            __('Lastname') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!!
                        $members_lastname !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400"> {{ __('Email
                                                            ID') }}</span><span
                        class="text-gray-800 dark:text-gray-300">@if($members_email
                        && filter_var($members_email, FILTER_VALIDATE_EMAIL))
                        <a href="mailto:{{ $members_email }}" class="text-blue-500 hover:underline">
                            {{ $members_email }}
                        </a>
                        @else
                        {{ $members_email }}
                        @endif</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{ __('Contact
                                                            No') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!!
                        $members_phone !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{ __('Date of
                                                            Birth') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!!
                        $members_dob !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400"> {{
                                                            __('Address') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!!
                        nl2br(e($members_address)) !!}</span></li>
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{ __('Address
                                                            Two') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!!
                        nl2br(e($members_address2)) !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Address Three') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! nl2br(e($members_address3)) !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('City') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $members_city !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('State') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $members_state !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Country') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $country !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Zip') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $members_zip !!}</span></li>
            </ul>
        </div>

        <!-- Activities -->
        <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
            <h3 class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-3">{{ __('Activities') }}</h3>
            <ul class="text-xs divide-y divide-gray-200 dark:divide-gray-700">
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('IP Address') }}</span><span
                        class="text-gray-800 dark:text-gray-300">{!! $login_ip !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Last Login') }}</span><span
                        class="text-gray-800 dark:text-gray-400">{!! $userdetails['lastlogin'] ?? '-' !!}</span></li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Login Attempts') }}</span><span
                        class="text-gray-800 dark:text-gray-400">{!! $login_attempt !!}</span></li>
            </ul>
        </div>

        <!-- Preferences -->
        <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
            <h3 class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-3">{{ __('Preferences') }}</h3>
            <ul class="text-xs divide-y divide-gray-200 dark:divide-gray-700">
                <li class="flex justify-between p-2"><span class="text-gray-600 dark:text-gray-400">{{
                                                            __('Replicated Website') }}
                        Mobile</span><span class="text-green-600">
                        @if($members_subdomain && $members_subdomain !== '-')
                        <span class="text-green-600 font-medium">{{
                                                                __('Enabled') }}</span>
                        @else
                        <span class="text-red-600">{{ __('Disabled') }}</span>
                        @endif</span>
                </li>
                <li class="flex justify-between p-2"><span
                        class="text-gray-600 dark:text-gray-400">{{ __('Language') }}</span><span
                        class="text-gray-800 dark:text-gray-400">{!! $language !!}</span></li>
            </ul>
        </div>

        <!-- Revenue Summary -->
        <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
            <h3 class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-3">{{ __('Revenue Summary') }}</h3>
            <div class="datatable-wrapper datatable-loading no-footer sortable fixed-columns">
                <div class="datatable-top"></div>
                <div class="datatable-container">
                    <table class="datatable-table">
                        <tbody>
                            @if(trim($revenue) === '' || str_contains($revenue, 'No revenue'))
                            <tr class="text-xs">
                                <td colspan="2" class="px-6 py-4 text-xs text-center text-gray-500 dark:text-gray-400">
                                    {{ __('No revenue data') }}
                                </td>
                            </tr>
                            @else
                            {!! $revenue !!}
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Yearly Summary -->
    <div class="mt-5 bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <h3 class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-3">{{ __('Yearly Summary') }}</h3>
        <div class="datatable-wrapper datatable-loading no-footer sortable fixed-columns">
            <div class="datatable-top"></div>
            <div class="datatable-container ">
                <table class="datatable-table w-full text-xs">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                        <tr>
                            <th class="px-3 py-2">Year</th>
                            <th class="px-3 py-2">YTD</th>
                            <th class="px-3 py-2">MTD</th>
                            <th class="px-3 py-2">L3M</th>
                            <th class="px-3 py-2">L6M</th>
                            <th class="px-3 py-2">Q1</th>
                            <th class="px-3 py-2">Q2</th>
                            <th class="px-3 py-2">Q3</th>
                            <th class="px-3 py-2">Q4</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @if(trim($sales) === '' || str_contains($sales, 'No sales data'))
                        <tr class="text-xs text-gray-500 dark:text-gray-400">
                            <td colspan="9" class="px-3 py-3 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No sales data') }}
                            </td>
                        </tr>
                        @else
                        {!! $sales !!}
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>