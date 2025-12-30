@extends('admin::components.common.main')
@section('content')

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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Compansation</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Rank Settings</span>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Rank Settings</span>
            </div>
        </li>
    </ol>
</div>
<main class="flex-grow">
    <div class="">

        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-10 dark:border-gray-800 dark:bg-gray-900 dark:text-white border border-gray-200 ">

                <div>

                    <div class="p-4 rounded-lg">

                        <div class="flex justify-between ">
                            <div>
                                <h3 class="text-sm font-medium text-gray-800 mb-10 dark:text-gray-200">{{__('Add Rank')}}
                                </h3>
                            </div>
                           <div class="space-x-3">
                        <button type="button" onclick="addConditionField()" class="px-4 py-2 rounded-lg bg-gray-800 text-white text-xs hover:bg-gray-900 dark:bg-blue-500 dark:hover:bg-blue-600">
                            {{ __('Add Another Condition') }}
                        </button>
                        <button type="button" id="add-level-btn" class="px-4 py-2 rounded-lg bg-gray-800 text-white text-xs hover:bg-gray-900 dark:bg-blue-500 dark:hover:bg-blue-600">
                            {{ __('Add Level Commission') }}
                        </button>
                    </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">

                            <!-- Left side: Form content -->

                            <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5" bis_skin_checked="1">

                             <form id="rankSettingsForm" method="POST" enctype="multipart/form-data" action="{{ route('updateranksetting') }}">
                            @csrf
                            <input type="hidden" name="rank_icon_id" id="rank_icon_id">
                            <div class="mb-5">
                                <label for="matrixid" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Plan') }}</label>
                                <select id="matrixid" name="matrixid" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                    <option value="" {{ old('matrixid') == '' ? 'selected' : '' }}>{{ __('Select Plan') }}</option>
                                    @foreach($matrices as $m)
                                        <option value="{{ $m->matrix_id }}" {{ old('matrixid') == $m->matrix_id ? 'selected' : '' }}>{{ $m->matrix_name }}</option>
                                    @endforeach
                                </select>
                                @error('matrixid')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="rank_title" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Rank Title Name') }}</label>
                                <input type="text" id="rank_title" name="rank_title" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required value="{{ old('rank_title') }}">
                                @error('rank_title')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="rank_color" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Rank Color') }}</label>
                                <div class="flex items-center">
                                    <input type="color" id="rank_color" name="rank_color" class="w-12 h-8 p-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700" value="{{ old('rank_color', '#6b7280') }}" style="width: 100%;" required>
                                    <img src="{{ asset('assets/img/avatar/color-picker.png') }}" alt="Color Picker" class="ml-2 h-6 w-6 cursor-pointer">
                                </div>
                                @error('rank_color')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="file_input" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Rank Icon (Upload)') }}</label>
                                <input id="file_input" type="file" accept="image/*" name="rank_icon" class="block w-full text-xs text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 focus:outline-none" onchange="previewImage(event)">
                                <div id="preview_container" class="relative mt-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow">

                                    <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="inline-flex items-center absolute top-3 right-3 me-3 px-4 py-2 rounded-lg bg-gray-800 text-white text-xs hover:bg-gray-900 dark:bg-blue-500 dark:hover:bg-blue-600" type="button">
                                            <svg class="w-6 h-6 text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"></path>
                                            </svg>

                                            choose avatar
                                        </button>
                                      <div class="flex flex-col items-center p-12 dark:bg-gray-800 dark:border-gray-700">
                                        <img id="image_preview" class="w-24 h-24 rounded-full shadow-md" src="{{ asset('assets/img/noimage.png') }}">
                                    </div>
                                </div>
                                @error('rank_icon')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="condn0" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Condition') }}</label>
                                <select id="condn0" name="condn0" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                    <option value="" {{ old('condn0') == '' ? 'selected' : '' }}>{{ __('Select') }}</option>
                                    <option value="1" {{ old('condn0') == '1' ? 'selected' : '' }}>{{ __('Direct Referral') }}</option>
                                    <option value="2" {{ old('condn0') == '2' ? 'selected' : '' }}>{{ __('Group Referral') }}</option>
                                    <option value="3" {{ old('condn0') == '3' ? 'selected' : '' }}>{{ __('Number of Sales') }}</option>
                                    <option value="4" {{ old('condn0') == '4' ? 'selected' : '' }}>{{ __('Product Sold') }}</option>
                                    <option value="5" {{ old('condn0') == '5' ? 'selected' : '' }}>{{ __('Target Achieved') }}</option>
                                    <option value="6" {{ old('condn0') == '6' ? 'selected' : '' }}>{{ __('Level Condition') }}</option>
                                    <option value="7" {{ old('condn0') == '7' ? 'selected' : '' }}>{{ __('PV Points') }}</option>
                                    <option value="8" {{ old('condn0') == '8' ? 'selected' : '' }}>{{ __('GPV Points') }}</option>
                                    <option value="9" {{ old('condn0') == '9' ? 'selected' : '' }}>{{ __('Sales Target') }}</option>
                                    <option value="10" {{ old('condn0') == '10' ? 'selected' : '' }}>{{ __('Group Sales Target') }}</option>
                                    <option value="11" {{ old('condn0') == '11' ? 'selected' : '' }}>{{ __('Online Sales PV') }}</option>
                                </select>
                                @error('condn0')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="value0" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Value') }}</label>
                                <input type="text" id="value0" name="value0" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required value="{{ old('value0') }}">
                                @error('value0')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="additional-fields-container"></div>
                            <div class="mb-5">
                                <label for="bonus" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Bonus') }}</label>
                                <input type="number" id="bonus" name="bonus" value="{{ old('bonus', 0) }}" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                @error('bonus')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="wallet" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Wallet Type') }}</label>
                                <select id="wallet" name="wallet" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                    <option value="" {{ old('wallet') == '' ? 'selected' : '' }}>{{ __('Select Wallet') }}</option>
                                    @if($wallets->isEmpty())
                                        <option value="" disabled>No wallets available</option>
                                    @else
                                        @foreach($wallets as $w)
                                            <option value="{{ $w->wallet_type_id }}" {{ old('wallet') == $w->wallet_type_id ? 'selected' : '' }}>{{ $w->wallet_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('wallet')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="directbonus" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Direct Bonus (%)') }}</label>
                                <input type="number" id="directbonus" name="directbonus" value="{{ old('directbonus', 0) }}" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                @error('directbonus')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="networkbonus" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Network Bonus (%)') }}</label>
                                <input type="number" id="networkbonus" name="networkbonus" value="{{ old('networkbonus', 0) }}" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                @error('networkbonus')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="maxbonus" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('Max Bonus') }}</label>
                                <input type="number" id="maxbonus" name="maxbonus" value="{{ old('maxbonus', 0) }}" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" required>
                                @error('maxbonus')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <div id="level-form-field" class="hidden mt-4">
                                    <label for="level-input" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">{{ __('No. of Level Commissions') }}</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="number" id="level-input" name="totallevel" class="text-xs text-gray-600 rounded-lg  block w-full p-2 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700" placeholder="Enter number of levels" value="{{ old('totallevel', 0) }}">
                                        <button id="generate-levels-btn" type="button" class="p-2 text-green-600 bg-green-100 rounded-lg hover:bg-green-200 focus:ring-2 focus:ring-green-300 dark:bg-green-200 dark:hover:bg-green-300 dark:focus:ring-green-600">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="sr-only">{{ __('Generate') }}</span>
                                        </button>
                                        <button id="close-level-btn" type="button" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-300 dark:bg-red-200 dark:hover:bg-red-300 dark:focus:ring-red-600">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            <span class="sr-only">{{ __('Close') }}</span>
                                        </button>
                                    </div>
                                    @error('totallevel')
                                        <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div id="level-container" class="mt-5 space-y-4"></div>
                            </div>
                            <input type="hidden" value="1" id="rankcount" name="rankcount">
                            <input type="hidden" id="rankform" name="rankform" value="{{ old('rankform') }}">
                            <input type="hidden" id="hidden_levelcomm" name="hidden_levelcomm" value="{{ old('hidden_levelcomm', 0) }}">
                            <div class="flex justify-end space-x-3 pt-6">
                                <button type="button" onclick="window.history.back()" class="px-4 py-2 text-xs text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 ">{{ __('Cancel') }}</button>
                                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-800 text-white text-xs hover:bg-gray-900 dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Submit') }}</button>
                            </div>
                        </form>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- card -->

            </div>
            <!--Row-1-->

        </div>

