@extends('admin::components.common.main')

@section('content')

 <div class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/admin/dashboard"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                        <div class="relative w-5 h-5 flex items-center justify-center">

                            <!-- Animated Border ONLY -->
                            <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                                animate-ping opacity-60"></span>

                            <!-- Static Icon -->
                            <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>

                        <a href="#"
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Reports

              </a>
                    </div>
                </li>

                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Admin Earnings
                       </span>
                    </div>
                </li>
            </ol>
      </div>



<main class="flex-grow">
    <div class="container mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">

        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 p-2">
                <!-- card -->
                <div class="w-full mx-auto p-4">
                <div class="export-buttons flex justify-end space-x-3">
                        <button id="export-csv" class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600"
>Export to CSV</button>
                        <button id="export-pdf" class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600"
>Export to PDF</button>
                        <button id="print-table" class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600"
>Print</button>
                    </div>
                    <!-- Data Table -->
                    <div class="py-6">
                        <div class="items-per-page-container flex justify-between items-center">
                            <div>
                                <!-- <label for="items-per-page" class="mr-2">Items per page:</label>
                                <select id="items-per-page" class="w-16 bg-white text-black dark:text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block p-2.5 dark:bg-gray-900 border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> -->
                            </div>
                            <!-- <div class="flex space-x-6">
                                <div>
                                    <span class="text-sm font-semibold">Paid Sum: </span>
                                    <span class="text-lg font-bold text-blue-600">$_SESSION['site_settings']['site_currency'] $total['paidsum']</span>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold">Unpaid Sum: </span>
                                    <span class="text-lg font-bold text-red-600">$_SESSION['site_settings']['site_currency'] $total['unpaidsum'] </span>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold">Profit: </span>
                                    <span class="text-lg font-bold text-red-600">$_SESSION['site_settings']['site_currency']  $total['profit'] </span>
                                </div>
                            </div> -->

                        </div>


                        <div id="table-container">
                        <table id="filter-table" class="min-w-full mt-5 divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr class="border-b border-gray-300 block md:table-row text-black text-xs uppercase">
                                    <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"> <span class="flex items-center">Username
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">Earning Type
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3 dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">Transaction ID
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">Date
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">Description
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">Payment Status
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3 dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">AMOUNT
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">Action
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                            </svg>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="data-body" class="block md:table-row-group">
                                <!-- Data will be inserted dynamically -->
                            </tbody>
                        </table>
                        <div class="datatable-bottom flex justify-between items-center mt-4 px-4">
                            <!-- Left: Entries Info -->
                            <p class="datatable-info text-sm  dark:text-white"></p>

                            <!-- Right: Pagination Controls -->
                            <div id="pagination" class="flex space-x-2">

                            </div>
                        </div>
                    </div>
                </div>
                </div>

            </div>
            <!-- card -->
        </div>
        <!--Row-1-->
    </div>
</main>
<!-- Modal - Same File-ல இருக்கும் -->
<div id="earningDetailsModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-50">

    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Admin Earnings Details
                </h3>
                <button type="button" onclick="closeEarningModal()"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-2xl p-1.5">
                    ×
                </button>
            </div>

            <div class="p-6" id="modalContent">
                <!-- AJAX content injected here -->
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end p-4 border-t border-gray-200 dark:border-gray-700">
                <button onclick="closeEarningModal()"
                        class="px-6 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


</main>
<script src="{{asset('js/jspdf.umd.min.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.autotable.min.js')}}"></script>
<script>
    const getadminearningsRecordDataUrl = "{{ route('admin.adminEarningsRecords') }}";
</script>

            <script>
    let dataTable; // Declare dataTable globally
let currentPage = 1; // Track current page
let recordsPerPage = 10; // Default records per page
const tableBody = document.querySelector("#filter-table tbody");
const paginationContainer = document.getElementById('pagination');

// Store the last search query globally
let lastSearchQuery = '';

