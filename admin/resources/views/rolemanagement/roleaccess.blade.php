@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __('Role Settings') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                                    <a href="/admin/dashboard"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                                        <div class="relative w-5 h-5 flex items-center justify-center">

                                            <!-- Animated Border ONLY -->
                                            <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                                                animate-ping opacity-60"></span>

                                            <!-- Static Icon -->
                                            <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10"
                                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                            </svg>
                                        </div>
                                    </a>
                                </li>
                     <li aria-current="page">
                         <div class="flex items-center">
                             <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                     stroke-width="2" d="m1 9 4-4-4-4" />
                             </svg>
                             <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Settings') }}</span>
                         </div>
                     </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Personalization') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Role Settings') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->

<!-- Content area -->

<main class="flex-grow">
      <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
       @include('components.common.info_message')
       <!--Success and Failure Messge-->
        <!-- card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

          <div class="flex justify-between ">
            <div>
              <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">{{ __('Role Settings') }}</h3>
            </div>

          </div>
          <div class="flex items-center justify-center gap-10 mb-5">

            <!--customer-form-->
            <input type="hidden" name="submenu_id" id="submenu_id" />
            <input type="hidden" name="mainmenu_id" id="mainmenu_id" />

            <!-- Header with Role Selection and Action Buttons -->
            <div class="mb-5 lg:w-3/4 w-full">
              <div>
                <label for="lastname" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Select
                    Role') }}</label>
                <select name="role_type" id="role_type" onchange="selectedRoleMenus(this.value);"
                  class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                  <!-- <option value="">-- Select the size --</option> -->
                  {!!$showroles!!}
                </select>
                <div class="gap-4 my-10 flex justify-end">
                  <!-- Update Role Button -->
                  <button type="submit"
                    class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900"
                    onclick="updateRole();">
                    {{ __('Update Role') }}
                  </button>

                  <!-- Add Role Button -->
                  <button type="button"
                    class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900"
                     id="add_role">
                    {{ __('Add Role') }}
                  </button>

                  <!-- Delete Role Button (Disabled) -->
                  <button type="button"
                    class="text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900"
                    onclick="deleterole();" id="deleterole">
                    {{ __('Delete Role') }}
                  </button>
                </div>
              </div>
              <!-- Menu Selection Section -->
              <div class="bg-white p-6 border rounded-lg shadow-lg dark:bg-neutral-300">
                     {!!$allmenu!!}
              </div>
              <!--customer-form-->
            </div>

          </div>

        </div>

        <!-- card -->
      </div>


      <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-opacity-50">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                {{ __('Add Role') }}
                </h3>
                <button type="button"  onclick="hideModal();"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                    >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
            <span id="view_order_details">

            <form action="{{route('create')}}" method="post" id="create_role">
                @csrf
                <input type="hidden" name="selectedmainmenu" id="selectedmainmenu">
                <input type="hidden" name="selectedsubmenuadd" id="selectedsubmenuadd">
                <div class="mb-4">
                    <label for="recipient_name" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Role Name:') }}</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-neutral-600 dark:border-neutral-500 dark:placeholder-neutral-400 dark:text-white" placeholder="" required>
                </div>
                <div class="mb-4">
                    <label for="role_type" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Make Copies of:') }}</label>
                    <select id="role_type" name="role_type" class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {!!$showroles!!}
                    </select>
                </div>

                <div class="flex justify-end" bis_skin_checked="1">
                    <button type="button" onclick="hideModal();" class="text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-neutral-900 dark:text-white  dark:hover:bg-neutral-700 dark:hover:border-neutral-600 dark:focus:ring-neutral-700">
                    {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="text-white bg-neutral-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-blue-800">
                    {{ __('Submit') }}
                    </button>
                </div>
            </form>

            </span>
            </div>
        </div>
    </div>
</div>

    </main>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>


// document.addEventListener("DOMContentLoaded", function () {
//     const checkboxes = document.querySelectorAll(".main-menu-checkbox");
//     const hiddenInput = document.getElementById("mainmenu_id");
//     const submenuCheckboxes = document.querySelectorAll(".sub-menu-checkbox");
//     const submenuHiddenInput = document.getElementById("submenu_id");

//     function updateHiddenInput(inputElement, checkboxes) {
//         let selectedValues = Array.from(checkboxes)
//             .filter(cb => cb.checked)
//             .map(cb => cb.value)
//             .join(",");

//         inputElement.value = selectedValues;
//         document.getElementById("all_menu").checked = false;
//     }

//     // Set hidden input values on page load
//     updateHiddenInput(hiddenInput, checkboxes);
//     updateHiddenInput(submenuHiddenInput, submenuCheckboxes);

//     // Add change event listeners
//     checkboxes.forEach(checkbox => {
//         checkbox.addEventListener("change", function () {
//             updateHiddenInput(hiddenInput, checkboxes);
//         });
//     });

//     submenuCheckboxes.forEach(checkbox => {
//         checkbox.addEventListener("change", function () {
//             updateHiddenInput(submenuHiddenInput, submenuCheckboxes);
//         });
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".main-menu-checkbox");
    const hiddenInput = document.getElementById("mainmenu_id");
    const submenuCheckboxes = document.querySelectorAll(".sub-menu-checkbox");
    const submenuHiddenInput = document.getElementById("submenu_id");
    const allMenuCheckbox = document.getElementById("all_menu");

    function updateHiddenInput(inputElement, checkboxes) {
        let selectedValues = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value)
            .join(",");

        inputElement.value = selectedValues;
    }

    function toggleAllCheckboxes(allCheckbox, checkboxes, inputElement) {
        if (allCheckbox.checked) {
            checkboxes.forEach(cb => cb.checked = true);
        } else {
            checkboxes.forEach(cb => cb.checked = false);
        }
        updateHiddenInput(inputElement, checkboxes);
    }

    // Set hidden input values on page load
    updateHiddenInput(hiddenInput, checkboxes);
    updateHiddenInput(submenuHiddenInput, submenuCheckboxes);

    // Handle "all_menu" checkbox functionality
    allMenuCheckbox.addEventListener("change", function () {
        toggleAllCheckboxes(allMenuCheckbox, checkboxes, hiddenInput);
        toggleAllCheckboxes(allMenuCheckbox, submenuCheckboxes, submenuHiddenInput);
    });

    // Handle individual checkbox changes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            updateHiddenInput(hiddenInput, checkboxes);
            allMenuCheckbox.checked = checkboxes.length === document.querySelectorAll(".main-menu-checkbox:checked").length;
        });
    });

    submenuCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            updateHiddenInput(submenuHiddenInput, submenuCheckboxes);
            allMenuCheckbox.checked = submenuCheckboxes.length === document.querySelectorAll(".sub-menu-checkbox:checked").length;
        });
    });
});




