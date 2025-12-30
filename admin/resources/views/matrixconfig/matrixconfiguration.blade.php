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
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Update Matrix</span>
            </div>
        </li>
    </ol>
</div>
<!-- breadcrub navs end-->
<!-- Content area -->

<main class="flex-grow">

    <!--Row-1-->
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-4 gap-5 mb-10">
        <!-- card -->
        <div class="bg-white rounded-lg h-fit shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-900 border">
            <div class="">
                <ul
                    class="flex flex-col space-y-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                    <li>
                        <button onclick="showTab('plan-name','plan-name','plan-scaling')" id="tab-plan-name"
                            class="tab-btn inline-flex items-center bg-gray-900 text-white dark:bg-blue-500 w-full font-medium rounded-lg text-xs px-4 py-2 me-2">
                            <div id="circle-dashboard"
                                class="w-6 h-6 flex justify-center items-center rounded-full font-bold  me-2 bg-gray-300 text-gray-900">
                                1
                            </div>
                            General Settings
                        </button>
                    </li>

                    <li>
                        <button onclick="showTab('plan-scaling','plan-name','entry-criteria')" id="tab-plan-scaling"
                            class="tab-btn inline-flex items-center w-full bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-medium rounded-lg text-xs px-4 py-2 me-2 mb-2">
                            <div id="circle-dashboard"
                                class="w-6 h-6 flex justify-center items-center rounded-full font-bold bg-gray-300 text-gray-900 me-2">
                                2
                            </div>
                            Plan Scaling
                        </button>
                    </li>

                    <li>
                        <button onclick="showTab('entry-criteria','plan-scaling','commission-setting')"
                            id="tab-entry-criteria"
                            class="tab-btn inline-flex items-center w-full bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-medium rounded-lg text-xs px-4 py-2 me-2 mb-2">
                            <div id="circle-dashboard"
                                class="w-6 h-6 flex justify-center items-center rounded-full font-bold bg-gray-300 text-gray-900 me-2">
                                3
                            </div>
                            Entry Criteria
                        </button>
                    </li>

                    <li>
                        <button onclick="showTab('commission-setting','entry-criteria','commission-setting')"
                            id="tab-commission-setting"
                            class="tab-btn inline-flex items-center w-full bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-medium rounded-lg text-xs px-4 py-2 me-2 mb-2">
                            <div id="circle-dashboard"
                                class="w-6 h-6 flex justify-center items-center rounded-full font-bold bg-gray-300 text-gray-900 me-2">
                                4
                            </div>
                            Commission Settings
                        </button>
                    </li>
                </ul>
            </div>
            <!--Tabs-->
        </div>

        <!-- card -->
        <div class="col-span-3 bg-white rounded-lg border dark:bg-gray-900 dark:border-gray-700">

            <form class="mx-auto validated-form" id="planForm" method="POST" novalidate
                action="{{ route('matrix.validatesetconfig', ['matrix_id' => $matrix_id]) }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="default_sponsor" id="default_members_id"
                    value="{{$errval['default_sponsor']?? ''}}">
                <input type="hidden" id="entryid" name="entryid" value="">
                <input type="hidden" name="matrix_id" id="matrix_id" value="{{ $matrix_id }}">
                <!-- Tab Content -->
                <div class="p-6 bg-white text-medium dark:bg-gray-900 rounded-lg w-full">
                    <div class="">
                        @include('matrixconfig.components.generalsettings')
                        @include('matrixconfig.components.planscaling')
                        @include('matrixconfig.components.entrycriteria')
                        @include('matrixconfig.components.commissionsettings')
                    </div>
                </div>
        </div>
        </form>
    </div>

    @include('matrixconfig.components.onetimelevelcommissions')
    @include('matrixconfig.components.addpackage')
    @include('matrixconfig.components.editpackage')
    @include('matrixconfig.components.packagelevelcommissions')

    <!-- Main modal -->
    @include('matrixconfig.components.updatesubscription')



    <!--chat-drawer:starts-->

   <script>
       const matrixTypeID={{$matrix_details['matrix_type_id']}}
    </script>
    @include('matrixconfig.components.matrixconfiguration_script')

    @endsection
