
<div id="plan-name" class="tab-content">
      <h3 class="text-sm font-semibold text-gray-800 mb-10 dark:text-gray-200">
        {{ __('General Settings') }} </h3>
    <div class="mb-5">
        <label for=""  class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
            {{ __('Plan Name') }}</label>
        <input type="text" id="matrix_name" name="matrix_name"
            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
            placeholder="" value="{{$matrix_details['matrix_name']}}" disabled>
    </div>

    <div class="mb-5">
        <label for="lastname"
             class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
            {{ __('Plan Type') }}</label>
        {!!$matrix_types!!}

        <p id="planname-error"
            class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
            {{ __('Please enter a valid planname') }}</p>
    </div>
    <div class="mb-5">
        <label for="lastname"
            class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
            {{ __('Default Sponsor') }}
        </label>
        <div class="relative">

            <div id="search-combobox" class="relative" data-hs-combo-box="">
                <div class="relative w-80">
                    <input type="text" name="default_sponsor_name" id="searchbox"
                    class="block w-full p-2  bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                        placeholder="Search..." aria-expanded="false"
                        data-hs-combo-box-input=""
                        onkeyup="filterSuggestions(this.value)"  value="{{ $errval['default_sponsor_name'] ?? '' }}"/>
                    {{-- <button type="button" onclick="memberSearch();"
                        class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg border border-blue-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-blue-800"
                        bis_size="{&quot;x&quot;:772,&quot;y&quot;:20,&quot;w&quot;:38,&quot;h&quot;:42,&quot;abs_x&quot;:1244,&quot;abs_y&quot;:6086}"><svg
                            class="w-4 h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20"
                            bis_size="{&quot;x&quot;:783,&quot;y&quot;:33,&quot;w&quot;:16,&quot;h&quot;:16,&quot;abs_x&quot;:1255,&quot;abs_y&quot;:6099}">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                bis_size="{&quot;x&quot;:783,&quot;y&quot;:33,&quot;w&quot;:14,&quot;h&quot;:14,&quot;abs_x&quot;:1255,&quot;abs_y&quot;:6099}">
                            </path>
                        </svg>
                    </button> --}}
                </div>
                <div id="suggestion-box"
 class="absolute z-50 w-full h-32 mt-1 bg-white border border-gray-300 rounded-lg shadow-md overflow-y-auto hidden">
                </div>

                <p id="defaultmembersid-error"
                    class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid default sponsor') }}</p>

            </div>

        </div>
    </div>
    <div class="mb-5">

        <table class="min-w-2xl ">
            <tbody>
                <tr>
                      <td class="pe-6  text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                        {{ __('Register Status') }}</td>
                    <td class="px-6  text-right ">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span
                               class="text-xs text-gray-500 dark:text-gray-400">{{ __('Replicated') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="register_status"
                                    name="register_status" value="1" class="sr-only peer"
                                    @if(($errval['register_status'] ?? 0) == 1) checked @endif>
                                <div
                                   class="relative w-11 h-6  bg-gray-200  rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ __('Default') }}</span>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
    <div class="mb-5">

        <table class="min-w-2xl  ">
            <tbody>
                <tr>
                    <td class="pe-6  text-gray-600 dark:text-gray-300 text-xs font-medium w-48">{{ __('Status') }}
                    </td>
                    <td class="px-6  text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="matrix_status"
                                    name="matrix_status" value="1" class="sr-only peer"
                                   @if(($errval['matrix_status'] ?? null) == 1)checked @endif>
                                <div
                             class="relative w-11 h-6  bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
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

    </div>
    <div class="mb-5">

        <table class="min-w-2xl  ">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                        {{ __('Account Activation') }}
                    </td>
                    <td class="px-6  text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ __('Via link') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="active_status"
                                    name="active_status" value="1" class="sr-only peer"
                                    @if(($errval['active_status'] ?? null) == 1)checked @endif>
                                <div
                                    class="relative w-11 h-6  bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ __('Automatic') }}</span>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="mb-5">
        <label for=""
           class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Description') }}</label>
        <textarea id="matrix_description" name="matrix_description" rows="4"
             class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
            placeholder="Write your content here..." required
            aria-describedby="matrixdescription-error">{{$errval['matrix_description'] ?? ''}}</textarea>

        <p id="matrixdescription-error"
            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
            {{ __('Please enter a valid description') }}</p>
    </div>
    <div class="flex justify-end pt-6">
        <div class="form-submit">
            <button type="button" onclick="navigateTab('plan-name','plan-scaling')"
class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600"
>{{ __('Continue') }}</button>
        </div>
    </div>
</div>
