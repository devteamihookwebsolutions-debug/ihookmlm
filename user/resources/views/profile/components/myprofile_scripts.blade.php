<script>
   
    var loadFile = function(event) {
        var input = event.target;
        var file = input.files[0];
        var type = file.type;
        // Get the preview ID from the data-preview-id attribute
        var previewId = input.getAttribute('data-preview-id');
        var output = document.getElementById(previewId);
        if (output) {
            output.src = URL.createObjectURL(file);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // free memory
            }
        } else {
            console.error("Preview element not found for ID:", previewId);
        }
    };
    const FORM_CONFIG = {
        REQUIRED_PATTERNS: {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^\d{10}$/,
            cardnumber: /^[0-9]{13,19}$/,       // 13 to 19 digit numbers
    card_month: /^(0[1-9]|1[0-2])\/\d{2}$/, // MM/YY format, optional improvement
    card_cvv: /^[0-9]{3,4}$/,  
            // Add more fields as needed
        },
    };
    class FormHandler {
        constructor(formId) {
            this.form = document.getElementById(formId);
            this.attachEventListeners();
        }
        attachEventListeners() {
            this.form?.addEventListener('submit', (e) => this.handleSubmit(e));
            // Real-time validation
            this.form.querySelectorAll('input[required], select[required]').forEach((input) => {
                input.addEventListener('input', () => this.validateInput(input));
            });
        }
        validateInput(input) {
            const value = input.value.trim();
            const pattern = FORM_CONFIG.REQUIRED_PATTERNS[input.name];
            const errorElement = document.getElementById(input.getAttribute('aria-describedby'));
            let isValid = true;

             
            if (!value && input.hasAttribute('required')) {
                isValid = false;
                this.showError(input, errorElement, 'This field is required.');
            } else if (pattern && !pattern.test(value)) {
                isValid = false;
                this.showError(input, errorElement, 'Invalid format.');
            } else {
                this.clearError(input, errorElement);
            }

            if (input.name === 'cardnumber') {
        value = value.replace(/\s+/g, ''); // remove all spaces
    }
            if (!value && input.hasAttribute('required')) {
    isValid = false;
    this.showError(input, errorElement, 'This field is required.');
} else if (pattern && !pattern.test(value)) {
    let customMessage = 'Invalid format.';
    if (input.name === 'cardnumber') customMessage = 'Card number must be 16 digits.';
    else if (input.name === 'card_month') customMessage = 'Use MM/YY format.';
    else if (input.name === 'card_cvv') customMessage = 'CVV must be 3 or 4 digits.';
    
    isValid = false;
    this.showError(input, errorElement, customMessage);
}
            return isValid;
        }
        showError(input, errorElement, message) {
            input.classList.add('border-red-500');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }
        }
        clearError(input, errorElement) {
            input.classList.remove('border-red-500');
            if (errorElement) {
                errorElement.classList.add('hidden');
            }
        }
        handleSubmit(e) {
            e.preventDefault();
            const inputs = Array.from(this.form.querySelectorAll('input[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));
            if (allValid) {
                this.form.submit();
            } else {
                console.error('Form validation failed.');
            }
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        new FormHandler('showMyProfileDetails');
        new FormHandler('saveAccountInfo');
        new FormHandler('showMyPasswordDetails');
        new FormHandler('updatecarddetails');
        new FormHandler('showMyTransaccPass');
        new FormHandler('saveTaxInformation');
        new FormHandler('showMyAvatarDetails');
        new FormHandler('updateaddress');
        new FormHandler('websiteibo');
        new FormHandler('social');
    });

    function showTab(tabId) {
        // Hide all tab content
        const tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.classList.remove('active');
            tab.classList.add('hidden');
        });

        // Show the selected tab content
        const selectedTab = document.getElementById(tabId);
        if (selectedTab) {
            selectedTab.classList.add('active');
            selectedTab.classList.remove('hidden');
        }
    }

    document.getElementById('members_country').addEventListener('change', function() {
        var countryCODE = this.value;
        if (countryCODE) {
            fetch('{{$_ENV['FCPATH']}}/getstates', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'country_code=' + encodeURIComponent(countryCODE),
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('members_state').innerHTML = html;
                })
                .catch(error => {
                    console.log('Error fetching states:', error);
                });
        } else {
            document.getElementById('members_state').innerHTML =
                "<option value=''>{{ __('Select country first') }}</option>";
        }
    });

    document.getElementById('members_country_1').addEventListener('change', function() {
        var countryCODE = this.value;
        if (countryCODE) {
            fetch(`{{$_ENV['FCPATH']}}/getstates`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'country_code=' + encodeURIComponent(countryCODE),
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('members_state_1').innerHTML = html;
                })
                .catch(error => {
                    console.log('Error fetching states:', error);
                });
        } else {
            document.getElementById('members_state_1').innerHTML =
                "<option value=''>{{ __('Select country first') }}</option>";
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        let countryDropdown = document.getElementById("members_country_1");
        // let state_id = document.getElementById('members_hidden_state').value;
        if (countryDropdown) {
            let countryCODE = countryDropdown.value;
            
            if (countryCODE) {
                fetch("{{$_ENV['FCPATH']}}/getstates", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "country_code=" + encodeURIComponent(countryCODE) + "&state_id=" + encodeURIComponent(state_id)
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById("members_state_1").innerHTML = html;
                })
                .catch(error => console.log("Error fetching states:", error));
            }
        }
    });
    

    function showAvatarGallery() {
        fetch(`{{ $_ENV['FCPATH'] }}/myprofile/getavatar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // or 'application/json' if needed
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('showavatargallery').innerHTML = html;
    
            // Show the modal (Bootstrap 5 assumed)

            // Set the response to the content of the #vieweditpackage container
            const targetEl = document.getElementById('crud-modal');

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
            console.error('Error loading avatar gallery:', error);
        });
    }

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

     document.addEventListener("DOMContentLoaded", function () {
    const cardNumberInput = document.getElementById("cardnumber");
    const expiryInput = document.getElementById("expirationdate");
    const cvvInput = document.getElementById("securitycode");

    cardNumberInput.addEventListener("input", function (e) {
        let value = this.value.replace(/\D/g, "").substring(0, 16); 
        this.value = value.replace(/(\d{4})(?=\d)/g, "$1 ");
    });

   
   expiryInput.addEventListener("input", function () {
    let raw = this.value.replace(/\D/g, "").substring(0, 4);
    if (raw.length >= 3) {
        const mm = raw.substring(0, 2);
        const yy = raw.substring(2);

        // Format
        this.value = mm + "/" + yy;

        // Validation
        const month = parseInt(mm, 10);
        const year = parseInt("20" + yy, 10); // e.g., '25' => 2025

        const now = new Date();
        const currentMonth = now.getMonth() + 1;
        const currentYear = now.getFullYear();

        const expiryError = document.getElementById("cardexp-error");

        if (month < 1 || month > 12 || year < currentYear || (year === currentYear && month < currentMonth)) {
            expiryError.classList.remove("hidden");
        } else {
            expiryError.classList.add("hidden");
        }

    } else {
        this.value = raw;
    }
});

 
    cvvInput.addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, "").substring(0, 4);
    });

   
    expiryInput.addEventListener("blur", function () {
        const regex = /^(0[1-9]|1[0-2])\/\d{2}$/;
        const error = document.getElementById("cardexp-error");
        if (!regex.test(this.value)) {
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });

    cardNumberInput.addEventListener("blur", function () {
        const digitsOnly = this.value.replace(/\s/g, '');
        const error = document.getElementById("cardnumber-error");
        if (digitsOnly.length < 13 || digitsOnly.length > 16) {
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });

    cvvInput.addEventListener("blur", function () {
        const val = this.value;
        const error = document.getElementById("cardcvv-error");
        if (val.length < 3 || val.length > 4) {
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });
});



</script>