var addRole = document.getElementById('add_role');
    var main_menus = document.getElementsByName('selectedmenu[]');
    var sub_menus = document.getElementsByName('selectedsubmenu[]');
    addRole.addEventListener('click',function(){

        var checkedValues = [];
        for (var i = 0; i < main_menus.length; i++) {
            if (main_menus[i].checked) {
                checkedValues.push(main_menus[i].value);
            }
        }
        document.getElementById('selectedmainmenu').value=checkedValues;
        var checkedSubmenu = document.getElementById('submenu_id').value;
        document.getElementById('selectedsubmenuadd').value=checkedSubmenu;

        const modal = document.getElementById('static-modal');
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');

    });

</script>
<script>
    // Toggle submenu visibility
    function toggleSubmenu(menuId) {
      const submenu = document.getElementById(`submenu-${menuId.split('-')[1]}`);
      const icon = document.getElementById(`${menuId}-icon`);

      // Toggle the hidden class and rotate the icon
      submenu.classList.toggle('hidden');
      icon.classList.toggle('rotate-90');
    }

    // Select All Checkbox
    document.getElementById('all_menu').addEventListener('change', function (e) {
      const isChecked = e.target.checked;

      // Select all menu checkboxes (both main menus and submenus)
      const checkboxes = document.querySelectorAll('input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
        checkbox.checked = isChecked;
      });

      // Show all submenus if "Select All" is checked
      const submenus = document.querySelectorAll('.submenu');
      submenus.forEach(submenu => {
        if (isChecked) {
          submenu.classList.remove('hidden');
        } else {
          submenu.classList.add('hidden');
        }
      });
    });

   function updateRole() {
    var role_type_id = document.getElementById('role_type').value;
    var mainmenu_id  = document.getElementById('mainmenu_id').value;
    var submenu_id   = document.getElementById('submenu_id').value;

    var url = "{{ route('rolemanagement.update') }}";  // Laravel generated URL

    var data = new URLSearchParams();
    data.append("role_type_id", role_type_id);
    data.append("mainmenu_id", mainmenu_id);
    data.append("submenu_id", submenu_id);

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",   // important!
        },
        body: data.toString(),
    })
    .then(response => response.text())
    .then(responseText => {
        if (responseText.trim() === "true") {
            window.location.href = "/admin/rolemanagement/view/1";
        }
    })
    .catch(error => console.error("Error:", error));
}



function deleterole() {
    const role_type_id = document.getElementById("role_type").value;

    if(role_type_id == '1'){
       Swal.fire({
                title: "Admin Role",
                text: "The admin role is the default role and cannot be deleted",
                icon: "error",
                width: 400,
                heightAuto: false,
                padding: "2.5rem",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "Cancel",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "px-4 py-2 bg-red-600 text-white rounded-lg",
                    cancelButton: "px-4 py-2 bg-neutral-300 text-black rounded-lg ml-2",
                },
                showConfirmButton: false
            });
        return;
    }

    Swal.fire({
        title: "Admin Role",
        text: "Do you really want to delete this role?",
        icon: "warning",
        width: 400,
        heightAuto: false,
        padding: "2.5rem",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        buttonsStyling: false,
        customClass: {
            confirmButton: "px-4 py-2 bg-red-600 text-white rounded-lg",
            cancelButton: "px-4 py-2 bg-neutral-300 text-black rounded-lg ml-2"
        },
    }).then((result) => {
        if (result.isConfirmed) {
            // Use Laravel route helper
            let url = "{{ route('delete', ['id' => ':id']) }}";
            url = url.replace(':id', role_type_id);

            fetch(url, { method: "GET" })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: "Deleted!",
                    text: data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/admin/rolemanagement/view/1";
                });
            })
            .catch(error => console.error("Error:", error));
        }
    });
}


function hideModal() {
    const modal = document.getElementById('static-modal');
    modal.classList.add('hidden'); // Add the 'hidden' class to hide the modal
    modal.setAttribute('aria-hidden', 'true');
}


function selectedRoleMenus(id) {
    window.location.href = "/admin/rolemanagement/view/" + id;
}


  </script>

@endsection
