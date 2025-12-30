<div id="plan-scaling" class="tab-content hidden">
    <h3 class="text-sm font-semibold text-gray-800 mb-10 dark:text-gray-200">
        {{ __('Plan Scaling') }}
    </h3>

    <div class="mb-5">
        <label for="level_width" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
            {{ __('Level Width') }}
        </label>

        @if ($matrix_details['matrix_type_id'] == 1)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_width" name="level_width" readonly value="2">

        @elseif($matrix_details['matrix_type_id'] == 2 || $matrix_details['matrix_type_id'] == 5)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_width" name="level_width" value="{{ $errval['level_width'] ?? '' }}">

        @elseif($matrix_details['matrix_type_id'] == 3)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_width" name="level_width" readonly value="1">

        @elseif($matrix_details['matrix_type_id'] == 4)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_width" name="level_width" value="{{ $errval['level_width'] ?? '' }}">

        @elseif($matrix_details['matrix_type_id'] == 7)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_width" name="level_width" value="{{ $errval['level_width'] ?? '' }}">
        @endif
    </div>

    <div class="mb-5">
        <label for="level_deep" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
            {{ __('Level Deep') }}
        </label>

        @if ($matrix_details['matrix_type_id'] == 1)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_deep" name="level_deep" value="{{ $errval['level_deep'] ?? '' }}">

        @elseif($matrix_details['matrix_type_id'] == 2 || $matrix_details['matrix_type_id'] == 5)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_deep" name="level_deep" value="{{ $errval['level_deep'] ?? '' }}">

        @elseif($matrix_details['matrix_type_id'] == 3)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_deep" name="level_deep" value="{{ $errval['level_deep'] ?? '' }}">

        @elseif($matrix_details['matrix_type_id'] == 4)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_deep" name="level_deep" value="{{ $errval['level_deep'] ?? '' }}">

        @elseif($matrix_details['matrix_type_id'] == 7)
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                   placeholder="" id="level_deep" name="level_deep" value="{{ $errval['level_deep'] ?? '' }}">
        @endif
    </div>

    <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                        {{ __('Registration') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('User + Admin') }}
                            </span>

                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="registration" name="registration" value="1"
                                       class="sr-only peer"
                                       {{ ($errval['registration'] ?? null) == 1 ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Admin only') }}
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between pt-6">
        <div class="form-submit">
            <button type="button" onclick="navigateTab('plan-scaling', 'plan-name', 'previous')"
                    class="text-gray-900 bg-white border border-gray-300hover:bg-gray-100 rounded-lg text-xs px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">
                {{ __('Back') }}
            </button>
        </div>
        <div class="form-submit">
            <button type="button" onclick="navigateTab('plan-scaling', 'entry-criteria')"
                    class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
                {{ __('Continue') }}
            </button>
        </div>
    </div>
</div>
