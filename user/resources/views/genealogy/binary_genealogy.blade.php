@extends('user::components.common.main')
@section('content')

<link href="{{ asset('/css/primitives.latest.css') }}" media="screen" rel="stylesheet" type="text/css" />
<style>
 div#contentpanel{position:relative!important;z-index:100!important;overflow:hidden!important;left:-200px!important}.input-group-text.btn.btn-info{padding:.85rem 1.15rem}@media screen and (max-width:767px){.bin_genealogy_tree{margin-top:90px}}.primitives-orgdiagram svg path{stroke:white;stroke-width:2px}.placeholder.orgdiagram path{stroke:white!important}
.geneasell .d-flex.justify-content-between{width:100%}.geneasell .select2-container{width:400px!important}.ui-layout-pane{background:0 0!important;border:none!important;margin-top:39px!important}.portlet.light{min-height:800px!important}.portlet.light.bordered{border:1px solid #e7ecf1!important;margin:20px}.portlet.light{padding:12px 20px 15px;background-color:#fff}.portlet.light.bordered>.portlet-title{border-bottom:1px solid #eef1f5}.portlet.light>.portlet-title{padding:0;min-height:48px}.portlet.light>.portlet-title>.caption{color:#666;padding:10px 0}.portlet>.portlet-title>.caption{float:left;display:inline-block;font-size:18px;line-height:18px;padding:10px 0}.portlet.light>.portlet-title>.caption>.caption-subject{font-size:16px}.font-green{color:#32c5d2!important}.uppercase{text-transform:uppercase!important}.sbold{font-weight:600!important}.pull-right{float:right;margin:-10px 0}span.cycle-title{font-size:22px;color:#32c5d3;text-align:center;display:list-item;list-style:none}ul.tab{list-style-type:none;margin:0;padding:0;overflow:hidden;border-bottom:1px solid #ddd}ul.tab li{float:left}ul.tab li a{display:inline-block;color:#000;text-align:center;padding:14px 16px;text-decoration:none;font-size:17px}ul.tab li a:hover{border-bottom:4px solid #32c5d7;border-top:1px solid #ddd;border-right:1px solid #ddd;border-left:1px solid #ddd}.active,ul.tab li a:focus{border-bottom:4px solid #32c5d7;border-top:1px solid #ddd;border-right:1px solid #ddd;border-left:1px solid #ddd}.btn.btn-outline.green-haze{border-color:#44b6ae;color:#44b6ae;background:0 0;border:1px solid #44b6ae;padding:4px 12px;border-radius:19px}.btn.btn-outline.red-haze{border-color:#c82828;color:#c82828;background:0 0;border:1px solid #c82828;padding:4px 12px;border-radius:19px;padding:0 7px;border-radius:19px;font-size:15px}a.pull-right.btn.green-haze.btn-outline.btn-circle.btn-sm{text-decoration:none}.caption-subject.font-green.sbold.uppercase.userg a{text-decoration:none;color:#32c5d4}.bp-item{overflow:visible!important}.caption-subject.font-green.sbold.uppercase.userg{margin-left:45%;padding-top:10px}.btn.btn-outline.green-haze{padding:1px 7px;margin-right:10px}a.pull-right.btn.green-haze.btn-outline.btn-circle.btn-sm{padding:0 7px;border-radius:19px;font-size:15px}.ranks_list label{color:#fff}img.man_img{width:70px}.ge_contt{top:-70px!important}.img-thumbnail,body{overflow:auto!important}.bp-item.bp-corner-all.bp-title-frame{top:11px!important;left:14px!important;width:90%!important}.bp-item.bp-title{top:1px!important;left:0!important;width:100px!important;text-align:center;right:0!important;margin:0 auto}.bp-item.bp-corner-all.bt-item-frame{background:0 0;border:none;border-radius:0}.bp-item.bp-corner-all.bp-title-frame{background:#e08957!important;border-radius:8px}.bp-photo-frame{margin-top:7px;margin-left:5px}.bp-item{color:#fff}.bp-photo-frame{border:none!important;left:68px!important;height:50px!important;top:32px!important;margin-top:13px!important}.bp-photo-frame img{height:70px!important;width:70px!important;border-radius:100%}.bp-item.bp-photo-frame{width:100%!important}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(3){left:67%!important;top:80px!important;width:160px!important;padding:2px 17px;height:40px!important}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(1){left:67%!important;top:39px!important;width:160px!important;padding:8px 17px;height:23px!important}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(2){left:67%!important;top:62px!important;width:160px!important;padding:2px 17px}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(4){width:160px!important;padding:2px 17px;left:67%!important;top:99px!important;height:23px!important;font-size:13px!important}.bp-item.bp-corner-all.bt-item-frame .bp-item:nth-child(2) a{color:#000;font-weight:700}.bp-highlight-frame{background:0 0!important;border:none!important}.bp-item.bp-corner-all.bp-title-frame{top:11px!important;left:66px!important;width:85px!important}.bp-item.bp-title{top:1px!important;left:16px!important;width:79px!important}.ge_contt{display:none;position:absolute;left:69%;top:10px}.bp-item.bp-corner-all.bt-item-frame:hover .ge_contt{display:block}.bp-item.bp-corner-all.bt-item-frame:hover .ge_contt .bp-item.bp-corner-all.bt-item-frame .bp-item:nth-child(4){display:block}.bp-item.bp-corner-all.bt-item-frame:hover .ge_contt .bp-item.bp-corner-all.bt-item-frame .bp-item:nth-child(4) a{display:block}.bp-cursor-frame{border:none!important;background:0 0!important;color:#eb8f00}.placeholder.orgdiagram path{fill-opacity:0;stroke:#fff!important}.bp-photo-frame{background:0 0!important}.ge_contt .bp-item{background:#e08957}.bp-item.bp-rankphoto-frame img{height:50px!important;width:35px!important;position:absolute;left:44px;top:28px;transform:rotate(20deg)}.ge_contt{top:-5px}
.Layer2 svg{width:1870px!important}
.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(4){left:67%!important;top:115px!important;width:160px!important;padding:2px 17px;height:23px!important}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(5){left:67%!important;top:135px!important;width:160px!important;padding:2px 17px;height:23px!important}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(6){left:67%!important;top:158px!important;width:160px!important;padding:2px 17px;height:23px!important}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(7){left:67%!important;top:180px!important;width:160px!important;padding:2px 17px;height:23px!important}.bp-item.bp-corner-all.bp-title-frame{background:#5867dd!important;border-radius:8px}.ge_contt .bp-item{margin-left:6px;background:#5867dd}.bp-item.bp-title{top:1px!important;left:0!important;width:79px!important}.ge_contt{z-index:100}.bp-item.bp-corner-all.bt-item-frame .bp-item:nth-child(2) a{color:#fff;font-weight:700}:focus{outline:0}.placeholder.orgdiagram path{stroke:#5867dd!important}.butt{padding:0}.butt a.gen_tit{padding-top:13px;font-size:14px;font-weight:500}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item:nth-child(6) a{color:#fff}.ge_contt{top:-157px!important}.ge_contt{display:none;position:absolute;left:0}.Layer7 .bp-item:first-child .ge_contt{left:69%;top:-45px!important}.bp-item a:hover{text-decoration:none}.bp-item.bp-corner-all.bt-item-frame .ge_contt .bp-item a{color:#fff}#contentpanel .bp-title { font-size: 12px;}/*iPhone 6 Portrait*/
@media only screen and (min-device-width:375px) and (max-device-width:667px) and (orientation :portrait){a#fullscreen{display:none}}@media only screen and (min-device-width:375px) and (max-device-width:667px) and (orientation :landscape){a#fullscreen{display:none}}@media only screen and (min-device-width:414px) and (max-device-width:736px) and (orientation :portrait){a#fullscreen{display:none}}@media only screen and (min-device-width:414px) and (max-device-width:736px) and (orientation :landscape){a#fullscreen{display:none}}@media only screen and (max-device-width:640px),only screen and (max-device-width:667px),only screen and (max-width:480px){a#fullscreen{display:none}}@media only screen and (max-device-width:640px),only screen and (max-device-width:667px),only screen and (max-width:480px) and (orientation :portrait){a#fullscreen{display:none}}@media only screen and (max-device-width:640px),only screen and (max-device-width:667px),only screen and (max-width:480px) and (orientation :landscape){a#fullscreen{display:none}}/*iPhone 6 Portrait*/
        </style>

        <!-- Breadcrumb -->
                        <div class="flex mb-4" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="user-d-board.html"
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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">My-Teams</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">My
                                            Organization</span>
                                    </div>
                                </li>
                            </ol>
                        </div>

<!-- breadcrub navs end-->
<!-- Content area -->
<main class="flex-grow">
  <div class="container mx-auto px-4 sm:px-6 lg:px-0 space-y-5">
    <!-- card -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-800 border">
      <div class="flex items-center justify-between space-x-4" bis_skin_checked="1">


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
              class="absolute z-50 w-full h-32 mt-1 bg-white rounded-lg shadow-md overflow-y-auto hidden"
             >
          </div>
      </div>


       </div>
      <input type="hidden" name="members_id" id="members_id" value="{{$members_id}}">
      <div class="" bis_skin_checked="1">

        <a aria-label="link" id="fullscreen" href="#" title="Full screen"  title="{{ __('Full screen') }}">
          <button type="button" onclick="applyTemplate()" class="px-3 py-3">
            <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H4m0 0v4m0-4 5 5m7-5h4m0 0v4m0-4-5 5M8 20H4m0 0v-4m0 4 5-5m7 5h4m0 0v-4m0 4-5-5"/>
                </svg>
            </button>

          </a>

     </div>

    </div>


      <div style="position: relative; height: 100vh; width: 100%;">

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

</main>
<script type="text/javascript">{!!$genealogy!!}</script>
@include('user::genealogy.components.bi_genealogy_script')
@endsection
