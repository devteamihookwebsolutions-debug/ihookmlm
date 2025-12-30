{{-- resources/views/admin/distributors/distributors.blade.php --}}
@extends('admin::components.common.main')

@section('content')



<!-- Breadcrumb -->
       <!-- Breadcrumb -->
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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Team</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Distributor</span>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <link rel="stylesheet" href="{{ asset('css/material.css') }}" media="print"
    onload="this.onload=null;this.removeAttribute('media');">
<script src="{{ asset('js/ej2.min.js') }}"></script>
<style type="text/css">
    /* Your full dark mode + watermark hide CSS here (same as before) */
    div:has(> a[href*="syncfusion.com"]) { display: none !important; }
    .e-grid .e-leftfreeze.e-freezeleftborder { border-right: none; }
    .e-grid .e-content { transform: translateZ(0); }
    /* ... rest of your dark CSS ... */
    .dark .e-grid .e-gridheader,
    .dark .e-grid .e-headercell { color: #a3a3a3; }
    .dark .e-grid .e-rowcell { color: #e5e5e5; }
    /* ... etc ... */
    #Gridstring_excelDlg_dialog-content
    {
          display:none;
    }
</style>
<main class="flex-grow">
    <div>
        @include('components.common.info_message')

        <div class="bg-white dark:bg-gray-900 dark:border-gray-700 border border-gray-200 rounded-lg shadow-sm p-6 mb-10">
            <div id="Grid"></div>
        </div>

<!-- Toggle Column Drawer Button -->
<div class="fixed bottom-5 right-5 z-50">
    <button id="toggleColumnBtn"
        class="bg-gray-800 hover:bg-gray-900 text-white rotate-90 fixed right-[-58px] top-[400px] rounded-lg px-5 py-3 shadow-2xl flex items-center gap-2">
        Toggle Columns
    </button>
</div>

<!-- Drawer - Hidden by default -->
<div id="drawer-right-example"
     class="fixed top-[314px] right-10 z-40 h-screen w-80 bg-white dark:bg-gray-900 shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-5">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-semibold">Toggle Columns</h5>
            <button id="closeDrawerBtn" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
        </div>
        <div id="columnToggleList" class="space-y-3"></div>
    </div>
</div>
    </div>
</main>
<!--data loaded-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const STORAGE_KEY = 'distributors_grid_columns_v1';

    const columns = [
        {
            field: 'members_id',
            headerText: 'ID',
            width: 90,
            textAlign: 'Center',
            template: (row) => `<a href="/admin/distributors/${row.members_id}" target="_blank" class="text-indigo-600 hover:underline font-medium">${row.members_id}</a>`
        },
        { field: 'members_username', headerText: 'Username', width: 150 },
        { field: 'directid_username', headerText: 'Sponsor', width: 150 },
        { field: 'members_email', headerText: 'Email', width: 220 },
        { field: 'members_firstname', headerText: 'First Name', width: 130 },
        { field: 'members_lastname', headerText: 'Last Name', width: 130 },
        { field: 'members_address', headerText: 'Address', width: 250 },
        { field: 'state_name', headerText: 'State', width: 130, allowSorting: false },
        { field: 'country_name', headerText: 'Country', width: 130, allowSorting: false },


        // 1. ACCOUNT STATUS - NEW COLUMN
        {
            field: 'account_status',
            headerText: 'Account Status',
            width: 140,
            textAlign: 'Center',
            template: (row) => {
                let status = row.account_status || '-';
                let colorClass = 'bg-gray-100 text-gray-800';
                if (status === 'Active') colorClass = 'bg-green-100 text-green-800';
                if (status === 'Inactive') colorClass = 'bg-red-100 text-red-800';
                if (status === 'Pending') colorClass = 'bg-yellow-100 text-yellow-800';

                return `<span class=" ">${status}</span>`;
            }
        },

{
    field: 'members_status_text',
    headerText: 'Status',
    width: 110,
    textAlign: 'Center',
    template: (row) => {

        let badge = 'bg-amber-100 text-amber-800'; // Pending

        if (row.members_status_text === 'Active') {
            badge = 'bg-green-100 text-emerald-800';
        }

        return `<span class="px-3 py-1.5 text-xs font-semibold ${badge}">
            ${row.members_status_text}
        </span>`;
    }
},



        {
            headerText: 'Auto Login',
            width: 130,
            textAlign: 'Center',
             template: (row) => `<a href="/admin/distributors/${row.members_id}" target="_blank" class="text-indigo-600 hover:underline font-medium">   <svg class="w-6 h-6 text-gray-800 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"></path>
                </svg></a>`
        }

    ];

    // Load saved column visibility
    let savedVisibility = {};
    try {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) savedVisibility = JSON.parse(saved);
    } catch(e) {}

    columns.forEach(col => {
        if (col.field && savedVisibility[col.field] !== undefined) {
            col.visible = savedVisibility[col.field];
        }
        // Auto Login column doesn't have field, so handle separately
        if (!col.field && savedVisibility['autologin'] !== undefined) {
            col.visible = savedVisibility['autologin'];
        }
    });


    // SYNCFUSION GRID USING SERVER-SIDE DataManager
    const grid = new ej.grids.Grid({
      dataSource: new ej.data.DataManager({
    url: "/admin/userManager/fetch",
    adaptor: new ej.data.UrlAdaptor(),
    headers: [
        { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
    ],
    crossDomain: false,

}),
        columns: columns,
        allowPaging: true,
        pageSettings: {
            pageSize: 10,
            pageSizes: [10, 20, 50, 100]
        },
        allowSorting: true,
        allowFiltering: true,
        filterSettings: { type: "Excel" },
        allowResizing: true,
        allowReordering: true,
        toolbar: ['Search'],
        height: "650px",
        width: "100%",
        frozenColumns: 2,

        created: function () {
            const list = document.getElementById('columnToggleList');
            list.innerHTML = '';

            this.columns.forEach((col, i) => {
                const fieldKey = col.field || 'autologin';
                const headerName = col.headerText;
                const isVisible = col.visible !== false;
                const isChecked = savedVisibility[fieldKey] !== undefined ? savedVisibility[fieldKey] : isVisible;

                const div = document.createElement('div');
                div.innerHTML = `
                    <label class="flex items-center space-x-3 cursor-pointer select-none">
                        <input type="checkbox" ${isChecked ? 'checked' : ''}
                               data-field="${fieldKey}" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm">${headerName}</span>
                    </label>
                `;
                list.appendChild(div);
            });

            list.addEventListener('change', (e) => {
                if (e.target.type === 'checkbox') {
                    const field = e.target.dataset.field;
                    const checked = e.target.checked;

                    if (field === 'autologin') {
                        const idx = this.columns.findIndex(c => c.headerText === 'Auto Login');
                        if (idx !== -1) this.columns[idx].visible = checked;
                    } else {
                        const idx = this.columns.findIndex(c => c.field === field);
                        if (idx !== -1) this.columns[idx].visible = checked;
                    }

                    this.refreshColumns();
                    savedVisibility[field] = checked;
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(savedVisibility));
                }
            });
        },

        columnVisibilityChanged: function(args) {
            if (args.column) {
                const key = args.column.field || 'autologin';
                savedVisibility[key] = args.visible;
                localStorage.setItem(STORAGE_KEY, JSON.stringify(savedVisibility));

                const cb = document.querySelector(`#columnToggleList input[data-field="${key}"]`);
                if (cb) cb.checked = args.visible;
            }
        }
    });

    grid.appendTo('#Grid');
});

// Auto-login function
function autoLogin(userId) {
    if (confirm('Are you sure you want to login as this distributor?')) {
        window.open(`/admin/auto-login/${userId}`, '_blank');
    }
}
</script>
<script>
// Clean & simple drawer control - no external lib needed
document.getElementById('toggleColumnBtn').addEventListener('click', function () {
    const drawer = document.getElementById('drawer-right-example');
    drawer.classList.toggle('translate-x-full');
});

document.getElementById('closeDrawerBtn').addEventListener('click', function () {
    document.getElementById('drawer-right-example').classList.add('translate-x-full');
});

// Optional: Close when clicking outside
document.getElementById('drawer-right-example').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.add('translate-x-full');
    }
});
</script>


@endsection
