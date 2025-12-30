<form name="prequizlesson" id="prequizlesson" method="POST" action="{{$_ENV['BCPATH']}}/elearning/updatequizlession/{{$sub1}}/{{$sub2}}" enctype="multipart/form-data">
    <div class="p-4 md:p-5 space-y-4">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="editquiz-tab"
                data-tabs-toggle="#editquiz-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="editlesson-quiz-tab"
                        onclick="changeQuizTab(1)" type="button" role="tab" aria-controls="editlesson-quiz"
                        aria-selected="false">{{ __('Edit lesson') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-black hover:border-neutral-300 dark:hover:text-neutral-300"
                        id="quizlessonsettings-tab" onclick="changeQuizTab(2)" type="button" role="tab"
                        aria-controls="quizlessonsettings" aria-selected="false">{{ __('Lesson Settings') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-black hover:border-neutral-300 dark:hover:text-neutral-300"
                        id="quizsettings-tab" onclick="changeQuizTab(3)" type="button" role="tab"
                        aria-controls="quizsettings" aria-selected="false">{{ __('Quiz Settings') }}</button>
                </li>
            </ul>
        </div>
        <div id="editquiz-tab-content">
            <input type="hidden" name="course_id_quiz" id="course_id_quiz" value="{{$sub1}}" />
            <input type="hidden" name="course_quiz_lesson_id" id="course_quiz_lesson_id" value="{{$sub2}}" />
            <div class="p-4 rounded-lg bg-neutral-50 dark:bg-neutral-900" id="editlesson-quiz" role="tabpanel"
                aria-labelledby="editlesson-quiz-tab">
                <div class="mb-5">
                    <!-- File Input -->
                    <div class="mb-5">
                        <label for="file_input" class="block mb-2 text-sm font-medium text-black dark:text-white">
                            {{ __('Upload Logo') }}
                        </label>
                        <input name="contentimage_path" id="contentimage_path" type="file" accept="image/*"
                            class="block w-full text-sm text-black rounded-lg cursor-pointer bg-neutral-50 dark:text-white focus:outline-none dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400"
                            onchange="previewImage_quiz(event)">
                    </div>

                    <!-- Preview Container -->

                    <div id="preview_container_quiz" class="mt-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-black dark:text-white">
                            {{ __('Preview') }}
                        </label>
                        <div
                            class="w-full bg-white border border-neutral-200 rounded-lg shadow dark:bg-neutral-900 dark:border-neutral-700">
                            <div class="flex flex-col items-center p-10">
                                <!-- Placeholder Image or Icon -->
                                @if ($lession['contentimage_path'] != '')
                                    <img class="w-48 h-48 mb-3 rounded-xl shadow-2xl object-cover"
                                        id="image_preview_quiz" src="{{ $contentimage_path }}" alt="No Image Available">
                                @else
                                    <img class="w-48 h-48 mb-3 rounded-xl shadow-2xl object-cover"
                                        id="image_preview_quiz"
                                        src="{{$_ENV['UI_ASSET_URL']}}/public/assets/img/noimage.png"
                                        alt="No Image Available">
                                @endif
                            </div>
                        </div>
                        <p class="text-xs mt-2">
                            {{ __('Allowed file format: png, jpg, svg (88 px X 50 px)') }}
                        </p>
                    </div>
                </div>
                <div
                    class="w-full mb-4  rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                    <div
                        class="flex items-center justify-between px-3 py-2 border-b border-neutral-200">
                        <div
                            class="flex flex-wrap items-center divide-neutral-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-neutral-600">
                            <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 12 20">
                                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                            d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                                    </svg>
                                    <span class="sr-only">Attach
                                        file</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 16 20">
                                        <path
                                            d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                                    </svg>
                                    <span class="sr-only">Embed
                                        map</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 16 20">
                                        <path
                                            d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                                        <path
                                            d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                                    </svg>
                                    <span class="sr-only">Upload
                                        image</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 16 20">
                                        <path
                                            d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                                        <path
                                            d="M14.067 0H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.933-2ZM6.709 13.809a1 1 0 1 1-1.418 1.409l-2-2.013a1 1 0 0 1 0-1.412l2-2a1 1 0 0 1 1.414 1.414L5.412 12.5l1.297 1.309Zm6-.6-2 2.013a1 1 0 1 1-1.418-1.409l1.3-1.307-1.295-1.295a1 1 0 0 1 1.414-1.414l2 2a1 1 0 0 1-.001 1.408v.004Z" />
                                    </svg>
                                    <span class="sr-only">Format
                                        code</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm-7 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm3.5 9.5A5.5 5.5 0 0 1 4.6 11h10.81A5.5 5.5 0 0 1 10 15.5Z" />
                                    </svg>
                                    <span class="sr-only">Add
                                        emoji</span>
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 21 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.5 3h9.563M9.5 9h9.563M9.5 15h9.563M1.5 13a2 2 0 1 1 3.321 1.5L1.5 17h5m-5-15 2-1v6m-2 0h4" />
                                    </svg>
                                    <span class="sr-only">Add
                                        list</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z" />
                                    </svg>
                                    <span class="sr-only">Settings</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z" />
                                        <path
                                            d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z" />
                                    </svg>
                                    <span class="sr-only">Timeline</span>
                                </button>
                                <button type="button"
                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                                        <path
                                            d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Download</span>
                                </button>
                            </div>
                        </div>
                        <button type="button" data-tooltip-target="tooltip-fullscreen"
                            class="p-2 text-black rounded-sm cursor-pointer sm:ms-auto hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-600">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 19 19">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 1h5m0 0v5m0-5-5 5M1.979 6V1H7m0 16.042H1.979V12M18 12v5.042h-5M13 12l5 5M2 1l5 5m0 6-5 5" />
                            </svg>
                            <span class="sr-only">Full
                                screen</span>
                        </button>
                        <div id="tooltip-fullscreen" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-neutral-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                            Show full
                            screen
                            <div class="tooltip-arrow" data-popper-arrow>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-neutral-900">
                        <label for="editor" class="sr-only">{{ __('Publish post') }}</label>
                        <textarea name="content" id="m_summernote_1" rows="8"
                            class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400"
                            placeholder="Write an article..." required>{{ $lession['courses_content'] }}</textarea>
                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-neutral-50 dark:bg-neutral-900" id="quizlessonsettings" role="tabpanel"
                aria-labelledby="quizlessonsettings">
                <!-- Quiz Form -->
                <div>
                    <h2 class="text-2xl font-semibold text-black mb-4">{{ __('Quiz') }}</h2>
                    <div class="mb-5">
                        <label
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Enter a Quiz Question') }}</label>
                        <div class="mt-4 relative w-full">
                            <input name="quzvalues" id="quzvalues"
                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                placeholder="Type your question">
                            <button type="button" onclick="submitquiz()"
                                class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg border border-blue-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-blue-800"><svg
                                    class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="submiterrors">
                        <a class="col" id="error10" style="color:red;"></a>
                    </div>
                    <div id="contentquiz"></div>
                    {{--  <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Enter a Quiz Question') }}</label>
                        <input x-model="currentQuestion" id="quzvalues" @keydown.enter.prevent="addQuestion"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                            placeholder="Type your question and press Enter">
                    </div>
                    <template x-for="(question, index) in questions" :key="index">
                        <div class="bg-neutral-100 p-4 rounded-lg mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-black  ">
                                    Question
                                    <span x-text="index + 1"></span>:
                                    <span x-text="question.text"></span>
                                </h3>
                                <button @click="removeQuestion(index)" type="button"
                                    class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-300 focus:outline-none dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-red-800"><svg
                                        class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>
                                </button>
                            </div>

                            <input type="text" name="quizanswer(index)"  x-model="question.answer" placeholder="Enter Answer"
                                class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                        </div>
                    </template>  --}}
                    <input type="hidden" name="quiz_id" id="quiz_id" value="">
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-neutral-50 dark:bg-neutral-900" id="quizsettings" role="tabpanel"
                aria-labelledby="quizsettings-tab">
                <div>
                    <div class="mb-5">
                        <label for="quizduration"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Quiz Duration') }}</label>
                        <input type="text" id="quizduration" name="quizduration" value="{{$quizdetails['quiz_duration']}}"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                    </div>
                    <div class="mb-5">
                        <label for="quizgrade"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Passing Grade') }} (%)</label>
                        <input type="text" id="quizgrade" name="quizgrade" value="{{$quizdetails['quiz_passgrade']}}"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                    </div>
                    <div class="mb-5">
                        <label for="quizpoint"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Points Total Cut After Re-take') }} (%)</label>
                        <input type="text" id="quizpoint" name="quizpoint" value="{{$quizdetails['quiz_cutoff']}}"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                    </div>
                    <div class="mb-5">
                        <label for="quizdiscription"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Quiz Description') }}</label>
                        <textarea id="quizdiscription" name="quizdiscription" rows="6"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">{{$quizdetails['quiz_description']}}</textarea>
                    </div>
                    <div class="mb-5">
                        <table class="min-w-2xl  ">
                            <tbody>
                                <tr>
                                    <td class="pe-6  text-black dark:text-white text-sm font-medium w-48">
                                        Status
                                    </td>
                                    <td class="px-6  text-right">
                                        <div class="flex items-center p-2.5">
                                            <!-- Left label -->
                                            <span
                                                class="text-sm font-medium text-black dark:text-white">Off</span>

                                            <label class="inline-flex items-center cursor-pointer mx-3">
                                                <input type="checkbox" id="edit_lesson_status"
                                                    name="edit_lesson_status" value="1" @if($quizdetails['status'] == '1') checked @endif
                                                    class="sr-only peer">
                                                <div
                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                </div>
                                            </label>

                                            <!-- Right label -->
                                            <span
                                                class="text-sm font-medium text-black dark:text-white">On</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal footer -->
    <div
        class="flex items-center justify-end p-4 md:p-5 border-t border-neutral-200 rounded-b ">
        <button type="button" id="editquizclose"
            class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
        <button type="button" onclick="submitQuizForm();"
            class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
    </div>
</form>
