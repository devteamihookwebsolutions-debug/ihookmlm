<script>
        // Global Variables
        let currentStep = 1; // Current step
        const totalSteps = 5; // Total number of steps
        let selectedCart = null; // Selected cart ID
        const nextBtn = document.getElementById('nextBtn');

    // Ensure the script runs only after DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        const cart_default_id = {{$cartconfigs['cart_id'] ?? 0}};
        if (cart_default_id && cart_default_id != 0) {
            setcartconfig(cart_default_id);
        }
    });

        // Function to show the current step content
        function showStep(stepNumber) {
            // Toggle visibility of step content
            document.querySelectorAll('.step-content').forEach((content, index) => {
                content.classList.toggle('hidden', index !== stepNumber - 1);
            });

           // Update stepper styles
            for (let i = 1; i <= totalSteps; i++) {
                const stepIndicator = document.getElementById(`step-header-${i}`).querySelector('div');

                // For completed steps
                if (i < stepNumber) {
                    stepIndicator.classList.add('bg-neutral-900');
                    stepIndicator.classList.remove('bg-neutral-500', 'bg-neutral-300');
                }
                // For the current step
                else if (i === stepNumber) {
                    stepIndicator.classList.add('bg-neutral-500', 'text-white');
                    stepIndicator.classList.remove('bg-neutral-900', 'bg-neutral-300');
                }
                // For remaining steps (including the last step)
                else {
                    stepIndicator.classList.add('bg-neutral-300', 'text-black');
                    stepIndicator.classList.remove('bg-neutral-500', 'bg-neutral-900');
                }

                // Ensure the last step gets bg-neutral-900 if it's finished
                if (i === totalSteps && i <= stepNumber) {
                    stepIndicator.classList.add('bg-neutral-900');
                    stepIndicator.classList.remove('bg-neutral-500');
                }
            }


            // Update button states
            document.getElementById('prevBtn').disabled = stepNumber === 1;
            // document.getElementById('nextBtn').textContent = stepNumber === totalSteps ? 'Finish' : 'Next';
        }

        // Function to handle navigation between steps
        // function changeStep(direction) {
        //     if (currentStep + direction > 0 && currentStep + direction <= totalSteps) {
        //         currentStep += direction;
        //         showStep(currentStep);


        //         if (currentStep === 2 || currentStep === 3 || currentStep === 4) {
        //             toggleFormVisibility(selectedCart, currentStep);
        //         }


        //         if (currentStep === 5) {
        //             showSuccessMessage(selectedCart);
        //         }
        //     }

        // }

        // Function to handle cart selection

        function setcartconfig(cartId) {

            // Deselect all cart items
            document.querySelectorAll('.group').forEach(cart => {
                cart.classList.remove('bg-neutral-200', 'border-neutral-500');
            });
            document.getElementById('cart_id').value = cartId;
            // Highlight the selected cart
            const selectedCartElement = document.getElementById('cart_id' + cartId);
            if (selectedCartElement) {
                selectedCartElement.classList.add('bg-neutral-200', 'border-neutral-500');
            }

            // Store selected cart and enable "Next" button
            selectedCart = cartId;
            document.getElementById('nextBtn').disabled = false;
        }

        // Toggle visibility of forms based on cart ID and current step
        function toggleFormVisibility(cartId, step) {
            const stepPrefixes = {
                2: 'cart-settings-form',
                3: 'api-access-form',
                4: 'modules-form'
            };

            const stepPrefix = stepPrefixes[step];
            if (!stepPrefix) return;

            const cartForms = document.querySelectorAll(`.${stepPrefix}`);
            cartForms.forEach(form => form.classList.add('hidden'));

            if (cartId) {
                const formId = getCartFormId(cartId, stepPrefix);
                const targetForm = document.getElementById(formId);
                if (targetForm) {
                    targetForm.classList.remove('hidden');
                } else {
                    console.error(`Form with ID ${formId} not found.`);
                }
            }
        }

        // Get the form ID based on cartId and step prefix
        function getCartFormId(cartId, prefix) {
            switch (cartId) {
                case 1:
                    return prefix === 'cart-settings-form' ? 'woocommerce-form' : prefix === 'api-access-form' ? 'woocommerce-api-form' : 'woocommerce-modules-form';
                case 2:
                    return prefix === 'cart-settings-form' ? 'shopify-form' : prefix === 'api-access-form' ? 'shopify-api-form' : 'shopify-modules-form';
                case 3:
                    return prefix === 'cart-settings-form' ? 'cscart-form' : prefix === 'api-access-form' ? 'cscart-api-form' : 'cscart-modules-form';
                default:
                    return null;
            }
        }

        // Function to display success message for Step 5
        function showSuccessMessage(cartId) {
            const successMessages = {
                1: 'WooCommerce setup completed successfully!',
                2: 'Shopify setup completed successfully!',
                3: 'CS-Cart setup completed successfully!'
            };

            const successContainer = document.getElementById('step5-success-message');
            successContainer.innerHTML = `<div class="p-6  text-center">
            <h3 class="text-2xl font-bold text-black sm:text-3xl dark:text-neutral-200">Congrats !</h3>
            <p class="mt-4 text-black sm:text-lg dark:text-neutral-200">${successMessages[cartId] || 'Setup completed successfully!'}</p>
        </div>`;
        }


        // Initialize the first step
        showStep(currentStep);
