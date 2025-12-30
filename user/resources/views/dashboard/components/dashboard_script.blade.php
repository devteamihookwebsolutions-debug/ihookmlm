<script>

 function setupBlockSalesCountryDetails() {
    if (typeof Highcharts === 'undefined') {
        loadScript('/public/assets/js/highcharts.js', () => {
            loadScript('/public/assets/js/map.js', () => {
                loadScript('/public/assets/js/world.js', () => {
                    console.log('Highcharts and map data loaded');
                    fetchAndRenderWorldMap();
                });
            });
        });
    } else {
        fetchAndRenderWorldMap();
    }
}

function fetchAndRenderWorldMap() {
    fetch('/user/dashboard/getcountrysalesdata')
        .then(response => response.json())
        .then(salesData => {
            // Ensure data is in format: [{ 'iso-a2': 'US', value: 5000 }, ...]
            renderWorldMapChart(salesData);
        })
        .catch(err => console.error('Failed to fetch sales data:', err));
}
function renderWorldMapChart(salesData) {
    const chartContainer = document.getElementById('world-map-container');
    if (!chartContainer) return;

    if (chartContainer.offsetWidth === 0 || chartContainer.offsetHeight === 0) {
        console.error('Invalid container size');
        return;
    }

    // Modify salesData to match the map format and ensure that each country has a color
    const updatedSalesData = salesData.map(item => {
        return {
            'iso-a2': item['iso-a2'],  // Country ISO code
            value: item.value,  // Sales value
            color: getColorForSales(item.value)  // Assign color based on sales
        };
    });

    // Function to determine color based on sales value
    function getColorForSales(salesValue) {
        // Example color scale: you can customize this based on your requirements
        if (salesValue < 1000) {
            return '#f4f4f4';  // Light color for low sales
        } else if (salesValue >= 1000 && salesValue < 3000) {
            return '#c6e2b3';  // Medium color for moderate sales
        } else {
            return '#006400';  // Dark green for high sales
        }
    }

    worldMapChartInstance = Highcharts.mapChart(chartContainer, {
        chart: {
            map: 'custom/world',
            backgroundColor: 'transparent',
            borderWidth: 0,
            margin: [0, 0, 0, 0],
            width: chartContainer.offsetWidth,
            height: chartContainer.offsetHeight,
            zoomType: 'xy',
            panning: true,
            panKey: 'shift'
        },
        title: { text: '' },
        mapNavigation: {
            enabled: true,
            enableMouseWheelZoom: true,
            buttonOptions: {
                alignTo: 'spacingBox',
                verticalAlign: 'top',
                x: 5,
                y: 60
            },
            buttons: {
                zoomIn: { text: '+' },
                zoomOut: { text: '-' }
            }
        },
        tooltip: {
            pointFormat: '{point.name}: <b>{point.value}</b> sales'
        },
        colorAxis: {
            min: 0,
            max: 5000,  // Adjust this max value based on your sales data
            minColor: '#ffffff',  // Color for countries with low sales
            maxColor: '#006400'   // Color for countries with high sales
        },
        series: [{
            name: 'Sales by Country',
            mapData: Highcharts.maps['custom/world'],
            joinBy: 'iso-a2',
            data: updatedSalesData,  // Use the updated sales data with assigned colors
            states: {
                hover: {
                    color: '#a4edba'
                }
            },
            dataLabels: {
                enabled: false
            }
        }],
        credits: { enabled: false }
    });
}


    function loadScript(src, callback) {
        const script = document.createElement('script');
        script.src = src;
        script.onload = callback;
        document.head.appendChild(script);
    }

    function loadCSS(href, callback) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        link.onload = callback;
        document.head.appendChild(link);
    }


    // Function to load modal content dynamically
    function loadModalContent(modalId,nextRankId) {
        const modal = document.getElementById(modalId);

        if(modalId === 'default-nextrank-modal') {
            const modalBody = modal.querySelector('#next-rank-contents');
            // Show loading state
            modalBody.innerHTML = 'Loading...';

            fetch(`/user/dashboard/getrankdetails/${nextRankId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {

                if (data && Object.keys(data).length > 0) {
                    // Initialize the content for the modal


                    let content = `
                        <div class="p-5">
                            <div class="text-base text-black dark:text-white mb-3 font-bold">
                    `;

                    // Loop over each key in the data object
                    Object.keys(data).forEach(key => {
                        // Initialize the rank name variable
                        let rankName = '';

                        // Use switch case to map the key to a rank name
                        switch (key) {
                            case '1':
                                rankName = 'Directs Referrals';
                                break;
                            case '2':
                                rankName = 'Group Referrals';
                                break;
                            case '3':
                                rankName = 'Number of Sales';
                                break;
                            case '4':
                                rankName = 'Products Sold';
                                break;
                            case '5':
                                rankName = 'Target Achieved';
                                break;
                            case '6':
                                rankName = 'Level Condition';
                                break;
                            case '7':
                                rankName = 'PV Points';
                                break;
                            case '8':
                                rankName = 'GPV Points';
                                break;
                            case '9':
                                rankName = 'Sales Target';
                                break;
                            case '10':
                                rankName = 'Group Sales Target';
                                break;
                            case '11':
                                rankName = 'Online Sales PV';
                                break;
                            default:
                                rankName = 'Direct Referrals'; // Default case
                                break;
                        }

                        // Add the rank name as a header
                        content += `<div class="flex justify-between items-center"><div class="text-base font-semibold text-black mb-3">${rankName}</div>`;

                        // Add the key-value pair to the content
                        content += `
                            <div class="flex mb-1 justify-between">
                                <div class="text-base font-semibold text-black mb-3">
                                    ${data[key]}
                                </div>
                            </div></div>

                            <div class="border border-neutral-300 rounded-lg p-5 mb-5">
                                  <div class="progress-bar">
                                      <div class="flex mb-1 justify-between">

                                          <div class="text-sm font-medium dark:text-white">

                                          </div>

                                          <div class="text-sm font-medium dark:text-white">

                                          </div>
                                      </div>

                                      <div
                                          class="w-full bg-neutral-200 rounded-full h-2.5 mb-4 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                                          <div class="bg-neutral-600 h-2.5 rounded-full dark:bg-neutral-300"
                                              style="width: 100%">100%</div>
                                      </div>
                                  </div>
                              </div>


                        `;
                    });

                    // Close the modal content
                    content += `</div></div>`;

                    // Update modal body with the generated content
                    modalBody.innerHTML = content;
                } else {
                    modalBody.innerHTML = 'No data found for this rank.';
                }
            })
            .catch(error => {
                modalBody.innerHTML = 'An error occurred while fetching data.';
                console.error('Error fetching rank details:', error);
            });


        }
         // Show the modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


function loadModalContentRank(modalId, nextRankId) {
    console.log("Function called with:", modalId, nextRankId);

    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error("Modal not found:", modalId);
        return;
    }

    // 🔥 Show the modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (modalId === 'default-nextrank-modal') {
        const modalBody = modal.querySelector('#next-rank-contents');
        if (!modalBody) {
            console.error("Modal body not found.");
            return;
        }

        modalBody.innerHTML = 'Loading...';

        fetch(`/user/dashboard/getrankdetailsrequirements/${nextRankId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            console.log("Fetched rank details:", data);
            modalBody.innerHTML = data;
        })
        .catch(error => {
            console.error("Error fetching rank details:", error);
            modalBody.innerHTML = `<p class="text-red-500">Failed to load rank details. Please try again.</p>`;
        });
    }
}

    // Function to hide the modal
    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
    }


    document.addEventListener("DOMContentLoaded", function () {
       // Function to open the modal and display QR code dynamically
    window.showQRCodeModal = function (modalId, qrUrl) {
        const qrModal = document.getElementById(modalId);  // Modal with dynamic ID
        const qrCodeContainer = document.getElementById(modalId + '-container');  // QR code container inside modal

        // Clear the existing QR code in the modal (if any)
        qrCodeContainer.innerHTML = "";

        // Create a new QR code dynamically inside the modal
        new QRCode(qrCodeContainer, {
            text: qrUrl,
            width: 110,
            height: 110,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Show the modal by removing the 'hidden' class
        qrModal.classList.remove("hidden");
    };

    // Function to close the QR modal
    window.closeQRCodeModal = function (modalId) {
        // Hide the modal by adding the 'hidden' class
        const qrModal = document.getElementById(modalId);
        qrModal.classList.add("hidden");
    };
    });
    const copyToClipboard = (elementId, defaultIconId = 'default-icon', successIconId = 'success-icon') => {
      const inputField = document.getElementById(elementId);
      const defaultIcon = document.getElementById(defaultIconId);
      const successIcon = document.getElementById(successIconId);

      if (!inputField || !navigator.clipboard) return;

      navigator.clipboard.writeText(inputField.value).then(() => {
         // Swap icons
         defaultIcon.classList.add('hidden');
         successIcon.classList.remove('hidden');

         // Success alert
         Swal.fire({
               title: "Copied!",
               text: "The link has been copied to your clipboard.",
               icon: "success",
               timer: 2000,
               showConfirmButton: false
         });

         // Reset icon after 2 seconds
         setTimeout(() => {
               successIcon.classList.add('hidden');
               defaultIcon.classList.remove('hidden');
         }, 2000);
      }).catch(err => {
         console.error("Error copying text:", err);
      });
   };

    const tabButtons = document.querySelectorAll('.tab-button');

    tabButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        // Remove active styles from all buttons
        tabButtons.forEach(b => {
          b.classList.remove('bg-white dark:bg-neutral-900', 'text-black dark:text-white', 'shadow');
          b.classList.add('text-black', 'hover:bg-white dark:bg-neutral-900', 'hover:text-black dark:text-white');
        });

        // Add active styles to clicked button
        btn.classList.add('bg-white dark:bg-neutral-900', 'text-black dark:text-white', 'shadow');
        btn.classList.remove('text-black', 'hover:bg-white dark:bg-neutral-900', 'hover:text-black dark:text-white');
      });
    });

    // Optional: Initialize first button as active on page load
    window.addEventListener('DOMContentLoaded', () => {
     //  tabButtons[0].classList.add('bg-white dark:bg-neutral-900', 'text-black dark:text-white', 'shadow');
      tabButtons[0].classList.remove('text-black');
    });
    var averageProgress = @json(session('averageProgress', 0)); // Get the average progress from server-side

