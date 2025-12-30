<div class="hidden" id="note" role="tabpanel" aria-labelledby="note-tab">
    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">{{ __('NOTE_REMARKS') }}</h3>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="note-tabs"
                data-tabs-toggle="#note-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="message-info-tab" data-tabs-target="#message-info" type="button" role="tab"
                        aria-controls="message-info" aria-selected="true" onclick="getUserDeatilsMessage();">
                        {{ __('Message') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="activites-tab" data-tabs-target="#activites" type="button" role="tab"
                        aria-controls="activites" aria-selected="false" onclick="getUserDeatilsActivity();">
                        {{ __('Activites') }}
                    </button>
                </li>
                <!-- Notes -->
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="notes-tab" data-tabs-target="#notes" type="button" role="tab" aria-controls="notes"
                        aria-selected="false">
                        {{ __('Notes') }}
                    </button>
                </li>
                <!-- Saved Notes Tab -->
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="savednotes-tab" data-tabs-target="#savednotes" type="button" role="tab"
                        aria-controls="savednotes" aria-selected="false" onclick="getUserSavedNotes();">
                        {{ __('Saved Notes') }}
                    </button>
                </li>
            </ul>
        </div>
        <div id="note-tab-content">
            <div  id="message-info" role="tabpanel"
                aria-labelledby="message-info-tab">
                
                <table id="message-table">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('Name') }}</span></th>
                            <th><span class="flex items-center">{{ __('Subject') }}</span></th>
                            <th><span class="flex items-center">{{ __('Date') }}</span></th>
                        </tr>
                    </thead>
                    <tbody id="showmessage">
                    </tbody>
                </table>
            </div>
            <div class="hidden" id="activites" role="tabpanel"
                aria-labelledby="activites-tab">
                
                <table id="activites-table">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('SNo') }}</span></th>
                            <th><span class="flex items-center">{{ __('Datetime') }}</span></th>
                            <th><span class="flex items-center">{{ __('IP Address') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="showactivity">
                    </tbody>
                </table>
            </div>
            <!-- notes Content -->
            <div class="hidden" id="notes" role="tabpanel"
                aria-labelledby="notes-tab">
               
                <form id="usernotes" action="/admin/usernotes/save/{{ $sub1 }}" method="POST"
                    enctype="multipart/form-data" novalidate="novalidate" class="validated-form">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Type your notes or remarks</label>
                        <textarea
                            class="w-full px-4 py-3 text-xs text-gray-600 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 resize-none"
                            rows="5" name="usernotes" required aria-describedby="usernotetextarea-error"></textarea>
                        <p id="usernotetextarea-error"
                            class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">'. __('Please enter
                            a valid Bonus name.') .'</p>
                    </div>

                    <div class="mb-3">
                        <select name="usernotes_privacy"
                            class="bg-gray-50 border text-xs border-gray-300 text-gray-600 text-xs rounded-lg block w-full px-4 py-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            aria-describedby="usernotes_privacy_select-error" required>
                            <option value="">{{ __('Select') }}
                            <option value="1">{{ __('Private(Shown just to me)') }}</option>
                            <option value="2">{{ __('Administrators (shown to administrators)') }}</option>
                        </select>
                        <p id="usernotes_privacy_select-error"
                            class="error-message mt-2 text-xs text-red-600 dark:text-red-500 hidden">'. __('Please enter
                            a valid Bonus name.') .'</p>
                    </div>
                    <div class="flex justify-end mt-3">
                        <div class="form-submit">
                            <button type="submit"
                                class="px-4 py-2 bg-gray-800 hover:bg-gray-900 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-xs rounded-lg transition-all duration-300 shadow-md hover:scale-105">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- savednotes Content -->
            <div class="hidden" id="savednotes" role="tabpanel"
                aria-labelledby="savednotes-tab">
                
                <table id="savednotes-table">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('S.No') }}</span></th>
                            <th><span class="flex items-center">{{ __('Notes') }}</span></th>
                            <th><span class="flex items-center">{{ __('Privacy') }}</span></th>

                        </tr>
                    </thead>
                    <tbody id="savednotes_list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>