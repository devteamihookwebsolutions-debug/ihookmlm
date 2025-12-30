<div class="grid gap-4 mb-4 sm:grid-cols-2">
    {{-- Username --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Username') }} <span class="text-red-600">*</span>
        </label>
        <input type="text" name="members_username" value="{{ old('members_username', $member->members_username ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
        <p class="mt-1 text-xs text-red-600 error-members_username"></p>
    </div>

    {{-- Email --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Email') }} <span class="text-red-600">*</span>
        </label>
        <input type="email" name="members_email" value="{{ old('members_email', $member->members_email ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
        <p class="mt-1 text-xs text-red-600 error-members_email"></p>
    </div>

    {{-- First Name --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('First Name') }}
        </label>
        <input type="text"
               name="members_firstname"
               value="{{ old('members_firstname', $member->members_firstname ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    </div>

    {{-- Last Name --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Last Name') }}
        </label>
        <input type="text"
               name="members_lastname"
               value="{{ old('members_lastname', $member->members_lastname ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    </div>

    {{-- Phone --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Phone') }}
        </label>
        <input type="text"
               name="members_phone"
               value="{{ old('members_phone', $member->members_phone ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    </div>

    {{-- Date of Birth --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Date of Birth') }}
        </label>
        <input type="date"
               name="members_dob"
               value="{{ old('members_dob', $member->members_dob?->format('Y-m-d')) }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    </div>

    {{-- Country --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Country') }}
        </label>
        <select name="members_country"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">--</option>
            @foreach($countries as $c)
                <option value="{{ $c->country_master_id }}"
                        {{ ($member->members_country ?? '') == $c->country_master_id ? 'selected' : '' }}>
                    {{ $c->country_master_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- State --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('State') }}
        </label>
        <select name="members_state"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">--</option>
            @foreach($states as $s)
                <option value="{{ $s->state_id }}"
                        {{ ($member->members_state ?? '') == $s->state_id ? 'selected' : '' }}>
                    {{ $s->state_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- City --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('City') }}
        </label>
        <input type="text"
               name="members_city"
               value="{{ old('members_city', $member->members_city ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    </div>

    {{-- Zip --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Zip') }}
        </label>
        <input type="text"
               name="members_zip"
               value="{{ old('members_zip', $member->members_zip ?? '') }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
    </div>

    {{-- Address Line 1 --}}
    <div class="sm:col-span-2">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Address Line 1') }}
        </label>
        <textarea name="members_address" rows="2"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('members_address', $member->members_address ?? '') }}</textarea>
    </div>

    {{-- Address Line 2 --}}
    <div class="sm:col-span-2">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Address Line 2') }}
        </label>
        <textarea name="members_address2" rows="2"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('members_address2', $member->members_address2 ?? '') }}</textarea>
    </div>

</div>