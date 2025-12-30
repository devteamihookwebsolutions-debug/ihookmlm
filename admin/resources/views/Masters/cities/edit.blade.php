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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">{{ __('Masters') }}</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Cities Edit') }}</span>
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
                        <h1 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Edit City</h1>
                        <a href="{{ route('cities.index') }}"
                            class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                            {{ __('Back to List') }}
                        </a>
                    </div>
                    <form action="{{ route('cities.update', $city) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-3">
                            <div>
                                <label for="city_name"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">City
                                    Name</label>
                                <input type="text" id="city_name" name="city_name"
                                    value="{{ old('city_name', $city->city_name) }}" maxlength="250"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    required>
                                @error('city_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="country_id"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Country</label>
                                <select id="country_id" name="country_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    required>
                                    <option value="" disabled>Select a country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_master_id }}"
                                        {{ old('country_id', $city->country_id) == $country->country_master_id ? 'selected' : '' }}>
                                        {{ $country->country_master_name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="state_id"
                                    class="block mb-3 text-xs text-gray-600 dark:text-gray-300">State</label>
                                <select id="state_id" name="state_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                                    required>
                                    <option value="" disabled>Select a state</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state_id }}"
                                        {{ old('state_id', $city->state_id) == $state->state_id ? 'selected' : '' }}>
                                        {{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 border-t pt-5 dark:border-gray-700 mt-8">
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                                {{ __('Update') }}
                            </button>
                            <a href="{{ route('cities.index') }}"
                                class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-900 border dark:border-gray-800 dark:text-gray-300 text-xs hover:bg-gray-300 dark:hover:bg-gray-800">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
