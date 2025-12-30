@extends('admin::components.common.main')
@section('content')
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
                      class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Compansation</a>
                  </div>
                </li>
                <li aria-current="page">
                  <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                      height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                    </svg>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Plans</span>
                  </div>
                </li>
              </ol>
            </div>
                @include('components.common.info_message')

         <main class="flex-grow">
              <div
                class="flex items-start p-4 mb-4 text-xs text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-900 dark:text-blue-400 dark:border-blue-800"
                role="alert">

                <svg class="flex-shrink-0 inline w-3 h-3 me-3 mt-1" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">info</span>
                <div class="">
                  <div class="font-medium mb-3">Instructions for add the package</div>
                  <ul class="gap-3 flex flex-col">
                    <li>1 : Select the set configuration link from the list</li>
                    <li>2 : Go to the entry criteria and select the membership type </li>
                    <li>3 : Change one time Registration into subscription and add package </li>
                    <li>4 :
                      If you set chargebee as a payment gateway then first set payment settings details and then add
                      plan configuration
                    </li>

                  </ul>
                </div>
              </div>

              <!-- content -->
              <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                <div class="mb-4 flex justify-end" bis_skin_checked="1">
                 <a href="{{ route('matrix.create') }}">
                      <button type="button"
                      class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-xs px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600">Add</button></a>
                    </a>
                </div>
                <!-- card -->

                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-5">

                  <!-- card -->
                  <div>
                    <div
                      class="p-2 bg-white text-xs text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full border dark:border-gray-700">
                      <table id="default-table">
                        <thead>
                           <tr>
                                        <th class="px-4 py-3 border">{{ __('Plan Name') }}</th>
                                        <th class="px-4 py-3 border">{{ __('Type') }}</th>
                                        <th class="px-4 py-3 border">{{ __('Status') }}</th>
                                        <th class="px-4 py-3 border">{{ __('Action') }}</th>
                                    </tr>
                        </thead>

                           <tbody>
                                    @if ($matrices && $matrices->isNotEmpty())
                                        @foreach ($matrices as $matrix)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-2">{{ $matrix->matrix_name }}</td>
                                                <td class="px-4 py-2">{{ $matrix->matrixType->matrix_type_name ?? 'N/A' }}</td>
                                                <td class="px-4 py-2">
                                                    <span class="px-2 py-1 text-xs font-medium {{ $matrix->matrix_status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded">
                                                        {{ $matrix->matrix_status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <div class="flex items-center gap-4">
                                                        <a href="{{ route('matrix.showconfig', ['matrix_id' => $matrix->matrix_id]) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center">
                                                            <svg class="w-5 h-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                            </svg>

                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-gray-500">{{ __('No plans available') }}</td>
                                        </tr>
                                    @endif
                                </tbody>

                      </table>
                    </div>
                  </div>
                  <div class="flex flex-col p-10">
                    <!--image-space-->
                  <img src="/assets/img/plans/plan.png" alt="add-customer" class="w-full sticky top-0 overflow-hidden">
                    <!--image-space-->
                  </div>

             @if ($matrices && $matrices->hasPages())
                    <div class="mt-4">
                        {{ $matrices->links() }}
                    </div>
                @endif
                </div>
              </div>
            </main>
<script>
    if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#default-table", {
            searchable: false,
            perPageSelect: false,
            paging: false
        });
    }
</script>
@endsection