// Event listener for DOM content loaded
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('export-csv').addEventListener('click', function(event) {

event.preventDefault(); // Prevent the page from reloading or performing the default action
const rows = document.querySelectorAll('#filter-table tbody tr');
let csvContent = 'Username, Earning Type, Transaction ID, Date, Description, Payment Status, AMOUNT \n'; // Set headers

rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    let rowData = [];
    cells.forEach((cell, index) => {
        if (index < cells.length - 1) { // Skip the last column
            rowData.push(cell.textContent.trim());
        }
    });
    csvContent += rowData.join(',') + '\n'; // Join each cell data with a comma and add a new row
});

const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
const link = document.createElement('a');
link.href = URL.createObjectURL(blob);
link.download = 'adminearnings.csv'; // Set the file name
link.click();
});
 // PDF Export using jsPDF
 document.getElementById('export-pdf').addEventListener('click', function(event) {
        event.preventDefault();

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const rows = document.querySelectorAll('#filter-table tbody tr');
        let tableData = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let rowData = [];
            cells.forEach((cell, index) => {
                // Skip the first column (index 0)
                if (index >= 0 && index < cells.length - 1) {
                    rowData.push(cell.textContent.trim());
                }
            });
            tableData.push(rowData);
        });

        doc.autoTable({
            head: [['Name', 'Earning Type', 'Transaction ID', 'Date', 'Description','paymentstatus','Payment Status','AMOUNT']], // Headers
            body: tableData,
        });

        doc.save('adminearnings.pdf'); // Download PDF file
    });

    document.getElementById('print-table').addEventListener('click', function(event) {
        event.preventDefault();

        const rows = document.querySelectorAll('#filter-table tbody tr'); // Get all rows in tbody
        let printContent = '<table border="1" cellpadding="5" cellspacing="0">'; // Start table

        rows.forEach(row => {
            let cells = row.querySelectorAll('td');
            let rowContent = '<tr>';

            cells.forEach((cell, index) => {
                if (index < cells.length - 1) { // Skip the last column
                    rowContent += `<td>${cell.innerHTML.trim()}</td>`;
                }
            });

            rowContent += '</tr>';
            printContent += rowContent;
        });

        printContent += '</table>'; // End table

        let printWindow = window.open('', '', 'height=500,width=800');

        printWindow.document.write('<html><head><title>Admin Earnings</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
        printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
        printWindow.document.write('</style></head><body>');
        printWindow.document.write('<h1>Admin Earnings</h1>');
        printWindow.document.write(printContent); // Insert only tbody content
        printWindow.document.write('</body></html>');

        printWindow.document.close();
        printWindow.print(); // Open print dialog
    });

    fetchRecords(); // Fetch initial records

// Listen for per-page changes
document.getElementById('items-per-page').addEventListener('change', function() {
    recordsPerPage = this.value;
    fetchRecords(); // Fetch records with updated pagination settings
});
// Initial load
    fetchRecords().then(() => {
        initializeDataTable(); // Initialize DataTable only once after first data load
    });
});

    const showAllRows = () => {
        const rows = tableBody.querySelectorAll("tr");

        rows.forEach(row => {
            row.style.display = "";
        });

        // Remove "no records" row if exists
        const noRecordsMessage = document.getElementById("no-records-message");
        if (noRecordsMessage) {
            noRecordsMessage.remove();
        }

        // Show pagination again
        paginationContainer.style.display = "block";
    };
// Create filter row with real event listeners
const createFilterRow = () => {
    const thead = document.querySelector('#filter-table thead');
    if (!thead) return;

    // Remove existing filter row if any
    const existingFilter = thead.querySelector('.search-filtering-row');
    if (existingFilter) existingFilter.remove();

    const tr = document.createElement('tr');
    tr.className = 'search-filtering-row text-black dark:text-white bg-white dark:bg-gray-900';

    const headerCells = thead.querySelector('tr').children;


};

