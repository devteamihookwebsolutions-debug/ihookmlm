<div class="bg-white w-full mx-auto p-6  text-black dark:bg-neutral-900 dark:text-white rounded-lg shadow-sm my-6 border border-neutral-200 dark:border-neutral-800" id="invoice">
  <!-- Header -->
  <div class="grid grid-cols-2 items-center mb-8">
      <div>
          <img src="{{$base64_site_logo}}" alt="Company Logo" class="h-16 w-16">
          <p class="mt-2 text-gray-800 dark:text-gray-200 font-bold">{{$_SESSION['site_settings']['company_name']}}</p>
          <p class="text-gray-500 dark:text-gray-400 text-sm">{{$_SESSION['site_settings']['company_address']}}</p>
          <p class="text-gray-500 dark:text-gray-400 text-sm">{{$_SESSION['site_settings']['site_notify_email']}}</p>
      </div>
      <div class="text-right">
          <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Invoice</h1>
          <p class="text-gray-500 dark:text-gray-400 text-sm">Invoice #: INV-{{ $invoicedetails['paymentData']['transaction_id'] }}</p>
          <p class="text-gray-500 dark:text-gray-400 text-sm">Invoice Date: {{$invoicedetails['paymentData']['date']}}</p>
          <p class="text-gray-500 dark:text-gray-400 text-sm">Order Date: {{$invoicedetails['paymentData']['date']}}</p>
      </div>
  </div>

  <!-- Client Info -->
  <div class="grid grid-cols-2 items-center mb-8">
      <div>
          <p class="font-bold text-gray-800 dark:text-white">Bill to:</p>
          <p class="text-gray-500 dark:text-gray-400">{{ $_SESSION['default']['customer_name'] }}</p>
          <p class="text-gray-500 dark:text-gray-400">{{ $_SESSION['default']['customer_email'] }}</p>
      </div>
      <div class="text-right">
          <p class="text-gray-500 dark:text-gray-400">User ID: {{ $_SESSION['default']['customer_name'] }}</p>
      </div>
  </div>

  <!-- Items Table -->
  <div class="flow-root">
      <table class="min-w-full border text-black dark:bg-neutral-900 dark:text-white rounded-lg shadow-sm my-6  border-neutral-200 dark:border-neutral-800">
          <thead class="bg-neutral-100 text-black dark:bg-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-900">
              <tr>
                  <th class="py-3 px-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Description</th>
                  <th class="py-3 px-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                  <th class="py-3 px-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Total</th>
              </tr>
          </thead>
          <tbody>
              <tr class="border-b border-neutral-200 dark:border-neutral-700">
                  <td class="py-4 px-4 text-sm text-gray-900 dark:text-gray-200">
                      <div class="font-medium">{{$invoicedetails['commissionData']['history_description']}} </div>
                      <div class="text-gray-500 dark:text-gray-400"></div>
                  </td>
                  <td class="py-4 px-4 text-right text-sm text-gray-500 dark:text-gray-400">{{$invoicedetails['commissionData']['history_datetime']}}</td>
                  <td class="py-4 px-4 text-right text-sm text-gray-500 dark:text-gray-400">{{$_SESSION['site_settings']['site_currency']}}{{$invoicedetails['commissionData']['history_amount']}}</td>
              </tr>
          </tbody>
          <tfoot>
              <tr>
                  <td colspan="2" class="py-4 px-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Subtotal</td>
                  <td class="py-4 px-4 text-right text-sm font-semibold text-gray-900 dark:text-white"> {{$_SESSION['site_settings']['site_currency']}}{{$invoicedetails['commissionData']['history_amount']}}</td>
              </tr>
              <tr>
                  <td colspan="2" class="py-4 px-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Grand Total (Incl.Tax)</td>
                  <td class="py-4 px-4 text-right text-sm font-semibold text-gray-900 dark:text-white">{{$_SESSION['site_settings']['site_currency']}}{{$invoicedetails['commissionData']['history_amount']}}</td>
              </tr>
          </tfoot>
      </table>