const charts = [];   // to keep chart instances
let currentSlide = 0; // track current slide index

if (!localStorage.getItem('fireworksShown')) {
    // If it's the first login, run the fireworks animation and store the flag in localStorage
    const intersectionObserver = new IntersectionObserver((entries, options) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                // element is in viewport, do the stuff
                fireworks();
                // it's good to remove observer, if you don't need it any more
                localStorage.setItem('fireworksShown', 'true'); // Set the flag in localStorage
            }
        });
    }, { threshold: 0.8 });

    // get your elements, by class name '.confetti'
    const elements = [...document.querySelectorAll('.confetti')];
    // start observing your elements
    elements.forEach((element) => intersectionObserver.observe(element, { threshold: 0.8 }));

    function fireworks() {
        var duration = 1.5 * 1000;
        var animationEnd = Date.now() + duration;
        var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            var particleCount = 50 * (timeLeft / duration);
            // since particles fall down, start a bit higher than random
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
        }, 250);
    }
}
</script>


 <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.tailwindcss.com"></script>

<script>
    const chartOptions = (value, label) => ({
      chart: {
        type: 'radialBar',
        height: 280,
        offsetY: -20
      },
      plotOptions: {
        radialBar: {
          startAngle: -135,
          endAngle: 135,
          hollow: { size: '80%', background: '#fff' },
          track: { background: '#f0f0f0', strokeWidth: '100%', margin: 0 },
          dataLabels: {
            show: true,
            name: {
              offsetY: -10,
              show: true,
              color: '#888',
              fontSize: '16px'
            },
            value: {
              formatter: (val) => parseInt(val) + ' %',
              color: '#111',
              fontSize: '32px',
              show: true,
            }
          }
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#ABE5A1'],
          inverseColors: true,
          stops: [0, 100]
        }
      },
      stroke: { lineCap: 'round' },
      series: [value],
      labels: [label]
    });

    // Safely encode PHP arrays to JS
    var totalrank = @json($totalRankCount ?? 0);
    var parval = {{ json_encode($rankwiz['parvalue'] ?? []) }};
    const rankIds = {{ json_encode($rankwiz['rank_ids'] ?? []) }};

    const slider = document.getElementById("slider");
    const prevBtn = document.getElementById("prev");
    const nextBtn = document.getElementById("next");
    const totalSlides = totalrank;
    let index = 0;

    function updateSlider(slideIndex, newValue) {
        slider.style.transform = `translateX(-${slideIndex * 33.333}%)`;

        prevBtn.disabled = slideIndex === 0;
        nextBtn.disabled = slideIndex === totalSlides - 1;

        prevBtn.classList.toggle('opacity-50', slideIndex === 0);
        prevBtn.classList.toggle('cursor-not-allowed', slideIndex === 0);
        nextBtn.classList.toggle('opacity-50', slideIndex === totalSlides - 1);
        nextBtn.classList.toggle('cursor-not-allowed', slideIndex === totalSlides - 1);

        const chartElement = document.getElementById("chart" + (slideIndex + 1));

        if (!chartElement) {
            console.error("Chart element not found for index:", slideIndex);
            return;
        }

        if (newValue === null || newValue === undefined) {
            console.error('Invalid value for chart:', newValue);
            return;
        }

        // Destroy existing chart
        if (chartElement.apexCharts) {
            chartElement.apexCharts.destroy();
        }

        // Render new chart
        const chart = new ApexCharts(chartElement, chartOptions(newValue, "Progress"));
        chart.render();
        chartElement.apexCharts = chart; // store reference
    }

    prevBtn.addEventListener("click", async () => {
        if (index > 0) {
            index--;
            const rankId = rankIds[index];
            try {
                const newVal = await fetchRankPercentage(rankId);
                updateSlider(index, newVal);
            } catch (error) {
                console.error("Error fetching rank percentage:", error);
            }
        }
    });

    nextBtn.addEventListener("click", async () => {
        if (index < totalSlides - 1) {
            index++;
            const rankId = rankIds[index];
            try {
                const newVal = await fetchRankPercentage(rankId);
                updateSlider(index, newVal);
            } catch (error) {
                console.error("Error fetching rank percentage:", error);
            }
        }
    });

    // Initial render
    updateSlider(0, parval[0]);

    function fetchRankPercentage(rankId) {
        return fetch(`/user/dashboard/getrankpercentage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ rank_id: rankId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                return data.percentage;
            } else {
                console.log('Server error:', data.message);
                return 0;
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            return 0;
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js@0.1.0"></script>
<!-- Highcharts CDNs -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/maps/modules/world.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
/* --------------------------------------------------------------
   GLOBAL DATA-TABLE STATE
   -------------------------------------------------------------- */
const dataTables = {}; // one entry per tableId

/* --------------------------------------------------------------
   SHOW MODAL + initialise table (once)
   -------------------------------------------------------------- */
function showBlockModal(modalId, tableId, fetchUrl) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // initialise **every** table the first time the modal opens
    if (!window[tableId + '_init']) {
        initDataTable(tableId, fetchUrl);
        window[tableId + '_init'] = true;
    }
}

/* --------------------------------------------------------------
   CLOSE MODAL
   -------------------------------------------------------------- */
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('flex');
}

/* --------------------------------------------------------------
   INITIALISE A SIMPLE-DATATABLE (searchable, no paging)
   -------------------------------------------------------------- */
function initDataTable(tableId, fetchUrl) {
    dataTables[tableId] = {
        recordsPerPage: 10,
        currentPage   : 1,
        totalRecords  : 0,
        isLoading     : false,
        hasMoreData   : true,
        fetchUrl
    };

    new simpleDatatables.DataTable(`#${tableId}`, {
        searchable: true,
        paging    : false,
        perPageSelect: false,
        labels: {
            placeholder: "Search ...",
            noRows     : "No records found",
            info       : ""
        }
    });

    fetchRecords(tableId); // first load
}

