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
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Commissions

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
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">User Commission
                       </span>
                    </div>
                </li>
            </ol>
      </div>


<!-- Content area -->

        <main class="flex-grow">
            <div class="container mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">

                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 p-6">

                        <!-- card -->
                        <div class="w-full mx-auto p-4">
                            <div class="export-buttons flex justify-end">
                                <button id="export-csv"
                                    class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">Export
                                    to CSV</button>
                                <button id="export-pdf"
                                    class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">Export
                                    to PDF</button>
                                <button id="print-table"
                                    class="px-4 py-2 rounded-lg bg-gray-800 ml-3 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">Print</button>
                            </div>

                            <div class="py-6">
                                <div class="items-per-page-container" style="display:none">
                                    <label for="items-per-page">Items per page:</label>
                                    <select id="items-per-page"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div id="table-container" >
                                    <table id="filter-table" class="min-w-full mt-5 divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr
                                                class="block md:table-row dark:border-gray-700 text-gray-500 text-xs uppercase">
                                                <th class="px-4 py-3"><span class="flex items-center">SNo<svg
                                                            class="w-4 h-4 ms-1" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th class="px-4 py-3"><span class="flex items-center">Username<svg
                                                            class="w-4 h-4 ms-1" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                        </svg>
                                                    </span>
                                                </th>
                                                <th class="px-4 py-3"><span class="flex items-center">AMOUNT<svg
                                                            class="w-4 h-4 ms-1" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                                        </svg>
                                                    </span></th>




                                            </tr>
                                        </thead>
                                        <!-- <tbody id="data-body" class="block md:table-row-group">

                                        </tbody> -->
                                        <tbody id="result" class="table-row-group">
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
            <!--Row-1-->



        </main>

<script src="{{asset('js/jspdf.umd.min.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.autotable.min.js')}}"></script>
<script>
    const getUserCommissionDataUrl = "{{ route('admin.getUserCommissionData') }}";
</script>

