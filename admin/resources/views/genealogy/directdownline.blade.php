@extends('admin::components.common.main')
@section('content')
<link href="{{$_ENV['UI_ASSET_URL']}}/assets/vendors/jstree/dist/themes/default/style.css" rel="stylesheet" type="text/css" />
<!-- custom styles end-->

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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Networks</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> Unilevel Genealogy</span>
                                    </div>
                                </li>
                            </ol>
                        </div>
<!-- breadcrub navs end-->
<!-- Content area -->
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!-- card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

            <div class="flex items-center justify-between space-x-4" bis_skin_checked="1">
                <!-- First Dropdown -->
                <div class="w-full max-w-xs" bis_skin_checked="1">
                    <select id="default_matrix" name="default_matrix"
                        class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($defaultmatrix as $record)
                            <option value="{{ $record['matrix_id'] }}" {{ $record['matrix_id'] == $selectedMatrixId ? 'selected' : '' }}>
                                {{ $record['matrix_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Second Dropdown -->
                <div class="w-full max-w-xs" bis_skin_checked="1">
                    <select id="selectTemplate" name="selectTemplate"
                        class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="luba" {{ $genealogyTemplate == 'luba' ? 'selected' : '' }}>luba</option>
                        <option value="olivia" {{ $genealogyTemplate == 'olivia' ? 'selected' : '' }}>olivia</option>
                        <option value="derek" {{ $genealogyTemplate == 'derek' ? 'selected' : '' }}>derek</option>
                        <option value="diva" {{ $genealogyTemplate == 'diva' ? 'selected' : '' }}>diva</option>
                        <option value="mila" {{ $genealogyTemplate == 'mila' ? 'selected' : '' }}>mila</option>
                        <option value="polina" {{ $genealogyTemplate == 'polina' ? 'selected' : '' }}>polina</option>
                        <option value="mery" {{ $genealogyTemplate == 'mery' ? 'selected' : '' }}>mery</option>
                        <option value="rony" {{ $genealogyTemplate == 'rony' ? 'selected' : '' }}>rony</option>
                        <option value="belinda" {{ $genealogyTemplate == 'belinda' ? 'selected' : '' }}>belinda</option>
                        <option value="ula" {{ $genealogyTemplate == 'ula' ? 'selected' : '' }}>ula</option>
                        <option {{ $genealogyTemplate == 'ana' ? 'selected' : '' }} value="ana">ana</option>


                    </select>
                </div>

                        <button type="button" onclick="applyTemplate()"
                            class=" bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm px-3 py-3 text-center">
                            <svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"></path>
                            </svg>
                        </button>
            </div>

            <div class="overflow-y-auto">
                <div id="grptree"></div>
            </div>

        </div>
    </div>
</main>
@include('genealogy.components.directdownline_script')
@endsection
