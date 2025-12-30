
<div id="editpackage-modal" 
     data-modal-backdrop="static"
     tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

<div class="relative p-4 w-full max-w-3xl max-h-full">
    <!-- Modal content -->
    <div 
     class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div 
            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Edit Package') }}</h3>
            <button type="button"
                                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                id="closeModalIcon">
               <svg class="w-3 h-3" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 14 14">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6">
                                                                                </path>
                                                                            </svg>
                <span class="sr-only">{{ __('Close modal') }}</span>
            </button>
        </div>
        <!-- Modal body -->
  
        <div class="p-4 md:p-5 space-y-4">
            <div class="mb-5">
                <label for=""
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Name') }}</label>
                <input type="text" id="edit_package_name" name="package_name"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    placeholder="" required="" aria-describedby="editpackagename-error">
                    <p id="editpackagename-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid name') }}</p>
            </div>
            
            <input type="hidden" name="edit_package_id" id="edit_package_id" value="0">
            <input type="hidden" name="edit_matrix_id" id="edit_matrix_id" value="0">

            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Package type') }}
                </label>
                <select id="edit_packagetype" name="packagetype"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                     required="" aria-describedby="editpackagetype-error">
                    <option value="">{{ __('Select') }}</option>
                    <option value="ON_REGISTRATION">{{ __('Registration') }}</option>
                    <option value="ON_UPGRADE">{{ __('Upgrade') }}</option>
                    <option value="ON_BOTH">{{ __('Both') }}</option>
                </select>
                <p id="editpackagetype-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid type') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Payment Method') }}

                </label>
                <select name="package_paymentmethod" id="edit_package_paymentmethod1" onchange="chooseEditPackMethod(this.value)"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                     required="" aria-describedby="editpackagepaymentmethod1-error">
                    <option value="onetime">{{ __('Manual Payment') }}</option>
                    <option value="onetimestripe">{{ __('Manual Payment - Stripe') }} </option>
                    <option value="subscription">{{ __('Auto Subscription') }}</option>
                    <option value="both">{{ __('Both') }}</option>
                </select>
                <p id="editpackagepaymentmethod1-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid method') }}</p>
            </div>
            <div class="mb-5 hidden" id="showeditstripeplanid">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Stripe Plan ID') }}
                </label>
                <input type="hidden" id="edit_stripe_planid" name="stripe_planid"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    placeholder="" aria-describedby="editstripeplanid-error">
                    <p id="editstripeplanid-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid stripe plan ID') }}</p>
            </div>

            <div class="mb-5 hidden" id="showeditautosubscription">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Payment Gateway') }} 
                </label>
                <select multiple="" searchable="Search here.." class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" name="package_paymentgateway[]" id="edit_package_paymentgateway1" required="" aria-describedby="editpackagepaymentgateway1-error" onchange="handleEditPaymentGateway(event)">
                    <option value="stripe">{{ __('Stripe') }} </option>
                    <option value="chargebee">{{ __('Chargebee') }} </option>
                    <option value="authorizenet">{{ __('Authorize net') }}</option>
                 </select>
                 <p id="editpackagepaymentgateway1-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid payment gateway') }}</p>
            </div>

            <div class="mb-5 hidden" id="showedituserchoosepaymentmethod">
                <label for="usertochoose"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('User to choose Payment Method') }}
                </label>
                <select name="usertochoose"  id="edit_usertochoose"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                    <option value="0">{{ __('Yes') }}</option>
                    <option value="1">{{ __('No') }} </option>
                </select>
            </div>

            <div class="mb-5 hidden" id="showedittotaloccurrence">
                <label for="lastname"
                      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Total Occourrence') }}
                </label>
                <input type="number" id="edit_package_totaloccurrence" name="package_totaloccurrence" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackagetotaloccurrence-error">
                    <p id="editpackagetotaloccurrence-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid total Occourrence') }}</p>
            </div>
            <div class="mb-5 hidden" id="showeditdurationdays">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Duration - Days') }}
                </label>
                <input type="number" id="edit_package_duration1" name="package_duration1" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackageduration1-error">
                    <p id="editpackageduration1-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid total Occourrence') }}</p>
            </div>
            <div class="mb-5" id="showeditgraceperiod">
                <label for="package_grace_period"
                    class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Grace Period- Days') }}
                </label>
                <input type="number" id="edit_package_grace_period" name="package_grace_period" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackagegracesperiod-error">
                    <p id="editpackagegracesperiod-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid grace period') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Price') }}
                </label>
                <input type="number" id="edit_package_price" name="package_price" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackageprice-error">
                    <p id="editpackageprice-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid price') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Direct Commission') }}

                </label>
                <input type="number" id="edit_package_direct_commission" name="package_direct_commission" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackagedirectcommission-error">
                    <p id="editpackagedirectcommission-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a direct Commission') }}</p>
            </div>

            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Method') }}

                </label>
                <select id="edit_package_direct_commission_method" name="package_direct_commission_method"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                     required="" aria-describedby="editpackagedirectcommissionmethod-error">
                    <option value="">{{ __('Select') }}
                    </option>
                    <option value="%">{{ __('%') }}</option>
                    <option value="flat">{{ __('Flat') }}</option>

                </select>
                <p id="editpackagedirectcommissionmethod-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please select method') }}</p>
            </div>
            
            <div class="mb-5">
                <label for="lastname"
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Wallet') }}

                </label>
                <select id="edit_package_direct_commission_wallet_type" name="package_direct_commission_wallet_type"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    required="" aria-describedby="editpackagedcwallettype-error">
                    <option value="">{{ __('Select') }}
                    </option>
                    <option value="1">{{ __('C-Wallet') }}</option>
                    <option value="2">{{ __('E-Wallet') }}</option>

                </select>
                <p id="editpackagedcwallettype-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please select Wallet') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('PV') }}
                </label>
                <input type="number" id="edit_package_pv" name="package_pv" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackagepv-error">
                    <p id="editpackagepv-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter pv') }}</p>
            </div>

            <div class="mb-5">
                <label for=""
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Description') }}</label>
                <textarea id="edit_packagedescription" name="packagedescription" rows="4"
                                                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your content here..." required="" aria-describedby="editpackagedescription-error"></textarea>
                    <p id="editpackagedescription-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter description') }}</p>
            </div>
            <div class="mb-5">
                <label for=""  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Package Icon') }}

                </label>
                <!-- Preview Container -->
                <div id="preview_container"
                                                                                class="relative w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <!-- Pencil Icon Button -->
                    <button onclick="document.getElementById('edit_package_image').click()"
                                                                                    class="absolute top-3 right-3 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                        type="button" title="Edit Logo">
                       <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                                        aria-hidden="true"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        fill="none" viewBox="0 0 24 24">
                                                                                        <path stroke="currentColor"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            stroke-width="1.3"
                                                                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28">
                                                                                        </path>
                                                                                    </svg>
                    </button>

                    <!-- Image Preview -->
                    <div class="flex flex-col items-center p-10">
                        <img id="editImagePreview2" class="w-32 h-32 mb-3 rounded-full shadow-lg"
                            src="/assets/img/plans/noimage.png"
                            alt="No Image Available">
                    </div>
                </div>
                <p class="text-xs mt-2">{{ __('Allowed file formats: PNG,JPG, SVG') }}</p>

                <!-- Hidden File Input -->
                <input id="edit_package_image" type="file" accept="image/*" class="hidden" name="package_image"
                    onchange="previewImage(event, 'editImagePreview2')">
                <input id="package_image_hidden" type="hidden" name="package_image_hidden" value="">

                    

                </div>

            <div class="mb-5 {{ ($taxtype ?? '') == '2' ? '' : 'hidden' }}" id="showedittaxcode">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Tax code') }}
                </label>
                <input type="number" id="edit_taxcode" name="taxcode" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="editpackagetaxcode-error">
                <p id="editpackagetaxcode-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter description') }}</p>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="flex justify-end py-6">
            <button type="button" 
                                                                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
  id="closeEditModalButton">{{ __('Cancel') }}</button>
            <button type="button"
                id="submitEditPackageButton"
                                                                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
  >{{ __('Submit') }}</button>
        </div>
    </div>
</div>
</div>
