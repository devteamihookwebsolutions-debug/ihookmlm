<script>

function goToPreviousTab(currentTab, previousTab) {
    console.log(`Going back from ${currentTab} to ${previousTab}`);

    // Hide the current tab
    document.getElementById(currentTab).classList.add('hidden');

    // Show the previous tab
    document.getElementById(previousTab).classList.remove('hidden');

    // Update button styles (if applicable)
    updateTabStyles(previousTab);
}

function goToNextTab(currentTab, nextTab) {
    console.log(`Going forward from ${currentTab} to ${nextTab}`);

    // Validate current tab if necessary
    const isValid = validateTab(currentTab);
    if (!isValid) {
        console.warn('Validation failed on', currentTab);
        return;
    }

    // Hide the current tab
    document.getElementById(currentTab).classList.add('hidden');

    // Show the next tab
    document.getElementById(nextTab).classList.remove('hidden');

    // Update button styles (if applicable)
    updateTabStyles(nextTab);
}

function validateTab(tabId) {


    console.log(tabId)
    // Define validation logic for each tab
    if (tabId === 'plan-name') {
        return validateRequiredField('#searchbox', '#defaultmembersid-error');
    }
    if (tabId === 'entry-criteria') {
        const isValid = validateAllEntryCriteria();
        return isValid; // Return the final result of all validations
    }
    if (tabId === 'commission-setting') {
        const isValid = validateAllCommissionSetting();

        console.log(isValid)
        if (isValid) {
            // Find and submit the form if validation passes
            document.getElementById('planForm').submit();  // Replace 'yourFormID' with the actual form ID
        }
        return isValid; // Return the final result of all validations
    }
    // Add validation for other tabs as needed
    return true;
}
// Function to validate all fields in the entry-criteria tab
function validateAllEntryCriteria() {
    let isValid = true;

    // Validate each field
    isValid = isValid && validateRequiredField('#registration_fee', '#registrationfee-error', '#show_one_time_registration');
    isValid = isValid && validateRequiredField('#registration_pv', '#registrationpv-error', '#show_one_time_registration');
    isValid = isValid && validateRequiredField('#onetime_reigster_taxcode', '#onetimereigstertaxcode-error', '#show_one_time_registration');
    isValid = isValid && validateRequiredField('#chargebee_plan_name', '#chargebeeplanname-error', '#show_one_time_registration');
    isValid = isValid && validateRequiredField('#direct_referrel_commission', '#directreferrelcommission-error', '#dr_on_fields');
    isValid = isValid && validateRequiredField('#direct_referrel_commission_wallet_type', '#directreferrelcommissionwallettype-error', '#dr_on_fields');
    
    // Return whether all validations passed
    return isValid;
}
// Function to validate all fields in the entry-criteria tab
function validateAllCommissionSetting() {
    let isValid = true;

    // Validate each field
    isValid = isValid && validateRequiredField('#joining_commission', '#joiningcommission-error', '#join_on_fields');
    isValid = isValid && validateRequiredField('#join_commission_wallet_type', '#joincommissionwallettype-error', '#join_on_fields');
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


    // Return whether all validations passed
    return isValid;
}

// Helper function to validate a required input field
function validateRequiredField(inputSelector, errorSelector, parentSelector = null) {
    const inputField = document.querySelector(inputSelector);
    const errorMessage = document.querySelector(errorSelector);
    const inputValue = inputField?.value.trim();


    // Move up one div from the input field
    const parentDiv = parentSelector ? document.querySelector(parentSelector) : null;

    // If the parent div is hidden, skip validation
    if (parentDiv && parentDiv.classList.contains('hidden')) {
        return true; // Skips validation if parent div is hidden
    }
    
    if (!inputValue) {
        // Show error message and apply error styling
        errorMessage.classList.remove('hidden');
        inputField?.classList.add('border-red-500');
       
        return false;
    } else {
        // Hide error message and reset styling
        errorMessage.classList.add('hidden');
        inputField?.classList.remove('border-red-500');
        
        return true;
    }
}
// Event listener for real-time validation while typing
document.addEventListener('input', function(event) {
    if (event.target.matches('#searchbox, #registration_fee')) {
        const tabId = event.target.closest('.tab-content').id;
        validateTab(tabId);
    }
});


