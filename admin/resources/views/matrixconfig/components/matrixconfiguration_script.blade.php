<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    // Function to handle tab navigation with validation
    function navigateTab(currentTab, targetTab, direction = 'next') {
        console.log(`${direction === 'next' ? 'Going forward' : 'Going back'} from ${currentTab} to ${targetTab}`);

        // Validate current tab before navigating forward
        if (direction === 'next' && !validateTab(currentTab)) {
            console.warn('Validation failed on', currentTab);
            return;
        }

        // Hide current tab
        document.getElementById(currentTab).classList.add('hidden');
        // Show target tab
        document.getElementById(targetTab).classList.remove('hidden');
        // Update tab styles
        updateTabStyles(targetTab);
    }

    // Central function to validate each tab
    function validateTab(tabId) {
        let isValid = true;  // Declare isValid once at the beginning

        switch (tabId) {
            case 'plan-name':
                // Validate the 'plan-name' tab
                isValid = isValid && validateRequiredField('#searchbox', '#defaultmembersid-error');
                isValid = isValid && validateRequiredField('#matrix_description', '#matrixdescription-error');
                break;
            case 'entry-criteria':
                // Validate all fields in the 'entry-criteria' tab
                isValid = isValid && validateAllEntryCriteria();
                break;
            case 'commission-setting':
                // Validate all fields in the 'commission-setting' tab
                isValid = isValid && validateAllCommissionSetting();
                // if (isValid) {
                //     // Find and submit the form if validation passes
                //     document.getElementById('planForm').submit();  // Replace 'yourFormID' with the actual form ID
                // }
                break;
            default:
                return true;  // If no specific validation is needed, just return true
        }

        return isValid;  // Return the final validation result
    }

    function validateAllEntryCriteria() {
        const fields = [
            { field: '#registration_fee', error: '#registrationfee-error', related: '#show_one_time_registration' },
            { field: '#registration_pv', error: '#registrationpv-error', related: '#show_one_time_registration' },
            // { field: '#registration_price', error: '#registrationprice-error', related: '#sub_register_fee_on_fields' },
            // { field: '#registration_taxcode', error: '#registrationtaxcode-error', related: '#sub_register_fee_on_fields' },
            // { field: '#onetime_register_taxcode', error: '#onetimereigstertaxcode-error', related: '#show_one_time_registration' },
            // { field: '#chargebee_plan_name', error: '#chargebeeplanname-error', related: '#show_one_time_registration' },
            { field: '#direct_referrel_commission', error: '#directreferrelcommission-error', related: '#dr_on_fields' },
            { field: '#direct_referrel_commission_wallet_type', error: '#directreferrelcommissionwallettype-error', related: '#dr_on_fields' }
        ];

        let isValid = true;
        for (const { field, error, related } of fields) {
            const result = validateRequiredField(field, error, related);
            if (!result) {
                // console.log(`Validation failed for ${field}`);
                isValid = false;
            }
        }
        // console.log('All validations passed:', isValid);
        return isValid;
    }
    // Function to validate all fields in the entry-criteria tab
    function validateAllCommissionSetting() {


        let isValid = true;

        // Validate each field
        isValid = isValid && validateRequiredField('#joining_commission', '#joiningcommission-error', '#join_on_fields');
        isValid = isValid && validateRequiredField('#join_commission_wallet_type', '#joincommissionwallettype-error', '#join_on_fields');
        if(matrixTypeID=='1'){
        isValid = isValid && validateRequiredField('#instantbinary_sales_volume', '#instantbinarysalesvolume-error', '#instantbinary_on_fields');
        isValid = isValid && validateRequiredField('#instantbinary_commission', '#instantbinarycommission-error', '#instantbinary_on_fields');
        isValid = isValid && validateRequiredField('#instantbinary_commission_wallet_type', '#instantbinarywallettype-error', '#instantbinary_on_fields');

        isValid = isValid && validateRequiredField('#dailybinary_sales_volume', '#dailybinarysalesvolume-error', '#dailybinary_on_fields');
        isValid = isValid && validateRequiredField('#dailybinary_commission', '#dailybinarycommission-error', '#dailybinary_on_fields');
        isValid = isValid && validateRequiredField('#dailybinary_commission_wallet_type', '#dailybinarywallettype-error', '#dailybinary_on_fields');
        isValid = isValid && validateRequiredField('#dailybinary_commission_capping', '#dailybinarycapping-error', '#dailybinary_on_fields');

        isValid = isValid && validateRequiredField('#weeklybinary_sales_volume', '#weeklybinarysalesvolume-error', '#weeklybinary_on_fields');
        isValid = isValid && validateRequiredField('#weeklybinary_commission', '#weeklybinarycommission-error', '#weeklybinary_on_fields');
        isValid = isValid && validateRequiredField('#weeklybinary_commission_wallet_type', '#weeklybinarywallettype-error', '#weeklybinary_on_fields');
        isValid = isValid && validateRequiredField('#weeklybinary_commission_capping', '#weeklybinarycapping-error', '#weeklybinary_on_fields');


        isValid = isValid && validateRequiredField('#monthlybinary_sales_volume', '#monthlybinarysalesvolume-error', '#monthlybinary_on_fields');
        isValid = isValid && validateRequiredField('#monthlybinary_commission', '#monthlybinarycommission-error', '#monthlybinary_on_fields');
        isValid = isValid && validateRequiredField('#monthlybinary_commission_wallet_type', '#monthlybinarywallettype-error', '#monthlybinary_on_fields');
        isValid = isValid && validateRequiredField('#monthlybinary_commission_capping', '#monthlybinarycapping-error', '#monthlybinary_on_fields');
        }
        // Return whether all validations passed
        return isValid;
    }
        // Generic function to validate multiple fields
    function validateAllFields(fields, formId = null) {
        let isValid = true;
        fields.forEach(field => {
            const [input, error, parent] = field.split(',');
            isValid = isValid && validateRequiredField(input, error, parent);
        });

        if (isValid && formId) {
            document.getElementById(formId).submit();
        }
        return isValid;
    }

    // Function to validate required fields
    function validateRequiredField(inputSelector, errorSelector, parentSelector = null) {
        const inputField = document.querySelector(inputSelector);
        const errorMessage = document.querySelector(errorSelector);
        const inputValue = inputField?.value.trim();
        const parentDiv = parentSelector ? document.querySelector(parentSelector) : null;

        if (parentDiv && parentDiv.classList.contains('hidden')) {
            return true; // Skips validation if parent div is hidden
        }

        if (!inputValue) {
            errorMessage.classList.remove('hidden');
            inputField?.classList.add('border-red-500');
            return false;
        } else {
            errorMessage.classList.add('hidden');
            inputField?.classList.remove('border-red-500');
            return true;
        }
    }

    // Function to update tab button styles
    function updateTabStyles(activeTabId) {
        document.querySelectorAll('.tab-btn').forEach(button => {
             button.classList.remove('bg-gray-900', 'text-white', 'dark:bg-blue-500');
            button.classList.add('bg-gray-200', 'text-gray-600', 'dark:bg-gray-700', 'dark:text-gray-300');
        });

        const activeTab = document.getElementById(`tab-${activeTabId}`);
         activeTab?.classList.add('bg-gray-900', 'text-white', 'dark:bg-blue-500');
        activeTab?.classList.remove('bg-gray-200', 'text-gray-600', 'dark:bg-gray-700', 'dark:text-gray-300');
    }

    // Function to toggle visibility of sections based on checkboxes
    function toggleVisibility(toggleId, showClass, hideClass) {
        const checkbox = document.getElementById(toggleId);
        document.getElementById(hideClass).classList.add('hidden');
        document.getElementById(showClass).classList.remove('hidden');
    }

    // Real-time validation for specific fields
    document.addEventListener('input', function(event) {

        if (event.target.matches('#searchbox, #registration_fee,#joining_commission, #join_commission_wallet_type, #instantbinary_sales_volume, #instantbinary_commission, #instantbinary_commission_wallet_type, #dailybinary_sales_volume, #dailybinary_commission, #dailybinary_commission_wallet_type, #dailybinary_commission_capping, #weeklybinary_sales_volume, #weeklybinary_commission, #weeklybinary_commission_wallet_type, #weeklybinary_commission_capping, #monthlybinary_sales_volume, #monthlybinary_commission, #monthlybinary_commission_wallet_type, #monthlybinary_commission_capping,#registration_pv, #onetime_reigster_taxcode, #chargebee_plan_name, #direct_referrel_commission, #direct_referrel_commission_wallet_type')) {
            const tabId = event.target.closest('.tab-content').id;
            validateTab(tabId);
        }
        if (event.target.matches('#package_name')) {
            validateRequiredField('#package_name', '#packagename-error', '#show_subscription');
        }
    });

    // Function to toggle member's account display
    function showMembersAccount(accountID) {
        document.getElementById('entryid').value = accountID;
        const sections = ['show_freemembership', 'show_paidmembership', 'show_paidmembership'];
        sections.forEach(section => document.getElementById(section).classList.add('hidden'));
        document.getElementById(`show_${['freemembership', 'paidmembership', 'paidmembership'][accountID - 1]}`).classList.remove('hidden');

        if(accountID==2){
            document.getElementById('show_paidmembership_fee_type').classList.remove('hidden');
        }
        if(accountID==3){
            document.getElementById('show_paidmembership_fee_type').classList.add('hidden');
            document.getElementById('show_one_time_registration').classList.add('hidden');
            document.getElementById('show_subscription').classList.remove('hidden');
        }
    }

    // Function to handle search with suggestions
    function memberSearch() {
        const membersUsername = document.querySelector('#searchbox').value;
        const encryptUrl = "{{ $matrix_id }}"; // Blade syntax for injecting PHP variables

        if (membersUsername !== '') {
            fetch("/genealogy/search", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({members_username: membersUsername, encrypturl: encryptUrl}),
            })
            .then(response => response.ok ? response.text() : Promise.reject("Error"))
            .then(data => window.location.href = `/genealogy/viewtree/${data}`)
            .catch(error => console.error("Error during genealogy search:", error));
        }
    }

    // Function to filter member suggestions
    function filterSuggestions(query) {
        const suggestionBox = document.getElementById("suggestion-box");
        const matrixId = "{{ $matrix_id }}";

        if (query.trim() === "") {
            suggestionBox.classList.add("hidden");
            return;
        }

        fetch(`/memberslist/getmembers/${query}`, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({matrix_id: matrixId}),
        })
        .then(response => response.json())
        .then(data => {
            suggestionBox.innerHTML = "";
            if (data.length === 0) {
                suggestionBox.classList.add("hidden");
                return;
            }

            data.forEach(member => {
                const div = document.createElement("div");
                div.textContent = member.members_username;
                div.dataset.value = member.members_id;
                div.classList.add("suggestion-item", "cursor-pointer", "p-2", "hover:bg-neutral-200");
                div.addEventListener("click", () => {
                    document.getElementById("searchbox").value = div.textContent.trim();;
                    suggestionBox.classList.add("hidden");
                    document.querySelector('#default_members_id').value = div.dataset.value;
                });
                suggestionBox.appendChild(div);
            });

            suggestionBox.classList.remove("hidden");
        })
        .catch(error => console.error("Error fetching suggestions:", error));
    }

    // Preview image function
    function previewImage(event, previewElementId) {
        const file = event.target.files[0];
        const imagePreview = document.getElementById(previewElementId);

        // console.log(previewElementId, imagePreview); // Debugging

        if (!imagePreview) {
            console.log(`Element with ID '${previewElementId}' not found.`);
            return;
        }


        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                if(previewElementId=='imagePreview2'){
                    document.getElementById('onetime_image').value = e.target.result;;
                }
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }


    // Toggle commission settings visibility
    function toggleCommissionVisibility(checkboxId, fieldsClass) {
        const checkbox = document.getElementById(checkboxId);
        const fields = document.getElementById(fieldsClass);
        checkbox.checked ? fields.classList.remove('hidden') : fields.classList.add('hidden');
    }

    function toggleRegistrationSubscription() {
        const checkbox = document.getElementById('members_paid_account_type');
        if (checkbox.checked) {
            document.getElementById('show_one_time_registration').classList.add('hidden');
            document.getElementById('show_subscription').classList.remove('hidden');
        } else {
            document.getElementById('show_one_time_registration').classList.remove('hidden');
            document.getElementById('show_subscription').classList.add('hidden');
        }
    }

    function toggleDirectReferralCommission() {
        const checkbox = document.getElementById('direct_referrel_commission_status');
        if (checkbox.checked) {
            document.getElementById('dr_on_fields').classList.remove('hidden');
        } else {
            document.getElementById('dr_on_fields').classList.add('hidden');
        }
    }

    function toggleSubRegistration() {
        const checkbox = document.getElementById('register_fee_status');
        const fields = document.getElementById('sub_register_fee_on_fields');

        if (checkbox.checked) {
            fields.classList.remove('hidden');
        } else {
            fields.classList.add('hidden');
        }
    }

    function toggleJoinCommissions() {
        const checkbox = document.getElementById('joining_commission_status');
        const joinOnFields = document.getElementById('join_on_fields');

        // Toggle visibility based on checkbox status
        if (checkbox.checked) {
            joinOnFields.classList.remove('hidden');
        } else {
            joinOnFields.classList.add('hidden');
        }
    }
    function toggleInstantBinaryCommissions() {
        const checkbox = document.getElementById('instantbinary_commission_status');
        const joinOnFields = document.getElementById('instantbinary_on_fields');

        // Toggle visibility based on checkbox status
        if (checkbox.checked) {
            joinOnFields.classList.remove('hidden');
        } else {
            joinOnFields.classList.add('hidden');
        }
    }
    function toggleDailyBinaryCommissions() {
        const checkbox = document.getElementById('dailybinary_commission_status');
        const joinOnFields = document.getElementById('dailybinary_on_fields');

        // Toggle visibility based on checkbox status
        if (checkbox.checked) {
            joinOnFields.classList.remove('hidden');
        } else {
            joinOnFields.classList.add('hidden');
        }
    }
    function toggleWeeklyBinaryCommissions() {
        const checkbox = document.getElementById('weeklybinary_commission_status');
        const joinOnFields = document.getElementById('weeklybinary_on_fields');

        // Toggle visibility based on checkbox status
        if (checkbox.checked) {
            joinOnFields.classList.remove('hidden');
        } else {
            joinOnFields.classList.add('hidden');
        }
    }
    function toggleMonthlyBinaryCommissions() {
        const checkbox = document.getElementById('monthlybinary_commission_status');
        const joinOnFields = document.getElementById('monthlybinary_on_fields');

        // Toggle visibility based on checkbox status
        if (checkbox.checked) {
            joinOnFields.classList.remove('hidden');
        } else {
            joinOnFields.classList.add('hidden');
        }
    }

    // Common function to handle visibility of elements
    function updateVisibility(elements, paymentMethod) {
        // Default logic: hide all elements
        Object.values(elements).forEach(element => element.classList.add('hidden'));

        // Update visibility based on the selected payment method
        const actions = {
            onetime: () => {
                elements.gracePeriod.classList.remove('hidden');
            },
            onetimestripe: () => {
               // elements.stripePlan.classList.remove('hidden');
                elements.userChoosePaymentMethod.classList.remove('hidden');
                elements.durationDays.classList.remove('hidden');
                elements.autoSubscription.classList.remove('hidden');
            },
            subscription: () => {
                //elements.stripePlan.classList.remove('hidden');
                elements.autoSubscription.classList.remove('hidden');
                elements.userChoosePaymentMethod.classList.remove('hidden');
                elements.durationDays.classList.remove('hidden');
            },
            both: () => {
                //elements.stripePlan.classList.remove('hidden');
                elements.gracePeriod.classList.remove('hidden');
                elements.userChoosePaymentMethod.classList.remove('hidden');
                elements.durationDays.classList.remove('hidden');
                elements.autoSubscription.classList.remove('hidden');
            }
        };

        // Execute the corresponding action if it exists
        if (actions[paymentMethod]) {
            actions[paymentMethod]();
        }
    }

    // Function to handle the "Choose Pack Method"
    function choosePackMethod(paymentMethod) {
        const elements = {
            stripePlan: document.getElementById('showstripeplanid'),
            autoSubscription: document.getElementById('showautosubscription'),
            gracePeriod: document.getElementById('showgraceperiod'),
            userChoosePaymentMethod: document.getElementById('showuserchoosepaymentmethod'),
            durationDays: document.getElementById('showdurationdays')
        };

        updateVisibility(elements, paymentMethod);
    }

    // Function to handle the "Choose Edit Pack Method"
    function chooseEditPackMethod(paymentMethod) {
        const elements = {
            stripePlan: document.getElementById('showeditstripeplanid'),
            autoSubscription: document.getElementById('showeditautosubscription'),
            gracePeriod: document.getElementById('showeditgraceperiod'),
            userChoosePaymentMethod: document.getElementById('showedituserchoosepaymentmethod'),
            durationDays: document.getElementById('showeditdurationdays')
        };

        updateVisibility(elements, paymentMethod);
    }
    // Common function to handle payment gateway changes
    function handlePaymentGatewayChange(event, elementId) {
        const selectedOptions = Array.from(event.target.selectedOptions).map(option => option.value);
        // console.log('Selected Payment Gateways:', selectedOptions);

        // Get the element by its ID
        const targetElement = document.getElementById(elementId);

        // Update visibility based on selected options
        if (selectedOptions.includes('authorizenet')) {
            targetElement.classList.remove('hidden');
        } else {
            targetElement.classList.add('hidden');
        }
    }

    // Function for normal payment gateway changes
    function handlePaymentGateway(event) {
        handlePaymentGatewayChange(event, 'showdurationdays');
    }

    // Function for edit payment gateway changes
    function handleEditPaymentGateway(event) {
        handlePaymentGatewayChange(event, 'showeditdurationdays');
    }

    function showEditPackage(id){
        var iden = document.getElementById('entryid').value;
        var url = '{{ config('app.ADMINPATH') }}/matrix/editpackage/' + id + '/' + '{{ $matrix_id }}?iden=' + iden;

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json(); // Now safe
        })
        .then(resp => {

           // Mapping of element IDs to response keys
            const fieldMappings = {
                'edit_package_name': 'package_name',
                'edit_packagetype': 'package_type',
                'edit_package_paymentmethod1': 'package_paymentmethod1',
                'edit_stripe_planid': 'stripe_planid',
                'edit_usertochoose':'usertochoose',
                'edit_package_totaloccurrence':'package_totaloccurrence',
                'edit_package_duration1':'package_duration',
                'edit_package_grace_period':'package_grace_period',
                'edit_package_duration1':'package_duration',
                'edit_package_price':'package_price',
                'edit_package_direct_commission':'package_direct_commission',
                'edit_package_direct_commission_method':'package_direct_commission_method',
                'edit_package_direct_commission_wallet_type':'package_direct_commission_wallet_type',
                'edit_package_pv':'package_pv',
                'edit_packagedescription':'package_description',
                'edit_taxcode':'taxcode',
                'editImagePreview2':'package_icon',
            };

            // Loop through the mappings and set the values

            const CDN_URL = "{{env('CDNCLOUDEXTURL') }}"; // Ensure this is correctly embedded in your Blade template
            // console.log(resp);
            for (const [elementId, responseKey] of Object.entries(fieldMappings)) {
                const element = document.getElementById(elementId);

                if (element && resp['errval'][responseKey] !== undefined) {
                    if (elementId === 'editImagePreview2') {
                        // Set image source correctly
                        element.src = CDN_URL +'/'+resp['errval'][responseKey];
                        element.classList.remove('hidden'); // Show image if hidden
                        document.getElementById('package_image_hidden').value=resp['errval'][responseKey];

                    } else {
                        console.log(resp['errval'][responseKey]);
                        element.value = resp['errval'][responseKey]; // Set value for text fields
                    }
                }
            }


            document.getElementById('edit_stripe_planid').value = resp['errval']['stripe_planid'];
            document.getElementById("edit_package_id").value=id;
            document.getElementById("edit_matrix_id").value='{{$matrix_id}}';


            // Set the response to the content of the #vieweditpackage container
            const targetEl = document.getElementById('editpackage-modal');

            // You can define optional settings here (e.g., animation, auto hide, etc.)
            const options = {
                backdrop: true,    // Controls whether the modal has a backdrop
                keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
                focus: true        // Controls whether the modal will be focused when opened
            };

            // Initialize the modal with Flowbite's Modal constructor
            const modal = new Modal(targetEl, options);
            modal.show();

        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }

    document.addEventListener("DOMContentLoaded", function() {

        const submitAddButton = document.getElementById('submitAddPackageButton');

        submitAddButton.addEventListener('click', async function(e) {
              e.preventDefault();// Prevent the default form submission
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let isValid = true; // Start with true, will set to false if validation fails

            // Validate each field
            isValid = isValid && validateRequiredField('#package_name', '#packagename-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#packagetype', '#packagetype-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#package_paymentmethod1', '#packagepaymentmethod1-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#stripe_planid', '#stripeplanid-error', '#showstripeplanid');
            isValid = isValid && validateRequiredField('#package_paymentgateway1', '#packagepaymentgateway1-error', '#showautosubscription');
            isValid = isValid && validateRequiredField('#package_totaloccurrence', '#packagetotaloccurrence-error', '#showtotaloccurrence');
            isValid = isValid && validateRequiredField('#package_duration1', '#packageduration1-error', '#showdurationdays');
            isValid = isValid && validateRequiredField('#package_grace_period', '#packagegracesperiod-error', '#showgraceperiod');
            isValid = isValid && validateRequiredField('#package_price', '#packageprice-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#package_direct_commission', '#packagedirectcommission-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#package_direct_commission_method', '#packagedirectcommissionmethod-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#package_direct_commission_wallet_type', '#packagedcwallettype-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#package_pv', '#packagepv-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#packagedescription', '#packagedescription-error', '#show_subscription');
            isValid = isValid && validateRequiredField('#taxcode', '#packagetaxcode-error', '#showtaxcode');

            // Repeat validation for other fields...

            if (isValid) {
                // Collect all input values, including file input
                const modal = document.getElementById('addpackage-modal');
                const inputs = modal.querySelectorAll('input, select, textarea');

                // console.log(inputs)

                let dataString = '';
                inputs.forEach(input => {
                    const name = input.name;
                    const value = input.type === 'file' ? input.files[0]?.name : input.value;
                    if (value !== undefined) {
                        dataString += `${encodeURIComponent(name)}=${encodeURIComponent(value)}&`;
                    }
                });

                  // Get Base64 Image from #imagePreview2
                const imageElement = document.getElementById("imagePreview2");
                if (imageElement && imageElement.src.startsWith("data:image")) {
                    dataString += `image_base64=${encodeURIComponent(imageElement.src)}&`;
                }

                dataString = dataString.slice(0, -1); // Remove trailing '&'

                submitAddButton.disabled = true; // Disable button to prevent multiple clicks



                try {
                    const response = await fetch("{{ route('matrix.insertPackage', ['matrix_id' => $matrix_id]) }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded","X-CSRF-TOKEN": csrfToken },
                        body: dataString,
                    });

                    if (!response.ok) throw new Error("Failed to insert data");


                    // Second GET request to fetch updated packages
                    const allPackageResponse = await fetch("{{ route('matrix.allpackage', ['matrix_id' => $matrix_id]) }}", {
                        method: "GET",
                         headers: { "X-CSRF-TOKEN": csrfToken }
                    });

                    if (!allPackageResponse.ok) {
                        throw new Error("Failed to fetch all packages");
                    }
                   const updatedHTML = await allPackageResponse.text();
                    document.getElementById("showallpackage").innerHTML = updatedHTML;
                    // Set the target element for the modal
                    const targetEl = document.getElementById('addpackage-modal');

                    // You can define optional settings here (e.g., animation, auto hide, etc.)
                    const options = {
                        backdrop: true,    // Controls whether the modal has a backdrop
                        keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
                        focus: true        // Controls whether the modal will be focused when opened
                    };

                    // Initialize the modal with Flowbite's Modal constructor
                    const modal = new Modal(targetEl, options);
                    modal.hide();

                    submitAddButton.disabled = false;


                    swal.fire({
                    title: "Package added successfully!",
                    text: "You have successfully added a new package.",
                    icon: "success", // 'success', 'error', 'warning', etc.
                    confirmButtonText: "OK",
                    confirmButtonText: "Yes",
                    customClass: {
                        popup: 'bg-white rounded-lg shadow-lg',
                        title: 'text-xl font-semibold text-black',
                        text: 'text-sm text-black',
                        confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                        cancelButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
                    }})


                    // Fetch updated data or handle success...
                } catch (error) {
                    console.error("Error:", error);
                } finally {
                    submitAddButton.disabled = false; // Re-enable the button
                }
            }
        });

    const submitEditButton = document.getElementById('submitEditPackageButton');

    submitEditButton.addEventListener('click', async function(event) {
        event.preventDefault(); // Prevent the default form submission

        let isValid = true; // Start with true, will set to false if validation fails

        // Validate each field
        isValid = isValid && validateRequiredField('#edit_package_name', '#editpackagename-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_packagetype', '#editpackagetype-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_package_paymentmethod1', '#editpackagepaymentmethod1-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_stripe_planid', '#editstripeplanid-error', '#showeditstripeplanid');
        isValid = isValid && validateRequiredField('#edit_package_paymentgateway1', '#editpackagepaymentgateway1-error', '#showeditautosubscription');
        isValid = isValid && validateRequiredField('#edit_package_totaloccurrence', '#editpackagetotaloccurrence-error', '#showedittotaloccurrence');
        isValid = isValid && validateRequiredField('#edit_package_duration1', '#editpackageduration1-error', '#showeditdurationdays');
        isValid = isValid && validateRequiredField('#edit_package_grace_period', '#editpackagegracesperiod-error', '#showeditgraceperiod');
        isValid = isValid && validateRequiredField('#edit_package_price', '#editpackageprice-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_package_direct_commission', '#editpackagedirectcommission-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_package_direct_commission_method', '#editpackagedirectcommissionmethod-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_package_direct_commission_wallet_type', '#editpackagedcwallettype-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_package_pv', '#editpackagepv-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_packagedescription', '#editpackagedescription-error', '#show_subscription');
        isValid = isValid && validateRequiredField('#edit_taxcode', '#editpackagetaxcode-error', '#showedittaxcode');


        console.log(isValid)
        if (isValid) {

            // Collect all input values, including file input
            const modal = document.getElementById('editpackage-modal');
            const inputs = modal.querySelectorAll('input, select, textarea');

            // Prepare the data string for sending
            let dataString = '';
            inputs.forEach(input => {
                const name = input.name;
                const value = input.type === 'file' ? input.files[0]?.name : input.value; // For file inputs, send the file name
                if (value !== undefined) {
                    dataString += `${encodeURIComponent(name)}=${encodeURIComponent(value)}&`;
                }
            });
            // Get Base64 Image from #imagePreview2
            const imageElement = document.getElementById("editImagePreview2");
            if (imageElement && imageElement.src.startsWith("data:image")) {
                dataString += `image_base64=${encodeURIComponent(imageElement.src)}&`;
            }

            dataString = dataString.slice(0, -1); // Remove the trailing '&'

            // Disable the submit button to prevent multiple submissions
            submitEditButton.disabled = true;
            var entryId = document.getElementById("entryid").value;
            const packageIdElement = document.getElementById("edit_package_id").value;
            const matrixIdElement = document.getElementById("edit_matrix_id").value;


            try {
                // Submit data via Fetch API
                 const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(`{{config('app.ADMINPATH')}}/matrix/updatePackage/${packageIdElement}/${matrixIdElement}`,{
                    method: "POST",
                    headers: {
                         "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: dataString,
                });

                if (!response.ok) {
                    throw new Error("Failed to insert data");
                }


                // Second GET request to fetch updated packages
                const allPackageResponse = await fetch("{{config('app.ADMINPATH')}}/matrix/viewAllPackage/{{$matrix_id}}", {
                    method: "GET",
                });

                if (!allPackageResponse.ok) {
                    throw new Error("Failed to fetch all packages");
                }

                const updatedHTML = await allPackageResponse.text();


                document.getElementById("showallpackage").innerHTML = updatedHTML;
                // Set the target element for the modal
                const targetEl = document.getElementById('editpackage-modal');

                // You can define optional settings here (e.g., animation, auto hide, etc.)
                const options = {
                    backdrop: true,    // Controls whether the modal has a backdrop
                    keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
                    focus: true        // Controls whether the modal will be focused when opened
                };

                // Initialize the modal with Flowbite's Modal constructor
                const modal = new Modal(targetEl, options);
                modal.hide();


                swal.fire({
                    title: "Package updated successfully!",
                    text: "You have successfully added a new package.",
                    icon: "success", // 'success', 'error', 'warning', etc.
                    confirmButtonText: "OK",
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'bg-white rounded-lg shadow-lg', // Customize popup style
                        title: 'text-xl font-semibold text-black', // Customize title style
                        text: 'text-sm text-black', // Customize text style
                        confirmButton: 'bg-neutral-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg', // Customize button style
                        cancelButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                    }
                });


                submitEditButton.disabled = false;

            } catch (error) {
                 console.error("Error:", error);
                // alert("An error occurred while processing your request.");
            } finally {
                // Enable the submit button again in case of error or success
                submitEditButton.disabled = false;
            }
        }
    });
    // Function to close modal
    const closeModal = (modalId) => {
        const targetEl = document.getElementById(modalId);

        // Define optional settings here (e.g., animation, auto hide, etc.)
        const options = {
            backdrop: true,    // Controls whether the modal has a backdrop
            keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
            focus: true        // Controls whether the modal will be focused when opened
        };

        // Initialize the modal with Flowbite's Modal constructor
        const modalInstance = new Modal(targetEl, options);
        modalInstance.hide();
    };

    // Get modal element
    const modal = document.getElementById('editpackage-modal');

    // Get both the close icon and close button
    const closeModalIcon = document.getElementById('closeModalIcon');
    const closeEditModalButton = document.getElementById('closeEditModalButton');

    // Attach event listeners to both close elements, passing the modal ID dynamically
    closeModalIcon.addEventListener('click', () => closeModal('editpackage-modal'));
    closeEditModalButton.addEventListener('click', () => closeModal('editpackage-modal'));


});


