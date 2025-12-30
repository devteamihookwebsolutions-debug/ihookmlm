
    <main>
    <!-- ===== Header Start ===== -->
                <header x-data="{menuToggle: false}"
                    class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white xl:border-b dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex grow flex-col items-center justify-between xl:flex-row xl:px-6">
                        <div
                            class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 lg:py-4 xl:justify-normal xl:border-b-0 xl:px-0 dark:border-gray-800">
                            <!-- Hamburger Toggle BTN -->
                            <button
                                :class="sidebarToggle ? 'xl:bg-transparent dark:xl:bg-transparent bg-gray-100 dark:bg-gray-900' : ''"
                                class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 xl:h-11 xl:w-11 xl:border dark:border-gray-800 dark:text-blue-500"
                                @click.stop="sidebarToggle = !sidebarToggle">
                                <svg class="hidden fill-current xl:block" width="16" height="12" viewBox="0 0 16 12"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
                                        fill="" />
                                </svg>

                                <svg :class="sidebarToggle ? 'hidden' : 'block xl:hidden'"
                                    class="fill-current xl:hidden" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
                                        fill="" />
                                </svg>

                                <!-- cross icon -->
                                <svg :class="sidebarToggle ? 'block xl:hidden' : 'hidden'" class="fill-current"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                                        fill="" />
                                </svg>
                            </button>

                            <!-- Hamburger Toggle BTN -->
                            <a href="index.html" class="xl:hidden">
                                <img class="dark:hidden w-16" src="/img/logox1.png" alt="Logo" />
                                <img class="hidden dark:block w-16" src="/img/logox1.png" alt="Logo" />
                            </a>

                            <!-- Application nav menu button -->
                            <button
                                class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 xl:hidden dark:text-blue-500 dark:hover:bg-gray-800"
                                :class="menuToggle ? 'bg-gray-100 dark:bg-gray-900' : ''"
                                @click.stop="menuToggle = !menuToggle">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
                                        fill="" />
                                </svg>
                            </button>

                            <!-- Application nav menu button -->
                            <div class="hidden xl:block">
                                <form>
                                    <div class="relative">
                                        <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-2/4">
                                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                                                    fill="" />
                                            </svg>
                                        </span>
                                        <input id="search-input" type="text" placeholder="Search or type command..."
                                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[430px] dark:border-gray-800 dark:bg-gray-900 dark:bg-gray-900 dark:text-gray-200 dark:placeholder:text-white/30" />

                                        <button id="search-button"
                                            class="absolute top-1/2 right-2.5 inline-flex -translate-y-2/4 items-center gap-0.5 rounded-lg border border-gray-200 bg-gray-50 px-[7px] py-[4.5px] text-xs -tracking-[0.2px] text-gray-500 dark:border-gray-800 dark:bg-gray-900 dark:text-blue-500">
                                            <span> ⌘ </span>
                                            <span> K </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div :class="menuToggle ? 'flex' : 'hidden'"
                            class="shadow-theme-md w-full items-center justify-between gap-4 px-5 py-4 xl:flex xl:justify-end xl:px-0 xl:shadow-none">

                            <!-- settings  -->
                            <div class="relative mt-1">

             <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
               <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"></path>
               </svg>
            </button>
           <div id="dropdown" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 hidden">
               <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                  <li>
                     <a href="/admin/site-settings" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Site</a>
                  </li>
                  <li>
                     <a href="/admin/apiconfiguration" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Api
                        Configuration</a>
                  </li>
               </ul>
            </div>
                            </div>

                            <!-- message  -->
                            <div class="relative" x-data="{ dropdownOpen: false, notifying: true }"
                                @click.outside="dropdownOpen = false">
                                <button
                                    class=" relative flex h-9 w-9 items-center justify-center rounded-full focus:ring-2 focus:ring-gray-300 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700  dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-blue-500 dark:hover:text-white"
                                    @click.prevent="dropdownOpen = ! dropdownOpen; notifying = false">
                                    <svg class=" w-5 h-5 text-gray-800 dark:text-white " aria-hidden="true" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 10.5h.01m-4.01 0h.01M8 10.5h.01M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.6a1 1 0 0 0-.69.275l-2.866 2.723A.5.5 0 0 1 8 18.635V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                    </svg>
                                </button>

                                <!-- Dropdown Start -->
                                <div x-show="dropdownOpen"
                                    class="dark:bg-gray-900 absolute mt-3 flex h-auto w-auto flex-col rounded-2xl border border-gray-200 bg-white p-3 sm:w-[361px] lg:right-0 dark:border-gray-800 dark:bg-gray-900">
                                    <!-- Message Card -->
                                    <div
                                        class="w-full max-w-md bg-gray-100 border border-gray-200 rounded-xl p-4 dark:bg-gray-900 dark:border-gray-800">
                                        <div class="flex justify-between items-start">
                                            <div class="flex gap-3">
                                                <img src="/img/profile-picture-5.jpg" alt="User avatar"
                                                    class="w-10 h-10 rounded-full object-cover" />
                                                <div class="">
                                                    <h3 class="text-gray-800 font-medium text-sm dark:text-gray-300">
                                                        John Doe</h3>
                                                    <p class="text-gray-500 text-xs">2 hours ago</p>
                                                    <p class="mt-2 text-gray-500 text-xs leading-relaxed">
                                                        Hey! Just wanted to check if the delivery reports were updated
                                                        this
                                                        morning.
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- 3-dot dropdown -->
                                            <div class="relative">
                                                <button id="dropdownButton" data-dropdown-toggle="dropdownMenu"
                                                    class="p-2 text-gray-500 rounded-lg bg-gray-100 dark:bg-gray-900 focus:ring-2 focus:ring-gray-200  dark:focus:ring-gray-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 12h.01M12 12h.01M18 12h.01"></path>
                                                    </svg>
                                                </button>

                                                <!-- Dropdown menu -->
                                                <div id="dropdownMenu"
                                                    class="hidden z-10 absolute border right-0 mt-2 w-auto bg-white rounded-lg shadow divide-y divide-gray-100 dark:bg-gray-900 dark:border-gray-800">
                                                    <ul class="py-1 text-xs text-gray-700 dark:text-gray-300 overflow-hidden"
                                                        aria-labelledby="dropdownButton">
                                                        <li><a href="#"
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Reply</a>
                                                        </li>
                                                        <li><a href="#"
                                                                class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dropdown End -->
                            </div>

                            <!-- apps   -->
                            <div class="relative">
                                <button id="apps-menu-button" data-dropdown-toggle="apps-dropdown"
                                    class="p-2 rounded-full hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 dark:hover:bg-blue-500">
                                    <svg class="w-5 h-5 text-gray-700 dark:text-white" aria-hidden="true" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="apps-dropdown"
                                    class="z-10 hidden bg-white  border overflow-hidden rounded-lg shadow w-72 dark:bg-gray-900 dark:border-gray-800">
                                    <!-- Header -->
                                    <div
                                        class="flex justify-between items-center border-b px-4 py-2 text-xs font-medium text-gray-700 dark:text-gray-200">
                                        <span>Apps</span>
                                        <span>Enabled</span>
                                    </div>

                                    <!-- Apps List -->
                                    <ul class="py-2">
                                        <li
                                            class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center gap-3">
                                                <img src="img/app-1.png" class="w-6 h-6" alt="Jira">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white">Jira
                                                    </p>
                                                    <p class="text-xs text-gray-500">Project management</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <div
                                                    class="w-10 h-5 bg-gray-200 peer-checked:bg-blue-600 rounded-full peer">
                                                </div>
                                                <div
                                                    class="absolute left-1 top-0.5 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5">
                                                </div>
                                            </label>
                                        </li>

                                        <li
                                            class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center gap-3">
                                                <img src="img/app-2.png" class="w-6 h-6" alt="Inferno">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white">Inferno
                                                    </p>
                                                    <p class="text-xs text-gray-500">Secure healthcare app</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer">
                                                <div
                                                    class="w-10 h-5 bg-gray-200 peer-checked:bg-blue-600 rounded-full peer">
                                                </div>
                                                <div
                                                    class="absolute left-1 top-0.5 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5">
                                                </div>
                                            </label>
                                        </li>

                                        <li
                                            class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center gap-3">
                                                <img src="img/app-3.png" class="w-6 h-6" alt="Evernote">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white">
                                                        Evernote
                                                    </p>
                                                    <p class="text-xs text-gray-500">Notes management app</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <div
                                                    class="w-10 h-5 bg-gray-200 peer-checked:bg-blue-600 rounded-full peer">
                                                </div>
                                                <div
                                                    class="absolute left-1 top-0.5 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5">
                                                </div>
                                            </label>
                                        </li>

                                        <li
                                            class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center gap-3">
                                                <img src="img/app-4.png" class="w-6 h-6" alt="GitLab">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white">GitLab
                                                    </p>
                                                    <p class="text-xs text-gray-500">DevOps platform</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer">
                                                <div
                                                    class="w-10 h-5 bg-gray-200 peer-checked:bg-blue-600 rounded-full peer">
                                                </div>
                                                <div
                                                    class="absolute left-1 top-0.5 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5">
                                                </div>
                                            </label>
                                        </li>

                                        <li
                                            class="flex items-center justify-between px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center gap-3">
                                                <img src="img/app-5.png" class="w-6 h-6" alt="Google WebDev">
                                                <div>
                                                    <p class="text-xs font-medium text-gray-900 dark:text-white">Google
                                                        webdev</p>
                                                    <p class="text-xs text-gray-500">Building web experiences</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <div
                                                    class="w-10 h-5 bg-gray-200 peer-checked:bg-blue-600 rounded-full peer">
                                                </div>
                                                <div
                                                    class="absolute left-1 top-0.5 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-5">
                                                </div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- user   -->
                            <div class="relative">
                                <button id="user-menu-button" data-dropdown-toggle="user-dropdown"
                                    class="flex items-center text-xs rounded-full focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
                                    type="button">
                                    <img class="w-6 h-6 rounded-full" src="/img/profile-picture-3.jpg"
                                        alt="user photo">
                                </button>

                                <!-- Dropdown menu -->
                                <div id="user-dropdown"
                                    class="z-10 hidden mr-20 bg-white border divide-y divide-gray-200 rounded-lg shadow w-56 dark:bg-gray-900 dark:divide-gray-800 dark:border-gray-800">
                                    <div class="px-4 py-3">
                                        <span class="block text-sm font-medium text-gray-600 dark:text-gray-300">Cody
                                            Fisher</span>
                                        <span
                                            class="block text-xs text-gray-500 dark:text-blue-500">c.fisher@gmail.com</span>
                                    </div>

                                    <ul class="py-2 text-xs text-gray-700 dark:text-gray-200"
                                        aria-labelledby="user-menu-button">

                                        <li>
                                            <a href="#"
                                                class="block border-b dark:border-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">My
                                                Account</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.logout') }}"
                                                class="block border-b dark:border-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Signout</a>
                                        </li>
                                        <li class="flex items-center justify-between px-4 py-2">
                                            <!-- Dark Mode Toggle -->
                                            <div class="flex items-center space-x-3">
                                                <span class="text-xs font-medium text-gray-900 dark:text-gray-300">☀️
                                                    Light</span>

                                                <!-- Toggle Switch -->
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" id="themeToggle" class="sr-only peer">
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700
                                                        peer-checked:after:translate-x-full after:content-[''] after:absolute
                                                        after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300
                                                        after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                                        dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                </label>
                                                <span class="text-xs font-medium text-gray-900 dark:text-gray-300">🌙
                                                    Dark</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- User Area -->
                        </div>
                    </div>
                </header>

                <!-- ===== Header End ===== -->
