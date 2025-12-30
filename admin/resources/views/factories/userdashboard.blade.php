@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __('User Dashboard') }}</h2>
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
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('User Dashboard') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
</div>
</div>
<!-- breadcrub navs end-->
<!-- breadcrub navs end-->

        <!-- Content area -->
        <main class="flex-grow">
            <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
                <!--Success and Failure Messge-->
            @include('components.common.info_message')
                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                    <!-- card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                        <div>
                            <div class="p-4 rounded-lg" id="default-group" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                                    <!-- Left side: Form content -->
                                    <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5" >
                                        <form class="mx-auto validated-form" novalidate name="user_dashboard" method="POST" action="{{route('updatedashboardsetting')}}" id="user_dashboard" enctype="multipart/form-data">
                                            @csrf
                                            <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">{{ __('User Dashboard') }}</h3>

                                            <div class="mb-5">
                                                    <label for=""
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Banner Image') }}</label>
                                                        <input class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400"
                                                        name="banner_image" id="banner_image" type="file"
                                                        onchange="previewImage(event)">
                                                </div>
                                                <div id="preview_container" class="mb-5">
                                                <label for="description" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Preview') }}</label>
                                                <div class="w-full bg-white border border-neutral-200 rounded-lg shadow dark:bg-neutral-900 dark:border-neutral-700">
                                                    <div class="flex flex-col items-center p-10">
                                                        <!-- Placeholder Image or Icon -->
                                                        <img class="w-auto h-auto mb-3 shadow-lg" id="image_preview"
                                                         @if($banner_imagelink != '') src="{{$banner_imagelink}}" @else src="{{$_ENV['UI_ASSET_URL']}}/public/assets/img/noimage.png" @endif
                                                        alt=""
                                                        >
                                                    </div>
                                                </div>
                                                <p id="image-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Upload an image with 1830 x 300 pixels only') }}</p>
                                                <input type="hidden" value="{{$banner_image}}" name="hidden_banner_image" />
                                                </div>


                                            <div class="mb-5">
                                                    <label for=""
                                                        class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Image') }}</label>
                                                        <input class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400"
                                                        name="dashboard_profile_image" id="dashboard_profile_image" type="file"
                                                        onchange="previewProfileImage(event)">
                                                </div>
                                                <div id="preview_container_profile" class="mb-5">
                                                <label for="description" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Preview') }}</label>
                                                <div class="w-full bg-white border border-neutral-200 rounded-lg shadow dark:bg-neutral-900 dark:border-neutral-700">
                                                    <div class="flex flex-col items-center p-10">
                                                        <!-- Placeholder Image or Icon -->
                                                        <img class="w-auto h-auto mb-3 shadow-lg" id="image_preview_profile"
                                                         @if($dashboard_profile_image != '')
                                                src="{{ config('cdn.cloudfront_url') }}/{{ $dashboard_profile_image }}"
                                                @else
                                                    src="{{ config('cdn.ui_asset_url') }}/assets/img/noimage.png"
                                                @endif
                                                            alt=""
                                                        >
                                                    </div>
                                                </div>
                                                <p id="Profileimage-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden">{{ __('Upload an image with 320 x 170 pixels only') }}</p>
                                                <input type="hidden" value="{{$dashboard_profile_image}}" name="hidden_dashboard_profile_image" />
                                                </div>


                                                <div class="mb-5">
                                                <label for="banner_content" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Content') }}</label>
                                                <textarea id="banner_content" name="banner_content" rows="4" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" placeholder="Write your content here..." required aria-describedby="banner_content-error">{{$banner_content}}</textarea>
                                                <p id="banner_content-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                                </div>
                                                <div class="mb-5">
                                                <label for="social_feed_script" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Social feed script') }}</label>
                                                <textarea id="social_feed_script" name="social_feed_script" rows="4" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" placeholder="Write your content here..." required aria-describedby="social_feed_script-error">{{$social_feed_script}}</textarea>
                                                <p id="social_feed_script-error" class="error-message mt-2 text-sm text-red-600 dark:text-red-500 hidden"></p>
                                                </div>


                                            <div class="flex justify-end">
                                                <button type="button"
                                                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
 onclick="window.history.back();">{{ __('Cancel') }}</button>
                                                <button type="submit" id="submit_btn"
                                                    class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="flex flex-col p-10">

                                </div>
                            </div>
                        </div>

                        <!-- card -->

                    </div>
                    <!--Row-1-->

                </div>
        </main>

<!--chat-drawer:starts-->
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
        };
    } else {
        console.error("Preview element not found for ID:", previewId);
    }
};

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
      form: document.getElementById('user_dashboard'),
    };
  }

  attachEventListeners() {
    this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));

    // Real-time validation for required inputs, selects, and textareas
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach((input) => {
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
    const inputs = Array.from(this.elements.form.querySelectorAll('input[required], select[required], textarea[required]'));
    const allValid = inputs.every((input) => this.validateInput(input));

    if (allValid) {
      this.elements.form.submit();
    } else {
      console.error('Form validation failed.');
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new FormHandler();
});
</script>

<!-- <script type="text/javascript">
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

    </script> -->
<script type="text/javascript">
  function previewImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview_container');
    const imagePreview = document.getElementById('image_preview');
    const submitButton = document.getElementById('submit_btn');
    const imageErrorMsg = document.getElementById('image-error');

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = new Image();
        img.src = e.target.result;

        img.onload = function () {
          if (img.width == 1830 && img.height == 300) {
            imageErrorMsg.classList.add('hidden');
            imagePreview.src = e.target.result;
            // previewContainer.classList.remove('hidden');
            submitButton.disabled = false;
          } else {
            imageErrorMsg.classList.remove('hidden');
       imagePreview.src = '{{ config("cdn.ui_asset_url") }}/assets/img/noimage.png';

            // previewContainer.classList.add('hidden');
            submitButton.disabled = true;
          }
        };
      };
      reader.readAsDataURL(file);
    } else {
 imagePreview.src = '{{ config("cdn.ui_asset_url") }}/assets/img/noimage.png';

      previewContainer.classList.add('hidden');
      submitButton.disabled = true;
    }
  }

  function previewProfileImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview_container_profile');
    const imagePreview = document.getElementById('image_preview_profile');
    const submitButton = document.getElementById('submit_btn');
    const imageErrorMsg = document.getElementById('Profileimage-error');

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = new Image();
        img.src = e.target.result;

        img.onload = function () {
          if (img.width != 0 && img.height != 0) {
            imageErrorMsg.classList.add('hidden');
            imagePreview.src = e.target.result;
            // previewContainer.classList.remove('hidden');
            submitButton.disabled = false;
          } else {
            imageErrorMsg.classList.remove('hidden');
          imagePreview.src = '{{ config("cdn.ui_asset_url") }}/assets/img/noimage.png';

            // previewContainer.classList.add('hidden');
            submitButton.disabled = true;
          }
        };
      };
      reader.readAsDataURL(file);
    } else {
     imagePreview.src = '{{ config("cdn.ui_asset_url") }}/assets/img/noimage.png';

      previewContainer.classList.add('hidden');
      submitButton.disabled = true;
    }
  }
</script>

@endsection
