<div id="show_one_time_registration" class="mt-5 {{  ($errval['members_account_type'] ?? null) == '2' &&  ($errval['members_paid_account_type'] ?? null) == ''  ? '' : 'hidden' }}">
    <div class="mb-5">
        <label for="lastname" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Registration Fee') }}
        </label>
        <input type="number" id="registration_fee" name="registration_fee" aria-describedby="helper-text-explanation"
                   class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
            placeholder="" required="" aria-describedby="registrationfee-error" value="{{ $errval['registration_fee'] ?? '' }}">
        <p id="registrationfee-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
            {{ __('Please enter a valid registration fee') }}</p>
    </div>
    <div class="mb-5">
        <label for="lastname" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Registration PV') }}
        </label>
        <input type="number" id="registration_pv" name="registration_pv" aria-describedby="helper-text-explanation"
         class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
            placeholder="" required="" aria-describedby="registrationpv-error" value="{{ $errval['registration_pv'] ?? '' }}">
        <p id="registrationpv-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
            {{ __('Please enter a valid registration pv') }}</p>
    </div>

<!--
    <div class="mb-5 ">
        <label for="lastname" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Registration PV') }}
        </label>
        <input type="number" id="chargebee_plan_name" name="chargebee_plan_name" aria-describedby="helper-text-explanation"
            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="" aria-describedby="chargebeeplanname-error" value="{{$chargebeeplanname}}">
        <p id="chargebeeplanname-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
            {{ __('Please enter a valid chargebee name') }}</p>
    </div> -->

<div class="mb-5">
    <label class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
        {{ __('One time fee image') }}
    </label>

    <!-- Preview + Upload Button -->
    <div class="relative w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <!-- Edit Button (Pencil) -->
        <button type="button"
                onclick="document.getElementById('onetime_image_input').click()"
                class="absolute top-3 right-3 z-10 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-1.5">
              <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                 viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="1.3"
                      d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
            </svg>
        </button>

<div class="flex flex-col items-center p-10">
    <img id="onetime_image_preview"
         src="{{ isset($errval['onetime_image']) && $errval['onetime_image'] ? asset($errval['onetime_image']) : asset('assets/img/plans/noimage.png') }}"
         alt="One time fee image"
         class="w-32 h-32 object-cover rounded-full shadow-lg border-4 border-white">
</div>
    </div>

    <!-- Real File Input (hidden) -->
    <input type="file"
           id="onetime_image_input"
           name="onetime_image"
           accept="image/png,image/jpeg,image/jpg,image/webpjpeg"
           class="hidden"
           onchange="previewOnetimeImage(event)">

    <p class="text-xs text-gray-500 mt-2">
        {{ __('Allowed: PNG, JPG, JPEG (Recommended size: 400x400px)') }}
    </p>
