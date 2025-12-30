@extends('admin::components.common.main')

@section('content')

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
                 <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>

                        <a href="#"
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">PV

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
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">PV
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
                         <!-- Data Table -->
                         <div class="py-6">
                         <div class="items-per-page-container">
                            <!-- <label for="items-per-page dark:text-white mb-2">Items per page:</label>
                            <select id="items-per-page" class="w-16 bg-white text-black dark:text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block p-2.5 dark:bg-gray-900 border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500">
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
                                            <th class="px-4 py-3  dark:text-white bg-white dark:bg-gray-900"><span class="flex items-center">{{ __('PV') }}<svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
                            <p class="datatable-info text-sm  dark:text-white"></p>

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

<script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
<script src="{{ asset('js/jspdf.plugin.autotable.min.js') }}"></script>

<script>
    const getCPVReportsDataUrl = "{{ route('admin.cpvreportData') }}";

let dataTable = null;
let currentPage = 1;
let recordsPerPage = 10;
let lastSearchQuery = '';
let lastColumnIndex = null;

    const tableBody = document.querySelector("#filter-table tbody");
    const paginationContainer = document.getElementById('pagination');
    const datatableInfo = document.querySelector('.datatable-info');
        // DOM LOADED — INITIALIZE EVERYTHING
    document.addEventListener('DOMContentLoaded', () => {
        // Export CSV
        document.getElementById('export-csv')?.addEventListener('click', function(e) {
            e.preventDefault();
            let csv = 'Sno,Username,Amount,Date\n';
            document.querySelectorAll('#filter-table tbody tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 4) {
                    const rowData = [
                        cells[0].textContent.trim(),
                        cells[1].textContent.trim(),
                        cells[2].textContent.trim(),
                        cells[3].textContent.trim()
                    ];
                    csv += rowData.join(',') + '\n';
                }
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pvreports.csv';
            a.click();
            URL.revokeObjectURL(url);
        });

        // Export PDF
        document.getElementById('export-pdf')?.addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            const tableData = [];

            document.querySelectorAll('#filter-table tbody tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 4) {
                    tableData.push([
                        cells[0].textContent.trim(),
                        cells[1].textContent.trim(),
                        cells[2].textContent.trim(),
                        cells[3].textContent.trim()
                    ]);
                }
            });

            doc.autoTable({
                head: [['Sno', 'Username', 'Amount', 'Date']],
                body: tableData,
                theme: 'striped',
                styles: { fontSize: 10 },
                headStyles: { fillColor: [41, 128, 185] }
            });
            doc.save('pvreports.pdf');
        });

        // Print Table
        document.getElementById('print-table')?.addEventListener('click', function(e) {
            e.preventDefault();
            const printWin = window.open('', '', 'height=700,width=1000');
            printWin.document.write(`
                <html><head><title>PV Reports</title>
                <style>
                    body { font-family: Arial; }
                    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    th, td { border: 1px solid #000; padding: 10px; text-align: left; }
                    th { background: #f0f0f0; }
                    h1 { text-align: center; }
                </style>
                </head><body>
                <h1>PV Reports</h1>
                ${document.querySelector('#filter-table').outerHTML}
                </body></html>
            `);
            printWin.document.close();
            printWin.print();
        });

        // Items per page
        document.getElementById('items-per-page')?.addEventListener('change', function() {
            recordsPerPage = parseInt(this.value) || 10;
            currentPage = 1;
            fetchRecords();
        });

        // Global Search (if you have input with id="global-search")
        document.getElementById('global-search')?.addEventListener('input', function(e) {
            lastColumnIndex = null;
            fetchRecords(1, e.target.value.trim());
        });

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

    // CREATE FILTER ROW — S.no FILTER REMOVED ONLY
    const createFilterRow = () => {
        const thead = document.querySelector('#filter-table thead');
        if (!thead) return;

        // Remove old filter row
        const oldRow = thead.querySelector('.search-filtering-row');
        if (oldRow) oldRow.remove();

        const filterRow = document.createElement('tr');
        filterRow.className = 'search-filtering-row text-black dark:text-white bg-white dark:bg-gray-900 border-b';

        const headerCells = thead.querySelector('tr').children;

        Array.from(headerCells).forEach((th, index) => {
            const thFilter = document.createElement('th');
            thFilter.className = 'p-2';

            // SKIP FILTER INPUT FOR S.no (index 0 only)
            if (index === 0) {
                // Keep empty cell for alignment
                filterRow.appendChild(thFilter);
                return;
            }

            // Create input for all other columns
            const input = document.createElement('input');
            input.type = 'search';
            input.className = 'datatable-input w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
            input.placeholder = `Search ${th.textContent.trim() || 'Column'}`;

            // Debounced column search
            let timer;
            input.addEventListener('input', function(e) {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    currentPage = 1;
                    lastSearchQuery = e.target.value.trim();
                    lastColumnIndex = index;
                    fetchRecords(currentPage, lastSearchQuery, lastColumnIndex);
                }, 500);
            });

            thFilter.appendChild(input);
            filterRow.appendChild(thFilter);
        });

        thead.appendChild(filterRow);

        // Restore last search value (skip index 0)
        if (lastSearchQuery && lastColumnIndex !== null && lastColumnIndex > 0) {
            const inputs = filterRow.querySelectorAll('input');
            const inputIndex = lastColumnIndex - 1; // -1 because we skipped column 0
            if (inputs[inputIndex]) {
                inputs[inputIndex].value = lastSearchQuery;
            }
        }
    };

    // FETCH RECORDS FROM SERVER
    const fetchRecords = async (page = 1, query = '', columnIndex = null) => {
        try {
            currentPage = page;
            lastSearchQuery = query;
            lastColumnIndex = columnIndex;

            const params = new URLSearchParams({
                page: page,
                perPage: recordsPerPage
            });

            if (query) {
                params.append('query', query.trim());
                if (columnIndex !== null) params.append('columnIndex', columnIndex);
            }

            const response = await fetch(`${getCPVReportsDataUrl}?${params.toString()}`);
            const result = await response.json();

            const records = result.records || [];
            const totalRecords = result.total_records || 0;
            const totalPages = result.total_pages || 1;

            tableBody.innerHTML = '';

            if (records.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-12 text-gray-500 text-lg">No records found</td></tr>`;
                datatableInfo.textContent = 'Showing 0 to 0 of 0 entries';
                paginationContainer.innerHTML = '';
                createFilterRow(); // Keep filter row even when empty
                return;
            }

            // Populate table rows
            records.forEach(record => {
                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-4 py-3 text-sm font-medium">${record.No || '-'}</td>
                        <td class="px-4 py-3 text-sm font-medium">${record.name || '-'}</td>
                        <td class="px-4 py-3 text-sm font-medium text-right">${record.amount || '0'}</td>
                        <td class="px-4 py-3 text-sm font-medium">${record.formatdate || '-'}</td>
                    </tr>`;
            });

            // Update info
            const from = (page - 1) * recordsPerPage + 1;
            const to = Math.min(page * recordsPerPage, totalRecords);
            datatableInfo.textContent = `Showing ${from} to ${to} of ${totalRecords} entries`;

            // Render pagination
            renderPagination(totalPages, page, query, columnIndex);

            // RECREATE FILTER ROW AFTER DATA LOAD (Critical!)
            createFilterRow();

        } catch (error) {
            console.error('Fetch error:', error);
            tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-red-600 py-8">Error loading data</td></tr>`;
        }
    };

    // RENDER PAGINATION
    const renderPagination = (totalPages, currentPage, query = '', columnIndex = null) => {
        paginationContainer.innerHTML = '';

        if (totalPages <= 1) return;

        const maxVisible = 5;
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }

        if (currentPage > 1) {
            paginationContainer.appendChild(createPageButton('Previous', currentPage - 1, query, columnIndex));
        }

        for (let i = startPage; i <= endPage; i++) {
            const btn = createPageButton(i, i, query, columnIndex);
            if (i === currentPage) {
                btn.classList.add('bg-gray-600', 'text-white', 'font-bold');
                btn.disabled = true;
            }
            paginationContainer.appendChild(btn);
        }

        if (currentPage < totalPages) {
            paginationContainer.appendChild(createPageButton('Next', currentPage + 1, query, columnIndex));
        }
    };

    const createPageButton = (label, page, query, columnIndex) => {
        const btn = document.createElement('button');
        btn.textContent = label;
        btn.type = 'button';
        btn.className = 'px-4 py-2 mx-1 text-sm border rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition';
        btn.addEventListener('click', () => fetchRecords(page, query, columnIndex));
        return btn;
    };


</script>



@endsection