/* --------------------------------------------------------------
   FETCH RECORDS (with page & per-page)
   -------------------------------------------------------------- */
async function fetchRecords(tableId) {
    const dt = dataTables[tableId];
    if (dt.isLoading || !dt.hasMoreData) return;

    dt.isLoading = true;
    const url = `/user/dashboard/${dt.fetchUrl}?page=${dt.currentPage}&perPage=${dt.recordsPerPage}`;

    try {
        const res = await fetch(url);
        const json = await res.json();

        if (json.records && json.records.length) {
            updateTable(tableId, json.records, json.columns || Object.keys(json.records[0]));
            dt.totalRecords = json.total_records;
            renderPagination(tableId, json.total_records);
        } else {
            dt.hasMoreData = false;
            document.querySelector(`#${tableId} tbody`).innerHTML = '<tr><td colspan="20" class="text-center">No records found</td></tr>';
            hidePagination(tableId);
        }
    } catch (e) {
        console.error(e);
        document.querySelector(`#${tableId} tbody`).innerHTML = '<tr><td colspan="20" class="text-center text-red-500">Error loading data</td></tr>';
    } finally {
        dt.isLoading = false;
    }
}

/* --------------------------------------------------------------
   UPDATE TABLE BODY
   -------------------------------------------------------------- */