function deletePackage (id){

    Swal.fire({
        title: 'Do you want to delete?',
        text: 'Package',
        icon: 'warning', // Use 'icon' instead of 'type'
        showCancelButton: true,
        width: 400,
        heightAuto: false,
        padding: '2.5rem',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'bg-white rounded-lg shadow-lg', // Customize popup style
            title: 'text-xl font-semibold text-black', // Customize title style
            text: 'text-sm text-black', // Customize text style
            confirmButton: 'bg-neutral-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg', // Customize button style
            cancelButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
        }

    }).then(async (result) => {
        if (result.isConfirmed) { // Using isConfirmed instead of value
            try {
                // Perform the delete operation with fetch
             const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const deleteResponse = await fetch(`{{config('app.ADMINPATH')}}/matrix/deletePackage/${id}`, {
                    method: 'DELETE',
                       headers: {
                         "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/x-www-form-urlencoded",

                    },
                });

                if (!deleteResponse.ok) {
                    throw new Error('Failed to delete package');
                }

                // Fetch the updated list of packages after deletion
                const allPackageResponse = await fetch(`{{config('app.ADMINPATH')}}/matrix/viewAllPackage/{{$matrix_id}}`, {
                    method: 'GET',
                });

                if (!allPackageResponse.ok) {
                    throw new Error('Failed to fetch all packages');
                }

                const updatedHTML = await allPackageResponse.text();
                document.getElementById('showallpackage').innerHTML = updatedHTML;

                Swal.fire("Deleted", "The package has been successfully deleted", "success");

            } catch (error) {
                console.error('Error:', error);
                Swal.fire("Error", "Something went wrong", "error");
            }
        }
    });

}

