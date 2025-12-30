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
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Matching Bonus</span>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Edit Matching Bonus</span>
            </div>
        </li>
    </ol>
</div>


<main class="flex-grow">

    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
        <div
            class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200">
            <div>
                <div class="p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                        <form action="{{ route('matchbonus.update', $sub1->matchbonus_id) }}" method="POST"
                            id="edit_matching_bonus" enctype="multipart/form-data" novalidate="novalidate"
                            class="col-span-1 md:col-span-1 lg:col-span-2 mb-5 validated-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="matchbonusid" value="{{ $matchbonus_id }}">
                            <input type="hidden" name="levelcount" id="levelcount" value="{{ count($match_details) }}">
                            <input type="hidden" id="commission_type" value="{{ $commission }}">

                            <!-- Plan Selection -->
                            <div class="mb-5 lg:w-1/2">
                                <label
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Select Plan') }}</label>
                                <select id="matrix_id_display"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    disabled>
                                    @foreach ($matrices as $id => $name)
                                    <option value="{{ $id }}" {{ $id == $matrix_id ? 'selected' : '' }}>{{ $name }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="matrix_id" value="{{ $matrix_id }}">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Plan cannot be changed after creation.') }}
                                </p>
                                <p id="matrixid-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please select a plan.') }}</p>
                            </div>

                            <!-- Matching Bonus Name -->
                            <div class="mb-5 lg:w-1/2">
                                <label
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Matching Bonus Name') }}</label>
                                <input type="text" id="matchingbonus_name" name="matchingbonus_name"
                                    value="{{ $matchbonus_name }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    aria-describedby="bonusname-error">
                                <p id="bonusname-error"
                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                    {{ __('Please enter a valid Bonus name.') }}</p>
                            </div>

                            <!-- Commission Sent Type -->
                            <div class="mb-5 lg:w-1/2">
                                <label
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission Sent Type') }}</label>
                                <select name="commissionsent_type" id="commissionsent_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                    <option value="1" {{ $commission_sent_type == 1 ? 'selected' : '' }}>
                                        {{ __('Daily') }}</option>
                                    <option value="2" {{ $commission_sent_type == 2 ? 'selected' : '' }}>
                                        {{ __('Weekly') }}</option>
                                    <option value="3" {{ $commission_sent_type == 3 ? 'selected' : '' }}>
                                        {{ __('Monthly') }}</option>
                                </select>
                            </div>

                            <!-- Status Toggle -->
                            <div class="mb-5 lg:w-1/2">
                                <table class="min-w-2xl">
                                    <tbody>
                                        <tr>
                                            <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                {{ __('Status') }}</td>
                                            <td class="px-6 text-right">
                                                <div class="flex items-center p-2.5">
                                                    <span
                                                        class="text-gray-600 dark:text-gray-300 text-xs">{{ __('OFF') }}</span>
                                                    <input type="hidden" name="matchbonus_status" value="0">
                                                    <label class="inline-flex items-center cursor-pointer mx-3">
                                                        <input type="checkbox" value="1" id="matchbonus_status"
                                                            name="matchbonus_status" class="sr-only peer"
                                                            {{ $status == '1' ? 'checked' : '' }}>
                                                        <div
                                                            class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-blue-600">
                                                        </div>
                                                    </label>
                                                    <span
                                                        class="text-gray-600 dark:text-gray-300 text-xs">{{ __('ON') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Level vs Rank Toggle -->
                            <div class="mb-5 lg:w-1/2">
                                <table class="min-w-2xl">
                                    <tbody>
                                        <tr>
                                            <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                                                {{ __('Level Commission For') }}</td>
                                            <td class="px-6 text-right">
                                                <div class="flex items-center p-2.5">
                                                    <span
                                                        class="text-gray-600 dark:text-gray-300 text-xs">{{ __('Level') }}</span>
                                                    <input type="hidden" name="levelcommissiontype" value="0">
                                                    <label class="inline-flex items-center cursor-pointer mx-3">
                                                        <input type="checkbox" value="1" id="chkPassport"
                                                            name="levelcommissiontype" class="sr-only peer"
                                                            {{ $commission == 2 ? 'checked' : '' }}>
                                                        <div
                                                            class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-600  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-blue-600">
                                                        </div>
                                                    </label>
                                                    <span
                                                        class="text-gray-600 dark:text-gray-300 text-xs">{{ __('Rank') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Add Level Button -->
                            <div class="mb-5 {{ $commission == 2 ? 'hidden' : '' }}" id="dvPassport">
                                <div class="flex justify-end items-center" id="addbox">
                                    <ul class="flex space-x-2">
                                        <li>
                                            <button type="button" id="btn2"
                                                class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">{{ __('Add') }}</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Add Rank Button -->
                            <div class="mb-5 {{ $commission == 2 ? '' : 'hidden' }}" id="dvPassport1">
                                <div class="flex justify-end items-center" id="addboxes">
                                    <ul class="flex space-x-2">
                                        <li>
                                            <button type="button" id="btn3"
                                                class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">{{ __('Add') }}</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Level Table -->
                            <div class="col-span-2 relative overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow p-2 {{ $commission == 2 ? 'hidden' : '' }}"
                                id="addlevelrank">
                                <table id="addmathingbonus"
                                    class="w-full text-sm text-left rtl:text-right text-black dark:text-white my-6">
                                    <thead
                                        class="text-xs text-black uppercase bg-gray-50 dark:bg-gray-800 dark:text-white border border-gray-200 dark:border-gray-800">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">{{ __('Levels') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Commission') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Commission Percentage') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Method') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Wallet') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($match_details as $index => $detail)
                                        @if ($commission == 1)
                                        <tr id="level_r{{ $index + 1 }}">
                                            <td class="p-3">
                                                <input type="number" name="l_levels[]" value="{{ $detail->levels }}"
                                                    readonly required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                            </td>
                                            <td  class="p-3">
                                                <input type="number" min="0" step="0.01" name="l_commission[]"
                                                    id="l{{ $index + 1 }}_commission"
                                                    value="{{ $detail->commission_amount }}" required
                                                    aria-describedby="l{{ $index + 1 }}_commission-error"
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                <p id="l{{ $index + 1 }}_commission-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                    Please enter a valid commission.</p>
                                            </td>
                                            <td  class="p-3">
                                                <select name="l_commissionpercentage[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="1"
                                                        {{ $detail->commission_percentage_from == 1 ? 'selected' : '' }}>
                                                        {{ __('Paring Bonus') }}</option>
                                                    <option value="2"
                                                        {{ $detail->commission_percentage_from == 2 ? 'selected' : '' }}>
                                                        {{ __('Total Sales') }} ({{ __('MLM') }})</option>
                                                </select>
                                            </td>
                                            <td  class="p-3">
                                                <select name="l_method[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="1"
                                                        {{ $detail->commission_type == 1 ? 'selected' : '' }}>%</option>
                                                </select>
                                            </td>
                                            <td class="p-3">
                                                <select name="l_wallet[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="2" {{ $detail->wallet_type == 2 ? 'selected' : '' }}>
                                                        {{ __('E-wallet') }}</option>
                                                    <option value="1" {{ $detail->wallet_type == 1 ? 'selected' : '' }}>
                                                        {{ __('C-wallet') }}</option>
                                                </select>
                                            </td>
                                            <td class="delete-cell p-3">
                                                <a href="#" onclick="confirmDelete1({{ $index + 1 }})"
                                                    class="text-gray-500 hover:text-gray-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Rank Table -->
                            <div class="col-span-2 relative overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow p-2 {{ $commission == 2 ? '' : 'hidden' }}"
                                id="addrankmatch">
                                <table id="addlevelmatchbonus"
                                    class="w-full text-sm text-left rtl:text-right text-black dark:text-white my-6">
                                    <thead
                                        class="text-xs text-black uppercase bg-gray-50 dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">{{ __('Levels') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Commission') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Commission Percentage') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Method') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Wallet') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Rank') }}</th>
                                            <th scope="col" class="px-6 py-3">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($match_details as $index => $detail)
                                        @if ($commission == 2)
                                        <tr id="rank_r{{ $index + 1 }}">
                                            <td class="p-3">
                                                <input type="number" name="r_levels[]" value="{{ $detail->levels }}"
                                                    readonly required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                            </td>
                                            <td class="p-3">
                                                <input type="number" min="0" step="0.01" name="r_commission[]"
                                                    id="r{{ $index + 1 }}_commission"
                                                    value="{{ $detail->commission_amount }}" required
                                                    aria-describedby="r{{ $index + 1 }}_commission-error"
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                <p id="r{{ $index + 1 }}_commission-error"
                                                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                                    Please enter a valid commission.</p>
                                            </td>
                                            <td class="p-3">
                                                <select name="r_commissionpercentage[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="1"
                                                        {{ $detail->commission_percentage_from == 1 ? 'selected' : '' }}>
                                                        {{ __('Paring Bonus') }}</option>
                                                    <option value="2"
                                                        {{ $detail->commission_percentage_from == 2 ? 'selected' : '' }}>
                                                        {{ __('Total Sales') }} ({{ __('MLM') }})</option>
                                                </select>
                                            </td>
                                            <td class="p-3">
                                                <select name="r_method[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="1"
                                                        {{ $detail->commission_type == 1 ? 'selected' : '' }}>%</option>
                                                </select>
                                            </td>
                                            <td class="p-3">
                                                <select name="r_wallet[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="2" {{ $detail->wallet_type == 2 ? 'selected' : '' }}>
                                                        {{ __('E-wallet') }}</option>
                                                    <option value="1" {{ $detail->wallet_type == 1 ? 'selected' : '' }}>
                                                        {{ __('C-wallet') }}</option>
                                                </select>
                                            </td>
                                            <td class="p-3">
                                                <select name="r_rank[]" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                                    <option value="">{{ __('Select Rank') }}</option>
                                                    @foreach ($ranks as $rank_id => $rank_name)
                                                    <option value="{{ $rank_id }}"
                                                        {{ $detail->rank_id == $rank_id ? 'selected' : '' }}>
                                                        {{ $rank_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="delete-cell p-3">
                                                <a href="#" onclick="confirmDelete2({{ $index + 1 }})"
                                                    class="text-gray-500 hover:text-gray-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Form Buttons -->
                            <div class="flex justify-center mt-10 space-x-3">
                                <a href="javascript:void(0);" onclick="window.history.back();"
                                    class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">{{ __('Cancel') }}</a>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">{{ __('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const FORM_CONFIG = {
        REQUIRED_PATTERNS: {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^\d{10}$/,
            matchingbonus_name: /.+/,
            matrix_id: /^[0-9]+$/,
            commissionsent_type: /^[1-3]$/,
            matchbonus_status: /^[0-1]$/,
            levelcommissiontype: /^[0-1]$/,
            'l_levels[]': /^[0-9]+$/,
            'l_commission[]': /^[0-9]+(\.[0-9]{1,2})?$/,
            'l_commissionpercentage[]': /^[1-2]$/,
            'l_method[]': /^[1]$/,
            'l_wallet[]': /^[1-2]$/,
            'r_levels[]': /^[0-9]+$/,
            'r_commission[]': /^[0-9]+(\.[0-9]{1,2})?$/,
            'r_commissionpercentage[]': /^[1-2]$/,
            'r_method[]': /^[1]$/,
            'r_wallet[]': /^[1-2]$/,
            'r_rank[]': /^[0-9]+$/
        },
    };

    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
        '{{ csrf_token() }}';

    class FormHandler {
        constructor() {
            this.initializeElements();
            this.attachEventListeners();
            this.updateDeleteIcons(this.elements.levelTable);
            this.updateDeleteIcons(this.elements.rankTable);
        }

        initializeElements() {
            this.elements = {
                form: document.getElementById('edit_matching_bonus'),
                matrixIdSelect: document.getElementById('matrix_id_display'),
                btnAddLevel: document.getElementById('btn2'),
                btnAddRank: document.getElementById('btn3'),
                chkPassport: document.getElementById('chkPassport'),
                levelTable: document.querySelector('#addmathingbonus tbody'),
                rankTable: document.querySelector('#addlevelmatchbonus tbody'),
                dvPassport: document.getElementById('dvPassport'),
                dvPassport1: document.getElementById('dvPassport1'),
                addlevelrank: document.getElementById('addlevelrank'),
                addrankmatch: document.getElementById('addrankmatch'),
                levelcount: document.getElementById('levelcount')
            };
        }

        attachEventListeners() {
            this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));

            document.querySelectorAll('input[required], select[required]').forEach((input) => {
                input.addEventListener('input', () => this.validateInput(input));
            });

            this.elements.btnAddLevel?.addEventListener('click', () => this.addLevelRow());
            this.elements.btnAddRank?.addEventListener('click', () => this.addRankRow());
            this.elements.chkPassport?.addEventListener('change', (e) => this.toggleRankMode(e.target
                .checked));
            this.elements.addlevelrank?.addEventListener('click', (e) => this.handleLevelDelete(e));
            this.elements.addrankmatch?.addEventListener('click', (e) => this.handleRankDelete(e));
        }

        validateInput(input) {
            const value = input.value.trim();
            const pattern = FORM_CONFIG.REQUIRED_PATTERNS[input.name];
            const errorElement = document.getElementById(input.getAttribute('aria-describedby'));

            let isValid = true;

            if (!value && input.hasAttribute('required')) {
                isValid = false;
                this.showError(input, errorElement, 'This field is required.');
            } else if (pattern && !pattern.test(value)) {
                isValid = false;
                this.showError(input, errorElement,
                `Please enter a valid ${input.name.replace('[]', '')}.`);
            } else {
                this.clearError(input, errorElement);
            }

            return isValid;
        }

        showError(input, errorElement, message) {
            input.classList.add('border-red-500');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }
        }

        clearError(input, errorElement) {
            input.classList.remove('border-red-500');
            if (errorElement) errorElement.classList.add('hidden');
        }

        handleSubmit(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form.querySelectorAll(
                'input[required], select[required]'));
            const allValid = inputs.every(input => this.validateInput(input));

            if (allValid) {
                this.elements.form.submit();
            } else {
                console.error('Form validation failed.');
            }
        }

        // Add Level Row (for Level-based bonus)
        addLevelRow() {
            const counter = parseInt(this.elements.levelcount.value) + 1;
            const newRow = this.elements.levelTable.insertRow();
            newRow.id = `level_r${counter}`;

            newRow.innerHTML = `
                    <td class="p-3">
                        <input type="number" name="l_levels[]" value="${counter}" readonly required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                    </td>
                    <td class="p-3">
                        <input type="number" min="0" step="0.01" name="l_commission[]" id="l${counter}_commission" required aria-describedby="l${counter}_commission-error" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        <p id="l${counter}_commission-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid commission.</p>
                    </td>
                    <td class="p-3">
                        <select name="l_commissionpercentage[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            <option value="1">{{ __('Paring Bonus') }}</option>
                            <option value="2">{{ __('Total Sales') }} ({{ __('MLM') }})</option>
                        </select>
                    </td>
                    <td class="p-3">
                        <select name="l_method[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            <option value="1">%</option>
                        </select>
                    </td>
                    <td class="p-3">
                        <select name="l_wallet[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            <option value="2">{{ __('E-wallet') }}</option>
                            <option value="1">{{ __('C-wallet') }}</option>
                        </select>
                    </td>
                    <td class="delete-cell p-3">
                        <a href="#" onclick="confirmDelete1(${counter})" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>
                        </a>
                    </td>
                `;

            this.updateDeleteIcons(this.elements.levelTable);
            this.elements.levelcount.value = counter;
        }

        // Add Rank Row (AJAX + Rank Dropdown)
        addRankRow() {
            const counter = parseInt(this.elements.levelcount.value) + 1;
            const matrixId = '{{ $matrix_id }}';

            if (!matrixId) {
                Swal.fire('Error', 'Matrix ID is missing.', 'error');
                return;
            }

            fetch("/admin/matchbonus/getrankgen", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: new URLSearchParams({
                        selectedValue: matrixId,
                        count: counter
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const ranks = data.ranks || [];
                    let rankOptions = '<option value="">{{ __("Select Rank") }}</option>';
                    ranks.forEach(rank => {
                        rankOptions += `<option value="${rank.id}">${rank.name}</option>`;
                    });

                    const newRow = this.elements.rankTable.insertRow();
                    newRow.id = `rank_r${counter}`;

                    newRow.innerHTML = `
                        <td class="p-3">
                            <input type="number" name="r_levels[]" value="${counter}" readonly required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" name="r_commission[]" id="r${counter}_commission" required aria-describedby="r${counter}_commission-error" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                            <p id="r${counter}_commission-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">Please enter a valid commission.</p>
                        </td>
                        <td>
                            <select name="r_commissionpercentage[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                <option value="1">{{ __('Paring Bonus') }}</option>
                                <option value="2">{{ __('Total Sales') }} ({{ __('MLM') }})</option>
                            </select>
                        </td>
                        <td>
                            <select name="r_method[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                <option value="1">%</option>
                            </select>
                        </td>
                        <td>
                            <select name="r_wallet[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                <option value="2">{{ __('E-wallet') }}</option>
                                <option value="1">{{ __('C-wallet') }}</option>
                            </select>
                        </td>
                        <td>
                            <select name="r_rank[]" required class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                                ${rankOptions}
                            </select>
                        </td>
                        <td class="delete-cell">
                            <a href="#" onclick="confirmDelete2(${counter})" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </a>
                        </td>
                    `;

                    this.updateDeleteIcons(this.elements.rankTable);
                    this.elements.levelcount.value = counter;
                })
                .catch(err => {
                    console.error('Error fetching ranks:', err);
                    Swal.fire('Error', 'Failed to load ranks.', 'error');
                });
        }

        toggleRankMode(isRank) {
            if (isRank) {
                this.elements.dvPassport1.classList.remove('hidden');
                this.elements.addrankmatch.classList.remove('hidden');
                this.elements.dvPassport.classList.add('hidden');
                this.elements.addlevelrank.classList.add('hidden');
                this.elements.levelTable.innerHTML = '';
            } else {
                this.elements.dvPassport.classList.remove('hidden');
                this.elements.addlevelrank.classList.remove('hidden');
                this.elements.dvPassport1.classList.add('hidden');
                this.elements.addrankmatch.classList.add('hidden');
                this.elements.rankTable.innerHTML = '';
            }
        }

        handleLevelDelete(e) {
            if (e.target.closest(".delete-cell a")) {
                e.preventDefault();
                const row = e.target.closest("tr");
                const id = row.id.replace('level_r', '');
                confirmDelete1(id);
            }
        }

        handleRankDelete(e) {
            if (e.target.closest(".delete-cell a")) {
                e.preventDefault();
                const row = e.target.closest("tr");
                const id = row.id.replace('rank_r', '');
                confirmDelete2(id);
            }
        }

        updateDeleteIcons(table) {
            const rows = table.querySelectorAll('tr');
            rows.forEach((row, i) => {
                const deleteCell = row.querySelector('td.delete-cell');
                if (deleteCell) {
                    deleteCell.classList.toggle('hidden', i !== rows.length - 1);
                }
            });
        }
    }

    new FormHandler();

    // Global Delete Confirmations
    window.confirmDelete1 = function(id) {
        const rowSelector = `#level_r${id}`;
        Swal.fire({
            title: '{{ __("Do you want to delete ?") }}',
            text: "{{ __('Matching Bonus Level') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("Yes, delete it!") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            customClass: {
                confirmButton: 'bg-red-600 text-white hover:bg-red-700',
                cancelButton: 'bg-gray-300 text-black hover:bg-gray-400'
            }
        }).then(result => {
            if (result.isConfirmed) {
                const row = document.querySelector(rowSelector);
                if (row) {
                    row.remove();
                    const table = document.querySelector('#addmathingbonus tbody');
                    const handler = new FormHandler();
                    handler.updateDeleteIcons(table);
                    Swal.fire('Deleted!', 'Level has been removed.', 'success');
                }
            }
        });
    };

    window.confirmDelete2 = function(id) {
        const rowSelector = `#rank_r${id}`;
        Swal.fire({
            title: '{{ __("Do you want to delete ?") }}',
            text: "{{ __('Matching Bonus Rank') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("Yes, delete it!") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            customClass: {
                confirmButton: 'bg-red-600 text-white hover:bg-red-700',
                cancelButton: 'bg-gray-300 text-black hover:bg-gray-400'
            }
        }).then(result => {
            if (result.isConfirmed) {
                const row = document.querySelector(rowSelector);
                if (row) {
                    row.remove();
                    const table = document.querySelector('#addlevelmatchbonus tbody');
                    const handler = new FormHandler();
                    handler.updateDeleteIcons(table);
                    Swal.fire('Deleted!', 'Rank has been removed.', 'success');
                }
            }
        });
    };
});
</script>
