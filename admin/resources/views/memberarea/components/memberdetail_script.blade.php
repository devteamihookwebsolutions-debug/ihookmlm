<script>


    document.getElementById('country').addEventListener('change', function () {
        var country_code = this.value; // Get selected country code
        var formData = new FormData();
        formData.append("country", country_code);

        fetch('/admin/showstatedetails', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('response').innerHTML = data;
        })
        .catch(() => {
            document.getElementById('response').innerHTML = "<b>Failed</b>";
        });
    });
function getUserDeatilsPlan() {
    const showplan = document.getElementById('showplan');
    if (!showplan) return console.error('Element #showplan not found');

    // Show loading
    showplan.innerHTML = `
        <div class="col-span-2 bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500 animate-pulse">Loading plan details...</p>
        </div>
    `;

    fetch(`/admin/userdetailsplan/show/{{ $sub1 }}`)
        .then(r => {
            if (!r.ok) throw new Error('Network error');
            return r.json();
        })
        .then(data => {
            // Inject full HTML
            showplan.innerHTML = data.html;

            // Show the tab
            document.querySelectorAll('[role="tabpanel"]').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById('plandetails').classList.remove('hidden');

            // Optional: Highlight active tab
            document.querySelectorAll('[data-tabs-target]').forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600');
                btn.classList.add('text-black', 'border-neutral-100');
            });
            document.querySelector('[data-tabs-target="#plandetails"]').classList.add('text-blue-600', 'border-blue-600');
        })
        .catch(err => {
            console.error(err);
            showplan.innerHTML = `
                <div class="col-span-2 bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                    <p class="text-red-600">Failed to load plan details.</p>
                </div>
            `;
        });
}
function getGenealogydrown() {
    const dropdown = document.getElementById("genealogydropdown");

    if (dropdown.classList.contains("hidden")) {
        dropdown.classList.remove("hidden");
    } else {
        dropdown.classList.add("hidden");
    }
}

