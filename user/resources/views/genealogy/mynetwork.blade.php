@extends('user::components.common.main')
@section('content')

   <!-- Breadcrumb -->
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

        @include('components.common.info_message')

        {{-- ==== SINGLE CARD ==== --}}
        <div class="bg-white rounded-lg shadow-sm p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="general_url w-full md:w-auto">
                    <label class="block text-sm font-medium text-black dark:text-white mb-2">{{ __('Referral Link') }}:</label>
                  <div class="relative max-w-sm">
                        <input id="referral-url-input"
                            type="text"
                            class="w-full bg-neutral-700 text-neutral-300 border border-neutral-600 rounded-lg pl-4 pr-12 py-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 cursor-text select-all"
                            value="{{ $referralurl ?? '#' }}"
                            readonly>

                        <!-- Copy Button - Perfectly Centered -->
                        <button type="button"
                                data-copy-target="#referral-url-input"
                                data-tooltip-target="tooltip-copy-referral"
                                class="copy-btn absolute inset-y-0 right-0 flex items-center pr-3 hover:bg-neutral-600 rounded-r-lg transition">

                            <!-- Default Copy Icon -->
                            <span class="default-icon">
                                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                                </svg>
                            </span>

                            <!-- Success Check Icon -->
                            <span class="success-icon hidden">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </button>

                        <!-- Tooltip -->
                        <div id="tooltip-copy-referral" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip bottom-full left-1/2 -translate-x-1/2 mb-2">
                            <span class="default-text">Copy to clipboard</span>
                            <span class="success-text hidden">Copied!</span>
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                </div>

                <div class="genel">
                    {!! $allgenealogy !!}
                </div>
            </div>

           <div class="flex justify-between items-center mt-6">
                <button type="button"
                        class="px-5 py-2.5 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black
                            transition-all duration-300 shadow-md hover:scale-105"
                        onclick="window.history.back();">
                    {{ __('Previous') }}
                </button>

                @php
                    $original_member_id = session('original_network_member_id') ?? auth()->user()->members_id;
                    $original_matrix_id = session('original_network_matrix_id') ??
                        \DB::table(config('ihook.prefix', 'ihook').'_matrix_members_link_table')
                            ->where('members_id', $original_member_id)
                            ->orderBy('link_id')
                            ->value('matrix_id') ?? 1;

                    $top_token = \Admin\App\Models\Middleware\MURLCrypt::encode($original_member_id, $original_matrix_id);
                    $top_url   = url('/user/network/view/' . $top_token . '/' . $original_member_id . '/' . $original_matrix_id);
                 @endphp

                <a href="{{ $top_url }}"
               class="px-5 py-2.5 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black
                            transition-all duration-300 shadow-md hover:scale-105">
                    {{ __('Top') }}
                </a>
            </div><br>

            <section class="bg-gray-800 flex justify-center flex-col py-12 relative rounded-lg overflow-hidden">
                <div class="relative w-full flex items-center justify-center">

                    {{-- ROOT --}}
                    <div class="flex flex-col items-center">
                        <div class="mb-12 relative flex justify-center text-center
                                    before:content-[''] before:absolute before:top-[115%] before:left-1/2 before:-translate-x-1/2
                                    before:w-px before:h-12 before:bg-white/70">
                         {!! $genealogytree !!}
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>


@include('user::genealogy.components.mynetwork_script')
@endsection