function setPackageLevelCommission(pid) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = `{{config('app.ADMINPATH')}}/matrix/packagelevel/{{$matrix_id}}/${pid}`;
    let currentLevel = 0;

     fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-Token': csrfToken
        },

        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch data");
            }
            return response.json();  // Directly parse the JSON response
        })
        .then(resp => {
            const data = resp.package_commission_settings ?? []; // Default to an empty array if null or undefined
            currentLevel = data.length ?? 0;

            const tableBody = document.getElementById('package-level-table-body');
            tableBody.innerHTML = '';  // Clear any existing rows before adding new ones



            // Append rows for each package commission setting
            if (data.length === 0) {
                // No records available
                const noRecordsRow = document.createElement('tr');
                const noRecordsCell = document.createElement('td');
                noRecordsCell.colSpan = 7;  // Adjust colSpan to 7 for your 7-column table
                noRecordsCell.classList.add('px-6', 'py-4', 'text-center');  // Add the classes for padding and centering
                noRecordsCell.textContent = 'No records available';
                noRecordsRow.appendChild(noRecordsCell);
                tableBody.appendChild(noRecordsRow);
            } else {
                // Append rows for each package commission setting
                data.forEach(item => {
                    createRow(tableBody, item, currentLevel++,pid,'{{config('app.ADMINPATH')}}/matrix/validatepackagelevel','{{config('app.ADMINPATH')}}/matrix/deletepackagelevel',false,'packagelevelcommissions-modal');
                });
            }

            // Handle modal display
            showModal('packagelevelcommissions-modal');

            // Handle add button
            handleAddButton(tableBody, pid, currentLevel,'add-button','{{config('app.ADMINPATH')}}/matrix/validatepackagelevel','{{config('app.ADMINPATH')}}/matrix/deletepackagelevel',false);

            // Update delete button visibility for last row
            updateDeleteButtonVisibility(tableBody);
        })
        .catch(error => console.error("Error:", error));
}