function changePendingDetails(id, mid, phid) {
    document.getElementById('awaiting').innerHTML = '';
    window.location.href = `/admin/usermanager/changependingstatus/${id}/${mid}/${phid}`;
}
function changeStatus(val) {
    Swal.fire({
        title: "{{ __('Change Status?') }}",
        text: "{{ __('Users') }}",
        icon: 'warning',
        width: 400,
        heightAuto: false,
        padding: '2.5rem',
        customClass: {
            popup: 'bg-white rounded-lg shadow-lg',
            title: 'text-xl font-semibold text-black',
            text: 'text-sm text-black',
            confirmButton: 'bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg',
            cancelButton: 'bg-neutral-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg',
        },
        showCancelButton: true,
        confirmButtonText: "{{ __('Yes, Sure!') }}",
        cancelButtonText: "{{ __('Cancel') }}",
        cancelButtonColor: '#d33',
        showLoaderOnConfirm: true,
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            let currentstatus = "{{ $errval['members_status'] }}";
            if (currentstatus == 1) {
                Swal.fire(
                    "{{ __('Suspended') }}",
                    "{{ __('User has been suspended') }}",
                    "success"
                ).then(() => {
                    window.location = "/admin/memberchangesuspend/suspend/" + val;
                });
            } else {
                Swal.fire(
                    "{{ __('Activated') }}",
                    "{{ __('User has been activated') }}",
                    "success"
                ).then(() => {
                    window.location = "/admin/memberchangeactive/active/" + val;
                });
            }
        } else {
            Swal.fire(
                "{{ __('Cancelled') }}",
                "{{ __('Your record is safe') }}",
                "error"
            );
        }
    });

    return false;
}

    function welcomeletter() {
        // Reload the page
        location.reload();

        // Construct the URL
        let url = `/admin/welcomeletter/show/{{$sub1}}`;

        // Perform the AJAX request using fetch
        fetch(url, {
            method: 'GET'
        })
        .then(response => response.text()) // If you need the response
        .then(resp => {
            // You can process the response here if needed
            console.log(resp);
        })
        .catch(error => console.error("Error:", error));
    }


    function autoLogin(member_id) {
        const url = "{{ route('user.user.autologin.token') }}";

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ member_id: member_id })
        })
        .then(r => r.json())
        .then(data => {
            if (data.token) {
                const redirectUrl = `{{ route('user.user.autologin.auto', ['token' => ':token', 'member_id' => ':id']) }}`
                    .replace(':token', data.token)
                    .replace(':id', member_id);

                window.open(redirectUrl, '_blank');
            }
        })
        .catch(err => console.error('Auto-login error:', err));
    }

    function previewImage(event) {
      const file = event.target.files[0];
      const previewContainer = document.getElementById('preview_container');
      const imagePreview = document.getElementById('image_preview');

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.src = e.target.result;
          previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = '';
        previewContainer.classList.add('hidden');
      }
    }


    function showmywebsitedetails() {
        let url = `/admin/showmywebsitedetails/show/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                document.getElementById('showwebsitedetails').innerHTML = resp;
            })
            .catch(error => console.error("Error:", error));
    }

    function showmysocialmediadetails() {
        let url = `/admin/showmysocialmedia/show/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                document.getElementById('showsocialdetails').innerHTML = resp;
            })
            .catch(error => console.error("Error:", error));
    }


    function paymenthistory() {
            let url = `/admin/userdetailspayment/show/{{$sub1}}`;
            fetch(url, { method: 'GET' })
                .then(response => response.text())
                .then(resp => {
                    const tableBody = document.querySelector("#search-table-2 tbody");
                    tableBody.innerHTML = resp;

                    if (typeof simpleDatatables !== 'undefined') {
                        new simpleDatatables.DataTable("#search-table-2", {
                            searchable: true,
                            sortable: false
                        });
                    }
                })
                .catch(error => console.error("Error:", error));
    }

    function previewImage(event) {
        const file = event.target.files[0];
        const imagePreview = document.getElementById('image_preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = e => imagePreview.src = e.target.result;
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '{{ asset('assets/img/avatar/no-rank.png') }}';
        }
    }
    function personalpurchase() {
        const url = `/admin/personalpurchase/show/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                const personalPurchaseTab = document.getElementById('personalpurchasetab');
                if (personalPurchaseTab) {
                    personalPurchaseTab.innerHTML = resp;
                } else {
                    console.error('Error: Element with ID "personalpurchasetab" not found.');
                }

                if (document.getElementById("search-table-3") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#search-table-3", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function transaction() {
        const url = `/admin/memberareatransaction/show/{{ $sub1 }}`;
        fetch(url).then(r => r.text()).then(html => {
            document.getElementById('showtransaction').innerHTML = html;
            if (window.simpleDatatables?.DataTable) {
                new simpleDatatables.DataTable("#transaction-table", {searchable:true, sortable:false});
            }
        });
    }

    function userdetailswithdrawal() {
        const url = `/admin/userdetailswithdrawal/show/{{ $sub1 }}`;
        fetch(url).then(r => r.text()).then(html => {
            document.getElementById('showwithdrawal').innerHTML = html;
            if (window.simpleDatatables?.DataTable) {
                new simpleDatatables.DataTable("#transaction-pay-table", {searchable:true, sortable:false});
            }
        });
    }

    function showuserdeatilspv() {
        const url = `/admin/showuserdeatilspv/show/{{ $sub1 }}`;
        fetch(url).then(r => r.text()).then(html => {
            document.getElementById('showpv').innerHTML = html;
            if (window.simpleDatatables?.DataTable) {
                new simpleDatatables.DataTable("#transaction-history-table", {searchable:true, sortable:false});
            }
        });
    }

    function showuserfundtransfer() {
        const url = `/admin/showuserfundtransfer/show/{{ $sub1 }}`;
        fetch(url).then(r => r.text()).then(html => {
            document.getElementById('showfundtransfer').innerHTML = html;
            if (window.simpleDatatables?.DataTable) {
                new simpleDatatables.DataTable("#transaction-fund-table", {searchable:true, sortable:false});
            }
        });
    }


    function invoice() {
        const url = `/admin/commission/invoice/{{ $sub1 }}`; // Changed
        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                const commissionInvoiceElement = document.getElementById('commission_invoice');
                if (commissionInvoiceElement) {
                    commissionInvoiceElement.innerHTML = resp;
                }

                // Initialize DataTable after content is loaded
                const showCommissionInvoice = document.getElementById('commission-table');
                if (showCommissionInvoice && typeof simpleDatatables.DataTable !== 'undefined') {
                    new simpleDatatables.DataTable(showCommissionInvoice, {
                        searchable: true,
                        sortable: true
                    });
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function showpackagedetails() {
        const url = `/admin/commission/packages/{{ $sub1 }}`; // Changed
        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                const purchasePackageElement = document.getElementById('purchase_package');
                if (purchasePackageElement) {
                    purchasePackageElement.innerHTML = resp;
                }

                // Initialize DataTable after content is loaded
                const showPurchasePackage = document.getElementById('purchase-table');
                if (showPurchasePackage && typeof simpleDatatables.DataTable !== 'undefined') {
                    new simpleDatatables.DataTable(showPurchasePackage, {
                        searchable: true,
                        sortable: true
                    });
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function loadPayoutHistory() {
        const tbody = document.getElementById('payoutdata');
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 animate-pulse">Loading...</td></tr>';

        fetch(`/admin/userpayoutdetails/get/${memberId}`)
            .then(r => r.text())
            .then(html => {
                tbody.innerHTML = html;
                if (typeof initDataTable === 'function') initDataTable('#payout-table');
            })
            .catch(() => {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-red-600">Failed to load</td></tr>';
            });
    }



    // Tab click listeners
    document.getElementById('payout-info-tab').addEventListener('click', () => {
        document.getElementById('payout-info').classList.remove('hidden');
        document.getElementById('ewallet-info').classList.add('hidden');
        loadPayoutHistory();
    });

    // Load default tab on page load
    document.addEventListener('DOMContentLoaded', () => {
        loadPayoutHistory();
    });

 function showparties() {
    const url = `/admin/showmemberparties/show/{{ $sub1 }}`;

    fetch(url).then(r => r.text())
        .then(resp => {
            document.getElementById('partytab').innerHTML = resp;

            // re-init DataTable if you use it
            if (window.simpleDatatables?.DataTable) {
                new simpleDatatables.DataTable("#search-table-parties", {
                    searchable: true,
                    sortable: false
                });
            }
        });
}

    function getUserCommission() {
        const url = `/admin/usercommissiondetails/get/{{ $sub1 }}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                const commissionList = document.getElementById('commission_list');
                if (commissionList) {
                    commissionList.innerHTML = resp;
                }

                if (document.getElementById("commission-report-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#commission-report-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => console.error("Error:", error));
    }


    function getUserDetailsWithdrawal() {
        const url = `/admin/userpayoutdetails/get/{{ $sub1 }}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                const payoutData = document.getElementById('payoutdata');
                if (payoutData) {
                    payoutData.innerHTML = resp;
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function getUserDetailsMessage() {
        const url = `/admin/userdetailsmessage/show/{{ $sub1 }}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {
                const messageContainer = document.getElementById('showmessage');
                if (messageContainer) {
                    messageContainer.innerHTML = resp;
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function getGenealogyDetails() {
        const url = `/admin/usergenealogydetails/get/{{ $sub1 }}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(resp => {

                const tableBody = document.querySelector("#genealogy-table tbody");

                    tableBody.innerHTML = '';

                    // Insert data into columns (assuming 3 columns)
                    tableBody.innerHTML = resp;
                if (document.getElementById("genealogy-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#genealogy-table", {
                        searchable: true,
                        sortable: false
                    });


                    console.log(tableBody);
                    if (typeof dataTable !== 'undefined' && dataTable) {
                        dataTable.refresh();
                    } else {
                        console.error("DataTable instance is undefined!");
                    }
                }


            })
            .catch(error => console.error("Error:", error));
    }


    function getReferrals() {
        const url = `/admin/getdirectreferral/get/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())  // Expecting text response
            .then(resp => {
                const referralsElement = document.getElementById('direct_referrals');
                if (referralsElement) {
                    referralsElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'direct_referrals' not found.");
                }
                if (document.getElementById("ibo-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#ibo-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });


    }

    function getPartyDetail() {
        const url = `/admin/userpartydetails/get/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text()) // Get the response as text
            .then(resp => {
                // Find the element with ID 'party_list' and set its inner HTML to the response
                const partyListElement = document.getElementById('party_list');
                if (partyListElement) {
                    partyListElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'party_list' not found.");
                }
                if (document.getElementById("hostparty-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#hostparty-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }

    function getCustomers() {
        const url = `/admin/getcustomers/get/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text())  // Get the response as text
            .then(resp => {
                // Find the element with ID 'customers_list' and set its inner HTML to the response
                const customersListElement = document.getElementById('customers_list');
                if (customersListElement) {
                    customersListElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'customers_list' not found.");
                }
                if (document.getElementById("customerorg-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#customerorg-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }

  function getProcessedEarn() {
    const memberId = '{{ $sub1 }}';
    const tbody = document.getElementById('processed_earning');

    if (!tbody) return console.error('Element #processed_earning not found');

    // Show loading
    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><span class="animate-pulse">Loading...</span></td></tr>';

    fetch(`/admin/userprocessedearning/get/${memberId}`)
        .then(response => response.text())
        .then(html => {
            tbody.innerHTML = html;

            // Re-init DataTable
            if (document.getElementById("earnings-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                // Destroy existing instance if exists
                if (window.earningsTable instanceof simpleDatatables.DataTable) {
                    window.earningsTable.destroy();
                }
                window.earningsTable = new simpleDatatables.DataTable("#earnings-table", {
                    searchable: true,
                    sortable: false
                });
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-600">Failed to load data.</td></tr>';
        });
}
    function getUserDeatilsWithdrawal() {
        const url = `/admin/userpayoutdetails/get/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text()) // Convert response to text
            .then(resp => {
                const payoutDataElement = document.getElementById('payoutdata');
                if (payoutDataElement) {
                    payoutDataElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'payoutdata' not found.");
                }

                if (document.getElementById("payout-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#payout-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }


    function getUserDeatilsMessage() {
        const url = `/admin/userdetailsmessage/show/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text()) // Convert response to text
            .then(resp => {
                const messageElement = document.getElementById('showmessage');
                if (messageElement) {
                    messageElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'showmessage' not found.");
                }

                if (document.getElementById("message-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#message-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }


    function getUserDeatilsActivity() {
        const url = `/admin/userdetailsactivity/show/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text()) // Convert response to text
            .then(resp => {
                const activityElement = document.getElementById('showactivity');
                if (activityElement) {
                    activityElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'showactivity' not found.");
                }

                if (document.getElementById("activites-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#activites-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching activity details:", error);
            });
    }

    function getUserSavedNotes() {
        const url = `/admin/usersavednotes/get/{{$sub1}}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text()) // Convert response to text
            .then(resp => {
                const notesElement = document.getElementById('savednotes_list');
                if (notesElement) {
                    notesElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'savednotes_list' not found.");
                }

                if (document.getElementById("savednotes-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                    const dataTable = new simpleDatatables.DataTable("#savednotes-table", {
                        searchable: true,
                        sortable: false
                    });
                }

            })
            .catch(error => {
                console.error("Error fetching saved notes:", error);
            });
    }

    function viewPaymentDetails(id, mid) {
        const url = `/admin/userdetails/paymentdetails/${id}/${mid}`;

        fetch(url, { method: 'GET' })
            .then(response => response.text()) // Convert response to text
            .then(resp => {
                const paymentDetailsElement = document.getElementById('view_payment_details');
                if (paymentDetailsElement) {
                    paymentDetailsElement.innerHTML = resp;
                } else {
                    console.error("Error: Element with ID 'view_payment_details' not found.");
                }

                // Set the response to the content of the #vieweditpackage container
                const targetEl = document.getElementById('paymentmoreinformation-modal');

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
                console.error("Error fetching payment details:", error);
            });
            // Function to close the modal
function closePaymentModal() {
    const modal = document.getElementById('paymentmoreinformation-modal');
    modal.classList.add('hidden');
}

// Optional: Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentModal();
    }
});

    }

    function showManualUpgrade(id, mid) {
        window.location = "/admin/manualupgrade/upgrade/" + id + '/' + mid;
    }

    function showMatrixMoreInformation(id) {
        const url = `/admin/userdetails/matrixmoreinfo`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `matrix_id=${id}`
        })
        .then(response => response.text())
        .then(resp => {
            // Insert response into the correct element
            const matrixDetailsElement = document.getElementById('view_matrix_details');
            if (matrixDetailsElement) {
                matrixDetailsElement.innerHTML = resp;
            } else {
                console.error("Error: Element with ID 'view_matrix_details' not found.");
            }

            const targetEl = document.getElementById('planinfo-modal');

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
            console.error("Error fetching matrix details:", error);
        });
    }


function editUser() {
    const memberId = '{{ $sub1 }}'; // or pass dynamically

    fetch(`/admin/getuserform/edituser/${memberId}`)
        .then(response => response.text())
        .then(resp => {
            document.getElementById("edituserformdata").innerHTML = resp;

            const targetEl = document.getElementById('crud-modal');
            const modal = new Modal(targetEl, { backdrop: true, keyboard: true, focus: true });
            modal.show();

            // === ADD FORM SUBMIT HANDLER HERE ===
            const form = document.getElementById('edituserform');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Stop page reload

                    // Clear previous errors
                    document.querySelectorAll('.error-members_username, .error-members_email').forEach(el => {
                        el.textContent = '';
                    });

                    const formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // Laravel CSRF

                    fetch(`/admin/UpdateUserForm/update/${memberId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            // 'Content-Type': 'multipart/form-data' → DON'T set, let browser set with boundary
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'User updated successfully!');
                            modal.hide();
                            location.reload(); // or update UI without reload
                        } else {
                            // Show validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(key => {
                                    const errorEl = document.querySelector(`.error-${key}`);
                                    if (errorEl) {
                                        errorEl.textContent = data.errors[key][0];
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Check console.');
                    });
                });
            }
        })
        .catch(error => console.error("Error loading form:", error));
}
    function previewImageContent(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_containercontent');
        const imagePreview = document.getElementById('image_previewcontent');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
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

    const closeModalIcon = document.getElementById('paymentmoreinformationcloseicon-modal');
    const closeplaninfoModalButton = document.getElementById('planinfo-modal');
    const closeplaninfoModalIcon = document.getElementById('planinfo-modal');
    const closeUserDetailsModalButton = document.getElementById('userdetailsIconCloseButton');
    const closeUserDetailsModalIcon = document.getElementById('userdetailsIconClose');

    closeEditModalButton.addEventListener('click', () => closeModal('paymentmoreinformation-modal'));
    closeModalIcon.addEventListener('click', () => closeModal('paymentmoreinformation-modal'));
    closeplaninfoModalButton.addEventListener('click', () => closeModal('planinfo-modal'));
    closeplaninfoModalIcon.addEventListener('click', () => closeModal('planinfo-modal'));
    closeUserDetailsModalButton.addEventListener('click', () => closeModal('crud-modal'));
    closeUserDetailsModalIcon.addEventListener('click', () => closeModal('crud-modal'));

    // Form Validation Scripts


    const FORM_CONFIG = {
        REQUIRED_PATTERNS: {
          email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
          phone: /^\d{10}$/,
          // Add more fields as needed
        },
      };

      class FormHandler {
        constructor() {
          this.initializeElements();
          this.attachEventListeners();
        }

        initializeElements() {
          this.elements = {
            form: document.getElementById('showMyPasswordDetails'),
            form1: document.getElementById('addcontactus1'),
            form2: document.getElementById('cmpmsg'),
            form3: document.getElementById('personalinfo'),
            form3: document.getElementById('usercontatcinfo'),
            form3: document.getElementById('billinginfo'),
            form3: document.getElementById('usernotes'),
          };
        }

        attachEventListeners() {
          this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));
          this.elements.form1?.addEventListener('submit', (e) => this.handleSubmit1(e));
          this.elements.form2?.addEventListener('submit', (e) => this.handleSubmit2(e));
          this.elements.form3?.addEventListener('submit', (e) => this.handleSubmit3(e));
          this.elements.form4?.addEventListener('submit', (e) => this.handleSubmit4(e));
          this.elements.form5?.addEventListener('submit', (e) => this.handleSubmit5(e));
          this.elements.form6?.addEventListener('submit', (e) => this.handleSubmit6(e));
          // Real-time validation
          document.querySelectorAll('input[required], select[required]').forEach((input) => {
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
            this.showError(input, errorElement);
          } else {
            this.clearError(input, errorElement);
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
          const inputs = Array.from(this.elements.form.querySelectorAll('input[required], select[required]'));
          const allValid = inputs.every((input) => this.validateInput(input));

          if (allValid) {
            this.elements.form.submit();
          } else {
            console.error('Form validation failed.');
          }
        }
        handleSubmit1(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form1.querySelectorAll('input[required], textarea[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
              this.elements.form1.submit();
            } else {
              console.error('Form validation failed.');
            }
          }
        handleSubmit2(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form2.querySelectorAll('input[required], textarea[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
              this.elements.form2.submit();
            } else {
              console.error('Form validation failed.');
            }
          }
        handleSubmit3(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form3.querySelectorAll('input[required], textarea[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
              this.elements.form3.submit();
            } else {
              console.error('Form validation failed.');
            }
          }
        handleSubmit4(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form4.querySelectorAll('input[required], textarea[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
              this.elements.form4.submit();
            } else {
              console.error('Form validation failed.');
            }
          }
        handleSubmit5(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form5.querySelectorAll('input[required], textarea[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
              this.elements.form5.submit();
            } else {
              console.error('Form validation failed.');
            }
          }
        handleSubmit6(e) {
            e.preventDefault();
            const inputs = Array.from(this.elements.form6.querySelectorAll('input[required], textarea[required], select[required]'));
            const allValid = inputs.every((input) => this.validateInput(input));

            if (allValid) {
              this.elements.form6.submit();
            } else {
              console.error('Form validation failed.');
            }
          }
      }

      document.addEventListener('DOMContentLoaded', () => {
        new FormHandler();
      });

  function getUserDeatilsPlan() {
    const memberId = '{{ $members_id }}'; // Use same as Blade

    if (!memberId) {
        alert('Member ID not found');
        return;
    }

    const container = document.getElementById('showplan');
    container.innerHTML = '<p class="text-center py-4 text-gray-500">Loading...</p>';

    fetch(`/admin/userdetailsplan/show/${memberId}`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.html) {
                container.innerHTML = data.html;
                document.getElementById('plandetails').classList.remove('hidden');
            } else {
                container.innerHTML = `<p class="text-red-500">Error: ${data.error}</p>`;
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            container.innerHTML = `<p class="text-red-500">Error: ${err.error || 'Server error'}</p>`;
        });
}
    // Also define other functions if missing
    function getGenealogyDetails() { /* ... */ }
    function getReferrals() { /* ... */ }
    function getPartyDetail() { /* ... */ }
    function getCustomers() { /* ... */ }

    function openPaymentInfoModal(paymentId, memberId) {
        const modal = document.getElementById('paymentInfoModal');
        const content = document.getElementById('paymentDetailsContent');

        // Show modal
        modal.classList.remove('hidden');

        // Show loading
        content.innerHTML = `<p class="text-center text-gray-500">Loading payment details...</p>`;

        // Fetch from your existing route (reuse or create new)
        fetch(`/admin/paymentinfo/${paymentId}`)
            .then(r => r.json())
            .then(data => {
                content.innerHTML = `
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Payment Gateway:</span>
                            <span class="text-gray-900 dark:text-white">${data.gateway || 'Ewallet'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Transaction ID:</span>
                            <span class="text-gray-900 dark:text-white">${data.transaction_id || '—'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Package:</span>
                            <span class="text-gray-900 dark:text-white">${data.package_name || '—'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Subscription Date:</span>
                            <span class="text-gray-900 dark:text-white">${data.subscription_date || '—'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Subscription Expiry Date:</span>
                            <span class="text-gray-900 dark:text-white">${data.expiry_date || '—'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Fee:</span>
                            <span class="text-gray-900 dark:text-white">$${data.amount || '0.00'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Paid Currency:</span>
                            <span class="text-gray-900 dark:text-white">${data.currency || 'USD'}</span>
                        </div>
                    </div>
                `;
            })
            .catch(err => {
                console.error(err);
                content.innerHTML = `<p class="text-red-600 text-center">Failed to load payment info.</p>`;
            });
    }



function viewPaymentDetails(paymentId, memberId) {
    const targetEl = document.getElementById('paymentmoreinformation-modal');
    if (!targetEl) return console.error('Modal not found');

    // Initialize or get modal
    let modal = targetEl._modal;
    if (!modal) {
        modal = new Modal(targetEl, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
        targetEl._modal = modal; // Cache it
    }

    // Show modal
    modal.show();
}

// Close modal using Flowbite
document.addEventListener('click', function(e) {
    if (e.target.id === 'paymentmoreinformationcloseicon-modal' ||
        e.target.id === 'paymentmoreinformationclose-modal') {

        const modalEl = document.getElementById('paymentmoreinformation-modal');
        const modal = modalEl._modal;
        if (modal) {
            modal.hide();
        }
    }
});

// Close on ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modalEl = document.getElementById('paymentmoreinformation-modal');
        if (modalEl && !modalEl.classList.contains('hidden')) {
            const modal = modalEl._modal;
            if (modal) modal.hide();
        }
    }
});


</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const memberId = '{{ $members_id }}'; // Ensure passed from controller

    function loadCommissionReport() {
        const url = '{{ route("user.commission-report", ":id") }}'.replace(':id', memberId);
        axios.get(url)
            .then(response => {
                document.getElementById('commission_list').innerHTML = response.data;
                // Re-init DataTable
                if (typeof simpleDatatables !== 'undefined') {
                    new simpleDatatables.DataTable("#commission-report-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error(error);
                document.getElementById('commission_list').innerHTML = '<tr><td colspan="4" class="text-center text-red-600">Failed to load</td></tr>';
            });
    }

    function loadProcessedEarn() {
        const url = '{{ route("user.processed-earnings", ":id") }}'.replace(':id', memberId);
        axios.get(url)
            .then(response => {
                document.getElementById('processed_earning').innerHTML = response.data;
                // Re-init DataTable
                if (typeof simpleDatatables !== 'undefined') {
                    new simpleDatatables.DataTable("#earnings-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(error => {
                console.error(error);
                document.getElementById('processed_earning').innerHTML = '<tr><td colspan="5" class="text-center text-red-600">Failed to load</td></tr>';
            });
    }

    // Load on tab click
    document.getElementById('commissionreport-info-tab').addEventListener('click', loadCommissionReport);
    document.getElementById('earnings-info-tab').addEventListener('click', loadProcessedEarn);

    // Auto-load if already on compensation tab
    if (location.hash === '#compensation') {
        loadCommissionReport(); // default to commission
    }

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('wallet-data');
    const memberId  = container.dataset.memberId;
    const currency  = container.dataset.currency || '$';

    if (!memberId) {
        document.getElementById('c-wallet-amount').textContent = currency + ' 0.00';
        document.getElementById('e-wallet-amount').textContent = currency + ' 0.00';
        return;
    }

    const fetchWallet = (type) => {
        fetch(`/admin/wallet/${type}/${memberId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(r => {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            const el = document.getElementById(`${type}-wallet-amount`);
            if (el) {
                el.textContent = data.currency + ' ' + Number(data.balance).toFixed(2);
            }
        })
        .catch(err => {
            console.error(`${type.toUpperCase()}-Wallet error:`, err);
            const el = document.getElementById(`${type}-wallet-amount`);
            if (el) el.textContent = currency + ' 0.00';
        });
    };

    fetchWallet('c');
    fetchWallet('e');
});
function approvePayment(memberId, matrixId, paymentId) {
    const btn = document.getElementById('pending-btn-' + paymentId);
    const loading = btn.querySelector('.loading');
    const text = btn.querySelector('.text');

    loading.classList.remove('hidden');
    text.classList.add('hidden');
    btn.disabled = true;

    fetch("{{ route('user.approve-payment') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            member_id: memberId,
            matrix_id: matrixId,
            payment_id: paymentId
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // UI update without reload
            const container = document.getElementById('membership-status-' + memberId);
            container.innerHTML = `
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">
                    Paid
                </span>`;
            toastr.success('Status updated to Paid');
        } else {
            alert(data.message || 'Failed');
            loading.classList.add('hidden');
            text.classList.remove('hidden');
            btn.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Server error');
        loading.classList.add('hidden');
        text.classList.remove('hidden');
        btn.disabled = false;
    });
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const memberId = '{{ $members_id }}'; // From Blade

    document.getElementById('ewallet-info-tab').addEventListener('click', function () {
        document.getElementById('ewallet-info').classList.remove('hidden');
        document.getElementById('payout-info').classList.add('hidden');
        loadEwalletHistory();
    });

    // Auto-load on tab open
    function loadEwalletHistory() {
        const tbody = document.getElementById('ewallet_history');
        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-8"><span class="animate-pulse">Loading E-Wallet...</span></td></tr>';

        fetch(`/admin/userewallethistory/get/${memberId}`)
            .then(r => r.text())
            .then(html => {
                tbody.innerHTML = html;

                // Re-init DataTable
                if (window.simpleDatatables?.DataTable) {
                    new simpleDatatables.DataTable("#ewallet-table", {
                        searchable: true,
                        sortable: false
                    });
                }
            })
            .catch(err => {
                console.error(err);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-red-600">Failed to load</td></tr>';
            });
    }


    // Optional: Load E-Wallet on page load if tab is active
    if (window.location.hash === '#ewallet-info') {
        document.getElementById('ewallet-info-tab').click();
    }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