</main>

    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full top-3">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 dark:border-gray-600 border border-gray-200">
                        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ __('Avatar') }}</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="default-modal">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">{{ __('Close modal') }}</span>
                            </button>
                        </div>
                    <div class="p-4 md:p-5 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $avatars = [
                    ['id' => 'avatar', 'path' => 'assets/img/avatar/avatar.png'],
                    ['id' => 'avatar1', 'path' => 'assets/img/avatar/avatar1.png'],
                    ['id' => 'avatar2', 'path' => 'assets/img/avatar/avatar2.png'],
                    ['id' => 'avatar3', 'path' => 'assets/img/avatar/avatar3.png'],
                    ['id' => 'avatar4', 'path' => 'assets/img/avatar/avatar4.png'],
                    ['id' => 'avatar5', 'path' => 'assets/img/avatar/avatar5.png'],
                ];
            @endphp
            @foreach($avatars as $avatar)
                <div class="relative bg-white rounded-full shadow-md overflow-hidden dark:bg-gray-900">
                    <img src="{{ asset($avatar['path']) }}" alt="Avatar"
                        class="w-full h-48 object-contain">
                    <div
                        class="absolute inset-0 bg-gray-900 bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button type="button"
                            class="avatar-image text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-2 py-2 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                            data-id="{{ $avatar['id'] }}"
                            data-image="{{ asset($avatar['path']) }}" data-modal-hide="default-modal">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
                    </div>
                </div>
            </div>



