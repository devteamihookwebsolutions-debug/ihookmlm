
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
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>

                        <a href="#"
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Personalization

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
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Registration</span>
                    </div>
                </li>
            </ol>
    </div>
<!-- breadcrub navs end-->

<!-- Content area -->

<main class="flex-grow">
            <div class="">
        <!--Success and Failure Messge-->
       @include('components.common.info_message')
       <!--Success and Failure Messge-->
               <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
                  <!-- card -->
                <form method="post" action="{{route('updateRegSettings')}}" name="registersettings" id="registersettings">
                    @csrf
                  <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                     <div class="relative overflow-x-auto sm:rounded-lg">
                                        {!! $category !!}
                        <div class="border-t pt-6 mt-6">
                           <div class="flex justify-end gap-2">
                              <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 text-xs text-gray-800 hover:bg-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600"
>{{ __('Update') }}</button>
                              <button  type="button" onclick="window.history.back();" class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600"
>{{ __('Cancel') }}</button>
                           </div>
                        </div>
                     </div>
                  </div>
                </form>
                  <!-- card -->
               </div>
               <!--Row-1-->
            </div>
         </main>


<!-- custom scripts start-->

<script language="javascript">
function displayteams(id)
   {
 if(document.getElementById('chkSub[5]').style.display == "none")
 {
       document.getElementById('chkSub[5]').style.display = "block";
 }
 else if(document.getElementById('chkSub[5]').style.display == "block")
 {
   document.getElementById('chkSub[5]').style.display = "none";
 }
}
</script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const chkSub16 = document.getElementById('chkSub16');
        const blockUsername = document.getElementById('blockusername');
        const selectAll1 = document.getElementById('selectall1');

        // Initial check to show/hide blockUsername based on chkSub16's state
        if (!chkSub16.checked) {
            blockUsername.classList.remove('hidden');
        } else {
            blockUsername.classList.add('hidden');
        }

        // Event listener for chkSub16
        chkSub16.addEventListener('click', function () {
            if (this.checked) {
                blockUsername.classList.add('hidden');
            } else {
                blockUsername.classList.remove('hidden');
            }
        });

        // Event listener for selectAll1
        selectAll1.addEventListener('click', function () {
            if (this.checked) {
                blockUsername.classList.add('hidden');
            } else {
                blockUsername.classList.remove('hidden');
            }
        });



        const selectAllCheckbox = document.getElementById('selectall1');
        const checkAllCheckboxes = document.querySelectorAll('.checkallc');
        selectAllCheckbox.addEventListener('click', function () {
            const isChecked = this.checked;
            checkAllCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked; // Toggle the checked state
            });
        });

        const selectAllCheckbox1 = document.getElementById('selectall');
        const checkAllCheckboxes1 = document.querySelectorAll('.case');
        selectAllCheckbox1.addEventListener('click', function () {
            const isChecked = this.checked;
            checkAllCheckboxes1.forEach(checkbox => {
                checkbox.checked = isChecked; // Toggle the checked state
            });
        });


    });
</script>





@endsection
