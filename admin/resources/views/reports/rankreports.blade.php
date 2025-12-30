@extends('admin::components.common.main')

@section('content')
<!-- Main Content Area -->
<!-- breadcrub navs start-->
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
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Rank Bonus
                       </span>
                    </div>
                </li>
            </ol>
    </div>



<main class="flex-grow">
    <div class="container mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">

       <div class="bg-white rounded-lg shadow p-6 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200 "
>
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
                        <div class="items-per-page-container">
                            <!-- <label for="items-per-page">Items per page:</label> -->
                            <!-- <select id="items-per-page" class="w-16 bg-white text-black dark:text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block p-2.5 dark:bg-gray-900 border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> -->
                        </div>
                        <div id="table-container">
                        <table id="filter-table" class="min-w-full mt-5 divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr class="border-b border-gray-300 block md:table-row text-black text-xs uppercase">
                                <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">{{ __('SNo') }}<svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                </th>
                                            <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">{{ __('Username') }}<svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                            </th>
                                            <th class="px-4 py-3 dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">{{ __('AMOUNT') }}<svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span></th>
                                            <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">{{ __('Wallet') }}<svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span></th>
                                            <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">{{ __('Date') }}<svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span></th>




                                </tr>
                            </thead>
                            <tbody id="data-body" class="block md:table-row-group">
                            <!-- Data will be inserted dynamically -->
                            </tbody>
                        </table>
                        <div class="datatable-bottom flex justify-between items-center mt-4 px-4">
                            <!-- Left: Entries Info -->
                            <p class="datatable-info text-sm text-gray-600"></p>

                            <!-- Right: Pagination Controls -->
                            <div id="pagination" class="flex space-x-2">

                            </div>
                        </div>
</div>
                        </div>

                        </div>
                    </div>


          </div>
          <!-- card -->
       </div>

 </main>

<script src="{{asset('js/jspdf.umd.min.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.autotable.min.js')}}"></script>
<script>
    const getRankBonusDataUrl = "{{ route('admin.getRankBonusData') }}";
</script>
<!-- custom scripts start-->
<script>
let dataTable; // Declare dataTable globally
let currentPage = 1; // Track current page
let recordsPerPage = 10; // Default records per page
const tableBody = document.querySelector("#filter-table tbody");
const paginationContainer = document.getElementById('pagination');

// Store the last search query globally

    let lastSearchQuery = '';
    let lastColumnIndex = null;
    let debounceTimer;

// Event listener for DOM content loaded
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('export-csv').addEventListener('click', function(event) {

event.preventDefault(); // Prevent the page from reloading or performing the default action
const rows = document.querySelectorAll('#filter-table tbody tr');
let csvContent = 'SNo, Username, Amount, Wallet, Date\n'; // Set headers

rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    let rowData = [];
    cells.forEach(cell => rowData.push(cell.textContent.trim()));
    csvContent += rowData.join(',') + '\n'; // Join each cell data with a comma and add a new row
});

const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
const link = document.createElement('a');
link.href = URL.createObjectURL(blob);
link.download = 'rankreports.csv'; // Set the file name
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
                if (index >= 0) {
                    rowData.push(cell.textContent.trim());
                }
            });
            tableData.push(rowData);
        });

        doc.autoTable({
            head: [['No', 'Username', 'Amount', 'Wallet', 'Date']], // Headers
            body: tableData,
        });

        doc.save('rankreports.pdf'); // Download PDF file
    });
    document.getElementById('print-table').addEventListener('click', function(event) {
        event.preventDefault();

        const rows = document.querySelectorAll('#filter-table tbody tr'); // Get all rows in tbody
        let printContent = '<table border="1" cellpadding="5" cellspacing="0">'; // Start table

        rows.forEach(row => {
            printContent += row.outerHTML; // Add each row to the content
        });

        printContent += '</table>'; // End table

        const printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Rank Reports</title></head><body>');
        printWindow.document.write('<h1>Rank Reports</h1>');
        printWindow.document.write(printContent); // Insert table content into the print window
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print(); // Trigger the print dialog
    });
    fetchRecords(); // Fetch initial records

// Listen for per-page changes

 fetchRecords().then(() => {
        initializeDataTable(); // Initialize DataTable only once after first data load
    });

});


// ----------------- Show All Rows -----------------
const showAllRows = () => {
    const rows = tableBody.querySelectorAll("tr");
    rows.forEach(row => row.style.display = "");

    const noRecordsMessage = document.getElementById("no-records-message");
    if (noRecordsMessage) noRecordsMessage.remove();

    paginationContainer.style.display = "block";
};