<!--chat-drawer:starts-->
<script>


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
      form: document.getElementById('rankSettingsForm'),
    };
  }

  attachEventListeners() {
    this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));

    // Real-time validation
    document.querySelectorAll('input[required], select[required]').forEach((input) => {
      input.addEventListener('input', () => this.validateInput(input));
    });
  }

  validateAllInputs() {
    const inputs = Array.from(this.elements.form.querySelectorAll('input[required], select[required]'));
    let isFormValid = true;

    inputs.forEach((input) => {
      const isValid = this.validateInput(input);

      console.log('inputs')
      console.log(input)
      console.log(isValid)
      console.log('inputs')
      if (!isValid) {
        isFormValid = false;
      }
    });

    return isFormValid;
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
      errorElement.textContent = '';
      errorElement.classList.add('hidden');
    }
  }

  handleSubmit(e) {
    e.preventDefault();

    // Validate all inputs at once
    const isFormValid = this.validateAllInputs();

    console.log('Submitting')
    if (isFormValid) {
      console.log('Form is valid. Submitting...');
      this.elements.form.submit(); // Proceed with form submission
    } else {
      console.log('Form validation failed.');
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new FormHandler();
});


        function toggleInputFields() {
            const urlInput = document.getElementById('url-input');
            const fileInput = document.getElementById('file-input');

            // Check which radio button is selected
            if (document.getElementById('url-radio').checked) {
                urlInput.classList.remove('hidden');
                fileInput.classList.add('hidden');
            } else if (document.getElementById('upload-radio').checked) {
                fileInput.classList.remove('hidden');
                urlInput.classList.add('hidden');
            }
        }

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

       function addConditionField() {
    let counter = parseInt(document.getElementById('rankcount').value) || 0;
    const container = document.getElementById('additional-fields-container');
    const newFieldWrapper = document.createElement('div');
    newFieldWrapper.classList.add('mb-5');
    const conditionLabel = document.createElement('label');
    conditionLabel.classList.add('block', 'mb-3', 'text-xs', 'text-gray-600', 'dark:text-gray-300');
    conditionLabel.textContent = '{{ __("Condition") }}';
    const conditionSelect = document.createElement('select');
    conditionSelect.classList.add('block', 'w-full', 'p-2', 'text-xs', 'text-gray-600', 'border', 'border-gray-300', 'rounded-lg', 'dark:bg-gray-800', 'dark:border-gray-700', 'dark:text-gray-300');
    conditionSelect.name = `condn${counter}`;
    conditionSelect.required = true;
    const options = [
        { value: "", label: "{{ __('Select') }}" },
        { value: "1", label: "{{ __('Direct Referral') }}" },
        { value: "2", label: "{{ __('Group Referral') }}" },
        { value: "3", label: "{{ __('Number of Sales') }}" },
        { value: "4", label: "{{ __('Product Sold') }}" },
        { value: "5", label: "{{ __('Target Achieved') }}" },
        { value: "6", label: "{{ __('Level Condition') }}" },
        { value: "7", label: "{{ __('PV Points') }}" },
        { value: "8", label: "{{ __('GPV Points') }}" },
        { value: "9", label: "{{ __('Sales Target') }}" },
        { value: "10", label: "{{ __('Group Sales Target') }}" },
        { value: "11", label: "{{ __('Online Sales PV') }}" },
    ];
    conditionSelect.innerHTML = options.map(option => `<option value="${option.value}">${option.label}</option>`).join('');
    const errorConditionMessage = document.createElement('p');
    errorConditionMessage.className = 'mt-2 text-xs text-red-600 dark:text-red-500 hidden';
    errorConditionMessage.textContent = '{{ __("Please select a condition.") }}';
    const valueLabel = document.createElement('label');
    valueLabel.classList.add('block', 'mb-3', 'text-xs', 'text-gray-600', 'dark:text-gray-300', 'mt-3');
    valueLabel.textContent = '{{ __("Value") }}';
    const valueInput = document.createElement('input');
    valueInput.type = 'text';
    valueInput.classList.add('block', 'w-full', 'p-2', 'text-xs', 'text-gray-600', 'border', 'border-gray-300', 'rounded-lg', 'dark:bg-gray-800', 'dark:border-gray-700', 'dark:text-gray-300');
    valueInput.name = `value${counter}`;
    valueInput.required = true;
    const errorValueMessage = document.createElement('p');
    errorValueMessage.className = 'mt-2 text-xs text-red-600 dark:text-red-500 hidden';
    errorValueMessage.textContent = '{{ __("Please enter a valid value.") }}';
    newFieldWrapper.appendChild(conditionLabel);
    newFieldWrapper.appendChild(conditionSelect);
    newFieldWrapper.appendChild(errorConditionMessage);
    newFieldWrapper.appendChild(valueLabel);
    newFieldWrapper.appendChild(valueInput);
    newFieldWrapper.appendChild(errorValueMessage);
    container.appendChild(newFieldWrapper);
    counter++;
    document.getElementById('rankcount').value = counter;
}

        // Get elements
    const addLevelBtn = document.getElementById('add-level-btn');
    const levelFormField = document.getElementById('level-form-field');
    const generateLevelsBtn = document.getElementById('generate-levels-btn');
    const levelInput = document.getElementById('level-input');
    const levelContainer = document.getElementById('level-container');

    // Show the Level Commission field when "Add Level Commission" is clicked
    addLevelBtn.addEventListener('click', () => {
        levelFormField.classList.remove('hidden');
    });

    // Generate Level Input Fields
    generateLevelsBtn.addEventListener('click', () => {
        const levelCount = parseInt(levelInput.value);

        // Clear previous input fields
        levelContainer.innerHTML = '';

        // Check if the input is a valid number
        if (isNaN(levelCount) || levelCount <= 0) {
            alert('Please enter a valid number greater than 0.');
            return;
        }


        // Generate input fields based on the level count
        for (let i = 1; i <= levelCount; i++) {
            const inputGroup = document.createElement('div');
            inputGroup.className = 'mb-5';

            const label = document.createElement('label');
            label.className = 'block mb-2 text-sm font-medium text-black dark:text-white';
            label.innerText = `Level ${i}  (%)`;

            const input = document.createElement('input');
            input.type = 'number';
            input.placeholder = `Enter value for Level ${i}`;
            input.className =
                'bg-gray-50 text-black dark:text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800  dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500';
            input.name = `lvl${i}`;
            input.required = true; // Add the required attribute
            input.setAttribute('aria-describedby', `lvl-error-${i}`); // Set the aria-describedby attribute dynamically

            // Create the error message element
            const errorMessage = document.createElement('p');
            errorMessage.id = `lvl-error-${i}`; // Unique ID for each error message
            errorMessage.className =
                'error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden';
            errorMessage.textContent = 'Please enter a valid level.';


            inputGroup.appendChild(label);
            inputGroup.appendChild(input);
            inputGroup.appendChild(errorMessage);
            levelContainer.appendChild(inputGroup);
        }
    });
      // Get elements
        const closeLevelBtn = document.getElementById('close-level-btn');

        // Close the Level Commission field when the close button is clicked
        closeLevelBtn.addEventListener('click', () => {
            levelFormField.classList.add('hidden');
            levelContainer.classList.add('hidden');
        });

          // Attach click event listener to each avatar image
    document.querySelectorAll('.avatar-image').forEach(function (image) {
        image.addEventListener('click', function () {
              // Get the data-id attribute from the clicked image
              var avatarId = this.getAttribute('data-id');

            // Update the value of the hidden input field with the ID of the clicked avatar
            document.getElementById('rank_icon_id').value = avatarId;

            // Get the image URL from the data-image attribute
            var newImageSrc = this.getAttribute('data-image');

            // Update the preview image's src attribute
            document.getElementById('image_preview').src = newImageSrc;

        });
    });

    function previewImage(event) {
        const file = event.target.files[0];
        const imagePreview = document.getElementById('image_preview');
        const rankIconId = document.getElementById('rank_icon_id');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                rankIconId.value = ''; // Clear avatar selection when file uploaded
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '{{ asset('public/assets/img/noimage.png') }}';
        }
    }

    // Avatar selection - EXACTLY LIKE OLD CODE
    document.querySelectorAll('.avatar-image').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const avatarId = this.getAttribute('data-id');
            const imageSrc = this.getAttribute('data-image');

            document.getElementById('rank_icon_id').value = avatarId;
            document.getElementById('image_preview').src = imageSrc;
            document.getElementById('file_input').value = ''; // Clear file input
        });
    });

    </script>
@endsection
