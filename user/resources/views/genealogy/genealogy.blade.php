@extends('user::components.common.main')

@section('title', 'Binary Genealogy Tree')

@section('content')
<link href="{{$_ENV['UI_ASSET_URL']}}/assets/custom/css/primitives.latest.css?3600" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{$_ENV['UI_ASSET_URL']}}/public/assets/css/classical_genealogy.css">

        <div class="flex mb-4" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="user-d-board.html"
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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">My-Teams</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">My
                                            Organization</span>
                                    </div>
                                </li>
                            </ol>
                        </div>

<main class="flex-grow">
    <div class="container mx-auto px-4 sm:px-6 lg:px-0 space-y-5">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-800 border">
            <div class="flex items-center justify-between space-x-4">
                <div class="relative flex items-center w-full max-w-md">
                    <div id="search-combobox" class="relative" data-hs-combo-box="">
                        <div class="relative w-80">
                            <input type="text" name="searchbox" id="searchbox"
                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                placeholder="Search..." onkeyup="filterSuggestions(this.value)" />
                        </div>
                        <div id="suggestion-box" class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-md overflow-y-auto hidden" style="max-height: 200px;"></div>
                    </div>
                </div>

                <input type="hidden" name="members_id" id="members_id" value="{{ $members_id }}">

                <div>
                    <a id="fullscreen" href="javascript:void(0)" title="{{ __('Full screen') }}">
                        <button type="button" onclick="applyTemplate()" class="px-3 py-3">
                            <svg class="w-6 h-6 text-black dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H4m0 0v4m0-4 5 5m7-5h4m0 0v4m0-4-5 5M8 20H4m0 0v-4m0 4 5-5m7 5h4m0 0v-4m0 4-5-5"/>
                            </svg>
                        </button>
                    </a>
                </div>
            </div>

            <div style="position: relative; height: 100vh; width: 100%;">
                <div id="contentpanel" class="mt-5">
                    <div id="westpanel" class="hidden p-4 border border-neutral-400 text-sm text-black overflow-scroll"></div>
                    <div id="centerpanel" class="overflow-hidden p-0 m-0 border-0"></div>
                    <div id="southpanel"></div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('user::genealogy.components.genealogy_script')

@endsection
