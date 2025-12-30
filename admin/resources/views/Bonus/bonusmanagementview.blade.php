@extends('admin::components.common.main')
@section( 'content')

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
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Bonus</span>
                  </div>
                </li>
              </ol>
            </div>

    <main class="flex-grow">
        <div class="">
            @include('components.common.info_message')

            <!-- Info Alert -->
            <div class="flex p-4 mb-6 text-xs text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-300" role="alert">
                <svg class="flex-shrink-0 inline w-3 h-3 me-3 mt-[2px]" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 336 1 1v4h1a1 1 0 0 1 0 2Z"></path>
                </svg>
                <div>{{ __('This tool will guide You to configure Custom Bonus Settings...') }}</div>
            </div>

            <!-- Card with Table -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 border dark:border-gray-800">
                <div class="flex justify-end mb-4">
                    <a href="/admin/addbonus" class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
                        {{ __('Add') }}
                    </a>
                </div>

                <!-- Data Table -->
                <div class="overflow-x-auto">
                    <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                        <thead>
                            <tr>
                                <th>{{ __('SNo') }}</th>
                                <th>{{ __('Bonus Name') }}</th>
                                <th>{{ __('Matrix') }}</th>
                                <th>{{ __('Works On') }}</th>
                                <th>{{ __('Bonus To') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created On') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody >
                            @forelse($bonuses as $bonus)
                            <tr class="text-xs">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bonus->bonus_name }}</td>
                                <td>{{ $bonus->matrix?->matrix_name ?? '—' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $bonus->workson)) }}</td>
                                <td>{{ $bonus->bonus_to ? 'User' : 'Admin' }}</td>
                              <td>
                                @if($bonus->bonus_status)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        Active
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                                <td>{{ $bonus->createdon }}</td>
                                 <td>
                                    <a href="{{ route('bonus.show', $bonus->bonusid) }}" class=""><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                            </svg></a>
                                 </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-gray-500 py-4">No bonuses available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

  @include('components.common.datatable_script')
@endsection
