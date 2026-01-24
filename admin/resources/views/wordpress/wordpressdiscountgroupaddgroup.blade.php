@include('components.common.header')
<!-- custom styles end-->
@include('components.common.topbars')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white mb-2">{{ __('Add Discount Group') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="{{$_ENV['BCPATH']}}/adminhome" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __('E-Store') }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Discount Group') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Add Discount Group') }}</span>
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


       <div class="bg-white rounded-lg shadow p-6 mb-7">
    <div>
        <div class="p-4 rounded-lg">
            <div class="flex items-center">
                <div>
                    <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">{{ __('Add Discount Group') }}</h3>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5">
                    <form  name="showaddgroup" id="showaddgroup" method="POST" action="{{$_ENV['BCPATH']}}/wordpressdiscountgroup/updategroup" enctype="multipart/form-data">
                        <div class="mb-5">
                            <label for="" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Group Name') }}</label>
                            <input type="text" name="group_name" id="group_name"  value="" 
                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                placeholder="" required>
                        </div>
                        <div class="">
                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __('Status') }}
                                        </td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <!-- Left label -->
                                                <span
                                                    class="text-sm font-medium text-black dark:text-white">{{ __('Off') }}</span>

                                                <!-- Toggle switch -->
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="status" id="status" value="1" class="sr-only peer">
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>
                                                <!-- Right label -->
                                                <span
                                                    class="text-sm font-medium text-black dark:text-white">{{ __('On') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="">

                            <table class="min-w-2xl">
                                <tbody>
                                    <tr>
                                        <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">{{ __('Cart Status') }}
                                        </td>
                                        <td class="px-6  text-right">
                                            <div class="flex items-center p-2.5">
                                                <!-- Left label -->
                                                <span
                                                    class="text-sm font-medium text-black dark:text-white">{{ __('Off') }}</span>

                                                <!-- Toggle switch -->
                                                <label class="inline-flex items-center cursor-pointer mx-3">
                                                    <input type="checkbox" name="cart_status" id="cart_status" value="1" class="sr-only peer">
                                                    <div
                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                    </div>
                                                </label>

                                                <!-- Right label -->
                                                <span
                                                    class="text-sm font-medium text-black dark:text-white">{{ __('On') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-end">
                            <a aria-label="link" href="javascript:void(0);" onclick="window.history.back();"> <button type="button"
                                class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button></a>
                            <button type="submit"
                                class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
                <div class="flex flex-col p-10">
                    <!--image-space-->
                    <img src="{{$_ENV['UI_ASSET_URL']}}/public/assets/img/sms.svg" alt="add-customer" class="w-full sticky top-0 overflow-hidden">
                    <!--image-space-->
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
 </main>
@include('components.common.footer')
<!-- custom scripts start-->

@include('components.common.footer_scripts')

@include('components.common.footer_end')