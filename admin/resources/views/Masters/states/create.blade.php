@extends('admin::components.common.main')

@section('content')
            <!-- Breadcrumb -->
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
                                class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">{{ __('Masters') }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m10 16 4-4-4-4" />
                            </svg>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('States Create') }}</span>
                        </div>
                    </li>
                </ol>
            </div>

            <main class="flex-grow">
            <div>
                @include('components.common.info_message')

                <div class="bg-white dark:bg-gray-900 border dark:border-gray-800 rounded-lg p-6 min-h-screen overflow-auto">
                       <div class="grid grid-cols-2">
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Create State</h1>
                        <a href="{{ route('admin.states.index') }}" class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                            {{ __('Back to List') }}
                        </a>
                    </div>
                    <form action="{{ route('admin.states.store') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label for="country_code" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Country Code</label>
                                <input type="text" id="country_code" name="country_code" maxlength="5" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"  oninput="this.value=this.value.toUpperCase()" required>
                              <span id='country_code_error'  class="text-red-500 text-xs hidden">Only allow characters<span>
                                @error('country_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="state_code" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">State Code</label>
                                <input type="text" id="state_code" name="state_code" maxlength="10" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required>
                               <span id='state_code_error'  class="text-red-500 text-xs hidden"> Special characters are not allowed except(.'-) <span>
                                @error('state_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="state_name" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">State Name</label>
                                <input type="text" id="state_name" name="state_name" maxlength="255" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" required>
                                <span id='state_name_error'  class="text-red-500 text-xs hidden">Numbers Special characters are not allowed except(.'-) <span>
                                @error('state_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 border-t pt-5 dark:border-gray-700 mt-8">
                            <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                                {{ __('Save') }}
                            </button>
                            <a href="{{ route('admin.states.index') }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-900 border dark:border-gray-800 dark:text-gray-300 text-xs hover:bg-gray-300 dark:hover:bg-gray-800">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
          </div>
            </div>
        </main>
@endsection
<script>

  document.addEventListener('DOMContentLoaded', function () {
   // alert("dfsdfsdf");
    const countrycode = document.getElementById('country_code');
    // alert($countrysortname);

    const errmsgcountrycode =document.getElementById('country_code_error');

    countrycode.addEventListener('keypress', function (e) {
        const char = String.fromCharCode(e.which);


        // allow letters (all languages) and space
        const regex =  /^[A-Za-z]$/;

        // /^[\p{L} . ']$/u
        if (!regex.test(char)) {
            e.preventDefault(); //  block number & special char
             errmsgcountrycode.classList.remove('hidden');

            // Hide error after 1.5 seconds
            setTimeout(() => {
                errmsgcountrycode.classList.add('hidden');

            }, 2000);
        }
    });
});
    document.addEventListener('DOMContentLoaded', function () {
   // alert("dfsdfsdf");
    const statecode = document.getElementById('state_code');
    // alert($countrysortname);

    const errmsgstatecode =document.getElementById('state_code_error');

    statecode.addEventListener('keypress', function (e) {
        const char = String.fromCharCode(e.which);


        // allow letters (all languages) and space
        const regex = /^[A-Za-z0-9-]$/;

        if (!regex.test(char)) {
            e.preventDefault(); //  block number & special char
             errmsgstatecode.classList.remove('hidden');

            // Hide error after 1.5 seconds
            setTimeout(() => {
                errmsgstatecode.classList.add('hidden');

            }, 2000);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
   // alert("ttttt");
    const statename= document.getElementById('state_name');
    // alert($countrysortname);

    const errmsgstate = document.getElementById('state_name_error');

    statename.addEventListener('keypress', function (e) {
        const char = String.fromCharCode(e.which);

        // allow letters (all languages) and space
        const regex = /^[\p{L} . ']$/u;

        if (!regex.test(char)) {
            e.preventDefault(); //  block number & special char
             errmsgstate.classList.remove('hidden');

            // Hide error after 1.5 seconds
            setTimeout(() => {
                errmsgstate.classList.add('hidden');

            }, 2000);
        }
    });
});
</script>
