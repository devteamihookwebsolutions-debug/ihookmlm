@extends('admin::components.common.main')
@section('content')
        <!-- Breadcrumb -->

<div class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin/dashboard"
                class="inline-flex items-center text-xs font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                <div class="relative w-5 h-5 flex items-center justify-center">

                    <!-- Animated Border ONLY -->
                    <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                                animate-ping opacity-60"></span>

                    <!-- Static Icon -->
                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                </div>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">General Settings

                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Site Settings
                </a>
            </div>
        </li>
    </ol>
</div>
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <div class="flex p-4 mb-6 text-sm text-blue-800 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 border border-blue-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                </path>
            </svg>
            <span class="sr-only">Info</span>
            <div>

                <div>
                    <p class="mb-2">{{ __('This tool will guide you to create tutorial for your customers. once you create any tutorial like video or PDF, it will be reflected in user side.') }}</p>


                </div>
            </div>
        </div>
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <div>
                    <div class="p-4 rounded-lg">
                        <div class="w-full mx-auto p-4">
                            <!-- Data Table -->
                            <div class="overflow-x-auto">
                                <!-- Table -->
                                <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                                    <thead>
                                        <tr>
                                            <th>{{ __('S.No') }}</th>
                                            <th>{{ __('User Name') }}</th>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Payment Mode') }}</th>
                                            <th>{{ __('Payment Status') }}</th>
                                            <th>{{ __('Created On') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! $course_payment !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('components.common.datatable_script')
<script>
    function changeelearningSettings(id, mid) {
        Swal.fire({
          title: "{{ __('Do You Want To Accept Withdrawal') }}",
          text: "",
          icon: "warning",
          width: 400,
          heightAuto: false,
          padding: "2.5rem",
          showCancelButton: true,
          confirmButtonText: "{{ __('Yes, I am sure!') }}",
          cancelButtonText: "{{ __('Cancel It') }}",
          customClass: {
            popup: "bg-white rounded-lg shadow-lg",
            confirmButton: "btn btn-primary text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2",
            cancelButton: "btn btn-secondary text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
          },
          buttonsStyling: false,
          confirmButtonColor: "#d33"
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`{{$_ENV['BCPATH']}}/coursepayment/changepaymentstatus/${id}/${mid}`, {
              method: "GET",
              cache: "no-cache"
            })
            .then(response => response.text())
            .then(resultData => {
              Swal.fire({
                title: "{{ __('Done') }}",
                text: "{{ __('Withdrawal Request Accepted') }}",
                icon: "success",
                customClass: {
                  popup: "bg-white rounded-lg shadow-lg",
                  title: "text-xl font-semibold text-black",
                  text: "text-sm text-black",
                  confirmButton: "btn btn-primary text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                },
                buttonsStyling: false
              }).then(() => {
                window.location.href = "{{$_ENV['BCPATH']}}/showcoursepayment";
              });
            })
            .catch(error => {
              console.error("Error:", error);
            });
          } else {
            Swal.fire({
              title: "{{ __('Cancelled') }}",
              text: "{{ __('Withdrawal Request Not Accepted') }}",
              icon: "error",
              customClass: {
                popup: "bg-white rounded-lg shadow-lg",
                title: "text-xl font-semibold text-black",
                text: "text-sm text-black",
                confirmButton: "btn btn-primary text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
              },
              buttonsStyling: false
            });
          }
        });
        return false;
      }


      function cancelelerningSettings(id, mid) {
        Swal.fire({
          title: "{{ __('Do You Want Cancel Withdrawal') }}",
          text: "{{ __('COURSE_PAYMENT') }}",
          icon: "warning",
          width: 400,
          heightAuto: false,
          padding: "2.5rem",
          showCancelButton: true,
          confirmButtonText: "{{ __('Yes, I am sure!') }}",
          cancelButtonText: "<span>{{ __('Cancel') }}</span>",
          cancelButtonColor: "#d33",
          customClass: {
            popup: "bg-white rounded-lg shadow-lg",
            confirmButton: "btn btn-primary text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2",
            cancelButton: "btn btn-secondary text-black dark:text-white bg-white focus:outline-none hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
          },
          buttonsStyling: false
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "{{ __('Deleted') }}",
              text: "{{ __('WITHDRAWAL_REQUEST_CANCELLED') }}",
              icon: "success",
              customClass: {
                popup: "bg-white rounded-lg shadow-lg",
                title: "text-xl font-semibold text-black",
                text: "text-sm text-black",
                confirmButton: "btn btn-primary text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
              },
              buttonsStyling: false
            }).then(() => {
              window.location = "{{$_ENV['BCPATH']}}/coursepayment/cancelpayment/" + id + "/" + mid;
            });
          } else {
            Swal.fire({
              title: "{{ __('Cancelled') }}",
              text: "{{ __('WITHDRAWAL_REQUEST_NOT_CANCELLED') }}",
              icon: "error",
              customClass: {
                popup: "bg-white rounded-lg shadow-lg",
                title: "text-xl font-semibold text-black",
                text: "text-sm text-black",
                confirmButton: "btn btn-primary text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
              },
              buttonsStyling: false
            });
          }
        });
        return false;
      }


</script>
@endsection
