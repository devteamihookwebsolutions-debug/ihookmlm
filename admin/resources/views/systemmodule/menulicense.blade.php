@extends('admin::components.common.main')

@section('content')


<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
        <h2 class="text-lg font-medium text-black mb-2 dark:text-white">{{ __("System Modules") }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __("Home") }}
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
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('System') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('System Modules') }}</span>
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
            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
            Here you can see the additional modules that we provide, you can purchase and enjoy the add-on features through our support team
            </div>
            </div>

                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5 mb-5">
                    <!-- Example cards -->
                    <div class="bg-white text-black rounded dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                      <div class="w-full mx-auto p-4">
                        <!-- Filter Section -->
                        <!-- Filter Section End -->
                    
                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table id="data-table" class="min-w-full divide-y divide-neutral-200 w-full text-sm text-left rtl:text-right text-black dark:text-white">
                            <tbody class="divide-y divide-neutral-200">
                            <tr>
                                    <td class="px-0 py-6">{{ __('Party plan') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkpartyplanactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatepartyplan">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="partyplan">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Sales Funnel') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checksalesfunnelactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatesalesfunnel">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="salesfunnel">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Social Media Engine') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checksocialmediaengineactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatesocialmediaengine">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="socialmediaengine">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Shop Replicate') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkshopreplicatedactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activateshopreplicated">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="shopreplicated">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Epin') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkepinactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activateepin">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="epin">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('SMS') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checksmsactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatepartyplan">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="sms">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Elearning') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkelearningactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activateelearning">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="elearning">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Shopify Integration') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkshopifyactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activateshopify">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="shopify">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Premium Elearning') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkpremium_elearningactive == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatepremiumelearning">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="premiumelearning">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Ticket Center') }}</td>
                                    <td class="px-0 py-6">
                                    @if($checkticketcenter == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activateticketcenter">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="ticketcenter">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Site Analytics') }}</td>
                                    <td class="px-0 py-6">
                                    @if($matomo_analytics == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatematomoanalytics">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="matomoanalytics">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-6">{{ __('Dynamic Compression') }}</td>
                                    <td class="px-0 py-6">
                                    @if($dynamiccompression == '1')
                                    <a aria-label="link" class="btn text-white bg-gradient-to-r from-green-500 to-teal-500 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-teal-300 rounded-lg px-4 py-2  cursor-pointer" id="activatedynamiccompression">{{ __('Activated') }}</a>@else
                                    <a aria-label="link" class="del_butt text-white bg-neutral-900 hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg px-4 py-2 cursor-pointer" id="dynamiccompression">
                                        {{ __('Purchase') }}
                                    </a>@endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        </div>
                    </div>                                               

                    </div>
                   
                </div>

              


            </div>
        </main>


<!-- Content area end-->
  <!-- Modal content -->

<div id="systemmodule" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t  dark:text-white">{{ __('License') }}</h3>
                <button type="button"
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
          
        </div>
    </div>
</div>














<!-- Footer -->


<script>
    document.addEventListener("DOMContentLoaded", function () {
  const mappings = {
    partyplan: "partyplanlicensekey",
    salesfunnel: "salesfunnellicensekey",
    socialmediaengine: "socialmediaenginelicensekey",
    shopreplicated: "shopreplicatedlicensekey",
    sms: "smslicensekey",
    epin: "epinlicensekey",
    elearning: "elearninglicensekey",
    messagecenter: "messagecenterlicensekey",
    ticketcenter: "ticketcenterlicensekey",
  };

  Object.keys(mappings).forEach((id) => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener("click", function () {
        const licenseKeyInput = document.getElementById("licensekey");
        if (licenseKeyInput) {
          licenseKeyInput.setAttribute("name", mappings[id]);
        }
        const modal = document.getElementById("systemmodule");
        if (modal) {
            modal.classList.remove("hidden");
        }
      });
    }
  });
});

</script>
@endsection