@include('components.common.header')
<!-- custom styles start-->
<!-- custom styles end-->
@include('components.common.topbars')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto ">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2  dark:text-white">{{ __('Select Position') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{$_ENV['FCPATH']}}/dashboard"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"></path>
                            </svg>
                            {{ __('My Teams') }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Waiting Room') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Select Position') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->

<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->

        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 mb-5" bis_skin_checked="1">
                    <form action="{{$_ENV['FCPATH']}}/waitingroom/update" id="editpromotionalbanner" method="post"
                        enctype="multipart/form-data" novalidate="novalidate">
                        <h3 class="text-lg font-semibold text-black mb-5 dark:text-white">Position Selection</h3>

                        <input type="hidden" name="members_id" value="{{$sub1}}">
                        <input type="hidden" name="matrix_id" value="{{$sub2}}">
                        <div class="" bis_skin_checked="1">
                            <label for="members_country"
                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Select Position') }}</label>

                        </div>
                        <div  class="relative" data-hs-combo-box="">
                            <div class="relative">
                                <input type="text" id="searchbox" name="searchbox" placeholder="{{ __('Name') }}"
                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                    placeholder="Search..." aria-expanded="false" data-hs-combo-box-input=""
                                    onkeyup="searchusers(this.value)" required/>
                            </div>
                            <div class="search-menu">
                                <div class="search-set">
                                </div>
                            </div>

                        </div>

                        <div class="flex justify-end mt-5" bis_skin_checked="1">
                            <a aria-label="link" href="javascript:void(0);" onclick="window.history.back();"><button
                                    type="button"
                                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>Cancel</button></a>
                            <button type="submit"
                                class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Submit</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</main>

<!-- Footer -->
@include('components.common.footer')
@include('components.common.footer_scripts')

<!-- custom scripts start-->
<!-- custom scripts end-->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const FORM_CONFIG = {
    REQUIRED_PATTERNS: {
      email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
      phone: /^\d{10}$/,
      // Add more fields as needed
    },
  };

  class FormHandler {
    constructor(form) {
      this.form = form;
      if (this.form) {
        this.attachEventListeners();
      } else {
        console.error("Form not found.");
      }
    }

    attachEventListeners() {
      this.form.addEventListener("submit", (e) => this.handleSubmit(e));

      // Real-time validation
      this.form.querySelectorAll("input[required], select[required], textarea[required]").forEach((input) => {
        input.addEventListener("input", () => this.validateInput(input));
      });
    }

    validateInput(input) {
      const value = input.value.trim();
      const pattern = FORM_CONFIG.REQUIRED_PATTERNS[input.name];

      let errorElement = document.getElementById(input.id + "-error");
      if (!errorElement) {
        errorElement = this.createErrorElement(input);
      }

      let isValid = true;

      if (!value && input.hasAttribute("required")) {
        isValid = false;
        this.showError(input, errorElement, "This field is required.");
      } else if (pattern && !pattern.test(value)) {
        isValid = false;
        this.showError(input, errorElement, "Invalid format.");
      } else {
        this.clearError(input, errorElement);
      }

      return isValid;
    }

    createErrorElement(input) {
      const errorElement = document.createElement("span");
      errorElement.id = input.id + "-error";
      errorElement.className = "text-red-500 text-sm hidden";
      input.insertAdjacentElement("afterend", errorElement);
      return errorElement;
    }

    showError(input, errorElement, message) {
      input.classList.add("border-red-500");
      errorElement.textContent = message;
      errorElement.classList.remove("hidden");
    }

    clearError(input, errorElement) {
      input.classList.remove("border-red-500");
      errorElement.classList.add("hidden");
    }

    handleSubmit(e) {
      e.preventDefault();
      const inputs = Array.from(this.form.querySelectorAll("input[required], select[required], textarea[required]"));
      const allValid = inputs.every((input) => this.validateInput(input));

      if (allValid) {
        console.log("Form submitted successfully!"); // Debugging: Log successful submission
        this.form.submit();
      } else {
        console.error("Form validation failed.");
      }
    }
  }

  // Initialize validation for all forms
  document.querySelectorAll("form").forEach((form) => {
    new FormHandler(form);
  });
});
</script>

<script type="text/javascript">
// function searchusers(value) {
//     document.querySelector(".search-menu").style.display = "block";
//     let matrixId = "{{$sub2}}"; // Ensure this variable is set correctly in your backend
//     let userid  = "{{$sub1}}";

//     if (value !== '') {
//         fetch(`{{$_ENV['FCPATH']}}/waitingroom/getmembers/${value}/${userid}`, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded'
//             },
//             body: new URLSearchParams({ matrix_id: matrixId })
//         })
//         .then(response => response.text())
//         .then(resp => {
//         console.log(resp);
//             document.querySelector(".search-set").innerHTML = resp;
//         })
//         .catch(error => console.error("Error:", error));
//     }
// }

function searchusers(value) {
    document.querySelector(".search-menu").style.display = "block";

    let matrixId = "{{$sub2}}"; // Ensure this variable is properly set from the backend
    let userid = "{{$sub1}}";

    if (value.trim() !== '') {
        fetch(`{{$_ENV['FCPATH']}}/waitingroom/getmembers/${encodeURIComponent(value)}/${encodeURIComponent(userid)}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ matrix_id: matrixId })
        })
        .then(response => response.text())
        .then(resp => {
            console.log(resp);
            document.querySelector(".search-set").innerHTML = resp;
        })
        .catch(error => console.error("Error:", error));
    }
}


// function getvalue(id) {
//     document.getElementById("members_id").value = id;
//     let selectedText = document.getElementById(id).innerHTML;
//     document.getElementById("searchbox").value = selectedText;
//     document.querySelector(".search-menu").style.display = "none";
// }

function getvalue(id) {
   const searchBox = document.getElementById('searchbox');
   const searchMenu = document.querySelector('.search-menu');

   let parts = id.split("_");
   let mem_id = parts[0];
   let uname = parts[1];

   searchBox.value = uname;
   searchMenu.style.display = 'none';
   }


</script>
<!-- custom scripts end-->
@include('components.common.footer_end')
