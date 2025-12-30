     </div>
  </div>
    <footer>
        <!-- footer  -->

       <div class="bottom-0 right-0 fixed w-full border-t h-15 bg-white dark:bg-gray-900 dark:border-gray-600 ">
                    <div
                        class="flex items-center justify-center ml-52 py-4 text-xs text-gray-600 dark:text-gray-200">
                        <p>© 2025 ihookwebsolutions. All rights reserved.</p>
                    </div>
                </div>

    </footer>
 </main>
     </div>
        <!-- ===== Content Area End ===== -->
</div>
        <script>
        const toggle = document.getElementById('themeToggle');

        // Check and apply stored theme
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
            toggle.checked = true;
        } else {
            document.documentElement.classList.remove('dark');
            toggle.checked = false;
        }

        // Toggle listener
        toggle.addEventListener('change', function () {
            if (this.checked) {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            }
        });
    </script>



    <script>
        const myteamsToggle = document.getElementById("myteams-toggle");
        const myteamsMenu = document.getElementById("myteams-menu");
        const myteamsIcon = document.getElementById("myteams-icon");

        myteamsToggle.addEventListener("click", () => {
            myteamsMenu.classList.toggle("hidden");

            if (myteamsMenu.classList.contains("hidden")) {
                // arrow
                myteamsIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                myteamsIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>
    <!-- Trending products js -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.getElementById("cardSlider");
            const cards = slider.children;
            const totalCards = cards.length;
            let index = 0;

            const nextBtn = document.getElementById("nextBtn");
            const prevBtn = document.getElementById("prevBtn");

            function updateSlider() {
                slider.style.transform = `translateX(-${index * 100}%)`;
            }

            nextBtn.addEventListener("click", () => {
                index = (index + 1) % totalCards; // loop to first card
                updateSlider();
            });

            prevBtn.addEventListener("click", () => {
                index = (index - 1 + totalCards) % totalCards; // loop to last card
                updateSlider();
            });

            // Optional Auto Slide every 4 seconds
            setInterval(() => {
                index = (index + 1) % totalCards;
                updateSlider();
            }, 4000);
        });
    </script>

    <!-- Chart.js Configuration -->
    <script>
        const ctx1 = document.getElementById('salesChart').getContext('2d');

        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                responsive: true,
                labels: ['Affiliate Program', 'Direct Buy', 'Adsense'],
                datasets: [{
                    data: [48, 33, 19],
                    backgroundColor: [
                        '#3641F5',
                        '#7592FF',
                        '#DDE9FF'
                    ],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: { label: ctx1 => `${ctx1.dataset.labels}: ${ctx1.parsed.y}%` },
                        backgroundColor: '#1F2937', // gray-800
                        titleColor: '#fff',
                        bodyColor: '#E5E7EB',
                        cornerRadius: 6,
                        padding: 8
                    }
                }
            }
        });
    </script>

    <!-- Chart.js CDN (for Graph) -->

    <!-- <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Performance',
                    data: [65, 59, 80, 81, 56, 70],
                    borderColor: 'rgb(89, 98, 112)',
                    backgroundColor: 'rgb(229, 231, 235)',
                    tension: 0.3,
                    fill: true,
                }]
            }
        });
    </script> -->

    <!-- dropdown  -->
    <!-- myteams dropdown    -->

    <!-- wp orders dropdown  -->

    <script>
        const wporderToggle = document.getElementById("wporder-toggle");
        const wporderMenu = document.getElementById("wporder-menu");
        const wporderIcon = document.getElementById("wporder-icon");

        wporderToggle.addEventListener("click", () => {
            wporderMenu.classList.toggle("hidden");

            if (wporderMenu.classList.contains("hidden")) {
                // arrow
                wporderIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                wporderIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>


    <!-- signup dropdown    -->
    <script>
        const signupToggle = document.getElementById("signup-toggle");
        const signupMenu = document.getElementById("signup-menu");
        const signupIcon = document.getElementById("signup-icon");

        signupToggle.addEventListener("click", () => {
            signupMenu.classList.toggle("hidden");

            if (signupMenu.classList.contains("hidden")) {
                // arrow
                signupIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                signupIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>

    <!-- profile dropdown    -->

    <script>
        const profileToggle = document.getElementById("profile-toggle");
        const profileMenu = document.getElementById("profile-menu");
        const profileIcon = document.getElementById("profile-icon");

        profileToggle.addEventListener("click", () => {
            profileMenu.classList.toggle("hidden");

            if (profileMenu.classList.contains("hidden")) {
                // arrow
                profileIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                profileIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>

    <!--package dropdown    -->

    <script>
        const packToggle = document.getElementById("pack-toggle");
        const packMenu = document.getElementById("pack-menu");
        const packIcon = document.getElementById("pack-icon");


        packToggle.addEventListener("click", () => {
            packMenu.classList.toggle("hidden");

            if (packMenu.classList.contains("hidden")) {
                // arrow
                packIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                packIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>

    <!--shop dropdown    -->

    <script>
        const shopToggle = document.getElementById("shop-toggle");
        const shopMenu = document.getElementById("shop-menu");
        const shopIcon = document.getElementById("shop-icon");


        shopToggle.addEventListener("click", () => {
            shopMenu.classList.toggle("hidden");

            if (shopMenu.classList.contains("hidden")) {
                // arrow
                shopIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                shopIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>

    <!--report dropdown    -->

    <script>
        const reportToggle = document.getElementById("report-toggle");
        const reportMenu = document.getElementById("report-menu");
        const reportIcon = document.getElementById("report-icon");


        reportToggle.addEventListener("click", () => {
            reportMenu.classList.toggle("hidden");

            if (reportMenu.classList.contains("hidden")) {
                // arrow
                reportIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                reportIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>



    <!--settings dropdown    -->

    <script>
        const settingsToggle = document.getElementById("settings-toggle");
        const settingsMenu = document.getElementById("settings-menu");
        const settingsIcon = document.getElementById("settings-icon");


        settingsToggle.addEventListener("click", () => {
            settingsMenu.classList.toggle("hidden");

            if (settingsMenu.classList.contains("hidden")) {
                // arrow
                settingsIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
            } else {
                // down arrow
                settingsIcon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
            }
        });
    </script>

    <script>
        const menus = [
            "lead",
            "customers",
            "tools",
            "reports",
            "partyplan",
            "epin",
            "store",
            // "messages",
            // "tickets",
            // "events",
            // "resources",
            // "payout",
            "adcam"
        ];

        menus.forEach((name) => {
            const toggle = document.getElementById(`${name}-toggle`);
            const menu = document.getElementById(`${name}-menu`);
            const icon = document.getElementById(`${name}-icon`);

            if (toggle && menu && icon) {
                toggle.addEventListener("click", () => {
                    menu.classList.toggle("hidden");

                    if (menu.classList.contains("hidden")) {
                        // arrow
                        icon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>`;
                    } else {
                        // down arrow
                        icon.innerHTML = `<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>`;
                    }
                });
            }
        });
    </script>

    <!--Timer-script:starts-->
    <script>
        function startTime() {
            var today = new Date();
            var hr = today.getHours();
            var min = today.getMinutes();
            var sec = today.getSeconds();
            ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
            hr = (hr == 0) ? 12 : hr;
            hr = (hr > 12) ? hr - 12 : hr;
            //Add a zero in front of numbers<10
            hr = checkTime(hr);
            min = checkTime(min);
            sec = checkTime(sec);
            document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var curWeekDay = days[today.getDay()];
            var curDay = today.getDate();
            var curMonth = months[today.getMonth()];
            var curYear = today.getFullYear();
            var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
            document.getElementById("date").innerHTML = date;

            var time = setTimeout(function () { startTime() }, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        startTime();
    </script>
    <!--Timer-script:ends-->

    <!--distributor-table-script-->
    <script>
        if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#default-table", {
                searchable: false,
                perPageSelect: false
            });
        }

    </script>
    <!--distributor-table-script-->

    <!--Chat-inside-script-->
    <script>
        const button = document.getElementById('setting');
        const dropdown = document.getElementById('dropdown-content');

        button.addEventListener('click', function () {
            dropdown.classList.toggle('hidden');
        });
    </script>
    <!--Chat-inside-script-->

    <script>

        const options = {
            chart: {
                // add these lines to update the size of the chart
                height: 240,
                width: 240,
                type: "area",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            fill: {
                type: "gradient",
                gradient: {
                    opacityFrom: 0.55,
                    opacityTo: 0,
                    shade: "#1C64F2",
                    gradientToColors: ["#1C64F2"],
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -26
                },
            },
            series: [
                {
                    name: "Developer Edition",
                    data: [1500, 1418, 1456, 1526, 1356, 1256],
                    color: "#1A56DB",
                },
                {
                    name: "Designer Edition",
                    data: [643, 413, 765, 412, 1423, 1731],
                    color: "#7E3BF2",
                },
            ],
            xaxis: {
                categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
                labels: {
                    formatter: function (value) {
                        return '$' + value;
                    }
                }
            },
        }

        if (document.getElementById("size-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("size-chart"), options);
            chart.render();
        }

    </script>


    <!-- responsive script  -->
    <script>
        const toggleBtnx = document.getElementById('asidexToggle');
        const asidex = document.getElementById('asidex');

        toggleBtnx.addEventListener('click', () => {
            asidex.classList.toggle('-translate-x-full');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".rank-meter").forEach((meter) => {
                const targetWidth = meter.style.width;
                meter.style.width = "0%";
                setTimeout(() => {
                    meter.style.width = targetWidth;
                }, 200);
            });
        });
    </script>
    <script data-cfasync="false" src="{{ asset('js/bui.min.js') }}"></script>
    <script defer src="{{ asset('js/tui.js') }}"></script>
    <script src="{{ asset('js/bundle.js') }}"></script>

    <!-- App js -->
    <script type="module" src="{{ asset('js/app.js') }}"></script>


</body>

</html>