// ----------------- Filter Rows -----------------
const filterRows = (searchQuery) => {
    const rows = tableBody.querySelectorAll("tr:not(#no-records-message)");
    let foundMatch = false;

    searchQuery = searchQuery.toLowerCase().trim();

    // Remove old "no records" row if exists
    const oldMessage = document.getElementById("no-records-message");
    if (oldMessage) oldMessage.remove();

    if (searchQuery === "") {
        rows.forEach(row => row.style.display = "");
        paginationContainer.style.display = "block";
        return;
    }

    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        let rowMatches = false;

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(searchQuery)) {
                rowMatches = true;
            }
        });

        if (rowMatches) {
            row.style.display = "";
            foundMatch = true;
        } else {
            row.style.display = "none";
        }
    });

    // Show "No records found"
    if (!foundMatch) {
        const message = document.createElement("tr");
        message.id = "no-records-message";
        message.innerHTML = `
            <td colspan="7" class="text-center py-4 font-medium">
                No records found
            </td>
        `;
        tableBody.appendChild(message);
        paginationContainer.style.display = "none";
    } else {
        paginationContainer.style.display = "block";
    }
};


// ----------------- Create Filter Row -----------------
const createFilterRow = () => {
    const thead = document.querySelector('#filter-table thead');
    if (!thead) return;

    // Remove old filter row
    const oldRow = thead.querySelector('.search-filtering-row');
    if (oldRow) oldRow.remove();

    const filterRow = document.createElement('tr');
    filterRow.className = 'search-filtering-row  dark:text-white bg-white dark:bg-gray-900';

    const headerCells = thead.querySelector('tr').children;

    Array.from(headerCells).forEach((th, index) => {
        const thFilter = document.createElement('th');

        // Skip columns you don't want search
        if (index === 0 || index === 2 || index === 3) {
            filterRow.appendChild(thFilter);
            return;
        }

        const input = document.createElement('input');
        input.type = 'search';
        input.className = 'datatable-input w-full px-2 py-1 text-sm border rounded';
        input.placeholder = `Search ${th.textContent.trim()}`;

        // Debounced search
        input.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const query = e.target.value.trim().toLowerCase();
                lastSearchQuery = query;
                lastColumnIndex = index;
                filterRows(query);
            }, 500);
        });

        thFilter.appendChild(input);
        filterRow.appendChild(thFilter);
    });

    thead.appendChild(filterRow);

    // Restore previous search
    if (lastSearchQuery && lastColumnIndex !== null) {
        const inputs = filterRow.querySelectorAll('input');
        const inputIndex = lastColumnIndex - 1; // skip S.No column
        if (inputs[inputIndex]) inputs[inputIndex].value = lastSearchQuery;
    }
};

// ----------------- Initialize DataTable -----------------
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
        console.log(searchInput);

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

// ----------------- Fetch Records from Server -----------------
 const fetchRecords = async (page = 1) => {
    try {
        const table = document.getElementById('filter-table');
        const tbody = table.querySelector('tbody');
        const datatableInfo = document.querySelector('.datatable-info');

        currentPage = page;

        const queryParams = new URLSearchParams({
            page,
            perPage: recordsPerPage
        });

        if (lastSearchQuery) queryParams.append('query', lastSearchQuery);

        const response = await fetch(`${getRankBonusDataUrl}?${queryParams.toString()}`);
        const data = await response.json();

        if (!data.records || data.records.length === 0) {
            tbody.innerHTML = "<tr id='no-data-row'><td colspan='7' class='text-center'>No records found</td></tr>";
            paginationContainer.style.display = 'none';
            return;
        }


        tbody.innerHTML = '';
        const totalRecords = data.total_records || 0;

        data.records.forEach(record => {
            tbody.innerHTML += `
                <tr class="border-b border-gray-300 hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium">${record.No}</td>
                    <td class="px-4 py-3 text-sm">${record.name}</td>
                    <td class="px-4 py-3 text-sm">${record.amount}</td>
                    <td class="px-4 py-3 text-sm">${record.wallet}</td>
                    <td class="px-4 py-3 text-sm">${record.date}</td>
                </tr>
            `;
        });

        // Update total info
        if (datatableInfo) {
            const startRecord = (page - 1) * recordsPerPage + 1;
            const endRecord = Math.min(page * recordsPerPage, totalRecords);
            datatableInfo.textContent = `Showing ${startRecord} to ${endRecord} of ${totalRecords} entries`;
        }

        // Update pagination
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
 @endsection
