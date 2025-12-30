<div id="commission-setting" class="tab-content hidden">
    <h3 class="text-sm font-semibold text-gray-800 mb-10 dark:text-gray-200">
    {{ __('Plan Scaling') }}</h3>

    @include('matrixconfig.components.joiningcommissionsettings')
    <!-- <div class="bg-red-100 p-4 mb-4">
    DEBUG: matrix_type_id = {{ $matrix_details['matrix_type_id'] }}
</div> -->
    @if($matrix_details['matrix_type_id']=='1')
    @include('matrixconfig.components.binarycommissionsettings')
    @endif

    <div class="flex justify-between pt-6">
        <div class="form-submit">
            <button type="button"
                onclick="navigateTab('commission-setting','entry-criteria','previous')"
                class="text-gray-900 bg-white border border-gray-300hover:bg-gray-100 rounded-lg text-xs px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">
              {{ __('Back') }}</button>
        </div>
        <div class="form-submit">
            <button type="button" onclick="validateAndSubmit()"
                class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
            {{ __('Submit') }}</button>
        </div>
    </div>
</div>