<script>
    let dataTable;
    let currentPage = 1;
    let recordsPerPage = 10;
    const tableBody = document.querySelector("#filter-table tbody");
    const paginationContainer = document.getElementById('pagination');
    const datatableInfo = document.querySelector('.datatable-info');

    let lastSearchQuery = '';
    let lastColumnIndex = null;
    let debounceTimer;

    document.addEventListener('DOMContentLoaded', () => {
        // Export CSV
        document.getElementById('export-csv').addEventListener('click', function(event) {
            event.preventDefault();
            const rows = document.querySelectorAll('#filter-table tbody tr:not(#no-records-message)');
            let csvContent = 'Sno,Username,Amount,Type,Date\n';

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).map(cell => cell.textContent.trim());
                csvContent += rowData.join(',') + '\n';
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'commissions.csv';
            link.click();
        });

        // Export PDF
        document.getElementById('export-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            if (!jsPDF) {
                alert('jsPDF library not loaded!');
                return;
            }

            const doc = new jsPDF('l', 'mm', 'a4'); // landscape for more columns
            const rows = document.querySelectorAll('#filter-table tbody tr:not(#no-records-message)');
            const tableData = [];

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).map(cell => cell.textContent.trim());
                tableData.push(rowData);
            });

            doc.autoTable({
                head: [['Sno', 'Username', 'Amount', 'Type', 'Date']],
                body: tableData,
                theme: 'striped',
                styles: { fontSize: 10 },
                headStyles: { fillColor: [41, 128, 185] }
            });

            doc.save('commissions.pdf');
        });

        // Print Table
        document.getElementById('print-table').addEventListener('click', function(event) {
            event.preventDefault();
            const printWindow = window.open('', '', 'height=700,width=1000');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Commissions Report</title>
                        <style>
                            table { width: 100%; border-collapse: collapse; font-size: 12px; }
                            th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                            h1 { text-align: center; }
                        </style>
                    </head>
                    <body>
                        <h1>Commissions Report</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>Sno</th><th>Username</th><th>Amount</th><th>Type</th><th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tableBody.innerHTML}
                            </tbody>
                        </table>
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        });

        // Items per page
        document.getElementById('items-per-page')?.addEventListener('change', function() {
            recordsPerPage = parseInt(this.value);
            currentPage = 1;
            fetchRecords();
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

    // Create filter row dynamically
    const createFilterRow = () => {
        const thead = document.querySelector('#filter-table thead');
        if (!thead) return;

        // Remove old filter row
        const oldRow = thead.querySelector('.search-filtering-row');
        if (oldRow) oldRow.remove();

        const filterRow = document.createElement('tr');
        filterRow.className = 'search-filtering-row text-black dark:text-white bg-white dark:bg-neutral-900';

        const headerCells = thead.querySelector('tr').children;

        Array.from(headerCells).forEach((th, index) => {
            const thFilter = document.createElement('th');

            // Skip filter for S.no (index 0)
            if (index === 0) {
                filterRow.appendChild(thFilter);
                return;
            }

            // Optional: Skip Amount (index 2) or Type (index 3) if you don't want text search
            if (index === 2 || index === 3) {
                filterRow.appendChild(thFilter);
                return;
            }

            const input = document.createElement('input');
            input.type = 'search';
            input.className = 'datatable-input w-full px-2 py-1 text-sm border rounded';
            input.placeholder = `Search ${th.textContent.trim()}`;

            input.addEventListener('input', function(e) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentPage = 1;
                    lastSearchQuery = e.target.value.trim();
                    lastColumnIndex = index;
                    fetchRecords();
                }, 500);
            });

            thFilter.appendChild(input);
            filterRow.appendChild(thFilter);
        });

        thead.appendChild(filterRow);

        // Restore previous search value
        if (lastSearchQuery && lastColumnIndex !== null) {
            const inputs = filterRow.querySelectorAll('input');
            if (inputs[lastColumnIndex - 1]) { // -1 because we skipped index 0
                inputs[lastColumnIndex - 1].value = lastSearchQuery;
            }
        }
    };

    // Fetch records from server
    const fetchRecords = async (page = currentPage) => {
        try {
            currentPage = page;

            const queryParams = new URLSearchParams({
                page: currentPage,
                perPage: recordsPerPage
            });

            if (lastSearchQuery) {
                queryParams.append('query', lastSearchQuery);
                if (lastColumnIndex !== null) {
                    queryParams.append('columnIndex', lastColumnIndex);
                }
            }

            const response = await fetch(`${getUserCommissionDataUrl}?${queryParams.toString()}`);
            if (!response.ok) throw new Error('Network error');

            const data = await response.json();
            const records = data.records || [];
            const totalRecords = data.total_records || 0;

            tableBody.innerHTML = '';

            if (records.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-8 text-gray-500">No records found</td></tr>`;
                if (datatableInfo) datatableInfo.textContent = 'Showing 0 to 0 of 0 entries';
                paginationContainer.innerHTML = '';
                return;
            }

            // Render rows with correct S.no
            records.forEach((record, index) => {
                const rowNum = (currentPage - 1) * recordsPerPage + index + 1;
                tableBody.innerHTML += `
                    <tr class="border-b border-neutral-300 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium">${rowNum}</td>
                        <td class="px-4 py-3 text-sm">${record.username || ''}</td>
                        <td class="px-4 py-3 text-sm">${record.amount || ''}</td>
                        <td class="px-4 py-3 text-sm">${record.type || ''}</td>
                        <td class="px-4 py-3 text-sm">${record.date || ''}</td>
                    </tr>
                `;
            });

            // Update info
            if (datatableInfo) {
                const start = (currentPage - 1) * recordsPerPage + 1;
                const end = Math.min(currentPage * recordsPerPage, totalRecords);
                datatableInfo.textContent = `Showing ${start} to ${end} of ${totalRecords} entries`;
            }

            renderPagination(totalRecords);
            createFilterRow(); // Recreate filter row after data load

        } catch (error) {
            console.error('Error:', error);
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-8 text-red-500">Error loading data</td></tr>`;
        }
    };

    // Render pagination
    const renderPagination = (totalRecords) => {
        const totalPages = Math.ceil(totalRecords / recordsPerPage);
        paginationContainer.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous
        if (currentPage > 1) {
            const prev = document.createElement('button');
            prev.textContent = 'Previous';
            prev.className = 'px-4 py-2 mx-1 border rounded hover:bg-gray-100';
            prev.onclick = () => fetchRecords(currentPage - 1);
            paginationContainer.appendChild(prev);
        }

        const maxButtons = 7;
        let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
        let endPage = Math.min(totalPages, startPage + maxButtons - 1);
        if (endPage - startPage + 1 < maxButtons) startPage = Math.max(1, endPage - maxButtons + 1);

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = 'px-4 py-2 mx-1 border rounded hover:bg-gray-100';
            if (i === currentPage) {
                btn.disabled = true;
                btn.classList.add('bg-neutral-600', 'text-white');
            }
            btn.onclick = () => fetchRecords(i);
            paginationContainer.appendChild(btn);
        }

        // Next
        if (currentPage < totalPages) {
            const next = document.createElement('button');
            next.textContent = 'Next';
            next.className = 'px-4 py-2 mx-1 border rounded hover:bg-gray-100';
            next.onclick = () => fetchRecords(currentPage + 1);
            paginationContainer.appendChild(next);
        }
    };
</script>





@endsection

