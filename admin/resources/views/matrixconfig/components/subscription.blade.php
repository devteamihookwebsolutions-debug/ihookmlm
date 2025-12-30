<div id="show_subscription" class="mt-5 {{ ($errval['members_account_type'] ?? null) == '2' && ($errval['members_paid_account_type'] ?? null) == '1'  ? '' : 'hidden'
}}">
    <!-- Registration Fee Form Fields (toggle switch) -->
    <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                        {{ __('Registration Fee') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('No') }}</span>

                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <!-- Hidden field to always send value (0 or 1) -->
                                <input type="hidden" name="register_fee_status" value="0">

                                <!-- Checkbox - only sends 1 when checked -->
                                <input type="checkbox" id="register_fee_status" name="register_fee_status" value="1"
                                    class="sr-only peer" onchange="toggleSubRegistration()"
                                    {{ ($errval['register_fee_status'] ?? 0) == 1 ? 'checked' : '' }}>

                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Yes') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>


        <!-- Subscription Form Fields -->
        <div id="sub_register_fee_on_fields"
            class="mt-5 {{ ($errval['register_fee_status'] ?? null) == '1' ? '' : 'hidden' }}">
            <div class="mb-5">
                <label for="registration_price" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                    {{ __('Registration Price') }}</label>
                <input type="text" id="registration_price" name="registration_price"
                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                    placeholder="" required="" aria-describedby="registrationprice-error"
                    value="{{$errval['registration_price'] ?? ''}}">
                <p id="registrationprice-error"
                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid commission') }}</p>
            </div>
            <div class="mb-5">
                <label for="on_field" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                    {{ __('Taxcode') }}</label>
                <input type="text" id="registration_taxcode" name="registration_taxcode"
                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                    placeholder="" required="" aria-describedby="registrationtaxcode-error"
                    value="{{$errval['registration_taxcode'] ?? ''}}">
                <p id="registrationtaxcode-error"
                    class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid tax code') }}</p>
            </div>
        </div>
        <div class="flex justify-end pt-4 pb-6">
            <!-- Modal toggle -->
            <button onclick="showModal('addpackage-modal')"
                class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
                {{ __('Add') }}
            </button>
        </div>

        <!-- Main modal -->

        <div class="mb-5">
            <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">

                <div class="datatable-container">
                    <table id="search-table" class="datatable-table">
                        <thead>
                            <tr>
                                <th style="width: 10%;">
                                    <span class="flex items-center">
                                        {{ __('Name') }}

                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="flex items-center">
                                        {{ __('Payment Method') }}

                                    </span>
                                </th>
                                <th style="width: 20%;">
                                    <span class="flex items-center">
                                        {{ __('Amount') }}

                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="flex items-center">
                                        {{ __('Duration') }}

                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="flex items-center">
                                        {{ __('Direct Commission') }}

                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="flex items-center">
                                        {{ __('Method') }}

                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="flex items-center">
                                        {{ __('PV') }}

                                    </span>
                                </th>
                                <th style="width: 20%;">
                                    <span class="flex items-center">
                                        {{ __('Action') }}

                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="showallpackage">
                            {!!$package!!}
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>