// Initialize DataTable only once
const initializeDataTable = () => {
    if (!dataTable) {
        dataTable = new simpleDatatables.DataTable("#filter-table", {
            searchable: true,
            paging: false,
            labels: {
                placeholder: "Search ...",
                searchTitle: "Search ",
                perPage: "per page",
                noRows: "No records found to display",
                info: false,
            }
        });

        // Listen for perpage event
        dataTable.on("datatable.perpage", (newPerPage) => {
            console.log(`Records per page changed to: ${newPerPage}`);
            recordsPerPage = newPerPage; // Update global variable
            currentPage = 1; // Reset to the first page
            fetchRecords(); // Fetch updated records
        });

        const searchInput = document.querySelector(".datatable-input");

        if (searchInput) {
            searchInput.addEventListener("input", () => {
                const searchQuery = searchInput.value.toLowerCase().trim(); // Get search query
                console.log("Search query changed1:", searchQuery);

                if (searchQuery === "") {
                    console.log("Search input is empty. Showing all rows and pagination.");
                    showAllRows(); // Show all rows
                    paginationContainer.style.display = "block"; // Show pagination
                } else {
                    console.log(`Filtering rows with query: ${searchQuery}`);
                    filterRows(searchQuery); // Filter rows based on the query
                }
            });
        }



    } else {
        dataTable.refresh();
    }
};

const filterRows = (searchQuery) => {
    const rows = tableBody.querySelectorAll("tr"); // Get all rows of the table
    let foundMatch = false; // Flag to track if any row matches the search

    console.log('Filtering rows with query:', searchQuery);
    if (searchQuery.trim() === "") {
        // If search query is empty, show all rows
        rows.forEach(row => {
            row.style.display = ""; // Show all rows
        });

        // Show pagination when no search query is entered
        paginationContainer.style.display = 'block';
        return; // Exit the function early
    }

    rows.forEach(row => {
        const cells = row.querySelectorAll("td"); // Get all cells in the row
        let rowMatches = false; // Flag to track if row matches search

        // Loop through each cell in the row
        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(searchQuery)) {
                rowMatches = true; // If any cell matches, mark the row as matching
            }
        });

        // Show or hide row based on whether it matches the search query
        if (rowMatches) {
            row.style.display = ""; // Show the row
            foundMatch = true;
        } else {
            row.style.display = "none"; // Hide the row
        }
    });

    // Show "No records found" message if no rows match the search query
    const noRecordsMessage = document.getElementById("no-records-message");
    if (!foundMatch) {
        if (!noRecordsMessage) {
            const message = document.createElement("tr");
            message.id = "no-records-message";
            message.innerHTML = '<td colspan="8" class="text-center">{{ __("No records found to display") }}</td>';
            tableBody.appendChild(message);
        }
        paginationContainer.style.display = 'none'; // Hide pagination
    } else {
        if (noRecordsMessage) {
            noRecordsMessage.remove(); // Remove "No records found" message if there are matching rows
        }
        paginationContainer.style.display = 'none'; // Show pagination if there are matching rows
    }
};

