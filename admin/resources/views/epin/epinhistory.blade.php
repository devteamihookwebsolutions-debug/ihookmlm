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
                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                </div>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">E-Pin</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">E-pin Histroy</span>
            </div>
        </li>

    </ol>
</div>
<!-- breadcrub navs end-->
<!-- Content area -->

<main class="flex-grow">
    <div class="">
        @include('components.common.info_message')

        <div class="bg-white text-black rounded dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5 p-6">

                <div id="table-container">
                <table id="filter-table">
                    <thead>
                        <tr class="border border-gray-300 md:border-none block md:table-row">
                            <th> <span class="flex items-center">{{ __('Members Username') }}
                                <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                            <th> <span class="flex items-center">{{ __('Code') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th><span class="flex items-center">{{ __('Amount') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th><span class="flex items-center">{{ __('Type') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th><span class="flex items-center">{{ __('Date') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th><span class="flex items-center">{{ __('Status') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th><span class="flex items-center">{{ __('Used Date') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th><span class="flex items-center">{{ __('Used By') }}
                                <svg class="w-4 h-4 ms-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg>
                            </span>
                        </th>
                        </tr>
                    </thead>
                    <tbody id="data-body" class="block md:table-row-group">
                        <!-- Data will be inserted dynamically -->
                    </tbody>
                </table>
                </div>

                <div id="pagination" class="datatable-bottom"></div>


            </div>

        </div>
        <!-- card -->
    </div>

</main>
<script>
    const getepinDataUrl = "{{ route('epinhistorydata') }}";
</script>
<!--chat-drawer:starts-->
<script>
let dataTable; // Declare dataTable globally
let currentPage = 1; // Current page being fetched
let isLoading = false; // Prevent multiple simultaneous requests
let recordsPerPage = 10; // Number of records per page
let totalRecords = 0; // Total number of records
let hasMoreData = true; // Flag to check if more data is available
const tableContainer = document.getElementById("table-container");
const tableBody = document.querySelector("#filter-table tbody");
const paginationContainer = document.getElementById("pagination");


document.addEventListener('DOMContentLoaded', () => {
    // Ensure the elements exist before adding event listeners
    if (tableContainer && paginationContainer) {
        // Fetch initial records
        fetchRecords();

        // Listen for changes in records per page
        const itemsPerPageSelect = document.getElementById('items-per-page');
        if (itemsPerPageSelect) {
            itemsPerPageSelect.addEventListener('change', function() {
                recordsPerPage = this.value;
                currentPage = 1; // Reset to the first page when items per page changes
                fetchRecords(); // Fetch updated records
            });
        }
        // Initialize DataTable
        initializeDataTable();
    } else {
        console.error("Required elements are not found in the DOM.");
    }
});

// Function to initialize DataTable (without destroying it repeatedly)
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

        // dataTable.on("datatable.search", () => {
        //     const searchInput = document.querySelector(".datatable-input");
        //     const searchQuery = searchInput ? searchInput.value.toLowerCase().trim() : ""; // Safely get the search value
        //     console.log("Search query changed:", searchQuery);

        //     if (searchQuery === "") {
        //         // Handle empty search input
        //         console.log("Search input is empty. Showing all rows and pagination.");
        //         showAllRows(); // Custom function to display all rows
        //         paginationContainer.style.display = "block"; // Show pagination
        //     } else {
        //         // Handle non-empty search input
        //         console.log(`Filtering rows with query: ${searchQuery}`);
        //         filterRows(searchQuery);
        //     }
        // });
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

// Function to show all rows in the table
const showAllRows = () => {
    const rows = tableBody.querySelectorAll("tr"); // Get all rows of the table
    rows.forEach(row => {
        row.style.display = ""; // Reset the display property to show all rows
    });

    // Optional: If you need to reset any "No records found" message
    const noRecordsMessage = document.getElementById("no-records-message");
    if (noRecordsMessage) {
        noRecordsMessage.remove();
    }
    paginationContainer.style.display = 'block';
    return; // Exit the function early
};

// Function to filter rows based on search query
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

const fetchRecords = async () => {
    const response = await fetch(`${getepinDataUrl}?page=${currentPage}&perPage=${recordsPerPage}`);
    const data = await response.json();

    // Fill table
    const tableBody = document.querySelector('#filter-table tbody');
    tableBody.innerHTML = '';
    data.records.forEach(record => {
        tableBody.innerHTML += `
            <tr class="text-xs">
                <td>${record.membername}</td>
                <td>${record.epin_code}</td>
                <td>${record.epin_amount}</td>
                <td>${record.package_name}</td>
                <td>${record.formatdate}</td>
                <td>${record.status}</td>
                <td>${record.useddate || "N/A"}</td>
                <td>${record.epin_user_id}</td>
            </tr>
        `;
    });

    // Render pagination
    renderPagination(currentPage, data.total_records, recordsPerPage);
};

// Render pagination buttons
const renderPagination = (currentPage, totalRecords, recordsPerPage) => {
    const totalPages = Math.ceil(totalRecords / recordsPerPage);
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = ''; // Clear previous buttons

    if (totalPages <= 1) return; // No pagination if only 1 page

    // Previous button
    const prevBtn = document.createElement('button');
    prevBtn.classList.add("pagination-button","px-4", "py-2", "mx-1", "border", "rounded", "text-gray-600", "border-gray-200", "dark:text-gray-300", "dark:border-gray-800", "text-xs", "hover:bg-gray-200","dark:hover:bg-gray-800");
    prevBtn.textContent = 'Previous';
    prevBtn.disabled = currentPage === 1;
    prevBtn.onclick = () => fetchPage(currentPage - 1);
    paginationContainer.appendChild(prevBtn);

    // Page number buttons
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.classList.add("pagination-button","px-4", "py-2", "mx-1", "border", "rounded", "text-gray-600", "border-gray-200", "dark:text-gray-300", "dark:border-gray-800", "text-xs", "hover:bg-gray-200","dark:hover:bg-gray-800");
        pageBtn.textContent = i;
        pageBtn.disabled = i === currentPage;
        if (i === currentPage) pageBtn.classList.add('active');
        pageBtn.onclick = () => fetchPage(i);
        paginationContainer.appendChild(pageBtn);
    }

    // Next button
    const nextBtn = document.createElement('button');
    nextBtn.classList.add("pagination-button","px-4", "py-2", "mx-1", "border", "rounded", "text-gray-600", "border-gray-200", "dark:text-gray-300", "dark:border-gray-800", "text-xs", "hover:bg-gray-200","dark:hover:bg-gray-800");
    nextBtn.textContent = 'Next';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => fetchPage(currentPage + 1);
    paginationContainer.appendChild(nextBtn);
};

// Change page
const changePage = (page) => {
 const totalPages = Math.ceil(data.total_records / recordsPerPage);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    fetchRecords();
};
const fetchPage = (pageNumber) => {
    currentPage = pageNumber;
    fetchRecords(); // Fetch records for the selected page
};

// Items per page dropdown
document.getElementById("items-per-page")?.addEventListener("change", function () {
    recordsPerPage = parseInt(this.value) || 10;
    currentPage = 1;
    fetchRecords();
});

// Initial fetch
fetchRecords();
</script>

@endsection
