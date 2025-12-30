    <!--Instant Binary Commission Form Fields (toggle switch) -->
    <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                    {{ __('Instant / Pairing Binary') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="instantbinary_commission_status" name="instantbinary_commission_status" value="1"
                                    class="sr-only peer" onchange="toggleInstantBinaryCommissions()" @if (($errval['instantbinary_commission_status'] ?? '') == '1') checked @endif>
                                <div
                                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('ON') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Joining Commission on Form Fields -->
        <div id="instantbinary_on_fields" class="mt-5 {{ ($errval['instantbinary_commission_status'] ?? '') == '1' ? '' : 'hidden' }}">
            <div class="flex flex-col space-y-4">
                <!-- Input Fields Row -->
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <!-- Commission Input -->

                    <div class="flex-1">
                        <label for="wallet"
                 class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Sales Volume') }}

                        </label>
                        <select id="instantbinary_sales_volume" name="instantbinary_sales_volume"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            required="" aria-describedby="instantbinarysalesvolume-error">
                            <option value="">{{ __('Select') }}</option>
          <option value="1" {{ (($errval['instantbinary_sales_volume'] ?? '') == '1') ? 'selected' : '' }}>{{ __('1:1') }}</option>
<option value="2" {{ (($errval['instantbinary_sales_volume'] ?? '') == '2') ? 'selected' : '' }}>{{ __('1:3 or 2:3') }}</option>

                        </select>
                        <p id="instantbinarysalesvolume-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid sales volume') }}</p>
                    </div>


                    <div class="flex-1">
                        <label for="instantbinary_commission"
                             class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission') }}</label>
                        <input type="number" id="instantbinary_commission" name="instantbinary_commission" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="instantbinarycommission-error" value="{{ $errval['instantbinary_commission'] ?? '' }}">
                            <p id="instantbinarycommission-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid commission') }}</p>
                    </div>

                    <!-- Commission Type Toggle -->
                    <div class="flex items-center p-2.5 pt-9">
                        <!-- Left label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Flat') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="instantbinary_commission_type" name="instantbinary_commission_type" value="1"
                                class="sr-only peer"  @if (($errval['instantbinary_commission_type'] ?? '') == '1') checked @endif>
                            <div
                                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('%') }}</span>
                    </div>

                    <!-- Wallet Selection -->
                    <div class="flex-1">
                        <label for="wallet"  class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Wallet Type') }}
                        </label>
                        <select id="instantbinary_commission_wallet_type" name="instantbinary_commission_wallet_type"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                             required="" aria-describedby="instantbinarywallettype-error">
                            <option value="">{{ __('Select') }}</option>
                            <option value="1" @if (($errval['instantbinary_commission_wallet_type'] ?? '') == '1') selected="selected" @endif>{{ __('C-Wallet') }}</option>
                            <option value="2" @if (($errval['instantbinary_commission_wallet_type'] ?? '') == '2') selected="selected" @endif>{{ __('E-Wallet') }}</option>

                        </select>
                        <p id="instantbinarywallettype-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid wallet type') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- Daily Binary Commission Form Fields (toggle switch) -->
    <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                     <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                    {{ __('Daily Binary') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span
                            class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="dailybinary_commission_status" name="dailybinary_commission_status" value="1"
                                    class="sr-only peer" onchange="toggleDailyBinaryCommissions()"@if (($errval['dailybinary_commission_status'] ?? '') == '1') checked @endif>
                                <div
                                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span
                            class="text-xs text-gray-500 dark:text-gray-400">{{ __('ON') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Joining Commission on Form Fields -->
        <div id="dailybinary_on_fields" class="mt-5 {{ ($errval['dailybinary_commission_status'] ?? '') == '1' ? '' : 'hidden' }}">
            <div class="flex flex-col space-y-4">
                <!-- Input Fields Row -->
                <div class="flex flex-wrap items-center justify-center gap-4">


                    <div class="flex-1">
                        <label for="wallet"
                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Sales Volume') }}
                        </label>
                        <select id="dailybinary_sales_volume" name="dailybinary_sales_volume"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                             required="" aria-describedby="dailybinarysalesvolume-error">
                            <option value="">{{ __('Select') }}</option>
                            <option value="1" @if (($errval['dailybinary_sales_volume'] ?? '') == '1') selected="selected" @endif>{{ __('1:1') }}</option>
                            <option value="2" @if (($errval['dailybinary_sales_volume'] ?? '') == '2') selected="selected" @endif>{{ __('1:3 or 2:3') }}</option>
                        </select>
                        <p id="dailybinarysalesvolume-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid sales volume') }}</p>
                    </div>

                    <!-- Commission Input -->
                    <div class="flex-1">
                        <label for="dailybinary_commission"
                           class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission') }}</label>
                        <input type="number" id="dailybinary_commission" name="dailybinary_commission" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="dailybinarycommission-error" value="{{ $errval['dailybinary_commission'] ?? '' }}">
                            <p id="dailybinarycommission-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid commission') }}</p>
                    </div>

                    <!-- Commission Type Toggle -->
                    <div class="flex items-center p-2.5 pt-9">
                        <!-- Left label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Flat') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="dailybinary_commission_type" name="dailybinary_commission_type" value="1"
                                class="sr-only peer"  @if (($errval['dailybinary_commission_type'] ?? '') == '1') checked @endif>
                            <div
                                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span
                       class="text-xs text-gray-500 dark:text-gray-400">{{ __('%') }}</span>
                    </div>

                    <!-- Wallet Selection -->
                    <div class="flex-1">
                        <label for="wallet"
                                                                                       class="block mb-3 text-xs text-gray-600 dark:text-gray-300">

                            {{ __('Wallet Type') }}
                        </label>
                        <select id="dailybinary_commission_wallet_type" name="dailybinary_commission_wallet_type"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                             required="" aria-describedby="dailybinarywallettype-error">
                            <option value="">{{ __('Select') }}</option>
                            <option value="1" @if (($errval['dailybinary_commission_wallet_type'] ?? '') == '1') selected="selected" @endif>{{ __('C-Wallet') }}</option>
                            <option value="2" @if (($errval['dailybinary_commission_wallet_type'] ?? '') == '2') selected="selected" @endif>{{ __('E-Wallet') }}</option>

                        </select>
                        <p id="dailybinarywallettype-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid wallet type') }}</p>
                    </div>

                    <div class="flex-1">
                        <label for="dailybinary_commission_capping"
                             class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Capping') }}</label>
                        <input type="number" id="dailybinary_commission_capping" name="dailybinary_commission_capping" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="dailybinarycapping-error" value="{{ $errval['dailybinary_commission_capping'] ?? '' }}">
                            <p id="dailybinarycapping-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid capping') }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>


     <!-- Weekly Binary Commission Form Fields (toggle switch) -->
     <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                     <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                    {{ __('Daily Binary') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span   class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="weeklybinary_commission_status" name="weeklybinary_commission_status" value="1"
                                    class="sr-only peer" onchange="toggleWeeklyBinaryCommissions()" @if (($errval['weeklybinary_commission_status'] ?? '') == '1') checked @endif>
                                <div
                                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span  class="text-xs text-gray-500 dark:text-gray-400">{{ __('ON') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Joining Commission on Form Fields -->
        <div id="weeklybinary_on_fields" class="mt-5 {{ ($errval['weeklybinary_commission_status'] ?? '') == '1' ? '' : 'hidden' }}">
            <div class="flex flex-col space-y-4">
                <!-- Input Fields Row -->
                <div class="flex flex-wrap items-center justify-center gap-4">


                    <div class="flex-1">
                        <label for="wallet"
                         class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Sales Volume') }}
                        </label>
                        <select id="weeklybinary_sales_volume" name="weeklybinary_sales_volume"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            required="" aria-describedby="weeklybinarysalesvolume-error">
                            <option value="">{{ __('Select') }}</option>
<option value="1" @if (($errval['weeklybinary_sales_volume'] ?? '') == '1') selected="selected" @endif>{{ __('1:1') }}</option>
<option value="2" @if (($errval['weeklybinary_sales_volume'] ?? '') == '2') selected="selected" @endif>{{ __('1:3 or 2:3') }}</option>

                        </select>
                        <p id="weeklybinarysalesvolume-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid sales volume') }}</p>
                    </div>

                    <!-- Commission Input -->
                    <div class="flex-1">
                        <label for="weeklybinary_commission"
                            class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission') }}</label>
                        <input type="number" id="weeklybinary_commission" name="weeklybinary_commission" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="weeklybinarycommission-error" value="{{ $errval['weeklybinary_commission'] ?? '' }}">
                            <p id="weeklybinarycommission-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid commission') }}</p>
                    </div>

                    <!-- Commission Type Toggle -->
                    <div class="flex items-center p-2.5 pt-9">
                        <!-- Left label -->
                        <span
                       class="text-xs text-gray-500 dark:text-gray-400">{{ __('Flat') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="dailybinary_commission_type" name="dailybinary_commission_type" value="1"
                                class="sr-only peer"  @if (($errval['dailybinary_commission_type'] ?? '') == '1') checked @endif>
                            <div
                                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('%') }}</span>
                    </div>

                    <!-- Wallet Selection -->
                    <div class="flex-1">
                        <label for="wallet"
                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Wallet Type') }}
                        </label>
                        <select id="weeklybinary_commission_wallet_type" name="weeklybinary_commission_wallet_type"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            required="" aria-describedby="weeklybinarywallettype-error">
                            <option value="">{{ __('Select') }}</option>
                         <option value="1" @if (($errval['weeklybinary_commission_wallet_type'] ?? '') == '1') selected="selected" @endif>{{ __('C-Wallet') }}</option>
                    <option value="2" @if (($errval['weeklybinary_commission_wallet_type'] ?? '') == '2') selected="selected" @endif>{{ __('E-Wallet') }}</option>

                        </select>
                        <p id="weeklybinarywallettype-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid wallet type') }}</p>
                    </div>

                    <div class="flex-1">
                        <label for="weeklybinary_commission_capping"
                           class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Capping') }}</label>
                        <input type="number" id="weeklybinary_commission_capping" name="weeklybinary_commission_capping" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="weeklybinarycapping-error" value="{{ $errval['weeklybinary_commission_capping'] ?? '' }}">
                            <p id="weeklybinarycapping-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid capping') }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>


       <!-- Monthly Binary Commission Form Fields (toggle switch) -->
       <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                    {{ __('Monthly Binary') }}

                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="monthlybinary_commission_status" name="monthlybinary_commission_status" value="1"
                                    class="sr-only peer" onchange="toggleMonthlyBinaryCommissions()" @if (($errval['monthlybinary_commission_status'] ?? '') == '1') checked @endif>
                                <div
                                                                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span  class="text-xs text-gray-500 dark:text-gray-400">{{ __('ON') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Joining Commission on Form Fields -->
        <div id="monthlybinary_on_fields" class="mt-5 {{ ($errval['monthlybinary_commission_status'] ?? '') == '1' ? '' : 'hidden' }}">
            <div class="flex flex-col space-y-4">
                <!-- Input Fields Row -->
                <div class="flex flex-wrap items-center justify-center gap-4">


                    <div class="flex-1">
                        <label for="wallet"  class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Sales Volume') }}

                        </label>
                        <select id="monthlybinary_sales_volume" name="monthlybinary_sales_volume"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                             required="" aria-describedby="weeklybinarysalesvolume-error">
                            <option value="">{{ __('Select') }}</option>
                            <option value="1" @if (($errval['monthlybinary_sales_volume'] ?? '') == '1') selected="selected" @endif>{{ __('1:1') }}</option>
                          <option value="2" @if (($errval['monthlybinary_sales_volume'] ?? '') == '2') selected="selected" @endif>{{ __('1:3 or 2:3') }}</option>

                        </select>
                        <p id="monthlybinarysalesvolume-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid sales volume') }}</p>
                    </div>

                    <!-- Commission Input -->
                    <div class="flex-1">
                        <label for="monthlybinary_commission"
                            class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission') }}</label>
                        <input type="number" id="monthlybinary_commission" name="monthlybinary_commission" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="monthlybinarycommission-error" value="{{ $errval['monthlybinary_commission'] ?? '' }}">
                            <p id="monthlybinarycommission-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid commission') }}</p>
                    </div>

                    <!-- Commission Type Toggle -->
                    <div class="flex items-center p-2.5 pt-9">
                        <!-- Left label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Flat') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="monthlybinary_commission_type" name="monthlybinary_commission_type" value="1"
                                class="sr-only peer"  @if (($errval['monthlybinary_commission_type'] ?? '') == '1') checked @endif>
                            <div
                                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('%') }}</span>
                    </div>

                    <!-- Wallet Selection -->
                    <div class="flex-1">
                        <label for="wallet"
                          class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Wallet Type') }}

                        </label>
                        <select id="monthlybinary_commission_wallet_type" name="monthlybinary_commission_wallet_type"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                             required="" aria-describedby="weeklybinarywallettype-error">
                            <option value="">{{ __('Select') }}</option>
                            <option value="1" @if (($errval['monthlybinary_commission_wallet_type'] ?? '') == '1') selected="selected" @endif>{{ __('C-Wallet') }}</option>
                            <option value="2" @if (($errval['monthlybinary_commission_wallet_type'] ?? '') == '2') selected="selected" @endif>{{ __('E-Wallet') }}</option>


                        </select>
                        <p id="monthlybinarywallettype-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid wallet type') }}</p>
                    </div>

                    <div class="flex-1">
                        <label for="monthlybinary_commission_capping"
                            class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Capping') }}</label>
                        <input type="number" id="monthlybinary_commission_capping" name="monthlybinary_commission_capping" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="monthlybinarycapping-error" value="{{ $errval['monthlybinary_commission_capping'] ?? '' }}">
                            <p id="monthlybinarycapping-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid capping') }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
