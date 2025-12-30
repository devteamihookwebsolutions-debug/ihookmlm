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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">{{ __('Masters') }}</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Cities View') }}</span>
            </div>
        </li>
    </ol>
</div>
<main class="flex-grow">
    <div class="  ">
        @include('components.common.info_message')

        <div class="bg-white dark:bg-gray-900 border dark:border-gray-800 rounded-lg p-6 min-h-screen overflow-auto">
            <div class="grid grid-cols-2">
                <div class="">
                    <div class="flex items-center mb-6">
                        <a href="{{ route('cities.index') }}" class="flex items-center">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m14 8-4 4 4 4" />
                            </svg>
                        </a>
                        <h1 class="text-sm ml-1 font-semibold text-gray-800 dark:text-gray-200">City Details</h1>
                    </div>
                    <div class="gap-4 mb-6 space-y-2 divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="flex items-center justify-between text-xs py-1">
                            <span class="w-1/4 text-gray-600 dark:text-gray-300">Name:</span>
                            <span class="text-gray-800 font-medium dark:text-gray-200">{{ $city->city_name }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs py-1">
                            <span class="w-1/4 text-gray-600 dark:text-gray-300">Country:</span>
                            <span
                                class="text-gray-800 font-medium dark:text-gray-200">{{ $city->country ? $city->country->country_master_name : 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs py-1">
                            <span class="w-1/4 text-gray-600 dark:text-gray-300">State:</span>
                            <span
                                class="text-gray-800 font-medium dark:text-gray-200">{{ $city->state ? $city->state->state_name : 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('cities.edit', $city) }}"
                            class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                            {{ __('Edit') }}
                        </a>
                        <button type="button"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white text-xs hover:bg-red-700"
                            data-modal-target="delete-modal-{{ $city->city_id }}"
                            data-modal-toggle="delete-modal-{{ $city->city_id }}">

                            {{ __('Delete') }}
                        </button>
                    </div>
                </div>
            </div>


            <!-- Delete Confirmation Modal -->
            <div id="delete-modal-{{ $city->city_id }}" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-neutral-700">
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Confirm Delete</h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="delete-modal-{{ $city->city_id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                Are you sure you want to delete the city "{{ $city->city_name }}"?
                            </p>
                            <div class="flex justify-end space-x-2">
                                <button data-modal-hide="delete-modal-{{ $city->city_id }}" type="button"
                                    class="px-4 py-2 text-xs bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                    Cancel
                                </button>
                                <form action="{{ route('cities.destroy', $city) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-xs bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