function createRow(tableBody, item, level,pid,saveUrl, deleteUrl, isOneTime,modalId) {

    // level = level === 0 ? 1 : level;


    const rows = tableBody.querySelectorAll('tr'); // Get all rows in the table body
    level = rows.length > 0 ? rows.length + 1 : 1;  // Set the level to the next available number (1 if no rows exist)


     // Remove the "No records available" row if it exists
     const noRecordsRow = tableBody.querySelector('tr td[colspan="7"]');
    if (noRecordsRow) {
        noRecordsRow.parentElement.remove();
    }
    const commissionName = isOneTime ? item.levelcommission_name : item.packagelevelcommission_name;
    const commissionAmount = isOneTime ? item.levelcommission_amount : item.packagelevelcommission_amount;
    const commissionMethod = isOneTime ? item.levelcommission_method : item.packagelevelcommission_method;
    const walletType = isOneTime ? item.levelcommission_wallet_type : item.packagelevelcommission_wallet_type;

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="${level}" readonly></td>
        <td><input type="text" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 w-36" value="${commissionName ?? ''}"></td>
        <td><input type="number" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 w-24" value="${commissionAmount ?? ''}" min="0"></td>
        <td><select class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 w-28">
            <option value="Flat" ${commissionMethod === 'Flat' ? 'selected' : ''}>Flat</option>
            <option value="%" ${commissionMethod === '%' ? 'selected' : ''}>%</option>
        </select></td>
        <td><select class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 w-36">
            <option value="C-Wallet" ${walletType === 'C-Wallet' ? 'selected' : ''}>C-Wallet</option>
            <option value="E-Wallet" ${walletType    === 'E-Wallet' ? 'selected' : ''}>E-Wallet</option>
        </select></td>
        <td> <button type="button" class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-full text-sm p-2 dark:bg-neutral-900 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd"></path>
                                <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
        </td>
        <td><button type="button" class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-full text-sm p-2 dark:bg-neutral-900 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700">
                    <svg class="w-6 h-6  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"></path>
                    </svg>

                    <span class="sr-only">Icon description</span>
                    </button></td>
    `;
    tableBody.appendChild(newRow);

    // Add event listeners for "Save" and "Delete" buttons
    newRow.querySelectorAll('button')[0].addEventListener('click', () => saveRow(newRow,pid,level,saveUrl,tableBody,modalId));
    newRow.querySelectorAll('button')[1].addEventListener('click', () => deleteRow(newRow, pid, level,deleteUrl,tableBody));
}

function saveRow(row,pid,level,saveUrl,tableBody,modalId) {
    const rowInputs = row.querySelectorAll('input, select');
    if (!validateRow(rowInputs)) {
        return;  // If invalid, prevent saving
    }

    const formData = new FormData();
    formData.append('id', rowInputs[0].value);
    formData.append('name', rowInputs[1].value.trim());
    formData.append('commission', rowInputs[2].value.trim());
    formData.append('method', rowInputs[3].value.trim());
    formData.append('wallet', rowInputs[4].value.trim());
    formData.append('matrixid', '{{$matrix_id}}');
    formData.append('pid', pid);
 const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(saveUrl, {
    method: 'POST',
    headers: {
        "X-CSRF-TOKEN": csrfToken
            },
            body: formData
        })
        .then(response => response.text())
        .then(resp => {
            swal.fire({
                title: "Level commission added successfully!",
                text: "You have successfully added a new package level commission.",
                icon: "success",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    text: 'text-sm text-black',
                    confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                    cancelButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
                }
            });
            row.querySelector('button').disabled = true;  // Disable the save button after saving
            // Close the modal
            closeModal(modalId);

        })
        .catch(error => console.error("Error:", error));
}


function deleteRow(row, pid, level,deleteUrl,tableBody) {
    swal.fire({
        title: "Are you sure?",
        text: "You are about to delete this level commission.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            popup: 'bg-white rounded-lg shadow-lg',
            title: 'text-xl font-semibold text-black',
            text: 'text-sm text-black',
            confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
            cancelButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
        }
    }).then(result => {
        if (result.isConfirmed) {
            row.remove();
            const rows = tableBody.querySelectorAll('tr'); // Get all rows in the table body
            if (rows.length === 0) { // If no rows are left
                const noRecordsRow = document.createElement('tr');
                noRecordsRow.innerHTML = `<td colspan="7" class="text-center p-4">No records available</td>`;
                tableBody.appendChild(noRecordsRow);
            }

            const formData = new FormData();
            formData.append('id', level);
            formData.append('matrix_id', '{{$matrix_id}}');
            formData.append('package_id', pid);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(deleteUrl, {
                 method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                        },
                        body: formData
                    })
                .then(response => response.text())
                .then(resp => console.log("Row deleted:", resp))
                .catch(error => console.error("Error:", error));
        }
    });
}

function handleAddButton(tableBody, pid,currentLevel,buttonId,saveUrl, deleteUrl, isOneTime) {

    const addButton = document.getElementById(buttonId);
    const noDataRow = document.getElementById('no-data-row');

    if (noDataRow) noDataRow.remove();

    addButton.addEventListener('click', event => {
        event.preventDefault();
        const lastRowInputs = tableBody.querySelectorAll('tr:last-child input, tr:last-child select');
        if (!validateRow(lastRowInputs)) {
            swal.fire({
                title: "Please fix the errors in the last row before adding a new one",
                text: "Level Commission",
                icon: "error",
                customClass: {
                    popup: 'bg-white rounded-lg shadow-lg',
                    title: 'text-xl font-semibold text-black',
                    text: 'text-sm text-black',
                    confirmButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
                    cancelButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
                }
            });
            return;  // Do not add a new row if the last row is invalid
        }

        createRow(tableBody, {}, currentLevel++,pid,saveUrl, deleteUrl, isOneTime);  // Create and append a new row
        updateDeleteButtonVisibility(tableBody);
    });
}

function validateRow(inputs) {
    let isValid = true;
    inputs.forEach(input => {
        input.classList.remove('border-red-500');  // Reset the border color
        if (input.type === 'text' && input.value.trim() === '') {
            isValid = false;
            input.classList.add('border-red-500');
        } else if (input.type === 'number' && (isNaN(input.value) || input.value <= 0)) {
            isValid = false;
            input.classList.add('border-red-500');
        }
    });
    return isValid;
}

function updateDeleteButtonVisibility(tableBody) {
    const rows = tableBody.querySelectorAll('tr');
    rows.forEach((row, index) => {
        const deleteButton = row.querySelectorAll('td button')[1];
        if (deleteButton) {
            deleteButton.style.display = index === rows.length - 1 ? 'inline-block' : 'none';
        }
    });
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        // console.error(`Modal with ID ${modalId} does not exist.`);
        return;
    }
    const modalInstance = new Modal(modal, { backdrop: true, keyboard: true });
    modalInstance.show();
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalInstance = new Modal(modal, { backdrop: true, keyboard: true });
    modalInstance.hide();
}


function toggleOnetimeLevelCommission(){
    const checkbox = document.getElementById('level_commisison_status');
        const elementsOnFields = document.getElementById('onetime_level_on_fields');

        // Toggle visibility based on checkbox status
        if (checkbox.checked) {
            elementsOnFields.classList.remove('hidden');
        } else {
            elementsOnFields.classList.add('hidden');
        }

}
function setOneTimeLevelCommission() {

    const url = `{{config('app.ADMINPATH')}}/matrix/level/{{$matrix_id}}`;
    let currentLevel = 0;
    let pid=0;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'GET',
        headers: {

            'X-CSRF-Token': token
        },

        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch data");
            }
            console.log(response);
            return response.json();  // Directly parse the JSON response
        })
        .then(resp => {
            const data = resp.level_commission_settings ?? []; // Default to an empty array if null or undefined
            currentLevel = data.length ?? 0;


            const tableBody = document.getElementById('onetime-level-table-body');
            tableBody.innerHTML = '';  // Clear any existing rows before adding new ones

            // Append rows for each package commission setting
            if (data.length === 0) {
                // No records available
                const noRecordsRow = document.createElement('tr');
                const noRecordsCell = document.createElement('td');
                noRecordsCell.colSpan = 7;  // Adjust colSpan to 7 for your 7-column table
                noRecordsCell.classList.add('px-6', 'py-4', 'text-center');  // Add the classes for padding and centering
                noRecordsCell.textContent = 'No records available';
                noRecordsRow.appendChild(noRecordsCell);
                tableBody.appendChild(noRecordsRow);
            } else {
                // Append rows for each package commission setting
                data.forEach(item => {
                    createRow(tableBody, item, currentLevel++,pid,'{{config('app.ADMINPATH')}}/matrix/validatelevel',
                    '{{config('app.ADMINPATH')}}/matrix/deletelevel',
                    true,'onetimelevelcommissions-modal');
                });
            }

            // Handle modal display
            showModal('onetimelevelcommissions-modal');

            // Handle add button
            handleAddButton(tableBody, pid, currentLevel,'add-onetime-button','{{ config('app.ADMINPATH')}}/matrix/validatelevel',
                    '{{ config('app.ADMINPATH')}}/matrix/deletelevel',
                    true);

            // Update delete button visibility for last row
            updateDeleteButtonVisibility(tableBody);
        })
        .catch(error => console.error("Error:", error));

}

function updateSubscription(id){

    fetch('{{env('ADMINPATH')}}/matrix/updatesubscription/'+id+ '/'+'{{$matrix_id}}', {
        method: 'GET'
    })
    .then(response => response.json())
    .then(resp => {

        const errval = resp.errval || {};
        const pack_payment_fields=resp.pack_payment_fields
        const pack_payment=resp.pack_payment

        // console.log(resp)
        // console.log('errval')
        // console.log(pack_payment_fields)

        // console.log('errval')

        // console.log('pack_payment_fields')
        if(pack_payment.stripe=='1')
        {
            document.getElementById("subscription_package_id").value = id;

            if (pack_payment_fields.stripe && pack_payment_fields.stripe.interval_selector) {
                document.getElementById('stripe_interval').innerHTML = pack_payment_fields.stripe.interval_selector;
                document.getElementById('stripe_trial_period').innerHTML = pack_payment_fields.stripe.trial_period_days;

                document.getElementById('showsetstripecontent').classList.add('hidden');
                document.getElementById('showgetstripecontent').classList.remove('hidden');
            } else {
                document.getElementById('showsetstripecontent').classList.remove('hidden');
                document.getElementById('showgetstripecontent').classList.add('hidden');
            }

            showModal('showupdatesubscription-modal');


        }
        if(pack_payment.chargebee=='1')
        {
            showModal('showupdatesubscription-modal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function submitStripeSubButton() {
    // Get the values of the form fields
    const intervalSelector = document.getElementById('interval_selector').value;
    const trialPeriodDays = document.getElementById('trial_period_days').value;
    const subPackageId=document.getElementById("subscription_package_id").value


    // Create a FormData object or a plain object
    const formData = new FormData();
    formData.append('interval_selector', intervalSelector);
    formData.append('trial_period_days', trialPeriodDays);
    formData.append('subscription_package_id', subPackageId);
    // You can log the data to see what is being sent
    // console.log('Form Data:', { interval: intervalSelector, trial_period_days: trialPeriodDays,subscription_package_id:subPackageId });

    // console.log(subPackageId);



    // Perform an AJAX request (using fetch)
    fetch('{{env('ADMINPATH')}}/matrix/updatesubpackagepay/'+subPackageId,{
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Handle the response data here
        console.log('Response:', data);
        closeModal('showupdatesubscription-modal'); // Close the modal after submission
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function submitChargebeeSubButton(){
 // Get the values of the form fields
    const intervalSelector = document.getElementById('interval_selector_chargebee').value;
    const trialPeriodDays = document.getElementById('trial_period_days_chargebee').value;

    // Create a FormData object or a plain object
    const formData = new FormData();
    formData.append('interval_selector_chargebee', intervalSelector);
    formData.append('trial_period_days_chargebee', trialPeriodDays);

    // You can log the data to see what is being sent
    console.log('Form Data:', { interval: intervalSelector, trial_period_days: trialPeriodDays });
    const subPackageId=document.getElementById("subscription_package_id").value
    // Perform an AJAX request (using fetch)
    fetch('{{env('ADMINPATH')}}/matrix/updatesubpackagepay/'+subPackageId,{
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Handle the response data here
        console.log('Response:', data);
        closeModal('showupdatesubscription-modal'); // Close the modal after submission
    })
    .catch(error => {
        console.error('Error:', error);
    });

}
function validateTrialPeriod(input) {
    const minValue = parseInt(input.getAttribute('min')) || 1;
    if (input.value === '' || parseInt(input.value) < minValue) {
        input.value = minValue; // Reset to minimum value
    }
}

function validateAndSubmit() {
    const isValid = validateTab('commission-setting');
    if (isValid) {
        document.getElementById('planForm').submit();
    } else {
        console.log('Form validation failed. Please correct the errors.');
    }
}


</script>