function updateTable(tableId, records, columns) {
    const tbody = document.querySelector(`#${tableId} tbody`);
    tbody.innerHTML = '';

    records.forEach(rec => {
        const tr = document.createElement('tr');
        columns.forEach(col => {
            const td = document.createElement('td');
            td.textContent = rec[col] ?? '—';
            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });
}

/* --------------------------------------------------------------
   PAGINATION
   -------------------------------------------------------------- */
function renderPagination(tableId, total) {
    const dt = dataTables[tableId];
    const pages = Math.ceil(total / dt.recordsPerPage);
    const container = document.getElementById(`${tableId}Pagination`);
    container.innerHTML = '';

    createBtn(container, 'Previous', dt.currentPage - 1, dt.currentPage === 1, tableId);

    const maxButtons = 7;
    let start = Math.max(1, dt.currentPage - Math.floor(maxButtons / 2));
    let end = Math.min(pages, start + maxButtons - 1);
    if (end - start + 1 < maxButtons) start = Math.max(1, end - maxButtons + 1);

    for (let i = start; i <= end; i++) {
        createBtn(container, i, i, i === dt.currentPage, tableId);
    }

    createBtn(container, 'Next', dt.currentPage + 1, dt.currentPage >= pages, tableId);
}

function createBtn(parent, label, page, disabled, tableId) {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.className = 'px-3 py-1 mx-1 border rounded text-sm';
    if (disabled) {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        btn.addEventListener('click', () => {
            dataTables[tableId].currentPage = page;
            fetchRecords(tableId);
        });
    }
    if (page === dataTables[tableId].currentPage) {
        btn.classList.add('bg-blue-600', 'text-white');
    }
    parent.appendChild(btn);
}

function hidePagination(tableId) {
    const el = document.getElementById(`${tableId}Pagination`);
    if (el) el.style.display = 'none';
}

/* --------------------------------------------------------------
   CHANGE PER-PAGE
   -------------------------------------------------------------- */
function updatePerPage(tableId, perPage, fetchUrl) {
    const dt = dataTables[tableId];
    dt.recordsPerPage = parseInt(perPage);
    dt.currentPage = 1;
    fetchRecords(tableId);
}
</script>
<script>
function loadRankTab(tab) {
    // 1. Hide all tab contents
    document.querySelectorAll('[data-tab]').forEach(t => t.classList.add('hidden'));

    // 2. Remove active style from ALL buttons
    document.querySelectorAll('.tab-button').forEach(b => {
        b.classList.remove('bg-white', 'dark:bg-neutral-700', 'text-blue-600');
        b.classList.add('bg-transparent', 'text-gray-600');
    });

    // 3. Show selected tab content
    const tabContent = document.querySelector(`[data-tab="${tab}"]`);
    if (tabContent) {
        tabContent.classList.remove('hidden');
    }

    // 4. Activate the correct button using data-tab attribute
    const activeButton = document.querySelector(`.tab-button[data-tab="${tab}"]`);
    if (activeButton) {
        activeButton.classList.remove('bg-transparent', 'text-gray-600');
        activeButton.classList.add('bg-white', 'dark:bg-neutral-700', 'text-blue-600');
    }

    // 5. Load dynamic content
    if (tab === 'history') {
        fetchRankHistory();
    } else if (tab === 'details') {
        fetchNextRanks();
    } else if (tab === 'current') {
        fetchCurrentRankChart();
    }
}
// 1. Current Rank Chart
function fetchCurrentRankChart() {
    const container = document.querySelector('[data-tab="current"] #rank-slider');
    container.innerHTML = '<div class="text-center py-20"><div class="animate-spin inline-block w-12 h-12 border-4 border-blue-500 rounded-full border-t-transparent"></div></div>';

    fetch('/user/dashboard/getcurrentrankchart')
        .then(r => r.text())
        .then(html => container.innerHTML = html);
}

// 2. Rank History
function fetchRankHistory() {
    const container = document.querySelector('[data-tab="history"]');
    container.innerHTML = '<div class="text-center py-20"><div class="animate-spin inline-block w-12 h-12 border-4 border-blue-500 rounded-full border-t-transparent"></div></div>';

    fetch('/user/dashboard/getrankhistory')
        .then(r => r.json())
        .then(data => {
            let html = '<div class="space-y-4">';
            data.forEach(h => {
                html += `
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-neutral-800 rounded-xl">
                    <div class="flex items-center gap-4">
                        <img src="${h.icon}" class="w-12 h-12 rounded-full ring-2 ring-white">
                        <div>
                            <p class="font-bold">${h.name}</p>
                            <p class="text-sm text-gray-500">${h.date}</p>
                        </div>
                    </div>
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>`;
            });
            html += '</div>';
            if (data.length === 0) html = '<p class="text-center py-16 text-gray-500">No rank history</p>';
            container.innerHTML = html;
        });
}

// 3. Next Ranks
function fetchNextRanks() {
    const container = document.querySelector('[data-tab="details"] .space-y-3');
    container.innerHTML = '<div class="text-center py-20"><div class="animate-spin inline-block w-12 h-12 border-4 border-purple-500 rounded-full border-t-transparent"></div></div>';

    fetch('/user/dashboard/getnextranks')
        .then(r => r.json())
        .then(ranks => {
            let html = '';
            ranks.forEach(r => {
                html += `
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-neutral-800 dark:to-neutral-700 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex-center text-white font-bold text-lg">
                            ${r.name.substring(0,2)}
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">${r.name}</h4>
                            <p class="text-xs text-gray-600">Click to view</p>
                        </div>
                    </div>
                    <button onclick="openRankModal(${r.id}, '${r.name}')"
                            class="p-3 bg-purple-600 text-white rounded-xl hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </button>
                </div>`;
            });
            if (ranks.length === 0) html = '<p class="text-center py-16 text-gray-500">No upcoming ranks</p>';
            container.innerHTML = html;
        });
}

// Auto load first tab
document.addEventListener('DOMContentLoaded', () => {
    loadRankTab('current');
});
</script>
<script>
function loadMemberRankFromLinkTable(memberId = null) {
    const container = document.getElementById('member-rank-container');
    container.innerHTML = '<div class="text-center py-10"><div class="animate-spin inline-block w-12 h-12 border-4 border-blue-500 rounded-full border-t-transparent"></div></div>';

    const url = memberId
        ? `/user/dashboard/get-rank-from-link-table?member_id=${memberId}`
        : `/user/dashboard/get-rank-from-link-table`;

    fetch(url)
        .then(r => r.json())
        .then(ranks => {
            if (ranks.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500 py-10">No rank found</p>';
                return;
            }

            let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';

            ranks.forEach(rank => {
                const achieved = rank.rank_achieved_date
                    ? new Date(rank.rank_achieved_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })
                    : 'Not Achieved';

                html += `
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-neutral-700">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="${rank.rank_image.includes('http') ? rank.rank_image : '/storage/' + rank.rank_image}"
                             class="w-16 h-16 rounded-full ring-4 ring-white shadow-md object-cover"
                             alt="${rank.rank_name}">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">${rank.rank_name}</h3>
                            <p class="text-sm text-gray-500">Rank ID: ${rank.rank_id}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Matrix ID</span>
                            <span class="font-medium">${rank.matrix_id}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Achieved On</span>
                            <span class="font-medium text-green-600">${achieved}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Commission</span>
                            <span class="font-bold text-blue-600">$${rank.commission}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Bonus</span>
                            <span class="font-bold text-purple-600">$${rank.bonus}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Next Rank ID</span>
                            <span class="font-medium">${rank.higher_rank || '—'}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-neutral-700">
                        <div class="flex items-center justify-center">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-500"
                                     style="width: 100%; background-color: ${rank.rank_color}"></div>
                            </div>
                        </div>
                        <p class="text-center text-xs mt-2 text-gray-500">Rank Active</p>
                    </div>
                </div>`;
            });

            html += '</div>';
            container.innerHTML = html;
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<p class="text-red-500 text-center">Error loading rank</p>';
        });
}
</script>
<script>
    // PREVENT DOUBLE LOADING
    let initialized = false;

    document.addEventListener("DOMContentLoaded", function () {
        if (initialized) return;
        initialized = true;

        // BLOCK 2 & BLOCK 3 LAZY LOADER (DB DATA)
        function loadBlock(id, url, nextId = null) {
            const block = document.getElementById(id);
            if (!block || block.dataset.loaded) return;

            fetch(`/user/dashboard/${url}`)
                .then(r => r.text())
                .then(html => {
                    block.innerHTML = html;
                    block.dataset.loaded = "true";

                    // BLOCK 2: SWIPER + MODALS
                    if (id === 'block2') {
                        if (typeof Swiper !== 'undefined') {
                            new Swiper(".mySwiper", {
                                loop: true,
                                autoplay: { delay: 3000 },
                                navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" }
                            });
                        }
                        document.querySelectorAll('[data-modal-target]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const modalId = btn.dataset.modalTarget;
                                const url = btn.dataset.modalUrl;
                                loadModalContent(modalId, url);
                            });
                        });
                    }

                    // BLOCK 3: WORLD MAP FROM DB
                    if (id === 'block3') {
                        loadHighchartsAndMap();
                    }

                    // SHOW NEXT BLOCK
                    if (nextId) {
                        const next = document.getElementById(nextId);
                        if (next) next.classList.remove('hidden');
                        observeBlock(nextId, getNextId(nextId));
                    }
                });
        }

        function observeBlock(id, nextId = null) {
            const block = document.getElementById(id);
            if (!block) return;

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        loadBlock(id, `dashboard_${id}`, nextId);
                        observer.unobserve(block);
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(block);
        }

        function getNextId(id) {
            const num = parseInt(id.replace('block', '')) + 1;
            return `block${num}`;
        }

        // LOAD HIGHCHARTS + WORLD MAP
        function loadHighchartsAndMap() {
            if (typeof Highcharts !== 'undefined') {
                renderWorldMap();
                return;
            }

            const scripts = [
                'https://code.highcharts.com/highcharts.js',
                'https://code.highcharts.com/maps/modules/map.js',
                'https://code.highcharts.com/mapdata/custom/world.js'
            ];

            scripts.forEach((src, i) => {
                const script = document.createElement('script');
                script.src = src;
                script.onload = () => { if (i === scripts.length - 1) renderWorldMap(); };
                document.head.appendChild(script);
            });
        }

        function renderWorldMap() {
            fetch('/user/dashboard/getcountrysalesdata')
                .then(r => r.json())
                .then(data => {
                    const container = document.getElementById('world-map-container');
                    if (!container) return;

                    const chartData = data.map(d => ({
                        'iso-a2': d['iso-a2'],
                        value: d.value,
                        color: d.value < 1000 ? '#f4f4f4' : d.value < 3000 ? '#c6e2b3' : '#006400'
                    }));

                    Highcharts.mapChart(container, {
                        chart: { map: 'custom/world', backgroundColor: 'transparent' },
                        title: { text: '' },
                        mapNavigation: { enabled: true },
                        colorAxis: { min: 0, max: 5000, minColor: '#fff', maxColor: '#006400' },
                        series: [{
                            data: chartData,
                            mapData: Highcharts.maps['custom/world'],
                            joinBy: 'iso-a2',
                            name: 'Sales',
                            states: { hover: { color: '#a4edba' } },
                            tooltip: { pointFormat: '{point.name}: <b>{point.value}</b>' }
                        }],
                        credits: { enabled: false }
                    });
                });
        }

        // MODAL CONTENT LOADER
        window.loadModalContentRank = function(modalId, rankId) {
            const modal = document.getElementById(modalId);
            const body = modal.querySelector('#next-rank-contents');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            body.innerHTML = 'Loading...';

            fetch(`/user/dashboard/getrankdetailsrequirements/${rankId}`)
                .then(r => r.text())
                .then(html => body.innerHTML = html)
                .catch(() => body.innerHTML = '<p class="text-red-500">Error loading data</p>');
        };

        window.hideModal = id => document.getElementById(id)?.classList.add('hidden');

        // START LAZY LOADING
        observeBlock('block2', 'block3');
    });
</script>
 <!-- ===== Page Wrapper End ===== -->
    <script data-cfasync="false" src="{{ asset('js/bui.min.js') }}"></script>
    <script defer src="{{ asset('js/tui.js') }}"></script>
    <script src="{{ asset('js/bundle.js') }}"></script>

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

    <script>

        const getChartOptions = () => {
            return {
                series: [52.8, 26.8, 20.4],
                colors: ["#1C64F2", "#16BDCA", "#9061F9"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: ["Direct", "Organic search", "Referrals"],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            }
        }

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
            chart.render();
        }

    </script>


    <!-- Chart.js CDN (for Graph) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
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
    </script>

    <!-- dropdown  -->
    <script src="{{ asset('js/choices.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

    <!-- Countup init -->
    <script type="module" src="{{ asset('js/countup.init.js') }}"></script>

    <!-- ApexChat js -->
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>

    <!-- Ecommerce dashboard init -->
    <script src="{{ asset('js/apexcharts-config.init.js') }}"></script>
    <script src="{{ asset('js/dashboard-ecommerce.init.js') }}"></script>

    <!-- App js -->
    <script type="module" src="{{ asset('js/app.js') }}"></script>

