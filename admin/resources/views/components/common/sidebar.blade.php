
   <!-- Sidebar -->
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

            <div class="flex flex-col no-scrollbar overflow-y-auto duration-300 ease-linear">
                <!-- Sidebar Menu -->
                <nav x-data="{selected: $persist('Dashboard')}">
                    <!-- Menu Group -->
                    <div>
                        <!-- Menu Items -->
                <ul class="space-y-2 font-awesome px-2 w-auto">

            <!-- fisrt ico dashboard -->
            <li>
                <a href="{{route('admin.dashboard')}}"
                   class="flex  items-center p-2 rounded-lg text-gray-500 dark:text-white
                                        hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4" aria-hidden="true" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                                        </svg>
                                        <span class="ml-3 relative text-xs whitespace-nowrap">Dashboard</span>
                                    </div>
                                </a>
                            </li>


            <!-- sec ico network -->
            <li>
                <!-- Accordion Header -->
                                <a id="networks-toggle"
                                    class="flex items-center p-2 rounded-lg cursor-pointer text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 12v4m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 0v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                        </svg>
                                        <span class="ml-3 relative text-xs whitespace-nowrap">Networks
                                            <svg id="networks-icon"
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
                   <div id="networks-menu" class="hidden pl-5">

                    <ul  class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                        <!-- <li>
                            <a href="{{ url(config('app.ADMINPATH') . '/grpgenealogy/viewtree/1') }}"
                                class="block px-4 py-2 hover:bg-gray100 dark:hover:bg-gray-600 dark:hover:text-white hidden sidebar-text">
                                Graphical Genealogy
                            </a>
                        </li> -->
        @php
            $memberId = Session::get('members_id', 1);
            $matrixId = Session::get('matrix_id', 1);
        @endphp

        <li>
            <a href="{{ route('grpgenealogy.viewtree', ['matrixId' => $matrixId, 'memberId' => $memberId]) }}"
          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white ">
                                                Graphical Genealogy</a>
        </li>

        <li>
            <a href="{{ route('genealogy.viewtree.classicview', ['matrixId' => $matrixId, 'memberId' => $memberId]) }}"
           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Classic
                                                View</a>
        </li>

            <li>
                    <a href="{{ route('genealogy.viewtree.collapseview', ['matrixId' => $matrixId, 'memberId' => $memberId]) }}"
                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Collapse View</a>
            </li>
                <li>
                        <a href="{{ route('genealogy.viewtree.tabularview', ['matrixId' => $matrixId, 'memberId' => $memberId]) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white ">
                        Tabular View
                    </a>
                </li>

                <li>

                        <li>
                            <a href="{{ route('genealogy.viewtree', ['matrixId' => $matrixId, 'memberId' => $memberId]) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Rank
                                                View</a>
                        </li>

                        <li>
                            <a href="{{ route('genealogy.viewtree.countgenealogy', ['matrixId' => $matrixId, 'memberId' => $memberId]) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white ">
                                Downline Count
                            </a>
                        </li>

                        <li>
                            <a href="network-g6.html"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white ">
                                Unilevel Genealogy
                            </a>
                        </li>

                    </ul>



            </li>

                   <!-- Masters section -->
            <li>
                <a href="#" id="masters-toggle"
                      class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                <div class="flex items-center">
                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18zm0-2a7 7 0 0 0 7-7V8a1 1 0 0 0-1-1h-3.06a1 1 0 0 1-.936-.664l-.904-2.257A1 1 0 0 0 12.936 3H11.06a1 1 0 0 0-.936.776l-.904 2.257A1 1 0 0 1 8.284 7H5a1 1 0 0 0-1 1v4a7 7 0 0 0 7 7h1z" />
                        </svg>
                        <span class="ml-3 relative text-xs whitespace-nowrap">Masters
                            <svg id="masters-icon"
                               class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                            </svg>
                        </span>
                   </div>
                </a>
                <div id="masters-menu" class="hidden pl-5">
                    <ul class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                        <li><a href="/admin/cities"
                                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">City</a>
                        </li>
                        <li><a href="/admin/states"
                                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">State</a>
                        </li>
                        <li><a href="/admin/countries"
                                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Country</a>
                        </li>
                    </ul>
                </div>
            </li>
  <!--  icon Team -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="team-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Team<svg id="team-icon"
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
                                <div id="team-menu" class="hidden pl-5">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a  href="{{route('admin.distributors.index')}}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Distributors</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.adddistributors') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Add
                                                Distributor</a>
                                        </li>
                                        <li>
                                            <a href="team-bulkupload.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bulk
                                                Upload
                                                Users</a>
                                        </li>
                                        <li>
                                            <a href="team-kycapproval.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">KYC
                                                Approval</a>
                                        </li>
                                        <li>
                                            <a href="team-abandonusers.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Abandon
                                                Users</a>
                                        </li>
                                        <li>
                                            <a href="team-socialuser.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Social
                                                Users</a>
                                        </li>
                                        <li>
                                            <a href="team-leads.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Leads</a>
                                        </li>
                                        <li>
                                            <a href="team-leads.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">User
                                                lead template</a>
                                        </li>
                                        <li>
                                            <a href="teamwporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lead
                                                Capture
                                                Page</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Customer
                                                Management</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add
                                                Customers</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Deleted
                                                Distributors</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Customer
                                                Groups</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add
                                                Order</a>
                                        </li>
                                        <li>
                                            <a href="wporders-retailcustomer-order.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Bulk Lead
                                                Uploads</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--  icon E-Store -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="estore-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">E-Store
                                            <svg id="estore-icon"
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
                                <div id="estore-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="replicated.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Discount
                                                Group</a>
                                        </li>
                                        <li>
                                            <a id="sponsor-toggle"
                                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <span class="ml-3 relative text-xs whitespace-nowrap">Order
                                                    Sponsor
                                                    <svg id="sponsor-icon"
                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                        aria-hidden="true" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m10 16 4-4-4-4" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div id="sponsor-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="rep-us-user.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Distributors
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-us-subs.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Customers
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="history-toggle"
                                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <span class="ml-3 relative text-xs whitespace-nowrap">Order
                                                    History
                                                    <svg id="history-icon"
                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                        aria-hidden="true" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m10 16 4-4-4-4" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div id="history-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="rep-us-user.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            All Orders
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-us-subs.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Distributors Order
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-us-eus.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Retail Customer Orders
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="leads-bulkuploaddate.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Products</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <!--  icon Party plan -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="party-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="m13.001 19.927 2.896 1.773c1.52.93 3.405-.442 2.992-2.179l-1.06-4.452 3.468-2.978c1.353-1.162.633-3.382-1.142-3.525L15.603 8.2l-1.754-4.226A1.973 1.973 0 0 0 13 3v16.927ZM10.999 3c-.36.205-.663.53-.848.974L8.397 8.2l-4.552.366c-1.775.143-2.495 2.363-1.142 3.525l3.468 2.978-1.06 4.452c-.413 1.737 1.472 3.11 2.992 2.178l2.896-1.773V3Z" />
                                        </svg>


                                        <span class="ml-3 relative text-xs whitespace-nowrap">Party Plan
                                            <svg id="party-icon"
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
                                <div id="party-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="customers-customers.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Party
                                                Reward
                                                Plan</a>
                                        </li>
                                        <li>
                                            <a href="customer-customerorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show
                                                Party
                                                Builder</a>
                                        </li>
                                        <li>
                                            <a href="customer-customerorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">User
                                                Party
                                                Template</a>

                                        </li>
                                        <li>
                                            <a href="customer-customerorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Create
                                                Party
                                                Plan</a>

                                        </li>
                                        <li>
                                            <a href="customer-customerorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View
                                                Portal
                                                Party</a>

                                        </li>
                                        <li>
                                            <a href="customer-customerorder.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Party
                                                Report</a>

                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--  icon Compansation -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="compansation-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4" />
                                        </svg>
                                        <span class="ml-3 relative text-xs whitespace-nowrap">Compansation
                                            <svg id="compansation-icon"
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
                                <div id="compansation-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">
                                        <li>
                                            <a href="/admin/plans"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Plans</a>
                                        </li>

                                        <li>
                                            <a href="/admin/showbonuslist"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bonus</a>
                                        </li>

                                        <li>
                                            <a href="/admin/customerbonus"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Customers
                                                Bonus</a>
                                        </li>
                                        <li>
                                            <a href="/admin/customerbonus"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Shop
                                                Bonus</a>
                                        </li>
                                        <li>
                                            <a href="/admin/generationbonus"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Generation
                                                Bonus</a>
                                        </li>
                                        <li>
                                            <a href="/admin/matchbonus"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Matching
                                                Bonus</a>
                                        </li>
                                        <li>
                                            <a href="tools-sms-blase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Retail
                                                Bonus</a>
                                        </li>
                                        <li>
                                            <a href="tools-sms-blase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bonus
                                                Pool Configuration </a>
                                        </li>
                                        <li>
                                            <a href="/admin/ranksetting"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Rank</a>
                                        </li>
                                        <li>
                                            <a href="tools-sms-blase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Product
                                                Level Commission</a>
                                        </li>
                                        <li>
                                            <a href="tools-sms-blase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Commission
                                                Settings</a>
                                        </li>
                                        <li>
                                            <a href="tools-sms-blase.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Admin
                                                Pool
                                                Wallet</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- ico Wallet -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="ewallet-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 8H5m12 0a1 1 0 0 1 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Wallet
                                            <svg id="ewallet-icon"
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
                                <div id="ewallet-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <li>
                                            <a href="{{route('admin.withdrawal') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Withdrawal</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.ewalletmanagement') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">E
                                                Wallet</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.fundtransfer') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Fund
                                                Transfer</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.sendbonus') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Send
                                                Bonus</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.detectfunds') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Deduct Funds
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- ico Report -->
                            <li>
                                <a href="#" id="report-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m11.5 11.5 2.071 1.994M4 10h5m11 0h-1.5M12 7V4M7 7V4m10 3V4m-7 13H8v-2l5.227-5.292a1.46 1.46 0 0 1 2.065 2.065L10 17Zm-5 3h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Report
                                            <svg id="report-icon"
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
                                <div id="report-menu" class="hidden pl-5">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <!-- users  -->
                                        <li>
                                            <a id="user-toggle"
                                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <span class="ml-3 relative text-xs whitespace-nowrap">Users
                                                    <svg id="user-icon"
                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                        aria-hidden="true" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m10 16 4-4-4-4" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div id="user-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="rep-us-user.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            User
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-us-subs.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Subscription
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-us-eus.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Export Users
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                        <!-- sales  -->
                                        <li>
                                            <a id="sales-toggle"
                                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <span class="ml-3 relative text-xs whitespace-nowrap">Sales
                                                    <svg id="sales-icon"
                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                        aria-hidden="true" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m10 16 4-4-4-4" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div id="sales-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="rep-sales-sales.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Sales
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-payment.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Sales By Payment Gateway
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-country.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Sales Country
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-rank.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Sales Rank
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-agent-bsales.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Agent By Sales
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-agent.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Agent By Downline
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-abts.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Agent By Team Sales
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-inrep.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Invoice Report
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                        <!-- Commissions  -->
                                        <li>
                                            <a id="commission-toggle"
                                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <span class="ml-3 relative text-xs whitespace-nowrap">Commissions
                                                    <svg id="commission-icon"
                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                        aria-hidden="true" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m10 16 4-4-4-4" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div id="commission-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="{{ route('admin.commissionreports') }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Total Commissions
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('admin.usercommissionreports') }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            User Commission
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="rep-sales-country.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Commissions Calendar
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>

                                        <!-- PV  -->
                                        <li>
                                            <a id="pv-toggle"
                                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <span class="ml-3 relative text-xs whitespace-nowrap">PV
                                                    <svg id="pv-icon"
                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                        aria-hidden="true" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m10 16 4-4-4-4" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div id="pv-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="{{ route('admin.cpvreport') }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            PV
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('admin.gpvreports') }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            GPV
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.adminearnings') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Admin Earnings
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.rankreports') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Rank Bonus
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.bonusachievedreports') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Bonus Achieved
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                SKU Reports
                                            </a>
                                        </li>
                                  <li>
                                    <a href="{{ route('admin.packagereports') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Packages
                                    </a>
                                </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Downline Sales - Packages
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Downline Sales - Ecommerce
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Campaign Click Stats
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Campaign Impression Stats
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Advanced Reporting
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Subscribers
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Admin Pool Wallet
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!--  icon Marketing -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="marketing-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 9H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h6m0-6v6m0-6 5.419-3.87A1 1 0 0 1 18 5.942v12.114a1 1 0 0 1-1.581.814L11 15m7 0a3 3 0 0 0 0-6M6 15h3v5H6v-5Z" />
                                        </svg>


                                        <span class="ml-3 relative text-xs whitespace-nowrap">Marketing
                                            <svg id="marketing-icon"
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
                                <div id="marketing-menu" class="hidden pl-5 ">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <li>
                                            <a href="reports-e-wallet-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Distributor
                                                Category</a>
                                        </li>
                                        <li>
                                            <a href="report-cash-wallet-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Campaign
                                                Distributor</a>
                                        </li>
                                        <!-- Premium  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="premium-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">
                                                    <!-- Icon -->

                                                    <span class="ml-3 relative text-xs">Premium E-Learning
                                                        <svg id="premium-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>

                                            </a>

                                           <!-- Nested Menu (hidden by default) -->
                                            <div id="premium-menu" class="hidden pl-5">
                                                <ul class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <!-- Manage Course (List all courses) -->
                                                    <li>
                                                        <a href="{{ route('elearning.showallelearning') }}"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Manage Course
                                                        </a>
                                                    </li>

                                                    <!-- Add Course (Create new course form) -->
                                                    <li>
                                                        <a href="{{ route('admin.elearning.show') }}"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Add Course
                                                        </a>
                                                    </li>

                                                    <!-- Course Payment (List payments) -->
                                                    <li>
                                                        <a href="{{ route('coursepayment.show') }}"
                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Course Payment
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>
                                        <!-- Coaching  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="coaching-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">
                                                    <!-- Icon -->

                                                    <span class="ml-3 relative text-xs">Coaching
                                                        <svg id="coaching-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>

                                            </a>

                                            <!-- Nested Menu (hidden by default) -->
                                            <div id="coaching-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="set-log.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Manage Course
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="report-my-pv-details.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lead
                                                contacts</a>
                                        </li>
                                        <li>
                                            <a href="report-package-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Campaign</a>
                                        </li>
                                        <li>
                                            <a href="report-downlinesalws-report.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Newsletter
                                                Templates</a>
                                        </li>
                                        <li>
                                            <a href="report-package-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Replicate
                                                Settings</a>
                                        </li>
                                        <li>
                                            <a href="report-package-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Live
                                                Events</a>
                                        </li>
                                        <li>
                                            <a href="report-package-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Resources</a>
                                        </li>
                                        <li>
                                            <a href="report-package-history.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Resources
                                                Category</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <!-- ico settings -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="settings-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                    <span class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <span class="ml-3 relative text-xs whitespace-nowrap">Settings
                                            <svg id="settings-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>

                                        </span>
                                    </span>

                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="settings-menu" class="hidden pl-5">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <!-- system  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="system-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">
                                                    <!-- Icon -->

                                                    <span class="ml-3 relative text-xs">System
                                                        <svg id="system-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>

                                            </a>

                                            <!-- Nested Menu (hidden by default) -->
                                            <div id="system-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="{{route('showbanners/login')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Login/Forget Password Banners
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('showbanners/register')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Register Banners
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('ewalletgateway')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Wordpress E-Wallet API
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('systemmodules')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            System Modules
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="set-sys-cron.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Cron Settings
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <!-- Accordion Header -->
                                                        <a id="logs-toggle"
                                                            class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                            <span class="flex items-center">
                                                                <!-- Icon -->

                                                                <span class="ml-3 relative text-xs">Logs
                                                                    <svg id="logs-icon"
                                                                        class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                                        aria-hidden="true" width="24" height="24"
                                                                        fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="m10 16 4-4-4-4" />
                                                                    </svg>
                                                                </span>

                                                        </a>

                                                        <!-- Nested Menu (hidden by default) -->
                                                        <div id="logs-menu" class="hidden pl-5">
                                                            <ul
                                                                class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                                <li>
                                                                    <a href="{{route('userlogs')}}"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                        Users
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{route('adminlogs')}}"
                                                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                        Admin
                                                                    </a>
                                                                </li>

                                                            </ul>

                                                        </div>
                                                    </li>

                                                </ul>

                                            </div>
                                        </li>

                                        <!-- personalization  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="personalization-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">
                                                    <!-- Icon -->

                                                    <span class="ml-3 relative text-xs">Personalization
                                                        <svg id="personalization-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>

                                            </a>

                                            <!-- Nested Menu (hidden by default) -->
                                            <div id="personalization-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="{{route('registersettings')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Registration
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('dashboardsettings')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            User Dashboard
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="set-per-reg.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Registration Theme
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="user-d-board.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Invoice Theme
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('enablefeature')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Enable & Disable Features
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href=" User-Languages-Edit.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            User Languages Edit
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="Admin-Language-Edit.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Admin Language Edit
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('terminologysettings', ['lang' => 'en']) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Terminology Settings
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('rolemanagement.view', ['id' => 1]) }}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Role Settings
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('currencysettings')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Currency Format Configuration
                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </li>

                                        <!-- payment  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="payment-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">

                                                    <span class="ml-3 relative text-xs">Payment
                                                        <svg id="payment-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>

                                            <!-- Nested Menu (hidden by default) -->
                                            <div id="payment-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="{{route('paymentsettings')}}"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Payment Settings
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-payout.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Payout
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-withdraw.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Withdraw
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-coupon.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Coupon
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-tax.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Tax
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-currency.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Currency
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-multi-currency.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Multi-Currency
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="payment-tax-settings.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Tax-Settings
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                        <!-- cms dropdown  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="cms-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">
                                                    <!-- Icon -->


                                                    <span class="ml-3 relative text-xs">CMS
                                                        <svg id="cms-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>

                                            <!-- Nested Menu (hidden by default) -->
                                            <div id="cms-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="cms-faq-settings.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            FAQ Settings
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="cms-ticket-category.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Ticket Category
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="cms-terms-settings.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Terms Settings
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                        <!-- notification  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="notification-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                                <span class="flex items-center">
                                                    <!-- Icon -->
                                                    <span class="ml-3 relative text-xs">Notification
                                                        <svg id="notification-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>

                                            <!-- Nested Menu -->
                                            <div id="notification-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="notification-mail.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Mail
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="notification.push.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Push
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="notification-autoresponder.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Autoresponder
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>

                                        <!-- cart  -->
                                        <li>
                                            <!-- Accordion Header -->
                                            <a id="cart-toggle"
                                                class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <span class="flex items-center">
                                                    <span class="ml-3 relative text-xs">Cart
                                                        <svg id="cart-icon"
                                                            class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                            aria-hidden="true" width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10 16 4-4-4-4" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>

                                            <!-- Nested Menu -->
                                            <div id="cart-menu" class="hidden pl-5">
                                                <ul
                                                    class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                                    <li>
                                                        <a href="cart-config.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Cart Configuration
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="shopify-config.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Shopify Configuration
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="reward-point-settings.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Reward Point Settings
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="reward-points.html"
                                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Reward Points
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                    </ul>

                                </div>
                            </li>

                            <!-- ico Events -->
                            <li>
                                <a href="#"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Events
                                        </span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico E-pin  -->
                            <li>
                                <a href="#" id="epin-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
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
                                <div id="epin-menu" class="hidden pl-5">
                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <li>
                                            <a href="{{route('sendpin') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Send Epin
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{route('epinhistory') }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Epin History
                                            </a>
                                        </li>

                                    </ul>

                                </div>
                            </li>

                            <!-- ico Ticket -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="ticket-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18.5 12A2.5 2.5 0 0 1 21 9.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2.5a2.5 2.5 0 0 1 0 5V17a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Ticket Center
                                        </span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico Message -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="Message-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Message Center</span>
                                    </div>
                                </a>
                            </li>

                            <!--ico Autoship -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="Autoship-toggle"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-xs">
                                    <div class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4  dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 7h6l2 4m-8-4v8H9m4-8V6c0-.26522-.1054-.51957-.2929-.70711C12.5196 5.10536 12.2652 5 12 5H4c-.26522 0-.51957.10536-.70711.29289C3.10536 5.48043 3 5.73478 3 6v9h2m14 0h2v-4m0 0h-5M8 8.66669V10l1.5 1.5m10 5c0 1.3807-1.1193 2.5-2.5 2.5s-2.5-1.1193-2.5-2.5S15.6193 14 17 14s2.5 1.1193 2.5 2.5Zm-10 0C9.5 17.8807 8.38071 19 7 19s-2.5-1.1193-2.5-2.5S5.61929 14 7 14s2.5 1.1193 2.5 2.5Z" />
                                        </svg>

                                        <span class="ml-3 relative text-xs whitespace-nowrap">Autoship</span>
                                    </div>
                                </a>
                            </li>

                            <!-- ico adcampaign -->
                            <li>
                                <!-- Accordion Header -->
                                <a href="#" id="adcampaign-toggle" data-tooltip-target="network-default"
                                    class="flex items-center p-2 rounded-lg text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                                    <span class="flex items-center">
                                        <!-- Icon -->
                                        <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 8H5m12 0a1 1 0 0 1 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1Z" />
                                        </svg>
                                        <span class="ml-3 relative text-xs whitespace-nowrap">Ad-Campaign
                                            <svg id="adcampaign-icon"
                                                class="absolute top-0 ml-40 w-5 h-5 text-gray-500 dark:text-white transition-transform duration-200"
                                                aria-hidden="true" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                            </svg>
                                        </span>
                                    </span>
                                </a>

                                <!-- Nested Menu (hidden by default) -->
                                <div id="adcampaign-menu" class="hidden pl-5">

                                    <ul
                                        class="py-2 text-xs text-gray-500 divide-y divide-gray-200 dark:text-gray-200 dark:divide-gray-800">

                                        <li>
                                            <a href="ad-campaign-ad-text.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad Text
                                            </a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-banner.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad Banner
                                            </a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-text-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad Text Approval
                                            </a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-banner-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad Banner Approval
                                            </a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-premium-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad Premium Approval
                                            </a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-banner-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad Categorys
                                            </a>
                                        </li>

                                        <li>
                                            <a href="ad-campaign-ad-premium-reports.html"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Ad General Categorys
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

               </ul>
                    </div>
                </nav>
            </div>
        </aside>
