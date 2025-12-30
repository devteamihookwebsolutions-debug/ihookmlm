
<div id="addpackage-modal" tabindex="-1" aria-hidden="true"
class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
<div class="relative p-4 w-full max-w-3xl max-h-full">
    <!-- Modal content -->
    <div class="elative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ __('Add Package') }}  </h3>
                <button  onclick="closeModal('addpackage-modal')" type="button"
                                                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                
               <svg class="w-5 h-5" fill="none"
                                                                                viewBox="0 0 16 16"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6">
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
                <input type="text" id="package_name" name="package_name"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    placeholder="" required="" aria-describedby="packagename-error">
                    <p id="packagename-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid name') }}</p>
            </div>

            <input type="hidden" name="eshopmethod" id="eshopmethod" value="0">
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Package type') }}
                </label>
                <select id="packagetype" name="packagetype"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    required="" aria-describedby="packagetype-error">
                    <option value="">{{ __('Select') }}</option>
                    <option value="ON_REGISTRATION">{{ __('Registration') }}</option>
                    <option value="ON_UPGRADE">{{ __('Upgrade') }}</option>
                    <option value="ON_BOTH">{{ __('Both') }}</option>
                </select>
                <p id="packagetype-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid type') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('Payment Method') }} 

                </label>
                <select name="package_paymentmethod1" id="package_paymentmethod1" onchange="choosePackMethod(this.value)"
                         class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                     required="" aria-describedby="packagetype-error">
                    <option value="onetime">{{ __('Manual Payment') }}  </option>
                    <option value="onetimestripe">{{ __('Manual Payment - Stripe') }}  </option>
                    <option value="subscription">{{ __('Auto Subscription') }} </option>
                    <option value="both">{{ __('Both') }} </option>
                </select>
                <p id="packagepaymentmethod1-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid method') }}</p>
            </div>
            <div class="mb-5 hidden" id="showstripeplanid">
                <label for="lastname"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Stripe Plan ID') }}
                </label>
                <input type="hidden" id="stripe_planid" name="stripe_planid" value="{{ $randomString }}"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                    placeholder="" aria-describedby="stripeplanid-error">
                    <p id="stripeplanid-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid stripe plan ID') }}</p>
            </div>

            <div class="mb-5 hidden" id="showautosubscription">
                <label for="lastname"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Payment Gateway') }} 
                </label>
                <select multiple="" searchable="Search here.." 
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                name="package_paymentgateway1[]" id="package_paymentgateway1" required="" aria-describedby="packagepaymentgateway1-error" onchange="handlePaymentGateway(event)">
                    <option value="stripe">{{ __('Stripe') }} </option>
                    <option value="chargebee">{{ __('Chargebee') }}  </option>
                    <option value="authorizenet">{{ __('Authorize net') }}  </option>
                 </select>
                 <p id="packagepaymentgateway1-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please enter a valid payment gateway') }}</p>
            </div>

            <div class="mb-5 hidden" id="showuserchoosepaymentmethod">
                <label for="usertochoose"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('User to choose Payment Method') }}
                </label>
                <select name="usertochoose" 
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500">
                    <option value="0">{{ __('Yes') }} </option>
                    <option value="1">{{ __('No') }} </option>
                </select>
            </div>

            <div class="mb-5 hidden" id="showtotaloccurrence">
                <label for="lastname"
                      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Total Occourrence') }}
                </label>
                <input type="number" id="package_totaloccurrence" name="package_totaloccurrence" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packagetotaloccurrence-error">
                    <p id="packagetotaloccurrence-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid total Occourrence') }}</p>
            </div>
            <div class="mb-5 hidden" id="showdurationdays">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Duration - Days') }}
                </label>
                <input type="number" id="package_duration1" name="package_duration1" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packageduration1-error">
                    <p id="packageduration1-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid total Occourrence') }}</p>
            </div>
            <div class="mb-5" id="showgraceperiod">
                <label for="package_grace_period"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                     {{ __('Grace Period- Days') }}
                </label>
                <input type="number" id="package_grace_period" name="package_grace_period" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packagegracesperiod-error">
                    <p id="packagegracesperiod-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid grace period') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-black dark:text-white"> {{ __('Price') }}
                </label>
                <input type="number" id="package_price" name="package_price" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packageprice-error">
                    <p id="packageprice-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a valid price') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Direct Commission') }}

                </label>
                <input type="number" id="package_direct_commission" name="package_direct_commission" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packagedirectcommission-error">
                    <p id="packagedirectcommission-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter a direct Commission') }}</p>
            </div>

            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('Method') }}
                </label>
                <select id="package_direct_commission_method" name="package_direct_commission_method"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                     required="" aria-describedby="packagedirectcommissionmethod-error">
                    <option value="">{{ __('Select') }}
                    </option>
                    <option value="%">{{ __('%') }}</option>
                    <option value="flat">{{ __('Flat') }}</option>

                </select>
                <p id="packagedirectcommissionmethod-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please select method') }}</p>
            </div>
            
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Wallet') }}

                </label>
                <select id="package_direct_commission_wallet_type" name="package_direct_commission_wallet_type"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                     required="" aria-describedby="packagedcwallettype-error">
                    <option value="">{{ __('Select') }}
                    </option>
                    <option value="1">{{ __('C-Wallet') }} </option>
                    <option value="2">{{ __('E-Wallet') }}</option>

                </select>
                <p id="packagedcwallettype-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                    {{ __('Please select Wallet') }}</p>
            </div>
            <div class="mb-5">
                <label for="lastname"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('PV') }}
                </label>
                <input type="number" id="package_pv" name="package_pv" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packagepv-error">
                    <p id="packagepv-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter pv') }}</p>
            </div>

            <div class="mb-5">
                <label for=""
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Description') }}</label>
                <textarea id="packagedescription" name="packagedescription" rows="4"
                                                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your content here..." required="" aria-describedby="packagedescription-error"></textarea>
                    <p id="packagedescription-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter description') }}</p>
            </div>
            <div class="mb-5">
                <label for=""  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    
                    {{ __('Package Icon') }}
                </label>
                <!-- Preview Container -->
                <div id="preview_container" class="relative w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <!-- Pencil Icon Button -->
                    <button onclick="document.getElementById('package_image').click()"
                        class="absolute top-3 right-3 text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:ring-4 focus:outline-none focus:ring-neutral-200 dark:focus:ring-neutral-700 rounded-lg text-sm p-1.5"
                        type="button" title="Edit Logo">
                        <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.3"
                                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28">
                            </path>
                        </svg>
                    </button>

                    <!-- Image Preview -->
                    <div class="flex flex-col items-center p-10">
                        <img id="imagePreview2" class="w-32 h-32 mb-3 rounded-full shadow-lg"
                            src="/assets/img/plans/noimage.png"
                            
                            alt="No Image Available">
                    </div>
                </div>
                <p class="text-xs mt-2">
                {{ __('Allowed file formats: PNG,JPG, SVG') }}</p>

                <!-- Hidden File Input -->
                <input id="package_image" type="file" accept="image/*" class="hidden" name="package_image"
                    onchange="previewImage(event, 'imagePreview2')">

            </div>

            <div class="mb-5 {{ ($taxtype ?? '') == '2' ? '' : 'hidden' }}" id="showtaxcode">
                <label for="lastname"
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Tax code') }}
                </label>
                <input type="number" id="taxcode" name="taxcode" aria-describedby="helper-text-explanation"
                                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" required="" aria-describedby="packagetaxcode-error">
                <p id="packagetaxcode-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">
                        {{ __('Please enter description') }}</p>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="flex justify-end py-6">
            <button type="button" 
                                                                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
 onclick="closeModal('addpackage-modal')"> {{ __('Cancel') }}</button>
            <button type="button"
                id="submitAddPackageButton"
                                                                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
  {{ __('Submit') }}</button>
        </div>
    </div>
</div>
</div>
