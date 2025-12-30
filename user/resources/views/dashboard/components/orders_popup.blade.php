
<!-- Main modal -->
<div id="ordersModal" tabindex="-1" aria-hidden="true"
  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-5xl max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow-sm dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
      <!-- Modal header -->
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-neutral-200">
        <h3 class="text-xl font-semibold text-black dark:text-white"> {{ __('Personal Orders') }}  </h3>
        <button type="button" onclick="closeModal('ordersModal')"
          class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
         >
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
      </div>
      <!-- Modal body -->
      <div class="p-4 md:p-5 space-y-4">
        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
          <div class="datatable-container">

            <div class="items-per-page-container">
                <label for="items-per-page">{{ __('Items per page:') }}</label>
               <select id="ordersModal-per-page" 
        onchange="updatePerPage('ordersTable', this.value, 'getordersdetails')"
        class="border rounded px-3 py-1 text-sm">
    <option value="10">10</option>
    <option value="25">25</option>
    <option value="50">50</option>
    <option value="100">100</option>
</select>
            
            </div>

            <div class="overflow-x-auto w-full">
              <table id="ordersTable" data-table-id="table1" class="w-full min-w-[600px]">
              <thead>
                <tr>
                  <th>
                    <span class="flex items-center">
                      OrderID
                      <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                      </svg>
                    </span>
                  </th>
                  
                  <th>
                    <span class="flex items-center">
                      Purchased
                      <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                      </svg>
                    </span>
                  </th>
                  <th>
                    <span class="flex items-center">
                      {{ __('Status') }}
                      <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                      </svg>
                    </span>
                  </th>
                  <th>
                    <span class="flex items-center">
                      Total
                      <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                      </svg>
                    </span>
                  </th>
                  <th>
                    <span class="flex items-center">
                      Payment Method
                      <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                      </svg>
                    </span>
                  </th>
                 
                  <th>
                    <span class="flex items-center">
                      {{ __('Date') }}
                      <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                      </svg>
                    </span>
                  </th>

                </tr>
              </thead>
              <tbody class="bg-white dark:bg-neutral-900">
                          
              </tbody>
            </table>
            </div>
                <div id="ordersTablePagination"></div>  <!-- ✅ This will be selected -->
          </div>
        </div>

      </div>
      <!-- Modal footer -->
      <div class="flex items-center justify-end p-4 md:p-5 border-neutral-200 rounded-b ">

      <a href="/user/shoporder">
          <button type="button"
          class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('view more') }}</button>
        </a>

      </div>
    </div>
  </div>
</div>