document.querySelector('#testwooconnection').addEventListener('click', async function () {
    const woocommercePath   = document.querySelector('#woocommerce_path').value.trim();
    const woocommerceSecret = document.querySelector('#woocommerce_secret').value.trim();
    const woocommerceKey    = document.querySelector('#woocommerce_key').value.trim();

    if (!woocommercePath || !woocommerceSecret || !woocommerceKey) {
        Swal.fire({
            title: 'Missing Data',
            text: 'Please fill in all WooCommerce credentials.',
            icon: 'warning',
        });
        return;
    }

    try {
        const response = await fetch("{{ route('cartconfig.testwooconnection') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: new URLSearchParams({
                woocommerce_path: woocommercePath,
                woocommerce_secret: woocommerceSecret,
                woocommerce_key: woocommerceKey,
            }),
            credentials: 'include'
        });

        const data = await response.json();

        if (response.ok && data.status === 'success') {
            Swal.fire({
                title: 'WooCommerce Connection',
                text: 'WooCommerce Connection SuccessFully!!!',
                icon: 'success',
                customClass: {
                    popup: 'bg-white-100 text-green-900 border border-green-300 rounded-lg shadow-lg',
                    title: 'text-lg font-semibold',
                    confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded',
                },
            });
        } else {
            // Show API error message from WooCommerce
            const errorMsg = data.message || JSON.stringify(data) || 'An error occurred';
            Swal.fire({
                title: 'Error',
                text: errorMsg,
                icon: 'error',
                customClass: {
                    popup: 'bg-white-100 text-red-900 border border-red-300 rounded-lg shadow-lg',
                    title: 'text-lg font-semibold',
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded',
                },
            });
        }

    } catch (error) {
        console.error('Test connection error:', error);
        Swal.fire({
            title: 'Error',
            text: 'An unexpected error occurred.',
            icon: 'error',
            customClass: {
                popup: 'bg-red-100 text-red-900 border border-red-300 rounded-lg shadow-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded',
            },
        });
    }
});


