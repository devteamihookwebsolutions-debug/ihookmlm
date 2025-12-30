
    <div class="flex h-screen overflow-hidden bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
        <!-- ===== Sidebar Start ===== -->
        <aside :class="sidebarToggle ? 'translate-x-0 xl:w-[60px]' : '-translate-x-full'"
            class="sidebar fixed top-0 left-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-auto border-r border-gray-200 bg-white px-2 transition-all duration-300 xl:static xl:translate-x-0 dark:border-gray-800 dark:bg-gray-900"
            @click.outside="if (!sidebarLocked) {sidebarToggle = false; sidebarLocked = true;}">
            <!-- SIDEBAR HEADER -->
            <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
                class="sidebar-header flex items-center gap-2 py-3">
                <a href="index.html">
                    <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                        <img class="w-24" src="/img/logox1.png" alt="Logo" />
                    </span>
                </a>
            </div>
            <!-- SIDEBAR HEADER -->

            <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
                <!-- Sidebar Menu -->
                <nav x-data="{selected: $persist('Dashboard')}">
                    <!-- Menu Group -->
                    <div>
                        <!-- Menu Items -->
                        <ul class="space-y-2 font-awesome px-2 w-auto">
                            <!-- fisrt ico dashboard -->
                            <li>
                                <a href="/user/dashboard" class="flex  items-center p-2 rounded-lg text-gray-500 dark:text-white
                                        hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4" aria-hidden="true" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                                        </svg>
                                        <span class="ml-3 text-xs">Dashboard</span>
                                    </div>
                                </a>
                            </li>

                            <!-- icon myteams -->
                            <li>
                                <!-- Accordion Header -->
                                <a id="myteams-toggle"
                                    class="flex items-center p-2 rounded-lg cursor-pointer text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 12v4m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 0v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                        </svg>
                                        <span class="ml-3 relative text-xs whitespace-nowrap">My-Teams
                                            <svg id="myteams-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="myteams-menu" class="hidden pl-5">
                                    <ul class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        @php
                                            $user       = Auth::user();
                                            $members_id = $user->members_id;

                                            // Get default matrix_id if not set
                                            if (empty($matrix_id) && $members_id) {
                                                $prefix = config('ihook.prefix', 'ihook');
                                                $matrix_id = \DB::table("{$prefix}_matrix_members_link_table")
                                                    ->where('members_id', $members_id)
                                                    ->orderBy('link_id')
                                                    ->value('matrix_id') ?? 1;
                                            }

                                            $encryptedToken = \Admin\App\Models\Middleware\MURLCrypt::encode($members_id, $matrix_id);

                                            // Get matrix details to check matrix_type_id
                                            $prefix = config('ihook.prefix', 'ihook');
                                            $matrix = \DB::table("{$prefix}_matrix_table")
                                                ->where('matrix_id', $matrix_id)
                                                ->first();

                                            $matrix_type_id = $matrix->matrix_type_id ?? 0; // fallback
                                        @endphp
                                        <!-- My Organization -->
                                        <li>
                                            <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            href="{{ url('/user/network/view/' . $encryptedToken . '/' . $members_id . '/' . $matrix_id) }}">
                                                My Organization
                                            </a>
                                        </li>

                                        <!-- Enroll New Distributor -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Enroll New Distributor
                                            </a>
                                        </li>

                                        <!-- Enroll a Customer -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Enroll a Customer
                                            </a>
                                        </li>

                                        <!-- Signup a lead -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Signup a lead
                                            </a>
                                        </li>

                                        <!-- Customer Management -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Customer Management
                                            </a>
                                        </li>

                                        <!-- Distributor Management -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Distributor Management
                                            </a>
                                        </li>

                                        <!-- Customer Groups -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Customer Groups
                                            </a>
                                        </li>

                                        <!-- Distributor Groups -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Distributor Groups
                                            </a>
                                        </li>

                                        <!-- Tree View -->
                                       <li>
                                            <a href="{{ url('/user/genealogy/tabularview/' . $encryptedToken) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Tree View
                                            </a>
                                    </li>

                                      <li>
                                            <a href="{{ route('user.advancedgenealogy.viewtree', ['encrypted' => $encryptedToken]) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                Advanced Genealogy
                                            </a>
                                        </li>
                                                <!-- Unilevel Genealogy -->
                                        @if($matrix_type_id == 3)
                                            <li>
                                                <a href="{{ route('') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                    Unilevel Genealogy
                                                </a>
                                            </li>
                                        @endif
                                        <!-- Downline Customer Retail Report -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Downline Customer Retail Report
                                            </a>
                                        </li>

                                        <!-- Downline Autoship Report -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Downline Autoship Report
                                            </a>
                                        </li>

                                        <!-- Waiting Room -->
                                        <li>
                                            <a href=""
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Waiting Room
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--  icon wporder -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="wporder-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">WP Orders
                                            <svg id="wporder-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="wporder-menu" class="hidden pl-5">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="wporders-ordersummary.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Order
                                                Summary</a>
                                        </li>
                                        <li>
                                            <a href="wporder-addorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add
                                                Order</a>
                                        </li>
                                        <li>
                                            <a href="wporders-allorders.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All
                                                Orders</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Retail
                                                Customer Orders</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>


                            <!--  icon lead -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="lead-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                                        </svg>

                                        <span class="ml-3 relative text-xs">Leads
                                            <svg id="lead-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="lead-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="replicated.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Leads
                                                / Replicated</a>
                                        </li>
                                        <li>
                                            <a href="lead-leadcontact.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Leads
                                                Contact</a>
                                        </li>
                                        <li>
                                            <a href="lead-leadcamp&msg.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Campaigns
                                                &amp; Messages</a>
                                        </li>
                                        <li>
                                            <a href="leads-bulkuploaddate.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bulk
                                                Upload data</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <!--  icon customer -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="customers-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>


                                        <span class="ml-3 relative text-xs">Customers
                                            <svg id="customers-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="customers-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="customers-customers.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Customer</a>
                                        </li>
                                        <li>
                                            <a href="customer-customerorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Orders</a>

                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--  icon Tools -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="tools-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16.872 9.687 20 6.56 17.44 4 4 17.44 6.56 20 16.873 9.687Zm0 0-2.56-2.56M6 7v2m0 0v2m0-2H4m2 0h2m7 7v2m0 0v2m0-2h-2m2 0h2M8 4h.01v.01H8V4Zm2 2h.01v.01H10V6Zm2-2h.01v.01H12V4Zm8 8h.01v.01H20V12Zm-2 2h.01v.01H18V14Zm2 2h.01v.01H20V16Z" />
                                        </svg>
                                        <span class="ml-3 relative text-xs">Tools
                                            <svg id="tools-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="tools-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="tools-showcase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Showcase</a>
                                        </li>

                                        <li>
                                            <a href="tools-sms-blase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">SMS
                                                Blase</a>
                                        </li>

                                        <li>
                                            <a href="tools-live-events.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Live
                                                Events</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--  icon Reports -->
                               <li>
                                <!-- Accordion Header -->
                                <a href="#" id="reports-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs">Reports
                                            <svg id="reports-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="reports-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <li>
                                            <a href="{{route('user.ewallet.history')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">E
                                                Wallet History</a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.cwallet.history')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cash
                                                Wallet History</a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.withdrawal.history')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Withdrawal
                                                History</a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.transtractional.history')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My
                                                Transactions History</a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.pvhistory.history')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My
                                                PV Details</a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.packagehistory')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Package
                                                History</a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.downlinesaleshistory')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Downline
                                                Sales Report</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- ico partyplan -->

                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="partyplan-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16.125 6H20v3.85927c0 1.33743-.6684 2.58633-1.7812 3.32823l-1.5791 1.0468M4.18754 17H16.8125M9.00004 7v7M12 7v7M4.94144 4.93762l-.875 13.99998C4.03046 19.5133 4.48767 20 5.06449 20H15.9356c.5768 0 1.034-.4867.998-1.0624l-.875-13.99998C16.0257 4.41059 15.5887 4 15.0606 4H5.93949c-.52806 0-.96511.41059-.99805.93762Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Party Plan
                                            <svg id="partyplan-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="partyplan-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <li>
                                            <a href="party-hostparty.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Host
                                                Party</a>
                                        </li>

                                        <li>
                                            <a href="party-partyreports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Party
                                                Reports</a>
                                        </li>
                                        <li>
                                            <a href="party-show-party-builder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show
                                                Party Builder</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- ico Epin -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="epin-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9.5 11.5 11 13l4-3.5M12 20a16.405 16.405 0 0 1-5.092-5.804A16.694 16.694 0 0 1 5 6.666L12 4l7 2.667a16.695 16.695 0 0 1-1.908 7.529A16.406 16.406 0 0 1 12 20Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">E-pin
                                            <svg id="epin-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="epin-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                     <li>
                                        <a href="{{ route('user.epinrequest.create') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Generate E-Pin
                                        </a>
                                    </li>
                                        <li>
                                            <a href="{{ route('user.epin.history') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My
                                                E-Pins</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--ico Store -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="store-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs">Store
                                            <svg id="store-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="store-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="store-wordpress-products.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Wordpress
                                                Products</a>
                                        </li>
                                        <li>
                                            <a href="store-wordpress-order-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Wordpress
                                                Order History</a>
                                        </li>
                                        <li>
                                            <a href="store-downline-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Downline
                                                Reports</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>


                            <!-- ico messages -->

                            <li>
                                <a href="message.html"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                                        </svg>
                                        <span class="ml-3 text-xs">Messages</span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico Events -->

                            <li>
                                <a href="events.html"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                        </svg>
                                        <span class="ml-3 text-xs">Events</span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico tickets  -->

                            <li>
                                <a href="tickets.html"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18.5 12A2.5 2.5 0 0 1 21 9.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2.5a2.5 2.5 0 0 1 0 5V17a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                                        </svg>
                                        <span class="ml-3 text-xs">Tickets</span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico Resources  -->

                            <li>
                                <a href="resources.html"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m17 21-5-4-5 4V3.889a.92.92 0 0 1 .244-.629.808.808 0 0 1 .59-.26h8.333a.81.81 0 0 1 .589.26.92.92 0 0 1 .244.63V21Z" />
                                        </svg>
                                        <span class="ml-3 text-xs">Resources</span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico Mass Payout  -->

                            <li>
                                <a href="masspayout.html"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                        </svg>

                                        <span class="ml-3 text-xs whitespace-nowrap">Mass Payout</span>
                                    </div>
                                </a>
                            </li>

                            <!-- ad-campaign  -->

                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="adcam-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 9H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h6m0-6v6m0-6 5.419-3.87A1 1 0 0 1 18 5.942v12.114a1 1 0 0 1-1.581.814L11 15m7 0a3 3 0 0 0 0-6M6 15h3v5H6v-5Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Ad-Campaign
                                            <svg id="adcam-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="adcam-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="ad-campaign-ad-text.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ad
                                                Text</a>
                                        </li>
                                        <li>
                                            <a href="ad-campaign-ad-banner.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ad
                                                Banner</a>
                                        </li>
                                        <li>
                                            <a href="ad-campaign-ad-text-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ad
                                                Text Reports</a>
                                        </li>
                                        <li>
                                            <a href="ad-campaign-ad-banner-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ad
                                                Banner Reports</a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-premium-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ad
                                                Premium Reports</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- 10th ico support -->

                            <li>
                                <a href="#"
                                    class="flex items-center p-2 mb-5 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 " aria-hidden="true" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M14.079 6.839a3 3 0 0 0-4.255.1M13 20h1.083A3.916 3.916 0 0 0 18 16.083V9A6 6 0 1 0 6 9v7m7 4v-1a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4v-6H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1v-6Z" />
                                        </svg>
                                        <span class="ml-3 text-xs whitespace-nowrap">Support</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </aside>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
            <!-- Small Device Overlay Start -->
            <div :class="sidebarToggle ? 'block xl:hidden' : 'hidden'"
                class="fixed z-50 h-screen w-full bg-gray-900/50"></div>
