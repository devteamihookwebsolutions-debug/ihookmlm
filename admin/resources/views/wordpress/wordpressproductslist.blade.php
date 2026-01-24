@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs end-->
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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">E-store</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                    aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Products</span>
            </div>
        </li>
    </ol>
 </div>
<!-- breadcrub navs end-->

<!-- Content area -->
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
    <div class="flex p-4 mb-6 text-sm text-blue-800 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 border border-blue-300" role="alert" bis_skin_checked="1">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
           <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"></path>
        </svg>
        <span class="sr-only">Info</span>
        <div bis_skin_checked="1">
           <div bis_skin_checked="1">
           <p class="mb-2">Here you can list out whole physical products from Woocommerce if you are already configured a store</p>
           </div>
        </div>
     </div>
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
        <div class="flex justify-end pt-4 pb-6" bis_skin_checked="1">
        <a aria-label="link" href="{{$_ENV['BCPATH']}}/wordpressproducts/eaddproducts">
            <button class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105" type="button">Add Product</button>
        </a>
        </div>

        <div id="preloader" class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-opacity-75 z-10 hidden">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-transparent border-t-blue-500 border-r-blue-500"></div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-5" id="product-container">{!! $products !!}</div>

        </div>

    </div>
    <div id="show-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-3xl max-h-full">
          <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
              <h3 class="text-xl font-semibold text-black dark:text-white">Product Details</h3>
              <button type="button" onclick="closeModal('show-modal');"
                class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                >
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal Body -->
            <div class="p-4 md:p-5 space-y-4" id="view_product_details">
            </div>
            <!-- Modal Footer -->
            <!-- <div class="flex justify-end py-6">
              <button type="button" onclick="closeModal('show-modal');"
                class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>Cancel</button>
              <button type="button"
                class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Submit</button>
            </div> -->
          </div>
        </div>
      </div>
</main>

<script>
   function showEproductDetails(id) {
    console.log('Fetching details for product ID:', id);

    fetch('{{$_ENV['BCPATH']}}/wordpressproducts/showeproducts/' + id, {
        method: 'GET',
        headers: {
            'Accept': 'text/html',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Server error: ' + response.status);
        }
        return response.text();
    })
    .then(html => {
        document.getElementById('view_product_details').innerHTML = html;

        const modalEl = document.getElementById('show-modal');
        const modal = new Modal(modalEl, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
        modal.show();
    })
    .catch(err => {
        console.error('Fetch error:', err);
        document.getElementById('view_product_details').innerHTML =
            '<div class="p-4 text-red-600">Failed to load details: ' + err.message + '</div>';

        const modalEl = document.getElementById('show-modal');
        const modal = new Modal(modalEl);
        modal.show();
    });
}

    function deleteeproducts(val) {
        const swalClasses = {
            confirmButton: 'px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-red-300',
            cancelButton: 'px-6 py-2 bg-neutral-300 text-black rounded-lg hover:bg-neutral-400 focus:outline-none focus:ring-4 focus:ring-neutral-300'
        };

        Swal.fire({
            title: 'Do you want to delete this product?',
            text: "This will delete the selected product.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Sure',
            cancelButtonText: 'Cancel',
            padding: '2.5rem',
            customClass: swalClasses
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                    customClass: swalClasses
                });

                fetch("{{ url('/admin/wordpressproducts/delete') }}/" + val, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(async (response) => {
                    Swal.close();

                    if (response.ok || response.redirected) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The product has been deleted successfully.',
                            icon: 'success',
                            padding: '2.5rem',
                            customClass: swalClasses
                        });

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        const errData = await response.json();
                        throw new Error(errData.message || 'Delete failed');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Something went wrong while deleting the product.',
                        icon: 'error',
                        padding: '2.5rem',
                        customClass: swalClasses
                    });
                    console.error('Delete error:', error);
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your record is safe.',
                    icon: 'info',
                    padding: '2.5rem',
                    customClass: swalClasses
                });
            }
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        let searchBox = document.getElementById("search-box");
        let showAllProducts = document.getElementById("product-container"); // Use an ID instead
        let preloader = document.getElementById("preloader");
        let rowsCnt = 8; // Default number of rows
        let isFetching = false;

         // Function to load more products
        function loadMoreProducts() {
            if (isFetching) return; // Prevent duplicate requests
            isFetching = true;
            preloader.classList.remove("hidden"); // Show preloader

            // Simulate an AJAX request to fetch data (Replace with actual API call)
            fetch(`{{$_ENV['BCPATH']}}/wordpressproducts/getrecords/${rowsCnt}`)
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "") {
                        window.removeEventListener("scroll", onScroll); // Stop fetching if no more data
                    } else {
                        showAllProducts.innerHTML += data;
                        rowsCnt += 8; // Increase row count
                    }
                })
                .catch(error => console.error("Error loading products:", error))
                .finally(() => {
                    isFetching = false;
                    preloader.classList.add("hidden"); // Show preloader
                });
        }

        // Function to check scroll position and trigger loading
        function onScroll() {
            if (window.innerHeight + window.scrollY >= document.body.scrollHeight - 50) {
                loadMoreProducts();
            }
        }

        // Attach scroll event
        window.addEventListener("scroll", onScroll);
    });


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
</script>
@endsection
