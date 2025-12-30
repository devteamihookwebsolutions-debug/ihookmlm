@include('components.common.header')
<link href="{{$_ENV['UI_ASSET_URL']}}/assets/custom/css/primitives.latest.css?3600" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{$_ENV['UI_ASSET_URL']}}/public/assets/css/classical_genealogy.css">
@include('components.common.topbars')

<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white  mb-2">{{ __('Classic View') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
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
                    <li aria-current="page">
                      <div class="flex items-center">
                          <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m1 9 4-4-4-4" />
                          </svg>
                          <span
                              class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Network') }}</span>
                      </div>
                  </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Classic View') }}</span>
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
    <!-- card -->
    <div class="bg-white dark:bg-neutral-400 rounded-lg shadow p-6 min-h-screen overflow-auto">
      <div class="flex items-center justify-between space-x-4" bis_skin_checked="1">

        <!-- First Dropdown -->
        <div class="w-full max-w-xs" bis_skin_checked="1">
          <select id="default_matrix" name="default_matrix"
            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">{{ __('Select') }}</option>
            @foreach ($defaultmatrix as $record)
            <option value="{{ $record['matrix_id'] }}"
              {{ $record['matrix_id'] == $selectedMatrixId ? 'selected' : '' }}>
              {{ $record['matrix_name'] }}
            </option>
            @endforeach
          </select>
        </div>

       <div class="relative flex items-center w-full max-w-md" bis_skin_checked="1">

        <div id="search-combobox" class="relative" data-hs-combo-box="">
          <div class="relative w-80">
              <input type="text" name="searchbox" id="searchbox"
                  class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                  placeholder="Search..." aria-expanded="false" data-hs-combo-box-input=""
                  onkeyup="filterSuggestions(this.value)" />
              <button type="button" onclick="genealogySearch();"
                  class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg border border-blue-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-blue-800"
                  bis_size="{&quot;x&quot;:772,&quot;y&quot;:20,&quot;w&quot;:38,&quot;h&quot;:42,&quot;abs_x&quot;:1244,&quot;abs_y&quot;:6086}"><svg
                      class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                      bis_size="{&quot;x&quot;:783,&quot;y&quot;:33,&quot;w&quot;:16,&quot;h&quot;:16,&quot;abs_x&quot;:1255,&quot;abs_y&quot;:6099}">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                          bis_size="{&quot;x&quot;:783,&quot;y&quot;:33,&quot;w&quot;:14,&quot;h&quot;:14,&quot;abs_x&quot;:1255,&quot;abs_y&quot;:6099}">
                      </path>
                  </svg></button>
          </div>
          <div id="suggestion-box"
              class="absolute z-50 w-full h-32 mt-1 bg-white rounded-lg shadow-md overflow-y-auto hidden">

          </div>
      </div>


       </div>
      <input type="hidden" name="members_id" id="members_id" value="{{$members_id}}">
      <div class="" >

        <a aria-label="link" id="fullscreen" href="#" title="Full screen"  title="{{ __('Full screen') }}">
          <button type="button" onclick="applyTemplate()" class="px-3 py-3">
            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H4m0 0v4m0-4 5 5m7-5h4m0 0v4m0-4-5 5M8 20H4m0 0v-4m0 4 5-5m7 5h4m0 0v-4m0 4-5-5"/>
                </svg>
            </button>
          </a>
     </div>

    </div>

      <div>

        <div id="contentpanel" class="mt-5">
          <!-- bpcontent -->
          <div id="westpanel" class="hidden p-4 border border-neutral-400 text-sm text-black overflow-scroll">
            <p id="pageFitMode"></p>
            <p id="orientationType"></p>
            <p id="verticalAlignment"></p>
            <p id="horizontalAlignment"></p>
            <p id="leavesPlacementType"></p>
            <p id="minimalVisibility"></p>
            <p id="selectionPathMode"></p>
            <p id="hasButtons"></p>
            <p id="hasSelectorCheckbox"></p>
            <p id="minimizedItemCornerRadius"></p>
            <p id="minimizedItemSize"></p>
            <p id="highlightPadding"></p>
            <p id="minimizedItemShapeType"></p>
            <p id="minimizedItemLineWidth"></p>
            <p id="minimizedItemLineType"></p>
            <p id="minimizedItemBorderColor"></p>
            <p id="minimizedItemFillColor"></p>
            <p id="minimizedItemOpacity"></p>
            <p id="normalLevelShift"></p>
            <p id="dotLevelShift"></p>
            <p id="lineLevelShift"></p>
            <p id="normalItemsInterval"></p>
            <p id="dotItemsInterval"></p>
            <p id="lineItemsInterval"></p>
            <p id="cousinsIntervalMultiplier"></p>
          </div>
          <div id="centerpanel" class="overflow-hidden p-0 m-0 border-0">
          </div>
          <div id="southpanel"></div>
          <!-- /bpcontent -->
        </div>
      </div>
    </div>

  </div>
  </div>
</main>
@include('components.common.footer')
@include('components.common.footer_scripts')
<script type="text/javascript">{!!$genealogy!!}</script>
@include('genealogy.components.genealogy_script')
@include('components.common.footer_end')
