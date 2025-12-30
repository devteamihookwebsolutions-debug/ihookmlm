<?php
$matrix_id = isset($_GET['sub1']) ? htmlspecialchars($_GET['sub1'], ENT_QUOTES, 'UTF-8') : '';
?>
<script type="text/javascript">
    function viewReferralsDetails(id, mid) {
        fetch('/user/network/referralsdetails', {
            method: 'POST',
            body: new URLSearchParams({
                'mid': mid,
                'id': id
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.text())
        .then(resp => {
            document.querySelector('#view_referrrals_details').innerHTML = resp;
        })
        .catch(error => console.error('Error:', error));

        document.querySelector('#referralmoreinformation').classList.add('show');
    }

    function showPacakge(id) {
        fetch('/user/network/pacakge', {
            method: 'POST',
            body: new URLSearchParams({
                'matrix_id': id
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.text())
        .then(resp => {
            document.querySelector('#view_package_details').innerHTML = resp;
        })
        .catch(error => console.error('Error:', error));

        document.querySelector('#package_details').classList.add('show');
    }

    function showMatrixMoreInformation(id) {
        fetch('/user/network/matrixmoreinfo', {
            method: 'POST',
            body: new URLSearchParams({
                'matrix_id': id
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.text())
        .then(resp => {
            document.querySelector('#view_matrix_details').innerHTML = resp;
        })
        .catch(error => console.error('Error:', error));

        document.querySelector('#matrixmoreinformation').classList.add('show');
    }

    function joinMatrix() {
        var selected = document.getElementById("inactivematrix").value;
        if (selected != '') {
            var values = selected.split('_');
            var id = values[0];
            var ec = values[1];
            window.location = "/user/joinnetwork/join/" + id + "/" + ec
        }

    }
    function activeMatrix() {
        var selected = document.getElementById("activematrix").value;
        if (selected != '') {
            var values = selected.split('_');
            var member_id = values[0];
            var matrix_id = values[1];
            window.location = "/user/network/view/matrix/" + member_id + "/" + matrix_id
        }
    }

    function upgardeMatrixSubcription(id, sid, pid) {
        window.location = "/user/package/upgrade/" + id + '/' + pid
    }
    function subscriptionreminder(id) {
    if (id == 1) {
        Swal.fire({
            title: "{{ __('Cancel stripe subscription before upgrade') }}",
            icon: 'warning',
            width: 400,
            padding: '2.5rem',
            showCancelButton: false,
            confirmButtonText: "{{ __('Ok') }}",
            confirmButtonColor: '#DD6B55',
            customClass: {
                confirmButton: 'btn btn-success m-btn m-btn--custom'
            }
        });
    } else if (id == 2) {
        Swal.fire({
            title: "{{ __('Cancel chargebee subscription before upgrade') }}",
            icon: 'warning',
            width: 400,
            padding: '2.5rem',
            showCancelButton: false,
            confirmButtonText: "{{ __('Ok') }}",
            confirmButtonColor: '#DD6B55',
            customClass: {
                confirmButton: 'btn btn-success m-btn m-btn--custom'
            }
        });
    }
}

function cancelsubscription(linkid) {
    Swal.fire({
        title: "{{ __('Do you want cancel subscription') }}",
        icon: 'warning',
        width: 400,
        padding: '2.5rem',
        showCancelButton: true,
        confirmButtonText: "{{ __('Ok') }}",
        cancelButtonText: "{{ __('Cancel') }}",
        confirmButtonColor: '#DD6B55',
        customClass: {
            confirmButton: 'btn btn-success m-btn m-btn--custom',
            cancelButton: 'btn btn-secondary m-btn m-btn--custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/user/network/stripecancelsubscription/' + linkid, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(resp => {
                Swal.fire("{{ __('Done') }}", "{{ __('Subscription cancelled') }}", "success");
                window.location.reload();
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("{{ __('Error') }}", "{{ __('Something went wrong') }}", "error");
            });
        } else {
            Swal.fire("{{ __('Cancel') }}", "{{ __('Record safe') }}", "error");
        }
    });
}

function chargebeecancelsubscription(linkid) {
    Swal.fire({
        title: "{{ __('Do you want cancel subscription') }}",
        icon: 'warning',
        width: 400,
        padding: '2.5rem',
        showCancelButton: true,
        confirmButtonText: "{{ __('Yes') }}",
        cancelButtonText: "{{ __('Cancel') }}",
        confirmButtonColor: '#DD6B55',
        customClass: {
            confirmButton: 'btn btn-success m-btn m-btn--custom',
            cancelButton: 'btn btn-secondary m-btn m-btn--custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/user/network/chargebeecancelsubscription/' + linkid, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(resp => {
                Swal.fire("{{ __('Done') }}", "{{ __('Subscription cancelled') }}", "success");
                window.location.reload();
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("{{ __('Error') }}", "{{ __('Something went wrong') }}", "error");
            });
        } else {
            Swal.fire("{{ __('Cancel') }}", "{{ __('Record safe') }}", "error");
        }
    });
}


function searchusers(value) {
    document.querySelector(".search-menu").style.display = "block";

    const matrix_id = '<?php echo $matrix_id; ?>';  // Assuming this PHP code is outputting the correct value

    if (value !== '') {
        fetch('/user/genealogy/getmembers/' + value, {
            method: 'POST',
            body: new URLSearchParams({ matrix_id: matrix_id }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.text())
        .then(resp => {
            document.querySelector(".search-menu").style.display = "block";

        })
        .catch(error => console.error('Error fetching members:', error));
    } else {
        $(".search-menu").hide();
        fetch('/user/genealogy/getmembers', {
            method: 'GET',
        })
        .then(response => response.text())
        .then(resp => {
            document.querySelector(".search-menu").style.display = "block";

        })
        .catch(error => console.error('Error fetching members:', error));
    }
}

    function getvalue(id) {
        document.getElementById("members_id").value = id;

        var get = document.getElementById(id).innerHTML;

        document.getElementById("searchbox").value = get;

        document.querySelectorAll(".search-menu").forEach(function(element) {
            element.style.display = "none";
        });
    }
    function genealogySearch() {
    var members_username = document.getElementById('searchbox').value;
    var matrix_id = '{{$matrix_id}}';

    fetch("/user/genealogy/search", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            members_username: members_username,
            matrix_id: matrix_id
        })
    })
    .then(response => response.json()) // Assuming the server returns JSON
    .then(data => {
        window.location = "/user/network/view/" + data;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

</script>
<!-- Flowbite Copy to Clipboard Script (Add once in your page) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const copyButton = document.querySelector('[data-copy-target="#referral-url-input"]');
    const input = document.getElementById('referral-url-input');
    const defaultIcon = copyButton.querySelector('.default-icon');
    const successIcon = copyButton.querySelector('.success-icon');
    const defaultTooltip = copyButton.closest('.relative').querySelector('.default-text');
    const successTooltip = copyButton.closest('.relative').querySelector('.success-text');

    copyButton.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(input.value);

            // Change icon
            defaultIcon.classList.add('hidden');
            successIcon.classList.remove('hidden');

            // Change tooltip
            defaultTooltip.classList.add('hidden');
            successTooltip.classList.remove('hidden');

            // Show success tooltip
            const tooltip = document.getElementById('tooltip-copy-referral');
            tooltip.classList.remove('invisible', 'opacity-0');
            tooltip.classList.add('visible', 'opacity-100');

            // Revert after 2 seconds
            setTimeout(() => {
                defaultIcon.classList.remove('hidden');
                successIcon.classList.add('hidden');
                defaultTooltip.classList.remove('hidden');
                successTooltip.classList.add('hidden');
                tooltip.classList.add('invisible', 'opacity-0');
            }, 2000);

        } catch (err) {
            console.error('Failed to copy:', err);
        }
    });
});
</script>