</div>
    <div class="mb-5">
        <label for="onetime_reigster_taxcode" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Taxcode') }}
        </label>
        <input type="text" id="onetime_reigster_taxcode" name="onetime_reigster_taxcode"
                                                            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
            placeholder=""  aria-describedby="onetimereigstertaxcode-error"   value="{{$errval['onetime_reigster_taxcode'] ?? ''}}">
        <p id="onetimereigstertaxcode-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500  hidden">
            {{ __('Please enter a valid taxcode') }}</p>
    </div>
    <div class="mb-5 {{ $chargebee_paymentsettings_status == '1' ? '' : 'hidden' }}">
        <label for="chargebee_plan_name" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
        {{ __('Chargebee Planname') }}
        </label>
        <input type="text" id="chargebee_plan_name" name="chargebee_plan_name"
               class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
            placeholder="" aria-describedby="chargebeeplanname-error"
            value="{{$errval['chargebee_plan_name'] ?? '' }}">
        <p id="chargebeeplanname-error" class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
            {{ __('Please enter a valid chargebee plan name') }}</p>
    </div>
    <!-- Direct Referral Commission Form Fields (toggle switch) -->
    <div class="mb-5">
        <table class="min-w-2xl">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 text-xs dark:text-gray-300 font-medium w-48">
                    {{ __('Direct Referral Commission') }}
                    </td>
                    <td class="px-6 text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="direct_referrel_commission_status"
                                    name="direct_referrel_commission_status" value="1" class="sr-only peer"
                                  @if(($errval['direct_referrel_commission_status'] ?? null) == 1) checked @endif

                                    onchange="toggleDirectReferralCommission()">
                                <div
                               class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('ON') }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Direct Referral Commission on Form Fields -->
        <div id="dr_on_fields" class="mt-5 {{ ($errval['direct_referrel_commission_status'] ?? null) == 1 ? '' : 'hidden' }}">
            <div class="flex flex-col space-y-4">

                <!-- Input Fields Row -->
                <div id="directreffalcommission" class="flex flex-wrap items-center justify-center gap-4">
                    <!-- Commission Input -->
                    <div class="flex-1">
                        <label for="lastname"
                            class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Commission') }}</label>
                        <input type="number" id="direct_referrel_commission" aria-describedby="helper-text-explanation"
                              class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="Commission" name="direct_referrel_commission" required
                            aria-describedby="directreferrelcommission-error"
                            value="{{$errval['direct_referrel_commission'] ?? ''}}">
                        <p id="directreferrelcommission-error"
                            class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a valid commission') }}</p>
                    </div>

                    <!-- Commission Type Toggle -->
                    <div class="flex items-center p-2.5 pt-9">
                        <!-- Left label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Flat') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="direct_referrel_commission_type"
                                name="direct_referrel_commission_type" value="1" class="sr-only peer"
                               @if(($errval['direct_referrel_commission_type'] ?? null) == 1)checked @endif>
                            <div
                           class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('%') }}</span>
                    </div>

                    <!-- Wallet Selection -->
                    <div class="flex-1">
                        <label for="wallet" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">
                        {{ __('Wallet Type') }}
                        </label>
                        <select id="direct_referrel_commission_wallet_type"
                            name="direct_referrel_commission_wallet_type"
                               class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            required aria-describedby="directreferrelcommissionwallettype-error">
                            <option value="">{{ __('Select') }}</option>
                           <option value="1" @if(($errval['direct_referrel_commission_wallet_type'] ?? null) == '1') selected @endif>{{ __('C-Wallet') }}</option>
                            <option value="2" @if(($errval['direct_referrel_commission_wallet_type'] ?? null) == '2') selected @endif>{{ __('E-Wallet') }}</option>

                        </select>
                        <p id="directreferrelcommissionwallettype-error"
                            class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">
                            {{ __('Please enter a select wallet') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="mb-5">

        <table class="min-w-2xl  ">
            <tbody>
                <tr>
                    <td class="pe-6 text-gray-600 text-xs dark:text-gray-300 font-medium w-48">
                    {{ __('Level Commission') }}
                    </td>
                    <td class="px-6  text-right">
                        <div class="flex items-center p-2.5">
                            <!-- Left label -->
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('OFF') }}</span>

                            <!-- Toggle switch -->
                            <label class="inline-flex items-center cursor-pointer mx-3">
                                <input type="checkbox" id="level_commisison_status" name="level_commisison_status"
                                    value="1" class="sr-only peer"  onchange="toggleOnetimeLevelCommission()" @if(($errval['level_commisison_status'] ?? null) == '1')checked
                                    @endif>
                                <div
                                       class="relative w-11 h-6  bg-gray-200  rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                            </label>

                            <!-- Right label -->
                            <span  class="text-xs text-gray-500 dark:text-gray-400">{{ __('ON') }}</span>
                            <div class="ms-10 {{ ($errval['level_commisison_status'] ?? null) == '1' ? '' : 'hidden' }}" id="onetime_level_on_fields">
                            <button onclick="setOneTimeLevelCommission()" type="button"
                class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">
                                {{ __('Set Level Commission') }}
                            </button>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

</div>
<script>
function previewOnetimeImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('onetime_image_preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