function updateTabStyles(activeTabId) {
    // Reset all tab button styles
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.classList.remove('bg-neutral-900', 'text-white');
        button.classList.add('bg-neutral-200','bg-neutral-50','text-black');
    });

    // Set active styles for the current tab
    const activeTab = document.getElementById(`tab-${activeTabId}`);
    activeTab?.classList.add('bg-neutral-900', 'text-white');
    activeTab?.classList.remove('bg-neutral-200','bg-neutral-50', 'text-black');
}


        function showMembersAccount(accountID) {

            // First, hide all sections
            document.getElementById('show_freemembership').classList.add('hidden');
            document.getElementById('show_paidmembership').classList.add('hidden');
            document.getElementById('show_free_entryupgrade').classList.add('hidden');

            // Show the corresponding section based on the accountID
            if (accountID == '1') {
                document.getElementById('show_freemembership').classList.remove('hidden');
            } else if (accountID == '2') {
                document.getElementById('show_paidmembership').classList.remove('hidden');
            } else if (accountID == '3') {
                document.getElementById('show_free_entryupgrade').classList.remove('hidden');
            }
        }
        function toggleRegistrationSubscription(){

            const checkbox = document.getElementById('members_paid_account_type');
            if (checkbox.checked) {  
                document.getElementById('show_one_time_registration').classList.add('hidden');
                document.getElementById('show_subscription').classList.remove('hidden');
                
            } else {
                           
                document.getElementById('show_one_time_registration').classList.remove('hidden');
                document.getElementById('show_subscription').classList.add('hidden');
            }

        }
        function toggleDirectReferralCommission(){

            const checkbox = document.getElementById('direct_referrel_commission_status');
            if (checkbox.checked) {               
                document.getElementById('dr_on_fields').classList.remove('hidden');
            } else {
                document.getElementById('dr_on_fields').classList.add('hidden');
               
            }
        }
        function toggleSubRegistration(){

            const checkbox = document.getElementById('register_fee_status');
            if (checkbox.checked) {               
                document.getElementById('sub_register_fee_on_fields').classList.remove('hidden');
            } else {
                document.getElementById('sub_register_fee_on_fields').classList.add('hidden');
            
            }
        }
        
  
          function memberSearch() {
              const membersUsername = document.querySelector('#searchbox').value;
              const encryptUrl = "{{ $sub1 }}"; // Blade syntax for injecting PHP variables
  
              if (membersUsername !== '') {
                  fetch("{{$_ENV['BCPATH']}}/genealogy/search", {
                      method: "POST",
                      headers: {
                          "Content-Type": "application/json",
                      },
                      body: JSON.stringify({
                          members_username: membersUsername,
                          encrypturl: encryptUrl,
                      }),
                  })
                  .then(response => {
                      if (!response.ok) {
                          throw new Error("Network response was not ok");
                      }
                      return response.text();
                  })
                  .then(data => {
  
                      window.location.href = `{{$_ENV['BCPATH']}}/genealogy/viewtree/${data}`;
                  })
                  .catch(error => {
                      console.error("Error occurred during genealogy search:", error);
                  });
              }
          }
  
  function filterSuggestions(query) {
      const suggestionBox = document.getElementById("suggestion-box");
      const items = suggestionBox.querySelectorAll("div[data-value]");
  
      if (query.trim() === "") {
          suggestionBox.classList.add("hidden");
          return;
      }
  
      const matrixId = "{{ $matrix_id }}";
      
      // Fetch members based on the query
      fetch(`{{$_ENV['BCPATH']}}/memberslist/getmembers/${query}`, {
          method: "POST",
          headers: {
              "Content-Type": "application/json",
          },
          body: JSON.stringify({ matrix_id: matrixId }),
      })
      .then((response) => response.json())
      .then((data) => {
          // Clear previous suggestions
          suggestionBox.innerHTML = "";
  
          if (data.length === 0) {
              suggestionBox.classList.add("hidden");
              return;
          }
  
          // Populate suggestions dynamically
          data.forEach((member) => {
              const div = document.createElement("div");
              div.textContent = member.members_username; // Adjust based on API response
              div.dataset.value = member.members_id; // Adjust based on API response
              div.dataset.namevalue = member.members_username; 
              div.classList.add("suggestion-item", "cursor-pointer", "p-2", "hover:bg-neutral-200");
  
              // Add click event to select the suggestion
              div.addEventListener("click", () => {
                  document.getElementById("searchbox").value = div.dataset.namevalue; // Adjust field based on API
                  suggestionBox.classList.add("hidden");
                  document.querySelector('#default_members_id').value = div.dataset.value;
              });
  
              suggestionBox.appendChild(div);
          });
  
          suggestionBox.classList.remove("hidden");
      })
      .catch((error) => {
          console.error("Error fetching suggestions:", error);
      });
  
  }

  function previewImage(event, previewElementId) {
    const file = event.target.files[0];
    const imagePreview = document.getElementById(previewElementId);

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden'); // Optionally remove the 'hidden' class if you want to show the image preview
        };
        reader.readAsDataURL(file);
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


    const submitButton = document.getElementById('submitAddPackageButton');
    submitButton.addEventListener('click', function() {


        let isValid = true;

        // Validate each field
        isValid = isValid && validateRequiredField('#package_name', '#packagename-error', '#show_subscription');

        return isValid;

    })

  </script>