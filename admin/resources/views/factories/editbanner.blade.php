
@extends('admin::components.common.main')

@section('content')
<!-- breadcrub navs start-->
   <div class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
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
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>

                        <a href="#"
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Settings

              </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">System</span>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Login/Forgot Password Banners</span>
                          <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                               @if($action == 'login')
                                    {{ __("Login/Forgot Password Banners") }}
                                @else
                                    {{ __("Register Banner") }}
                                @endif
                        </span>
                    </div>
                </li>
            </ol>
      </div>
<!-- breadcrub navs end-->

    <main class="flex-grow">
        <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
             <!--Success and Failure Messge-->
       @include('components.common.info_message')
     <!--Success and Failure Messge-->


            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">

                    <!--form-->
                        <div class="customer-form">
                              <form name="editbanner" id="editbanner" method="POST"
                               action="{{ route('validateeditbanner', [
        'action' => $action,
        'id' => $banner->banner_id
    ]) }}"
    method="POST"
    enctype="multipart/form-data" enctype="multipart/form-data" class="mb-5 pt-4">
 @csrf
                                <div class="mb-5">
                                <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Upload Banner Image') }}</label>
                                <input class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400" id="banner_image" name="banner_image" type="file" accept="image/x-png,image/gif,image/jpeg,image/png" value="{{ $banner_image}}" onchange="previewImage(event)">
                                <!-- <div class="mt-4">
    <img id="imagePreview" class="w-full h-auto object-cover rounded-lg shadow-md hidden" alt="Image Preview">
</div> -->
                              @if($action == 'login')
                                <label class="text-sm font-[550] dark:text-white">{{ __('Note: Image dimensions must be exactly 975 pixels in width and 940 pixels in height.') }}</label>

                                @else
                                <label class="text-sm font-[550] dark:text-white">{{ __('Note: Image dimensions must be exactly 650 pixels in width and 940 pixels in height.') }}</label>
                                @endif
                        </div>
                        <div class="relative">
                                    <img  id="imagePreview" alt="Image Preview" src="{{$banner_image}}" class="w-[21%] h-auto object-cover rounded-lg shadow-md">
                       </div>
                       <span id="errorMessage" class="text-red-500 text-sm mt-2 hidden"></span>

                                <input aria-label="label" type="hidden" name="banner_image" id="banner_image" value="{{$banner_image}}">
                             <div class="mb-5 pt-4">
                                    <label for=""class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Status') }}</label>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-black font-medium">{{ __('OFF') }}</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" name="banner_status" id="banner_status"  value="1" @if($errval['banner_status'] == '1') checked @endif/>
                                            <div class="w-12 h-6 bg-neutral-900 rounded-full peer peer-checked:bg-neutral-500 peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-neutral-300 after:rounded-full after:h-5 after:w-5 after:transition-transform"></div>
                                        </label>
                                        <span id="toggleText" class="text-black font-medium">{{ __('ON') }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-end p-4">
                                    <div class="form-submit">
                                        <button type="submit" name="submit" id="submit"  class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                                        <button type="button" onclick="window.history.back();" class=" text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-neutral-900  dark:hover:bg-neutral-800 dark:hover:border-neutral-600 dark:focus:ring-neutral-700 ">{{ __('Cancel') }}</button>
                                     </div>
                                </div>
                            </form>
                         </div>

                         </div>
                    </div>
                </div>
            </div>
        </main>



<!-- Content area end-->




<!-- end::Footer -->
<!--begin::MLM CustomPage Scripts -->
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const errorMessage = document.getElementById('errorMessage');
        const imagePreview = document.getElementById('imagePreview');
        const submitButton = document.getElementById('submit');

        // Clear previous error messages
        errorMessage.textContent = '';
        errorMessage.classList.add('hidden');

        // Enable the submit button by default
        submitButton.disabled = false;

        if (file) {
            // // Check file size (max 300 KB)
            // if (file.size > 300 * 1024) {
            //     errorMessage.textContent = 'File size must be under 300 KB.';
            //     errorMessage.classList.remove('hidden');
            //     imagePreview.classList.add('hidden');
            //     submitButton.disabled = true; // Disable the submit button if size exceeds
            //     return;
            // }

            // Create FileReader to preview the image
            const reader = new FileReader();

            reader.onload = function() {
                const img = new Image();
                img.src = reader.result;

                // Show image preview
                img.onload = function() {
                    imagePreview.src = reader.result;
                    imagePreview.classList.remove('hidden');
                };

                img.onerror = function() {
                    errorMessage.textContent = 'Invalid image file.';
                    errorMessage.classList.remove('hidden');
                    imagePreview.classList.add('hidden');
                };
            };

            reader.readAsDataURL(file);
        }
    }
</script>

<!-- custom scripts end-->

@endsection