document.getElementById("testsyconnection").addEventListener("click", function () {
    const shopName = document.getElementById("shop_name").value;
    const apiKey = document.getElementById("api_key").value;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('cartconfig.testsyconnection') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": token
        },
        body: `shop_name=${encodeURIComponent(shopName)}&api_key=${encodeURIComponent(apiKey)}`
    })
    .then(response => response.text())
    .then(resp => {
        const response = resp.trim();
        if (response.toLowerCase().includes("successfully")) {
            Swal.fire({
                title: "Shopify Connection",
                text: response,
                icon: "success",
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "bg-green-500 text-white rounded-lg px-4 py-2 hover:bg-green-600 focus:outline-none"
                }
            });
        } else {
            Swal.fire({
                title: "Error",
                text: response,
                icon: "error",
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "bg-red-500 text-white rounded-lg px-4 py-2 hover:bg-red-600 focus:outline-none"
                }
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: "Error",
            text: "An error occurred while connecting.",
            icon: "error",
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "bg-red-500 text-white rounded-lg px-4 py-2 hover:bg-red-600 focus:outline-none"
            }
        });
        console.error("Connection error:", error);
    });
});

    // Initialize the form element and error messages
  //  const form = document.getElementById('woocommerce_sec1');
   // const errorMessages = document.querySelectorAll('.error-message');

    // Reset error messages
    function resetErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach((error) => {
        error.classList.add('hidden');
    });
}
    // Show error message
    function showError(input, message) {
        // alert(message);

    const errorElement = document.getElementById(input.id + '-error');
    if (errorElement) {
        // alert(errorElement);
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        input.classList.add('border-red-500');  // Tailwind border for error state
    }
}


    // Validate the form
    function validateStep2Form() {
        let isValid = true;
        // alert(5);
        // alert(selectedCart);
    if (selectedCart == 1) {
        isValid = validateCartForm("woocommerce_sec1");
    } else if (selectedCart == 2) {
        isValid = validateCartForm("shopify_sec1");  // Ensure this points to the correct form
    }
    else if (selectedCart == 3) {
        isValid = validateCartForm("cscart_sec");  // Ensure this points to the correct form
    }
    console.log("Step 2 validation isValid:", isValid);
    return isValid;
}
function validateCartForm(formId) {
    // alert(formId);
    let isValid = true;
    resetErrors(); // Reset any previous errors

    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required]');

    // Loop through all required inputs and validate
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            // alert('error');
            // alert(input);
            showError(input, `${input.previousElementSibling.textContent} is required.`);
        } else {
            input.classList.remove('border-red-500');  // Remove error styling
        }
    });

    console.log("ISvalid for form", formId, ":", isValid);
    return isValid;
}

    // Show error message for selectedCart
    function showSelectedCartError(message) {
        selectedCartError.textContent = message;
        selectedCartError.classList.remove('hidden');
    }

    // Validate the form for Step 1
    function validateStep1Form() {
        let isValid = true;
        resetErrors(); // Reset any previous errors

        // Check if selectedCart is null
        if (selectedCart === null) {
            isValid = false;
            showSelectedCartError("Please choose an option.");
        }
        console.log("Step 1 validation isValid:", isValid);
        return isValid;
    }
    function validateForm() {
    let isValid = true;

    // Check validation based on the current step
    if (currentStep === 1) {
        isValid = validateStep1Form(); // Step 1 validation
    } else if (currentStep === 2) {
        isValid = validateStep2Form(); // Step 2 validation
    } else {
        isValid = true; // Fixed typo here, make sure it's 'isValid'
    }

    console.log("isValid returning:", isValid);
    return isValid;
}


    // Handle the step change with validation
    function changeStep(direction) {
        console.log("validateForm:", validateForm);

        if (currentStep + direction > 0 && currentStep + direction <= totalSteps) {

            if (!validateForm()) {

                return; // Stop the step change if form is not valid
            }

            currentStep += direction;
            showStep(currentStep);

              // Change button text to 'Finish' on the last step
        nextBtn.textContent = currentStep === totalSteps ? 'Finish' : 'Next';
        if (currentStep === totalSteps) {
            nextBtn.addEventListener('click', handleSubmit);
        } else {
            nextBtn.removeEventListener('click', handleSubmit);
        }

            console.log("currentStep:", currentStep, "direction:", direction);


            if (currentStep > 1 && selectedCartError) {
            selectedCartError.classList.add('hidden');
        }

            // Dynamically handle form visibility at Step 2, Step 3, and Step 4
            if (currentStep === 2 || currentStep === 3 || currentStep === 4) {
                toggleFormVisibility(selectedCart, currentStep);
            }

            // Handle success display for Step 5
            if (currentStep === 5) {
                showSuccessMessage(selectedCart);
            }
        }
    }


function handleSubmit() {
    const cartIdInput = document.getElementById('cart_id');
    const cartids = cartIdInput.value.trim();  // cleaner

    console.log("cartid:", cartids);
    // No need to set cartIdInput.value again — it's already set

    const inputs = document.querySelectorAll('#wholecartdata input, #wholecartdata select');

    let formData = {};

    inputs.forEach(input => {
        if (input.type === 'checkbox') {
            formData[input.name] = input.checked ? input.value : '';
        } else if (input.type === 'radio') {
            if (input.checked) {
                formData[input.name] = input.value;
            }
        } else {
            formData[input.name] = input.value;
        }
    });

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!csrfToken) {
        console.error("CSRF token not found in meta tag");
        // Optionally alert or show error to user
        return;
    }

    fetch('{{ $_ENV['BCPATH'] }}/cartconfig/completecart', {  // or use route('cartconfig.completecart') if named
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,          // ← This is the key line
            'Accept': 'application/json'         // good to have
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        console.log("Status:", response.status, response.statusText);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`Server error ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log("Success response:", data);
        if (cartids === "1" || cartids === "3") {
            window.location.href = '{{ $_ENV['BCPATH'] }}/cartconfig';
        } else {
            window.location.href = '{{ $_ENV['BCPATH'] }}/shopifyconf';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        // Better UX: show toast/alert with error.message
        // alert('Failed to save cart configuration: ' + error.message);
    });
}
</script>