const fetchRecords = async (page = 1, query = lastSearchQuery, dataColumns = null) => {
    try {
        const table = document.getElementById('filter-table');
        const tableBody = table ? table.querySelector('tbody') : null;
        const datatableInfo = document.querySelector('.datatable-info');
        if (!tableBody || !paginationContainer) {
            console.error("Table body or pagination element not found in the DOM.");
            return;
        }

        currentPage = page;

        const queryParams = new URLSearchParams({
            page,
            perPage: recordsPerPage,
        });

        if (lastSearchQuery) {
            queryParams.append('query', lastSearchQuery);
            if (lastColumnIndex !== null) {
                queryParams.append('columnIndex', lastColumnIndex);
            }
        }

        const response = await fetch(`${getadminearningsRecordDataUrl}?${queryParams.toString()}`);
        const rawData = await response.json();

        // ✅ Handle data whether wrapped in "original" or direct
        const data = rawData.original || rawData;
        const records = data.records || [];
        const totalRecords = data.total_records || 0;

        if (!records.length) {
            tableBody.innerHTML = "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
             createFilterRow();
            return;
        }

        tableBody.innerHTML = ''; // Clear old rows
        records.forEach((record) => {
            tableBody.innerHTML += `
                <tr class="border-b border-gray-300 block md:table-row">
                    <td class="font-medium whitespace-nowrap dark:text-white">${record.Name}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.earningtype}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.transid}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.date}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.description}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.paymentstatus}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.amount}</td>
                    <td class="font-medium  whitespace-nowrap dark:text-white">${record.action}</td>
                </tr>
            `;
        });

        // ✅ Update datatable info
        if (datatableInfo) {
            const startRecord = (page - 1) * recordsPerPage + 1;
            const endRecord = Math.min(page * recordsPerPage, totalRecords);
            datatableInfo.textContent = `Showing ${startRecord} to ${endRecord} of ${totalRecords} entries`;
        }

        renderPagination(totalRecords, currentPage);

        initializeDataTable();
        createFilterRow();
    } catch (error) {
        console.error('Error fetching records:', error);
    }
};

// Function to render pagination
const renderPagination = (totalRecords, currentPage) => {
    const totalPages = Math.ceil(totalRecords / recordsPerPage);
    paginationContainer.innerHTML = ''; // Clear existing pagination buttons

    const maxPageButtonsToShow = 10; // Maximum number of page buttons to show
    const startPage = Math.max(1, currentPage - Math.floor(maxPageButtonsToShow / 2));
    const endPage = Math.min(totalPages, startPage + maxPageButtonsToShow - 1);

    // ✅ Previous button (Hide when on first page)
    if (currentPage > 1) {
        const prevButton = document.createElement("button");
        prevButton.classList.add("pagination-button", "px-4", "py-2", "mx-1", "border", "rounded");
        prevButton.textContent = "Previous";
        prevButton.onclick = () => fetchPageRecords(currentPage - 1);
        paginationContainer.appendChild(prevButton);
    }

    // ✅ Page buttons
    for (let i = startPage; i <= endPage; i++) {
        const button = document.createElement("button");
        button.classList.add("pagination-button", "px-4", "py-2", "mx-1", "border", "rounded");
        button.textContent = i;
        button.onclick = () => fetchPageRecords(i);
        if (i === currentPage) {
            button.disabled = true;
            button.classList.add("active", "bg-gray-500", "text-white");
        }
        paginationContainer.appendChild(button);
    }

    // ✅ Next button (Hide when on last page)
    if (currentPage < totalPages) {
        const nextButton = document.createElement("button");
        nextButton.classList.add("pagination-button", "px-4", "py-2", "mx-1", "border", "rounded");
        nextButton.textContent = "Next";
        nextButton.onclick = () => fetchPageRecords(currentPage + 1);
        paginationContainer.appendChild(nextButton);
    }
};

// Function to handle page click event for pagination
function fetchPageRecords(pageId) {
    fetchRecords(pageId);
}
</script>

<script>
function viewDetails(id) {
    const url = "{{ route('admin.adminEarningsdetailsdata', ':id') }}".replace(':id', id);

    document.getElementById('modalContent').innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-blue-600"></div>
            <p class="mt-4 text-gray-600">Loading...</p>
        </div>`;

    document.getElementById('earningDetailsModal').classList.remove('hidden');

    fetch(url)
        .then(r => r.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
        })
        .catch(err => {
            document.getElementById('modalContent').innerHTML = `
                <div class="text-center py-10 text-red-600">
                    <p>Error loading details</p>
                </div>`;
        });
}

function closeEarningModal() {
    document.getElementById('earningDetailsModal').classList.add('hidden');
}
</script>

<!-- custom scripts end-->
@endsection
