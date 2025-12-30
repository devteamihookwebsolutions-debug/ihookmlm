    <!-- Joining Commission Form Fields (toggle switch) -->
    <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                    {{ __('Joining Commission') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="joining_commission_status" name="joining_commission_status" value="1"
                                    class="sr-only peer" onchange="toggleJoinCommissions()" @if (($errval['joining_commission_status'] ?? '') == '1') checked @endif>
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
        <div id="join_on_fields" class="mt-5 {{ ($errval['joining_commission_status'] ?? '') == '1' ? '' : 'hidden' }}">
            <div class="flex flex-col space-y-4">
                <!-- Input Fields Row -->
                <div id="joincommission" class="flex flex-wrap items-center justify-center gap-4">
                    <!-- Commission Input -->
                    <div class="flex-1">
                        <label for="lastname"
                            class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission') }}</label>
                        <input type="number" id="joining_commission" name="joining_commission" aria-describedby="helper-text-explanation"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="" required="" aria-describedby="joiningcommission-error" value="{{ $errval['joining_commission'] ?? '' }}">
                            <p id="joiningcommission-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                                        {{ __('Please enter a valid commission') }}</p>
                    </div>

                    <!-- Commission Type Toggle -->
                    <div class="flex items-center p-2.5 pt-9">
                        <!-- Left label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Flat') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="joining_commission_type" name="joining_commission_type" value="1"
                                class="sr-only peer"  @if (($errval['joining_commission_type'] ?? '') == '1') checked @endif>
                            <div
                                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('%') }}</span>
                    </div>

                    <!-- Wallet Selection -->
                    <div class="flex-1">
                        <label for="wallet"
                                                                class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Wallet Type') }}
                        </label>
                        <select id="join_commission_wallet_type" name="join_commission_wallet_type"
                                                                class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                             required="" aria-describedby="joincommissionwallettype-error">
                            <option value="">{{ __('Select') }}</option>
                           <option value="1" @if (($errval['join_commission_wallet_type'] ?? '') == '1') selected="selected" @endif>{{ __('C-Wallet') }}</option>
                            <option value="2" @if (($errval['join_commission_wallet_type'] ?? '') == '2') selected="selected" @endif>{{ __('E-Wallet') }}</option>

                        </select>
                        <p id="joincommissionwallettype-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid wallet type') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
