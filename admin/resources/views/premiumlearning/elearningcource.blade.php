
@extends('admin::components.common.main')
@section('content')
        <!-- Breadcrumb -->

<div class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin/dashboard"
                class="inline-flex items-center text-xs font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">General Settings

                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Site Settings
                </a>
            </div>
        </li>
    </ol>
</div>

<link href="{{ asset('/css/cropper.min.css') }}" rel="stylesheet">

<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <div class="bg-neutral-800 text-white border border-neutral-800 rounded-lg p-6 space-x-6 items-center mb-8"
            role="alert">
            <div>
                <div class="flex justify-between items-center flex-wrap">
                    <div class="flex gap-2">
                        <h3 class="text-4xl text-neutral-100 mb-4">{{ __('Successful way to promote your Elearning') }}
                        </h3>
                    </div>
                    <div class="flex gap-2">
                        <svg class="w-auto max-w-[16rem] h-40 text-black dark:text-white" aria-hidden="true" width="748" height="678" viewBox="0 0 748 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M165 279V464" stroke="#d6e2fb" stroke-width="2" stroke-linecap="round"/>
                            <path d="M145 279L75 464" stroke="#d6e2fb" stroke-width="2" stroke-linecap="round"/>
                            <path d="M185 279L255 464" stroke="#d6e2fb" stroke-width="2" stroke-linecap="round"/>
                            <path d="M0 12.2174C0 5.46991 3.70484 0 8.275 0H322.725C327.295 0 331 5.46991 331 12.2174V268.783C331 275.53 327.295 281 322.725 281H8.27499C3.70484 281 0 275.53 0 268.783V12.2174Z" fill="#d6e2fb"/>
                            <path d="M0 12.2174C0 5.46991 3.70484 0 8.275 0H322.725C327.295 0 331 5.46991 331 12.2174V268.783C331 275.53 327.295 281 322.725 281H8.27499C3.70484 281 0 275.53 0 268.783V12.2174Z" fill="url(#paint0_linear_275_1057)" fill-opacity="0.3"/>
                            <rect x="83" y="180" width="164" height="18" rx="6" fill="#F9FAFB"/>
                            <rect x="116" y="210" width="98" height="10" rx="5" fill="#F9FAFB"/>
                            <path d="M154.345 95.0876C154.345 105.99 151.112 116.647 145.055 125.712C138.998 134.777 130.389 141.843 120.317 146.015C110.244 150.187 99.1607 151.279 88.4679 149.152C77.775 147.025 67.953 141.775 60.2439 134.066C52.5348 126.356 47.2848 116.534 45.1578 105.842C43.0309 95.1487 44.1225 84.0653 48.2947 73.9928C52.4668 63.9204 59.5321 55.3113 68.597 49.2543C77.662 43.1973 88.3195 39.9644 99.2219 39.9644V64.1989C93.1127 64.1989 87.1406 66.0105 82.061 69.4046C76.9814 72.7987 73.0223 77.6228 70.6844 83.267C68.3466 88.9111 67.7349 95.1218 68.9267 101.114C70.1185 107.105 73.0604 112.609 77.3803 116.929C81.7001 121.249 87.204 124.191 93.1958 125.383C99.1876 126.575 105.398 125.963 111.042 123.625C116.687 121.287 121.511 117.328 124.905 112.248C128.299 107.169 130.111 101.197 130.111 95.0876H154.345Z" fill="#c8d8fa"/>
                            <path d="M99.2217 39.9644C106.461 39.9644 113.629 41.3902 120.316 44.1604C127.004 46.9306 133.081 50.9909 138.2 56.1096C143.318 61.2282 147.379 67.305 150.149 73.9928C152.919 80.6807 154.345 87.8487 154.345 95.0876L130.11 95.0876C130.11 91.0312 129.311 87.0146 127.759 83.267C126.207 79.5194 123.932 76.1143 121.063 73.246C118.195 70.3777 114.79 68.1024 111.042 66.5501C107.295 64.9978 103.278 64.1989 99.2217 64.1989V39.9644Z" fill="#F9FAFB"/>
                            <path d="M232.896 39.9644C243.798 39.9644 254.456 43.1973 263.52 49.2543C272.585 55.3113 279.651 63.9204 283.823 73.9928C287.995 84.0653 289.087 95.1487 286.96 105.842C284.833 116.534 279.583 126.356 271.874 134.066C264.165 141.775 254.343 147.025 243.65 149.152C232.957 151.279 221.873 150.187 211.801 146.015C201.729 141.843 193.119 134.777 187.062 125.712C181.005 116.647 177.772 105.99 177.772 95.0876L202.007 95.0876C202.007 101.197 203.819 107.169 207.213 112.248C210.607 117.328 215.431 121.287 221.075 123.625C226.719 125.963 232.93 126.575 238.922 125.383C244.914 124.191 250.417 121.249 254.737 116.929C259.057 112.609 261.999 107.105 263.191 101.114C264.383 95.1218 263.771 88.9111 261.433 83.267C259.095 77.6228 255.136 72.7986 250.056 69.4046C244.977 66.0105 239.005 64.1989 232.896 64.1989V39.9644Z" fill="#c8d8fa"/>
                            <path d="M232.896 150.211C218.276 150.211 204.255 144.403 193.918 134.066C183.58 123.728 177.772 109.707 177.772 95.0876C177.772 80.468 183.58 66.4472 193.918 56.1096C204.255 45.772 218.276 39.9644 232.896 39.9644V64.1989C224.703 64.1989 216.847 67.4532 211.054 73.246C205.261 79.0387 202.007 86.8954 202.007 95.0876C202.007 103.28 205.261 111.136 211.054 116.929C216.847 122.722 224.703 125.976 232.896 125.976V150.211Z" fill="#F9FAFB"/>
                            <path d="M195.5 100L252.5 84.5" stroke="#111928" stroke-width="2" stroke-linecap="round"/>
                            <path d="M337.5 123.5L352 120.5C357.5 127.167 367.4 140.8 363 142C357.5 143.5 340.5 144.5 327 139C313.5 133.5 262 90.5 254.5 89.5C247 88.5 237.5 89.0002 237.5 86.5002C237.5 84.0002 244 81.5002 254.5 82.5002C262.9 83.3002 313.333 110.167 337.5 123.5Z" fill="#FDBA8C"/>
                            <path d="M337.5 123.5L352 120.5C357.5 127.167 367.4 140.8 363 142C357.5 143.5 340.5 144.5 327 139C313.5 133.5 262 90.5 254.5 89.5C247 88.5 237.5 89.0002 237.5 86.5002C237.5 84.0002 244 81.5002 254.5 82.5002C262.9 83.3002 313.333 110.167 337.5 123.5Z" fill="url(#paint1_linear_275_1057)"/>
                            <path d="M402.5 263.5L406 197.5H468C476.8 225.9 477.667 253.333 477 263.5H402.5Z" fill="#2563eb"/>
                            <path d="M402.5 263.5L406 197.5H468C476.8 225.9 477.667 253.333 477 263.5H402.5Z" fill="url(#paint2_linear_275_1057)"/>
                            <path d="M426.5 58.4999C419.3 60.0999 419.167 67.8333 419 72.4999L431 95H455.5C454 90.1666 449.5 80.3999 447.5 71.9999C445 61.4999 435.5 56.4999 426.5 58.4999Z" fill="#111928"/>
                            <circle cx="449" cy="57" r="10" fill="#111928"/>
                            <path d="M421.694 97.899L423.5 83H431C431.4 93.4 437.833 99.6667 441.5 102C439.5 104.833 434.4 111.4 426 111C417.6 110.6 416.166 104.833 416.5 102L420.057 100.221C420.958 99.7709 421.572 98.8987 421.694 97.899Z" fill="#FDBA8C"/>
                            <path d="M421.694 97.899L423.5 83H431C431.4 93.4 437.833 99.6667 441.5 102C439.5 104.833 434.4 111.4 426 111C417.6 110.6 416.166 104.833 416.5 102L420.057 100.221C420.958 99.7709 421.572 98.8987 421.694 97.899Z" fill="url(#paint3_linear_275_1057)"/>
                            <path d="M417.5 76.5C419.1 69.3 422.5 64.8333 424 63.5C426.167 64 430.6 65.9 431 69.5C431.4 73.1 432.833 74.3333 433.5 74.5L434.992 73.8605C436.164 73.3581 437.528 73.7397 438.27 74.7776C438.993 75.7901 438.94 77.174 438.088 78.0806C430.025 86.6581 421.862 87.9448 419.5 87C417 86 415.5 85.5 417.5 76.5Z" fill="#FDBA8C"/>
                            <path d="M423.807 74.2451C423.682 74.6892 423.22 74.9479 422.776 74.8229C422.332 74.6979 422.073 74.2365 422.198 73.7924C422.323 73.3483 422.785 73.0896 423.229 73.2146C423.673 73.3396 423.932 73.801 423.807 74.2451Z" fill="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M423.794 70.89C423.247 70.6671 422.709 70.7104 422.154 70.8577C421.94 70.9146 421.72 70.787 421.663 70.5725C421.606 70.3581 421.734 70.1382 421.948 70.0812C422.588 69.9111 423.324 69.8309 424.097 70.146C424.867 70.4594 425.608 71.1374 426.323 72.3462C426.436 72.5372 426.373 72.7835 426.182 72.8965C425.991 73.0094 425.744 72.9461 425.631 72.7552C424.969 71.6358 424.345 71.1145 423.794 70.89Z" fill="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M420.269 72.1477C420.452 72.2703 420.501 72.5181 420.378 72.701L417.323 77.2596C417.269 77.341 417.303 77.452 417.394 77.4885L419.576 78.3637C419.78 78.4457 419.88 78.6779 419.798 78.8824C419.716 79.0868 419.483 79.1861 419.279 79.1041L417.097 78.2289C416.535 78.0036 416.324 77.3182 416.661 76.8155L419.716 72.257C419.838 72.074 420.086 72.025 420.269 72.1477Z" fill="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M419.651 81.9222C420.288 82.0548 420.942 81.9126 421.603 81.558C421.798 81.4532 422.042 81.5266 422.146 81.7221C422.251 81.9176 422.178 82.1611 421.982 82.266C421.207 82.6819 420.359 82.8903 419.487 82.7086C418.614 82.5268 417.78 81.9672 417.008 80.9695C416.872 80.7941 416.904 80.5418 417.079 80.406C417.255 80.2702 417.507 80.3024 417.643 80.4778C418.333 81.3699 419.015 81.7897 419.651 81.9222Z" fill="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M436.632 76.9157C436.929 76.4893 436.997 76.0181 436.978 75.5133C436.97 75.3181 437.123 75.1539 437.318 75.1466C437.513 75.1393 437.677 75.2917 437.685 75.4869C437.706 76.07 437.632 76.7176 437.212 77.3206C436.793 77.9204 436.067 78.4256 434.89 78.8049C434.704 78.8648 434.504 78.7627 434.445 78.5767C434.385 78.3908 434.487 78.1915 434.673 78.1315C435.763 77.7803 436.332 77.3454 436.632 76.9157Z" fill="#111928"/>
                            <path d="M467 116.5C462.2 108.5 450 103.833 445.5 102.5L438 105.5C434.5 105.833 426.9 106.4 424.5 106C422.1 105.6 415.5 103.5 412.5 102.5L350.5 119L360.5 149.5L394.5 147.5C393.3 163.1 400.667 187.333 404.5 197.5H469.5L467 170.5L490.5 166C484.667 152.833 471.8 124.5 467 116.5Z" fill="#F9FAFB"/>
                            <path d="M467 116.5C462.2 108.5 450 103.833 445.5 102.5L438 105.5C434.5 105.833 426.9 106.4 424.5 106C422.1 105.6 415.5 103.5 412.5 102.5L350.5 119L360.5 149.5L394.5 147.5C393.3 163.1 400.667 187.333 404.5 197.5H469.5L467 170.5L490.5 166C484.667 152.833 471.8 124.5 467 116.5Z" fill="url(#paint4_linear_275_1057)"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M468.623 170.189L450 173.5L445.5 147.5L419.5 155.5L413.375 197.5H468.828L469.222 194.495L467 170.5L468.623 170.189Z" fill="url(#paint5_linear_275_1057)"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M394.499 147.5C395.333 142.333 397.699 130.4 400.499 124L354.975 132.65L360.499 149.5L394.499 147.5Z" fill="url(#paint6_linear_275_1057)"/>
                            <path d="M429 104.5C423.054 104.17 418.972 102.68 416.98 101.608C416.35 101.269 415.595 101.174 414.937 101.455L412.5 102.5C414.5 104.167 420.5 107.5 428.5 107.5C436.5 107.5 442.5 104.167 445.5 102.5L443.495 101.498C442.876 101.188 442.146 101.225 441.549 101.576C439.202 102.953 435.261 104.848 429 104.5Z" fill="#9ab7f6"/>
                            <path d="M456 172.5L475 169L481 272.5H468.5L456 172.5Z" fill="#FDBA8C"/>
                            <path d="M456 172.5L475 169L481 272.5H468.5L456 172.5Z" fill="url(#paint7_linear_275_1057)"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.427 306.568C27.427 308.25 27.7333 309.861 28.2931 311.348C28.7588 312.585 28.4398 314.033 27.4301 314.886C22.8606 318.744 19.9585 324.516 19.9585 330.965C19.9585 333.247 20.3219 335.444 20.994 337.502C21.3428 338.57 21.0489 339.76 20.2141 340.512C13.943 346.162 10.0005 354.347 10.0005 363.453C10.0005 380.502 23.8214 394.323 40.8704 394.323C57.9193 394.323 71.7402 380.502 71.7402 363.453C71.7402 354.432 67.8711 346.315 61.7018 340.671C60.8728 339.913 60.588 338.72 60.9451 337.655C61.6495 335.553 62.0312 333.304 62.0312 330.965C62.0312 324.516 59.129 318.744 54.5596 314.886C53.5499 314.033 53.2309 312.585 53.6966 311.348C54.2564 309.861 54.5626 308.25 54.5626 306.568C54.5626 299.075 48.4882 293 40.9948 293C33.5015 293 27.427 299.075 27.427 306.568Z" fill="#d6e2fb"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M41.1187 305.725C40.722 305.725 40.4005 306.047 40.4005 306.443L40.4005 425.691C40.4005 426.087 40.722 426.409 41.1187 426.409C41.5153 426.409 41.8369 426.087 41.8369 425.691L41.8369 306.443C41.8369 306.047 41.5154 305.725 41.1187 305.725Z" fill="#9ab7f6"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.0093 359.632C26.6865 359.863 26.6118 360.311 26.8423 360.634L40.5346 379.803C40.7652 380.126 41.2137 380.201 41.5365 379.97C41.8593 379.74 41.934 379.291 41.7035 378.968L28.0112 359.799C27.7807 359.477 27.3321 359.402 27.0093 359.632Z" fill="#9ab7f6"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M55.229 330.007C55.5518 330.237 55.6265 330.686 55.396 331.009L41.7037 350.178C41.4731 350.501 41.0246 350.575 40.7018 350.345C40.379 350.114 40.3042 349.666 40.5348 349.343L54.2271 330.174C54.4576 329.851 54.9062 329.776 55.229 330.007Z" fill="#9ab7f6"/>
                            <path d="M60.4712 408.518C60.5071 407.701 59.8542 407.019 59.0362 407.019H22.9526C22.1346 407.019 21.4817 407.701 21.5175 408.518L23.881 462.406C23.9147 463.174 24.5473 463.78 25.3161 463.78H56.6727C57.4415 463.78 58.0741 463.174 58.1077 462.406L60.4712 408.518Z" fill="#d6e2fb"/>
                            <path d="M60.4712 408.518C60.5071 407.701 59.8542 407.019 59.0362 407.019H22.9526C22.1346 407.019 21.4817 407.701 21.5175 408.518L23.881 462.406C23.9147 463.174 24.5473 463.78 25.3161 463.78H56.6727C57.4415 463.78 58.0741 463.174 58.1077 462.406L60.4712 408.518Z" fill="url(#paint8_linear_275_1057)"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M703.427 306.568C703.427 308.25 703.733 309.861 704.293 311.348C704.759 312.585 704.44 314.033 703.43 314.886C698.861 318.744 695.959 324.516 695.959 330.965C695.959 333.247 696.322 335.444 696.994 337.502C697.343 338.57 697.049 339.76 696.214 340.512C689.943 346.162 686.001 354.347 686.001 363.453C686.001 380.502 699.821 394.323 716.87 394.323C733.919 394.323 747.74 380.502 747.74 363.453C747.74 354.432 743.871 346.315 737.702 340.671C736.873 339.913 736.588 338.72 736.945 337.655C737.65 335.553 738.031 333.304 738.031 330.965C738.031 324.516 735.129 318.744 730.56 314.886C729.55 314.033 729.231 312.585 729.697 311.348C730.256 309.861 730.563 308.25 730.563 306.568C730.563 299.075 724.488 293 716.995 293C709.502 293 703.427 299.075 703.427 306.568Z" fill="#d6e2fb"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M717.12 305.725C716.723 305.725 716.401 306.047 716.401 306.443L716.401 425.691C716.401 426.087 716.723 426.409 717.12 426.409C717.516 426.409 717.838 426.087 717.838 425.691L717.838 306.443C717.838 306.047 717.516 305.725 717.12 305.725Z" fill="#9ab7f6"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M703.009 359.632C702.687 359.863 702.612 360.311 702.842 360.634L716.535 379.803C716.765 380.126 717.214 380.201 717.537 379.97C717.859 379.74 717.934 379.291 717.703 378.968L704.011 359.799C703.781 359.477 703.332 359.402 703.009 359.632Z" fill="#9ab7f6"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M731.229 330.007C731.552 330.237 731.627 330.686 731.396 331.009L717.704 350.178C717.473 350.501 717.025 350.575 716.702 350.345C716.379 350.114 716.304 349.666 716.535 349.343L730.227 330.174C730.458 329.851 730.906 329.776 731.229 330.007Z" fill="#9ab7f6"/>
                            <path d="M736.471 408.518C736.507 407.701 735.854 407.019 735.036 407.019H698.953C698.135 407.019 697.482 407.701 697.518 408.518L699.881 462.406C699.915 463.174 700.547 463.78 701.316 463.78H732.673C733.442 463.78 734.074 463.174 734.108 462.406L736.471 408.518Z" fill="#d6e2fb"/>
                            <path d="M736.471 408.518C736.507 407.701 735.854 407.019 735.036 407.019H698.953C698.135 407.019 697.482 407.701 697.518 408.518L699.881 462.406C699.915 463.174 700.547 463.78 701.316 463.78H732.673C733.442 463.78 734.074 463.174 734.108 462.406L736.471 408.518Z" fill="url(#paint9_linear_275_1057)"/>
                            <rect width="748" height="42" rx="6" transform="matrix(-1 0 0 1 748 464)" fill="#d6e2fb"/>
                            <path d="M352 253C352.5 240 357 208.7 371 187.5" stroke="#111928"/>
                            <rect x="376.143" y="173" width="10" height="20" rx="5" transform="rotate(37.3807 376.143 173)" fill="#111928"/>
                            <rect width="148" height="283" rx="6" transform="matrix(-1 0 0 1 666 251)" fill="#c8d8fa"/>
                            <rect x="260" y="251" width="293" height="283" rx="6" fill="#d6e2fb"/>
                            <rect x="260" y="251" width="293" height="283" rx="6" fill="url(#paint10_linear_275_1057)"/>
                            <circle cx="406" cy="393" r="97" fill="url(#paint11_linear_275_1057)"/>
                            <path d="M505.147 224.138C505.068 222.982 505.984 222 507.143 222H531.857C533.016 222 533.932 222.982 533.853 224.138L532 251H507L505.147 224.138Z" fill="#c8d8fa"/>
                            <path d="M508 232H531L530 251H509L508 232Z" fill="url(#paint12_linear_275_1057)"/>
                            <path d="M420.5 416C408.5 417.6 409.833 427.667 412 432.5L417 484L431 481C438.333 472.833 454 455 458 449C462 443 456.666 438.5 453.5 437C454.5 421.5 435.5 414 420.5 416Z" fill="#111928"/>
                            <path d="M408.984 442.218C408.193 444.037 407.042 445.467 405.843 446.318C404.635 447.176 403.46 447.399 402.543 447.001C401.627 446.602 400.988 445.591 400.792 444.122C400.597 442.665 400.857 440.847 401.647 439.029C402.438 437.211 403.589 435.78 404.788 434.929C405.996 434.071 407.171 433.848 408.088 434.246C409.004 434.645 409.643 435.657 409.839 437.125C410.034 438.582 409.774 440.4 408.984 442.218Z" stroke="#111928"/>
                            <path d="M408.5 470C390.9 464 406.166 439.167 415 428.5C420.591 429.199 419.974 437.329 419.285 442.15C419.127 443.253 419.678 444.339 420.675 444.837C421.494 445.247 422.47 445.186 423.232 444.678L425.873 442.918C428.525 441.15 432.132 442.25 433.346 445.197C434.056 446.922 433.752 448.891 432.629 450.381C429.202 454.928 424.329 462.35 423 468C421.4 474.8 427.666 479.5 431 481L432 495.5C420.4 499.5 413.5 497.167 411.5 495.5L408.5 470Z" fill="#FDBA8C"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M408.5 470C408.5 470 408.5 470 408.5 470L411.5 495.5C413.5 497.167 420.4 499.5 432 495.5L431 481C427.667 479.5 421.4 474.8 423 468C423.613 465.396 424.979 462.415 426.608 459.513C419.507 468.662 411.609 470.327 408.5 470L408.5 470Z" fill="url(#paint13_linear_275_1057)"/>
                            <path d="M403 437L424 443.5" stroke="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M400.616 456.036C400.665 455.7 400.722 455.361 400.786 455.02C402.007 454.908 403.827 454.438 405.709 453.093C405.934 452.933 406.246 452.985 406.407 453.209C406.567 453.434 406.515 453.746 406.29 453.907C404.139 455.443 402.028 455.952 400.616 456.036Z" fill="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M410.218 434.877C410.426 434.573 410.634 434.272 410.841 433.976C411.701 435.332 412.059 436.557 412.127 437.237C412.154 437.512 411.954 437.757 411.679 437.784C411.404 437.812 411.159 437.611 411.132 437.336C411.085 436.868 410.834 435.951 410.218 434.877Z" fill="#111928"/>
                            <path d="M405.41 440.956C405.184 441.484 405.428 442.095 405.956 442.321C406.483 442.548 407.095 442.304 407.321 441.776C407.548 441.248 407.304 440.637 406.776 440.41C406.248 440.184 405.637 440.428 405.41 440.956Z" fill="#111928"/>
                            <path d="M427.5 452.5C428.667 451.5 431 449.8 431 447C431 444.2 428 444.5 426.5 445.5" stroke="#111928" stroke-linecap="round"/>
                            <path d="M380.5 499C362.1 507 356.167 554.667 355.5 577.5H478C477.333 554.667 473.1 507 461.5 499C447 489 403.5 489 380.5 499Z" fill="#F9FAFB"/>
                            <path d="M380.5 499C362.1 507 356.167 554.667 355.5 577.5H478C477.333 554.667 473.1 507 461.5 499C447 489 403.5 489 380.5 499Z" fill="url(#paint14_linear_275_1057)"/>
                            <rect x="346" y="545" width="143" height="133" rx="16" fill="#d6e2fb"/>
                            <rect x="346" y="545" width="143" height="133" rx="16" fill="url(#paint15_linear_275_1057)"/>
                            <path d="M243 494C223 494 211.333 532.333 208 551.5C243.833 570.333 315.5 596.7 315.5 551.5C315.5 506.3 295.5 494.333 285.5 494H243Z" fill="#c8d8fa"/>
                            <path d="M243 494C223 494 211.333 532.333 208 551.5C243.833 570.333 315.5 596.7 315.5 551.5C315.5 506.3 295.5 494.333 285.5 494H243Z" fill="url(#paint16_linear_275_1057)"/>
                            <path d="M241 511.5C243.8 527.1 243.167 548 242.5 556.5H304.5C304.5 541.5 287 500.5 287 488.5C287 476.5 293 426 268.5 426C244 426 237.5 492 241 511.5Z" fill="#111928"/>
                            <rect x="185" y="545" width="143" height="133" rx="16" fill="#d6e2fb"/>
                            <rect x="185" y="545" width="143" height="133" rx="16" fill="url(#paint17_linear_275_1057)"/>
                            <path d="M91.9301 416C103.93 417.6 102.597 427.667 100.43 432.5L95.4302 484L81.4302 481C74.0968 472.833 66 464 62 458C58 452 55 437.5 62.5 435.5C62.5 424 76.9301 414 91.9301 416Z" fill="#111928"/>
                            <path d="M103.93 470C124 470 106.264 439.167 97.4302 428.5C91.8227 429.201 95.5297 438.142 96.982 443.148C97.2983 444.238 96.7394 445.345 95.7241 445.853C94.9194 446.255 93.9639 446.213 93.1979 445.741L90.7434 444.229C88.2156 442.673 84.9122 444.135 84.3651 447.053C84.1337 448.287 84.4721 449.551 85.1927 450.579C88.2384 454.925 92.0213 462.513 93.4299 468.5C95.0299 475.3 84.7633 479.5 81.4299 481L80.4299 495.5C92.0299 499.5 98.9299 497.167 100.93 495.5L103.93 470Z" fill="#FDBA8C"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M103.999 470C103.976 470 103.953 470 103.93 470L100.93 495.5C98.9299 497.166 92.0298 499.5 80.4298 495.5L81.4298 481C81.5844 480.93 81.7539 480.855 81.9365 480.774C85.6899 479.105 94.9557 474.984 93.4298 468.5C92.9645 466.522 92.24 464.369 91.3686 462.217C96.1428 466.414 101.578 469.714 103.999 470Z" fill="url(#paint18_linear_275_1057)"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M102.212 434.877C102.004 434.573 101.796 434.272 101.588 433.976C100.728 435.332 100.371 436.557 100.303 437.237C100.275 437.512 100.476 437.757 100.751 437.784C101.025 437.812 101.27 437.611 101.298 437.336C101.344 436.868 101.595 435.951 102.212 434.877Z" fill="#111928"/>
                            <path d="M107.019 440.956C107.246 441.484 107.002 442.095 106.474 442.321C105.946 442.548 105.335 442.304 105.108 441.776C104.882 441.248 105.126 440.637 105.654 440.41C106.182 440.184 106.793 440.428 107.019 440.956Z" fill="#111928"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M87.0829 446.157C86.7036 446.539 86.4999 447.067 86.4999 447.721C86.4999 448.982 87.1035 449.973 87.7997 450.725C88.3761 451.348 89.053 451.844 89.5472 452.205C89.6426 452.275 89.7312 452.34 89.811 452.4C90.0319 452.566 90.3453 452.521 90.511 452.3C90.6767 452.079 90.632 451.766 90.4111 451.6C90.3181 451.53 90.2198 451.458 90.1177 451.383C89.6225 451.02 89.038 450.591 88.5335 450.046C87.9333 449.398 87.4999 448.638 87.4999 447.721C87.4999 447.285 87.6296 447.026 87.7919 446.863C87.9632 446.69 88.2238 446.572 88.5693 446.524C89.2751 446.425 90.163 446.644 90.7479 446.986C90.9864 447.125 91.2926 447.044 91.4318 446.806C91.5709 446.567 91.4904 446.261 91.2519 446.122C90.5035 445.685 89.3914 445.399 88.4306 445.533C87.9427 445.602 87.4534 445.785 87.0829 446.157Z" fill="#111928"/>
                            <path d="M132.5 499C150.9 507 156.833 554.667 157.5 577.5H35C35.6667 554.667 39.9 507 51.5 499C66 489 109.5 489 132.5 499Z" fill="#F9FAFB"/>
                            <rect x="24" y="545" width="143" height="133" rx="16" fill="#d6e2fb"/>
                            <rect x="24" y="545" width="143" height="133" rx="16" fill="url(#paint19_linear_275_1057)"/>
                            <defs>
                            <linearGradient id="paint0_linear_275_1057" x1="273.5" y1="291" x2="219.5" y2="125.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint1_linear_275_1057" x1="483" y1="116.5" x2="300.798" y2="143.181" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7F270F"/>
                            <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint2_linear_275_1057" x1="439.838" y1="147.5" x2="439.838" y2="263.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#111928"/>
                            <stop offset="1" stop-color="#111928" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint3_linear_275_1057" x1="429.478" y1="73" x2="429.478" y2="99" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7F270F"/>
                            <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint4_linear_275_1057" x1="479" y1="256" x2="479" y2="137.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint5_linear_275_1057" x1="463" y1="191" x2="434.5" y2="178" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint6_linear_275_1057" x1="400" y1="156.5" x2="388.5" y2="133.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint7_linear_275_1057" x1="468.5" y1="84" x2="468.5" y2="218" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7F270F"/>
                            <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint8_linear_275_1057" x1="-25.4505" y1="445.529" x2="87.7106" y2="445.529" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#9ab7f6"/>
                            <stop offset="1" stop-color="#9ab7f6" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint9_linear_275_1057" x1="650.549" y1="445.529" x2="763.711" y2="445.529" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#9ab7f6"/>
                            <stop offset="1" stop-color="#9ab7f6" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint10_linear_275_1057" x1="307.5" y1="506.135" x2="307.5" y2="345.043" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint11_linear_275_1057" x1="406" y1="296" x2="406" y2="453.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#F9FAFB"/>
                            <stop offset="1" stop-color="#F9FAFB" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint12_linear_275_1057" x1="519.5" y1="226" x2="519.5" y2="256.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#d6e2fb"/>
                            <stop offset="1" stop-color="#d6e2fb" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint13_linear_275_1057" x1="420.5" y1="450" x2="422.25" y2="488.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7F270F"/>
                            <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint14_linear_275_1057" x1="416.75" y1="416" x2="416.75" y2="577.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint15_linear_275_1057" x1="417.5" y1="508" x2="417.5" y2="678" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint16_linear_275_1057" x1="277" y1="607.5" x2="277" y2="494" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#2563eb"/>
                            <stop offset="1" stop-color="#2563eb" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint17_linear_275_1057" x1="256.5" y1="508" x2="256.5" y2="678" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint18_linear_275_1057" x1="95.25" y1="452" x2="95.25" y2="493" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7F270F"/>
                            <stop offset="1" stop-color="#7F270F" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="paint19_linear_275_1057" x1="95.5" y1="508" x2="95.5" y2="678" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#c8d8fa"/>
                            <stop offset="1" stop-color="#c8d8fa" stop-opacity="0"/>
                            </linearGradient>
                            </defs>
                            </svg>
                    </div>
                </div>
            </div>
        </div>
        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <!-- Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                <div>
                    <div class="p-4 rounded-lg ">
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 xl:grid-cols-12 items-start">
                            <!-- Tables -->
                            <div class="xl:col-span-9 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 ">
                                <!-- Profile -->
                                <div class=" rounded-lg bg-neutral-50 dark:bg-neutral-900" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div
                                        class="xl:col-span-2 bg-white  rounded dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                                        <div class="flex flex-col space-y-2 w-full mb-5">
                                            <label for="title"
                                                class="block text-sm font-medium text-black dark:text-white">{{ __('Your Course Title') }}</label>
                                            <input placeholder="Your Course Title Here" pattern="[A-Za-z0-9 ]+"
                                                class="bg-white text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                name="title" id="title" type="text">
                                            <div class="text-red-500 text-sm">
                                                <p id="error"></p>
                                                <p id="error1" class="text-center"></p>
                                            </div>
                                        </div>
                                        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
                                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center"
                                                id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                                <li class="me-2" role="presentation">
                                                    <button
                                                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                                                        id="personal-info-tab" data-tabs-target="#personal-info"
                                                        type="button" role="tab" aria-controls="personal-info"
                                                        aria-selected="true">{{ __('Description') }}</button>
                                                </li>
                                                <li class="me-2" role="presentation">
                                                    <button disabled
                                                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                                                        id="contact-info-tab" data-tabs-target="#contact-info"
                                                        type="button" role="tab" aria-controls="contact-info"
                                                        aria-selected="false">{{ __('Curriculum') }}</button>
                                                </li>
                                                <li class="me-2" role="presentation">
                                                    <button disabled
                                                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                                                        id="my-sites-tab" data-tabs-target="#my-sites" type="button"
                                                        role="tab" aria-controls="my-sites"
                                                        aria-selected="false">{{ __('FAQ') }}</button>
                                                </li>
                                                <li class="me-2" role="presentation">
                                                    <button disabled
                                                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                                                        id="social-media-tab" data-tabs-target="#social-media"
                                                        type="button" role="tab" aria-controls="social-media"
                                                        aria-selected="false">{{ __('Announcements') }}</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="checktitle" id="checktitle" value="">
                                        <input type="hidden" name="course_id" id="course_id" value="">
                                        <input type="hidden" name="status" id="status" value="">
                                        <input type="hidden" name="type" id="type" value="">
                                        <div id="default-tab-content">
                                            <div class="rounded-lg bg-neutral-50 dark:bg-neutral-900 p-6" id="personal-info"
                                                role="tabpanel" aria-labelledby="personal-info-tab">
                                                <h3 class="text-lg font-semibold text-black mb-5 dark:text-white">
                                                    {{ __('Description') }}
                                                </h3>
                                                {{--  <form>  --}}
                                                    <div
                                                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mb-5">
                                                        <div class="mb-5">
                                                            <label for=""
                                                                class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Package Icon') }}
                                                            </label>
                                                            <!-- Preview Container -->
                                                            <div id="preview_container"
                                                                class="relative w-full bg-white border border-neutral-200 rounded-lg shadow dark:bg-neutral-900 dark:border-neutral-700">
                                                                <!-- Pencil Icon Button -->
                                                                <button data-modal-target="default-modal"
                                                                    data-modal-toggle="default-modal"
                                                                    class="absolute top-3 right-3 text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:ring-4 focus:outline-none focus:ring-neutral-200 dark:focus:ring-neutral-700 rounded-lg text-sm p-1.5"
                                                                    type="button" title="Edit Logo">
                                                                    <svg class="w-6 h-6 text-black dark:text-white"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="1.3"
                                                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28">
                                                                        </path>
                                                                    </svg>
                                                                </button>

                                                                <!-- Image Editor Modal -->
                                                                <div id="default-modal" tabindex="-1"
                                                                    aria-hidden="true"
                                                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

                                                                    <div
                                                                        class="relative p-4 w-full max-w-2xl bg-white rounded-lg shadow-lg">
                                                                        <!-- Modal header -->
                                                                        <div
                                                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-neutral-200">
                                                                            <h3
                                                                                class="text-xl font-semibold text-black dark:text-white">
                                                                                {{ __('Edit Course Banner') }}
                                                                            </h3>
                                                                            <button type="button"
                                                                                class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                                                                                data-modal-hide="default-modal">
                                                                                <svg class="w-3 h-3"
                                                                                    aria-hidden="true"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none"
                                                                                    viewBox="0 0 14 14">
                                                                                    <path stroke="currentColor"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                                </svg>
                                                                                <span
                                                                                    class="sr-only">{{ __('Close modal') }}</span>
                                                                            </button>
                                                                        </div>


                                                                        <!-- Modal Body with Image Editor -->
                                                                        <div class="p-4">
                                                                            <div class="flex flex-col items-center">
                                                                                <img id="editor_image"
                                                                                    class="w-auto max-h-80 h-60 rounded-xl"
                                                                                    src="/assets/img/plans/noimage.png">
                                                                            </div>
                                                                        </div>

                                                                        <!-- Modal Footer -->
                                                                        <div class="flex justify-end p-4 border-t">
                                                                            <input type="file" id="inputImage"
                                                                                name="file"
                                                                                accept=".jpg,.jpeg,.png,.gif,.svg"
                                                                                class="hidden">
                                                                            <button id="select_image" type="button"
                                                                                class="bg-neutral-300 px-4 py-2 rounded-lg mr-2">{{ __('Choose Image') }}</button>
                                                                            <button id="crop_image" type="button"
                                                                                data-modal-hide="default-modal"
                                                                                class="bg-neutral-600 text-white px-4 py-2 rounded-lg">{{ __('Crop & Save') }}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Image Preview -->
                                                                <div class="flex flex-col items-center p-10">
                                                                    <img name="banner" id="banner"
                                                                        class="w-auto h-60 mb-3 rounded-xl shadow-lg"
                                                                        src="/assets/img/plans/noimage.png"
                                                                        alt="No Image Available">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="image_crop_file_hidd" id="image_crop_file_hidd" value="">
                                                            <p class="text-xs mt-2 dark:text-white">
                                                                Allowed file formats: PNG, JPG, SVG (100px x 34px)</p>
                                                        </div>
                                                        <div class="submiterrors">
                                                            <a class="col" id="error2" style="color:red;"></a>
                                                            </div>
                                                        <div
                                                            class="w-full mb-4  rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                                                            <div
                                                                class="flex items-center justify-between px-3 py-2 border-b border-neutral-200">
                                                                <div
                                                                    class="flex flex-wrap items-center divide-neutral-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-neutral-600">
                                                                    <div
                                                                        class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 12 20">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                                                                            </svg>
                                                                            <span
                                                                                class="sr-only">{{ __('Attach file') }}</span>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 16 20">
                                                                                <path
                                                                                    d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                                                                            </svg>
                                                                            <span class="sr-only">Embed map</span>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 16 20">
                                                                                <path
                                                                                    d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                                                                                <path
                                                                                    d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                                                                            </svg>
                                                                            <span
                                                                                class="sr-only">{{ __('Upload image') }}</span>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 16 20">
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
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 20 20">
                                                                                <path
                                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm-7 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm3.5 9.5A5.5 5.5 0 0 1 4.6 11h10.81A5.5 5.5 0 0 1 10 15.5Z" />
                                                                            </svg>
                                                                            <span class="sr-only">Add emoji</span>
                                                                        </button>
                                                                    </div>
                                                                    <div
                                                                        class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 21 18">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M9.5 3h9.563M9.5 9h9.563M9.5 15h9.563M1.5 13a2 2 0 1 1 3.321 1.5L1.5 17h5m-5-15 2-1v6m-2 0h4" />
                                                                            </svg>
                                                                            <span class="sr-only">Add list</span>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 20 20">
                                                                                <path
                                                                                    d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z" />
                                                                            </svg>
                                                                            <span class="sr-only">Settings</span>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 20 20">
                                                                                <path
                                                                                    d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z" />
                                                                                <path
                                                                                    d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z" />
                                                                            </svg>
                                                                            <span class="sr-only">Timeline</span>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="currentColor"
                                                                                viewBox="0 0 20 20">
                                                                                <path
                                                                                    d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                                                                                <path
                                                                                    d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                                                                            </svg>
                                                                            <span class="sr-only">Download</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    data-tooltip-target="tooltip-fullscreen"
                                                                    class="p-2 text-black rounded-sm cursor-pointer sm:ms-auto hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 19 19">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M13 1h5m0 0v5m0-5-5 5M1.979 6V1H7m0 16.042H1.979V12M18 12v5.042h-5M13 12l5 5M2 1l5 5m0 6-5 5" />
                                                                    </svg>
                                                                    <span class="sr-only">Full screen</span>
                                                                </button>
                                                                <div id="tooltip-fullscreen" role="tooltip"
                                                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-neutral-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                                                                    Show full screen
                                                                    <div class="tooltip-arrow" data-popper-arrow>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="px-4 py-2 bg-white rounded-b-lg dark:bg-neutral-900">
                                                                <label for="editor"
                                                                    class="sr-only">{{ __('Publish post') }}</label>
                                                                <textarea name="description" id="description" rows="8"
                                                                    class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400"
                                                                    placeholder="Write an article..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="submiterrors">
                                                            <a class="col" id="error6" style="color:red;"></a>
                                                        </div>
                                                        <input type="hidden" name="coursemethod" id="coursemethod" value="1">
                                                        <div class="mb-5">
                                                            <table class="min-w-2xl  ">
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            class="pe-6  text-black dark:text-white text-sm font-medium w-48">
                                                                            {{ __('Status') }}
                                                                        </td>
                                                                        <td class="px-6  text-right">
                                                                            <div class="flex items-center p-2.5">
                                                                                <span
                                                                                    class="text-sm font-medium text-black dark:text-white">{{ __('Off') }}</span>
                                                                                <label
                                                                                    class="inline-flex items-center cursor-pointer mx-3">
                                                                                    <input type="checkbox"
                                                                                    name="course_status" id="course_status"
                                                                                        value="1"
                                                                                        class="sr-only peer">
                                                                                    <div
                                                                                        class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                                    </div>
                                                                                </label>
                                                                                <span
                                                                                    class="text-sm font-medium text-black dark:text-white">{{ __('On') }}</span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <div class="form-submit">
                                                            <button type="button" id="submitdesc" onclick="submitcourse()"
                                                                class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Submit</button>
                                                        </div>
                                                    </div>
                                                {{--  </form>  --}}
                                            </div>
                                        </div>
                                        <div class="rounded-lg bg-neutral-50 dark:bg-neutral-900 p-6 hidden" id="contact-info"
                                            role="tabpanel" aria-labelledby="contact-info-tab">
                                            <h3 class="text-lg font-semibold text-black mb-5 dark:text-white">
                                                {{ __('Curriculum') }}
                                            </h3>
                                            {{--  <form>  --}}
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mb-5">
                                                    <div class="">
                                                        <button type="button" id="titlenumber"
                                                            class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:hover:bg-[#FF5D19]">{{ __('Add Course') }}</button>
                                                    </div>
                                                    <div class="hidden"  id="totalnumber" >
                                                        <label for="lastname"
                                                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Number of subtitle') }}</label>
                                                        <input type="number" id="totaltitle" name="totaltitle"
                                                            min="1"
                                                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                            placeholder="">
                                                            <div class="submiterrors">
                                                                <a class="col" id="error3" style="color:red;"></a>
                                                            </div>
                                                    </div>

                                                    <div id="nolevelinput">
                                                        <div id="accordion-container"></div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end">
                                                    <div class="form-submit">
                                                        <button type="button" onclick="submitlessioninsertcourse()"
                                                            class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Update</button>
                                                    </div>
                                                </div>
                                            {{--  </form>  --}}
                                        </div>
                                        <div class="rounded-lg bg-neutral-50 dark:bg-neutral-900 p-6 hidden" id="my-sites"
                                            role="tabpanel" aria-labelledby="my-sites-tab">
                                            <h3 class="text-lg font-semibold text-black mb-5 dark:text-white">
                                              {{  __('FAQ') }}
                                            </h3>
                                            {{--  <form>  --}}
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mb-5">
                                                    <div class="mb-5">
                                                        <label for="lastname"
                                                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{  __('FAQ') }}</label>
                                                            <div class="mt-4 relative w-full">
                                                                <input  class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500" type="text" name="faqvalues"  value="" id="faqvalues">
                                                                <button type="button"  onclick="submitfaq();"
                                                                    class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-neutral-700 rounded-e-lg border border-blue-700 hover:bg-neutral-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-neutral-600 dark:hover:bg-neutral-700 dark:focus:ring-blue-800"><svg
                                                                        class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="submiterrors">
                                                            <a class="col" id="error10" style="color:red;"></a>
                                                            </div>
                                                        {{--  <textarea id="message" rows="4"
                                                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                            placeholder="Write your content here..."></textarea>  --}}
                                                    </div>
                                                    <div id="contentfaq"></div>
                                                </div>
                                                <input type="hidden" name="faq_id" id="faq_id" value="">
                                                <div class="flex justify-end">
                                                    <div class="form-submit">
                                                        <button type="button" onclick="submitfaqtotal();"
                                                            class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>Update</button>
                                                    </div>
                                                </div>
                                            {{--  </form>  --}}
                                        </div>
                                        <div class="rounded-lg bg-neutral-50 dark:bg-neutral-900 p-6 hidden" id="social-media"
                                            role="tabpanel" aria-labelledby="social-media-tab">
                                            <h3 class="text-lg font-semibold text-black mb-5 dark:text-white">
                                                Announcements </h3>
                                            {{--  <form>  --}}
                                                <div
                                                    class="w-full mb-4  rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 ">
                                                    <div
                                                        class="flex items-center justify-between px-3 py-2 border-b border-neutral-200">
                                                        <div
                                                            class="flex flex-wrap items-center divide-neutral-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-neutral-600">
                                                            <div
                                                                class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 12 20">
                                                                        <path stroke="currentColor"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                                                                    </svg>
                                                                    <span class="sr-only">Attach file</span>
                                                                </button>
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 16 20">
                                                                        <path
                                                                            d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                                                                    </svg>
                                                                    <span class="sr-only">Embed map</span>
                                                                </button>
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
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
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 16 20">
                                                                        <path
                                                                            d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                                                                        <path
                                                                            d="M14.067 0H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.933-2ZM6.709 13.809a1 1 0 1 1-1.418 1.409l-2-2.013a1 1 0 0 1 0-1.412l2-2a1 1 0 0 1 1.414 1.414L5.412 12.5l1.297 1.309Zm6-.6-2 2.013a1 1 0 1 1-1.418-1.409l1.3-1.307-1.295-1.295a1 1 0 0 1 1.414-1.414l2 2a1 1 0 0 1-.001 1.408v.004Z" />
                                                                    </svg>
                                                                    <span class="sr-only">Format code</span>
                                                                </button>
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM13.5 6a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm-7 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm3.5 9.5A5.5 5.5 0 0 1 4.6 11h10.81A5.5 5.5 0 0 1 10 15.5Z" />
                                                                    </svg>
                                                                    <span class="sr-only">Add emoji</span>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 21 18">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9.5 3h9.563M9.5 9h9.563M9.5 15h9.563M1.5 13a2 2 0 1 1 3.321 1.5L1.5 17h5m-5-15 2-1v6m-2 0h4" />
                                                                    </svg>
                                                                    <span class="sr-only">Add list</span>
                                                                </button>
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z" />
                                                                    </svg>
                                                                    <span class="sr-only">Settings</span>
                                                                </button>
                                                                <button type="button"
                                                                    class="p-2 text-black rounded-sm cursor-pointer hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:text-white dark:hover:bg-neutral-600">
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
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
                                                                    <svg class="w-4 h-4" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
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
                                                        <button type="button"
                                                            data-tooltip-target="tooltip-fullscreen"
                                                            class="p-2 text-black rounded-sm cursor-pointer sm:ms-auto hover:text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-600">
                                                            <svg class="w-4 h-4" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 19 19">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M13 1h5m0 0v5m0-5-5 5M1.979 6V1H7m0 16.042H1.979V12M18 12v5.042h-5M13 12l5 5M2 1l5 5m0 6-5 5" />
                                                            </svg>
                                                            <span class="sr-only">Full screen</span>
                                                        </button>
                                                        <div id="tooltip-fullscreen" role="tooltip"
                                                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-neutral-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                                                            Show full screen
                                                            <div class="tooltip-arrow" data-popper-arrow>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-neutral-900">
                                                        <label for="editor" class="sr-only">Publish
                                                            post</label>
                                                        <textarea name="announcement" id="announcement" value="{{$announcement}}" rows="8"
                                                            class="block w-full px-0 text-sm text-black bg-white border-0 dark:bg-neutral-900 focus:ring-0 dark:text-white dark:placeholder-neutral-400"
                                                            placeholder="Write an article..." required>{{$announcement}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end">
                                                    <div class="form-submit">
                                                        <button type="button" onclick="submitannouncement();"
                                                            class="text-white bg-neutral-900 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-neutral-900 dark:hover:bg-neutral-700 dark:focus:ring-neutral-700 dark:border-neutral-700">Update</button>
                                                    </div>
                                                </div>
                                            {{--  </form>  --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="xl:col-span-3 ">
                                <div class="max-w-lg mx-auto">
                                    <!-- Accordion -->
                                    <div id="accordion-collapse" data-accordion="collapse">
                                        <!-- Add Price -->
                                        <h2 id="accordion-heading-1">
                                            <button type="button" disabled
                                                class="flex items-center justify-between w-full p-5 font-medium text-left border border-neutral-200 rounded-t-xl focus:ring-1 focus:ring-neutral-200 text-black dark:text-white" id="add_price_button"
                                                data-accordion-target="#accordion-body-1" aria-expanded="false"
                                                aria-controls="accordion-body-1">
                                                <span>{{ __('Add Price') }}</span>
                                                <svg class="w-8 h-8 text-black dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                        d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </h2>
                                        <div id="accordion-body-1" class="hidden" aria-labelledby="accordion-heading-1">
                                            <div class="p-5 border border-neutral-200">
                                                <label for="price"
                                                    class="block mb-2 text-sm font-medium text-black">{{ __('Add Price* ()') }}</label>
                                                <input type="number" name="price" min="0" id="price"
                                                    aria-describedby="helper-text-explanation"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500"
                                                    placeholder="90210" required="">
                                                <p id="error22" class="text-red-500 text-sm mt-2" style="color:red;"></p>
                                            </div>
                                        </div>

                                        <!-- Duration -->
                                        <h2 id="accordion-heading-2">
                                            <button type="button" disabled id="duration_button"
                                                class="flex items-center justify-between w-full p-5 font-medium text-left border border-neutral-200 focus:ring-1 focus:ring-neutral-200 text-black dark:text-white"
                                                data-accordion-target="#accordion-body-2" aria-expanded="false"
                                                aria-controls="accordion-body-2">
                                                <span>{{ __('Duration') }}</span>
                                                <svg class="w-8 h-8 text-black dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                                </svg>

                                            </button>
                                        </h2>
                                        <div id="accordion-body-2" class="hidden" aria-labelledby="accordion-heading-2">
                                            <div class="p-5 border border-neutral-200">
                                                <label for="time"
                                                    class="block mb-2 text-sm font-medium text-black">{{ __('Select time') }}:</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                                        <svg class="w-4 h-4 text-black dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <input type="time" name="duration" id="duration"
                                                        class="bg-neutral-50 dark:bg-neutral-900 text-black dark:text-white text-sm rounded-md border border-neutral-200 dark:border-neutral-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full p-2.5 placeholder-neutral-500 dark:placeholder-neutral-400" value="00:00" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Video -->
                                        {{--  <h2 id="accordion-heading-3">
                                            <button type="button"
                                                class="flex items-center justify-between w-full p-5 font-medium text-left border border-neutral-200 focus:ring-1 focus:ring-neutral-200 text-black dark:text-white"
                                                data-accordion-target="#accordion-body-3" aria-expanded="false"
                                                aria-controls="accordion-body-3">
                                                <span>{{ __('Video') }}</span>
                                                <svg class="w-8 h-8 text-black dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M19 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1Zm0 0-4 4m5 0H4m1 0 4-4m1 4 4-4m-4 7v6l4-3-4-3Z">
                                                    </path>
                                                </svg>

                                            </button>
                                        </h2>
                                        <div id="accordion-body-3" class="hidden" aria-labelledby="accordion-heading-3">
                                            <div class="p-5 border border-neutral-200">
                                                <label for="time"
                                                    class="block mb-2 text-sm font-medium text-black">
                                                    {{ __('Select time') }}:</label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                                        <svg class="w-4 h-4 text-black dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <input type="time" name="videoduration" id="videoduration"
                                                        class="bg-neutral-50 dark:bg-neutral-900 text-black dark:text-white text-sm rounded-md border border-neutral-200 dark:border-neutral-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full p-2.5 placeholder-neutral-500 dark:placeholder-neutral-400" value="00:00">
                                                </div>
                                            </div>
                                        </div>  --}}

                                        <!-- Plan -->
                                        <h2 id="accordion-heading-4">
                                            <button type="button" disabled id="plan_button"
                                                class="flex items-center justify-between w-full p-5 font-medium text-left border border-neutral-200 rounded-b-xl focus:ring-1 focus:ring-neutral-200 text-black dark:text-white"
                                                data-accordion-target="#accordion-body-4" aria-expanded="false"
                                                aria-controls="accordion-body-4">
                                                <span>{{ __('Plan') }}</span>
                                                <svg class="w-8 h-8 text-black dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m10.051 8.102-3.778.322-1.994 1.994a.94.94 0 0 0 .533 1.6l2.698.316m8.39 1.617-.322 3.78-1.994 1.994a.94.94 0 0 1-1.595-.533l-.4-2.652m8.166-11.174a1.366 1.366 0 0 0-1.12-1.12c-1.616-.279-4.906-.623-6.38.853-1.671 1.672-5.211 8.015-6.31 10.023a.932.932 0 0 0 .162 1.111l.828.835.833.832a.932.932 0 0 0 1.111.163c2.008-1.102 8.35-4.642 10.021-6.312 1.475-1.478 1.133-4.77.855-6.385Zm-2.961 3.722a1.88 1.88 0 1 1-3.76 0 1.88 1.88 0 0 1 3.76 0Z">
                                                    </path>
                                                </svg>

                                            </button>
                                        </h2>
                                        <div id="accordion-body-4" class="hidden" aria-labelledby="accordion-heading-4">
                                            <div class="p-5 border border-neutral-200">
                                                <label for="user_type"
                                                    class="block mb-2 text-sm font-medium text-black">{{ __('Minimum Membership') }}
                                                    <div class="mb-5">
                                                        <div class="flex items-center p-2.5">
                                                            <!-- Left label -->
                                                            <span
                                                                class="text-sm font-medium text-black dark:text-white">{{ __('User') }}</span>

                                                            <label class="inline-flex items-center cursor-pointer mx-3">
                                                                <input type="checkbox" name="user_type" id="user_type" value="1" @if($user_type == '1') checked @endif class="sr-only peer">
                                                                <div
                                                                    class="relative w-11 h-6  bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-neutral-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-neutral-900">
                                                                </div>
                                                            </label>

                                                            <!-- Right label -->
                                                            <span
                                                                class="text-sm font-medium text-black dark:text-white">{{ __('All User') }}</span>
                                                        </div>
                                                    </div>
                                                </label>
                                                {{--  <select id="user_type" name="user_type"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                                    <option value="1">All User</option>
                                                    <option value="2">User</option>
                                                </select>  --}}

                                                {{--  <select id="matrix_id" name="matrix_id"
                                                    class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                                    <option value="">Select</option>
                                                    <option value="1">iconunilevel</option>
                                                    <option value="2">binary</option>
                                                </select>  --}}

                                                <div id="show_matrix" class="mb-5">
                                                    <label for="matrix_id"
                                                    class="block mt-4 mb-2 text-sm font-medium text-black">{{ __('Plan') }}</label>
                                                    {!! $matrixtype !!}
                                                </div>
                                                <div id="showpack_rank" class="hidden"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-6 text-center">
                                        <button type="button" id="subextra" disabled
                                            class="w-full text-white bg-neutral-800 hover:bg-neutral-900 focus:outline-none focus:ring-4 focus:ring-neutral-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-[#ffcc00] dark:hover:bg-neutral-900 dark:focus:ring-neutral-900 dark:border-[#ffcc00]"
                                            onclick="submitextra();">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="addlession" tabindex="-1"
    class="hidden  overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-6 w-full max-w-5xl max-h-screen">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 max-h-[90vh] overflow-y-auto">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Add Lesson') }}</h3>
                <button type="button" id="addlessioncloseicon"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                   >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">Close
                        modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div id="showleassonform"></div>
            </div>
        </div>
    </div>
</div>
<div id="editquiz" tabindex="-1"
    class="hidden  overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-6 w-full max-w-5xl max-h-screen">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800 max-h-[90vh] overflow-y-auto">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Add Quiz') }}</h3>
                <button type="button" id="editquizcloseicon"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                   >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">Close
                        modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div id="showeditquizform"></div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end py-6">
                <button  type="button" id="editquizclose"
                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/js/cropper.min.js') }}"></script>
<script>


    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("title").addEventListener("input", function() {
            // This regex removes any character that is not a letter, number, or space.
            this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '');
        });

        document.getElementById("titlenumber").addEventListener("click", function () {
            const element = document.getElementById("totalnumber");

            if (element) {
                element.classList.toggle("hidden"); // Toggle the 'hidden' class
            } else {
                console.error("Error: Element with ID 'totalnumber' not found.");
            }
        });
        function previewImage(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('preview_container');
            const imagePreview = document.getElementById('banner');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                previewContainer.classList.add('hidden');
            }
        }
    });

    function submitcourse() {
        var x = document.getElementById("title").value;
        if (x == "") {
            document.getElementById("error").innerHTML = "{{ __('This field is required') }}";
        } else {
            document.getElementById("error").innerHTML = "";
        }

        // Perform Ajax call without jQuery (replacing jQuery AJAX)
        var formData = new FormData();
        formData.append('title', x);

        fetch("{{$_ENV['BCPATH']}}/elearning/checktitle", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("checktitle").value = data;
        })
        .catch(error => console.error("Error in checking title:", error));

        var checktitle = document.getElementById("checktitle").value;

        if (checktitle > 0) {
            document.getElementById("error1").innerHTML = "{{ __('Title Already exists') }}";
        } else {
            document.getElementById("error1").innerHTML = "";
        }

        var banner = document.getElementById("banner").value;
        if (banner == "") {
            document.getElementById("error2").innerHTML = "{{ __('This field is required') }}";
        } else {
            document.getElementById("error2").innerHTML = "";
        }

        var description = document.getElementById("description").value;
        if (description == "") {
            document.getElementById("error6").innerHTML = "{{ __('This field is required') }}";
        } else {
            document.getElementById("error6").innerHTML = "";
        }

        // Bootstrap Switch handling (native JS equivalent)
        var c_status = document.getElementById('course_status').checked ? 1 : 0;
        document.getElementById('status').value = c_status;

        var titleerror = document.getElementById("error").innerHTML;
        var titleerror1 = document.getElementById("error1").innerHTML;
        var bannererror1 = document.getElementById("error2").innerHTML;
        var descriptionerror6 = document.getElementById("error6").innerHTML;
        if (titleerror == '' && descriptionerror6 == '') {;

            var form_data = new FormData();
            var status = document.getElementById("status").value;
            form_data.append("title", x);
            form_data.append("description", description);
            form_data.append("course_status", status);

            form_data.append('banner', document.getElementById('image_crop_file_hidd').value);

            fetch("{{$_ENV['BCPATH']}}/elearning/insertcourse", {
                method: "POST",
                body: form_data
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('contact-info-tab').disabled = false;
                Swal.fire({
                    title: '{{ __("Description Updated Successfully") }}', // Static or dynamic value
                    text: '{{ __("Your action was successful.") }}', // Static or dynamic value
                    icon: 'success',
                    confirmButtonText: '{{ __("Okay") }}',
                    customClass: {
                        popup: 'bg-white rounded-lg shadow-lg', // Customize popup style
                        title: 'text-xl font-semibold text-black', // Customize title style
                        text: 'text-sm text-black', // Customize text style
                        confirmButton: 'bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg', // Customize button style
                        cancelButton: 'bg-neutral-200 text-black hover:bg-neutral-100 font-semibold py-2 px-4 rounded-lg',
                    }
                });
                document.getElementById('course_id').value = data;
                document.getElementById("submitdesc").classList.add('hidden');
            })
            .catch(error => console.error("Error submitting course:", error));
        }
    }

    function submitlessioninsertcourse() {
        let totaltitle = document.getElementById("totaltitle").value.trim();
        let errorElement = document.getElementById("error3");

        // Validate Title
        if (totaltitle == "") {
            errorElement.innerHTML = "{{ __('This field is required') }}";
            return;
        } else {
            errorElement.innerHTML = "";
        }


        let formData = new FormData();
        formData.append("totaltitle", totaltitle);

        // Collecting subtitles dynamically
        let subtitles = document.querySelectorAll('.subtitlelession');
        subtitles.forEach((item, index) => {
            let subtitleValue = item.value.trim();
            formData.append(`subtitle${index + 1}`, subtitleValue);
        });

        let id = document.getElementById("course_id").value;

        fetch(`{{$_ENV['BCPATH']}}/elearning/insertsubcourse/${id}`, {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('my-sites-tab').disabled = false;
            showlession(); // Call function after success
        })
        .catch(error => console.error("Error:", error))
        .finally(() => {
        });
    }

    function showlession() {

        let id = document.getElementById("course_id").value;

        fetch(`{{$_ENV['BCPATH']}}/elearning/showlession/${id}`, {
            method: "GET"
        })
        .then(response => response.text())
        .then(data => {
            let noLevelInput = document.getElementById("nolevelinput");
            if (noLevelInput) {
                noLevelInput.innerHTML = data;
            } else {
                console.error("Error: Element with ID 'nolevelinput' not found.");
            }

             // Initialize accordion functionality
             document.querySelectorAll("[data-accordion-target]").forEach(button => {
                button.addEventListener('click', function () {
                    const target = document.querySelector(this.getAttribute('data-accordion-target'));
                    target.classList.toggle('hidden');
                });
            });

            // Initialize tab switching functionality
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function (e) {
                    // Prevent default form submission or page refresh behavior
                    e.preventDefault();

                    const tabGroup = this.closest('ul').getAttribute('data-tab-group');
                    const tabName = this.getAttribute('data-tab');

                    // Hide all tab content in the current group
                    document.querySelectorAll(`#${tabGroup} .tab-content`).forEach(tabContent => {
                        tabContent.classList.add('hidden');
                    });

                    // Show the clicked tab content
                    document.getElementById(tabName).classList.remove('hidden');
                });
            });
        })
        .catch(error => console.error("Error:", error))
        .finally(() => {
        });
    }
    function submitLesson(courseid, lessonid, type) {
        let formData = new FormData();

        // Collect lesson values
        document.querySelectorAll(".sublessionvalues").forEach((item, index) => {
            formData.append(`lessionvalues${index + 1}`, item.value);
        });

        // Collect quiz values
        document.querySelectorAll(".subquizvalues").forEach((item, index) => {
            formData.append(`subquizvalues${index + 1}`, item.value);
        });

        let id = document.getElementById("course_id").value;

        fetch(`{{$_ENV['BCPATH']}}/elearning/addsubtitlelession/${courseid}/${lessonid}/${type}`, {
            method: "POST",
            body: formData
        })
        .then(response => response.text()) // Assuming server returns text data
        .then(data => {
            // document.getElementById("showdetails").value = data;
            showlession(); // Call function to update the UI
        })
        .catch(error => console.error("Error:", error));
    }
    function deletelesson(id, lessonid) {
        Swal.fire({
            title: "{{ __('Do you want to delete?') }}",
            text: "",
            icon: "warning",
            width: 400,
            heightAuto: false,
            padding: "2.5rem",
            showCancelButton: true,
            confirmButtonText: "{{ __('Yes, sure') }}",
            cancelButtonText: "{{ __('Cancel') }}",
            customClass: {
                popup: "bg-white rounded-lg shadow-lg", // Popup style
                title: "text-xl font-semibold text-black", // Title style
                text: "text-sm text-black", // Text style
                confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg", // Confirm button
                cancelButton: "bg-neutral-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg" // Cancel button
            }
        }).then((result) => {
            if (result.isConfirmed) {

                fetch(`{{$_ENV['BCPATH']}}/elearning/deletelession/${id}/${lessonid}`, { method: "GET" })
                    .then(response => response.text())
                    .then(() => {
                        Swal.fire({
                            title: "{{ __('Lesson deleted successfully!') }}",
                            icon: 'success',
                            customClass: {
                                popup: "bg-white rounded-lg shadow-lg",
                                title: "text-xl font-semibold text-black",
                                text: "text-sm text-black",
                                confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                            }
                        }).then(() => {
                            showlession();
                        });

                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            title: "{{ __('Error') }}",
                            text: "{{ __('Something went wrong while deleting') }}",
                            icon: "error",
                            customClass: {
                                popup: "bg-white rounded-lg shadow-lg",
                                title: "text-xl font-semibold text-black",
                                text: "text-sm text-black",
                                confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                            }
                        });
                    });
            } else {
                Swal.fire({
                    title: "{{ __('Cancelled') }}",
                    text: "{{ __('Your record is safe') }}",
                    icon: "error",
                    customClass: {
                        popup: "bg-white rounded-lg shadow-lg",
                        title: "text-xl font-semibold text-black",
                        text: "text-sm text-black",
                        confirmButton: "bg-neutral-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg"
                    }
                });
            }
        });

        return false;
    }
    function addlession(course_id, lession_id, type) {
        // Fetch lesson data
        fetch(`{{$_ENV['BCPATH']}}/elearning/addlession/${course_id}/${lession_id}/${type}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("showleassonform").innerHTML = data;

                // Show modal
                const targetEl = document.getElementById('addlession');
                const options = {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                };

                const modal = new Modal(targetEl, options);
                modal.show();

                // Handle the total level input event
                const totalTitleOne = document.getElementById("totaltitleone");
                if (totalTitleOne) {
                    totalTitleOne.addEventListener("input", function() {
                        let totallevel = this.value.trim();
                        let noLevelInputOne = document.getElementById("nolevelinputone");

                        if (totallevel !== "") {
                            totallevel = parseInt(totallevel, 10);

                            if (totallevel > 0 && totallevel <= 50) {
                                let levelInputTest = "";
                                for (let i = 1; i <= totallevel; i++) {
                                    levelInputTest += `
                                        <div class="mb-5">
                                            <label class="block mb-2 text-sm font-medium text-black dark:text-white">
                                                {{ __('Embed Video Name ${i}') }}
                                            </label>
                                            <input type="text" name="add_embed_name${i}" id="add_embed_name${i}" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                            <div class="submiterrors">
                                                <a class="col error5 text-red-500"></a>
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <label class="block mb-2 text-sm font-medium text-black dark:text-white">
                                                {{ __('Embed Video ${i}') }}
                                            </label>
                                            <input type="url" name="add_embed_video${i}" id="add_embed_video${i}" class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                                        </div>`;
                                }

                                noLevelInputOne.innerHTML = levelInputTest;
                            } else {
                                Swal.fire({
                                    title: totallevel > 50 ? "Level must be below 50" : "Invalid Level",
                                    text: "Please enter a valid number",
                                    icon: "warning",
                                    width: 400,
                                    heightAuto: false,
                                    padding: "2.5rem",
                                    buttonsStyling: false,
                                    customClass: {
                                        popup: "bg-white rounded-lg shadow-lg",
                                        title: "text-xl font-semibold text-black",
                                        text: "text-sm text-black",
                                        confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                                    },
                                    confirmButtonText: "OK"
                                });
                            }
                        } else {
                            noLevelInputOne.innerHTML = "";
                        }
                    });
                }

                // Handle form submission for adding a lesson
                const submitButton = document.getElementById('submitLessonButton');
                if (submitButton) {
                    submitButton.addEventListener('click', function(e) {
                        e.preventDefault();

                        var form = document.getElementById('addprelesson');
                        if (!form) {
                            console.error("Error: Form 'addprelesson' not found!");
                            return;
                        }

                        var formData = new FormData(form);

                        fetch(`{{$_ENV['BCPATH']}}/elearning/insertlession/${course_id}/${lession_id}`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            closeModal('addlession');
                            showlession();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                } else {
                    console.warn("Warning: 'submitLessonButton' not found!");
                }

                // Handle form submission for editing a lesson
                const editSubmitButton = document.getElementById('editsubmitLessonButton');
                if (editSubmitButton) {
                    editSubmitButton.addEventListener('click', function(e) {
                        e.preventDefault();

                        var form = document.getElementById('preeditlesson');
                        if (!form) {
                            console.error("Error: Form 'preeditlesson' not found!");
                            return;
                        }

                        var formData = new FormData(form);

                        fetch(`{{$_ENV['BCPATH']}}/elearning/updatelession/${course_id}/${lession_id}`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            closeModal('addlession');
                            showlession();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                } else {
                    console.warn("Warning: 'editsubmitLessonButton' not found!");
                }
            })
            .catch(error => console.error("Error fetching lesson:", error));
    }


    const closeModal = (modalId) => {
        const targetEl = document.getElementById(modalId);

        // Define optional settings here (e.g., animation, auto hide, etc.)
        const options = {
            backdrop: true,    // Controls whether the modal has a backdrop
            keyboard: true,    // Controls whether the modal can be closed by pressing the ESC key
            focus: true        // Controls whether the modal will be focused when opened
        };

        // Initialize the modal with Flowbite's Modal constructor
        const modalInstance = new Modal(targetEl, options);
        modalInstance.hide();
    };

    function quizlession(course_id, lession_id, type) {

        fetch(`{{$_ENV['BCPATH']}}/elearning/editshowquiz/${course_id}/${lession_id}/${type}`)
            .then(response => response.text())
            .then(data => {
                console.log(data);
                document.getElementById("showeditquizform").innerHTML = data;

                // Use the Fetch API to make the request
                fetch(`{{$_ENV['BCPATH']}}/elearning/getquiz/${course_id}`, {
                    method: "GET",
                })
                .then(response => response.text())  // Assuming the response is text/HTML
                .then(data => {
                    // Update the content of the #contentquiz element with the fetched data
                    document.getElementById("contentquiz").innerHTML = data;

                })
                .catch(error => {
                    console.error("Error:", error);
                });


                // Show modal using Flowbite's Modal constructor
                const targetEl = document.getElementById('editquiz');

                const options = {
                    backdrop: true,  // Ensures the backdrop is displayed
                    keyboard: true,       // Allows closing with ESC key
                    focus: true           // Focuses the modal when opened
                };

                if (targetEl) {
                    const modal = new Modal(targetEl, options);
                    modal.show();
                }

            })
            .catch(error => console.error("Error fetching quiz lesson:", error));
    }

    function submitextra() {
        const id = document.getElementById("course_id")?.value.trim();
        const matrix_id = document.getElementById("matrix_id")?.value;
        const package_id = document.getElementById("package_id")?.value;
        const rank_id = document.getElementById("rank_id")?.value;
        const status = document.getElementById("status")?.value;
        const type = document.getElementById("type")?.value;

        const price = document.getElementById("price")?.value;
        const duration = document.getElementById("duration")?.value;
        const videoduration = document.getElementById("videoduration")?.value;

        // Price validation
        if (parseFloat(price) < 0) {
            document.getElementById("error22").innerHTML = "Price value must be greater than 0";
            return;
        } else {
            document.getElementById("error22").innerHTML = "";
        }

        document.getElementById('subextra').style.display = 'none';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('user_type', type);
        formData.append('matrix_id', matrix_id);
        formData.append('course_status', status);
        formData.append('package_id', package_id);
        formData.append('rank_id', rank_id);
        formData.append('price', price);
        formData.append('duration', duration);
        formData.append('videoduration', videoduration);

        fetch("{{$_ENV['BCPATH']}}/elearning/insertcourcedetails", {
            method: "POST",
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text(); // Read response as text
        })
        .then(text => {
            try {
                return JSON.parse(text); // Try to parse JSON
            } catch (error) {
                console.warn("Warning: Response is not valid JSON:", text);
                return {}; // Return empty object if JSON is invalid
            }
        })
        .then(data => {
            Swal.fire({
                title: "Courses updated successfully!",
                icon: "success",
                customClass: {
                    popup: "bg-white rounded-lg shadow-lg",
                    title: "text-xl font-semibold text-black",
                    text: "text-sm text-black",
                    confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                }
            });

            window.location = '{{$_ENV['BCPATH']}}/elearning/showallelearning';
        })
        .catch(error => console.error("Error:", error));
    }


    document.getElementById('user_type').addEventListener('change', function(event) {
        const state = event.target.checked;

        if (state) {
            document.getElementById("type").value = '1';
            // document.getElementById("plans").classList.add('hidden');
            document.getElementById("showpack_rank").classList.add('hidden');
            document.getElementById("show_matrix").classList.add('hidden');
        } else {
            document.getElementById("type").value = '0';
            // document.getElementById("plans").classList.remove('hidden');
            document.getElementById("showpack_rank").classList.remove('hidden');
            document.getElementById("show_matrix").classList.remove('hidden');
        }
    });


    function submitfaqtotal() {
        var formData = new FormData();
        var id = document.getElementById("course_id").value.trim();

        document.querySelectorAll(".subans").forEach((item, index) => {
            formData.append(`faqanswer${index + 1}`, item.value);
        });

        document.querySelectorAll(".subquest").forEach((item, index) => {
            formData.append(`faqquestion${index + 1}`, item.value);
        });

        fetch(`{{$_ENV['BCPATH']}}/elearning/insertcourseansfaq/${id}`, {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('social-media-tab').disabled = false;
            document.getElementById('add_price_button').disabled = false;
            document.getElementById('duration_button').disabled = false;
            document.getElementById('plan_button').disabled = false;
            document.getElementById('subextra').disabled = false;
            Swal.fire({
                title: "{{ __('FAQ Updated Successfully') }}",
                icon: 'success',
                customClass: {
                    popup: "bg-white rounded-lg shadow-lg",
                    title: "text-xl font-semibold text-black",
                    text: "text-sm text-black",
                    confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                }
            }).then(() => {
                showsublession();
            });
        })
        .catch(error => console.error("Error:", error));
    }

    function showsublession() {
        var id = document.getElementById("course_id").value;

        fetch(`{{$_ENV['BCPATH']}}/elearning/showsublession/${id}`, {
            method: "GET"
        })
        .then(response => response.text())
        .then(data => {
            let container = document.getElementById("cont");

            if (container) {
                container.insertAdjacentHTML("beforeend", data);
            }
            // else {
            //    console.error("Error: Element with ID 'cont' not found.");
            // }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }



    function submitfaq() {
        let faqvalues = document.getElementById("faqvalues").value;
        let errorElement = document.getElementById("error10");

        // Validate input field
        if (!faqvalues) {
            errorElement.innerHTML = "{{ __('This field is required') }}";
            return; // Stop execution if validation fails
        } else {
            errorElement.innerHTML = "";
        }

        // Create FormData object
        let formData = new FormData();
        formData.append("faqvalues", faqvalues);

        let id = document.getElementById("course_id").value.trim();
        let url = `{{$_ENV['BCPATH']}}/elearning/insertcoursefaq/${id}`;

        // Send request using Fetch API
        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => response.text()) // Assuming response is text
        .then(data => {
            document.getElementById("faq_id").value = data;
            document.getElementById("faqvalues").value = ""; // Clear input field
            showlessionfaq(); // Call function after success
        })
        .catch(error => console.error("Error:", error));
    }


    function showlessionfaq() {

        let id = document.getElementById("course_id").value.trim();
        let url = `{{$_ENV['BCPATH']}}/elearning/showcoursefaq/${id}`;

        fetch(url, { method: "GET" })
            .then(response => response.text()) // Assuming response is HTML content
            .then(data => {
                document.getElementById("contentfaq").innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }


    function removefaq(id, fid) {
        Swal.fire({
            title: "{{ __('Do you want to delete?') }}",
            text: "",
            icon: "warning",
            width: 400,
            heightAuto: false,
            padding: "2.5rem",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "{{ __('Yes, sure') }}",
            cancelButtonText: "Cancel",
            customClass: {
                popup: "bg-white rounded-lg shadow-lg",
                title: "text-xl font-semibold text-black",
                text: "text-sm text-black",
                confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg",
                cancelButton: "bg-neutral-200 text-black hover:bg-red-600 font-semibold py-2 px-4 rounded-lg"
            }
        }).then((result) => {
            if (result.isConfirmed) {

                fetch(`{{$_ENV['BCPATH']}}/elearning/delete/${id}/${fid}`, {
                    method: "GET"
                })
                .then(response => response.text())
                .then(() => {
                    Swal.fire({
                        title: "{{ __('FAQ Deleted') }}",
                        icon: "success",
                        customClass: {
                            popup: "bg-white rounded-lg shadow-lg",
                            title: "text-xl font-semibold text-black",
                            text: "text-sm text-black",
                            confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                        }
                    }).then(() => {
                        window.location = `{{$_ENV['BCPATH']}}/elearning/editelearning/${id}`;
                    });
                });
            } else {
                Swal.fire({
                    title: "{{ __('Cancelled') }}",
                    text: "{{ __('Your record is safe') }}",
                    icon: "error",
                    customClass: {
                        popup: "bg-white rounded-lg shadow-lg",
                        title: "text-xl font-semibold text-black",
                        text: "text-sm text-black",
                        confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                    }
                });
            }
        });

        return false;
    }

    function submitannouncement() {
        var announcement = document.getElementById("announcement").value;

        if (announcement !== '') {
            var id = document.getElementById("course_id").value.trim();

            fetch(`{{$_ENV['BCPATH']}}/elearning/submitannouncement/${id}`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ announcement })
            })
            .then(response => response.text())
            .then(() => {
                Swal.fire({
                    title: "{{ __('Announcement updated successfully') }}",
                    icon: 'success',
                    customClass: {
                        popup: "bg-white rounded-lg shadow-lg",
                        title: "text-xl font-semibold text-black",
                        text: "text-sm text-black",
                        confirmButton: "bg-black text-white hover:bg-neutral-800 font-semibold py-2 px-4 rounded-lg"
                    }
                });

                document.getElementById("social-media").classList.add("active");
            })
            .catch(error => console.error("Error:", error));
        }
    }

    function showpackgerank(val) {
        var id = document.getElementById("course_id").value.trim();

        fetch(`{{$_ENV['BCPATH']}}/elearning/showpak_rank/${val}/${id}`)
            .then(response => response.text())
            .then(data => {
                // document.getElementById("plans").classList.remove("hidden");
                document.getElementById("showpack_rank").classList.remove("hidden");
                document.getElementById("showpack_rank").innerHTML = data;
            })
            .catch(error => console.error("Error:", error));
    }



    //const closeAddModalButton = document.getElementById('addlessionclose');
    const closeModalIcon = document.getElementById('addlessioncloseicon');
    //const closeEditModalButton = document.getElementById('editquizclose');
    //const closeEditModalIcon = document.getElementById('editquizcloseicon');
    //closeAddModalButton.addEventListener('click', () => closeModal('addlession'));
    closeModalIcon.addEventListener('click', () => closeModal('addlession'));
    //closeEditModalButton.addEventListener('click', () => closeModal('editquiz'));
    //closeEditModalIcon.addEventListener('click', () => closeModal('editquiz'));

    document.addEventListener("DOMContentLoaded", function() {
        let cropper;
        const image = document.getElementById("editor_image");
        const uploadInput = document.getElementById("inputImage");
        const selectButton = document.getElementById("select_image");
        const cropButton = document.getElementById("crop_image");

        // Open file dialog when "Choose Image" is clicked
        selectButton.addEventListener("click", function() {
            uploadInput.click();
        });

        // Initialize Cropper.js when an image is selected
        uploadInput.addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;

                    // Destroy previous cropper instance if exists
                    if (cropper) cropper.destroy();

                    // Initialize cropper
                    cropper = new Cropper(image, {
                        aspectRatio: 16 / 9,
                        viewMode: 2,
                        autoCropArea: 1,
                        responsive: true
                    });
                };
                reader.readAsDataURL(file);
            }
        });









        document.getElementById("totaltitle").addEventListener("input", function () {
            const subtitleCount =  this.value.trim();
            const accordionContainer = document.getElementById('accordion-container');

            // Clear existing accordions
            accordionContainer.innerHTML = "";
            if (subtitleCount !== "") {

                if (subtitleCount > 0 && subtitleCount <= 50) {
                    for (let i = 1; i <= subtitleCount; i++) {
                        const sectionHTML = `
                            <div id="accordion-item-${i}" class="mb-3">
                                <h2>
                                    <button type="button"
                                        class="flex flex-col items-start w-full p-4 font-medium text-left text-black bg-neutral-100 hover:bg-neutral-200 border border-neutral-200 rounded-lg focus:ring-0 transition-all"
                                        data-accordion-target="#accordion-body-${i}" aria-expanded="false" aria-controls="accordion-body-${i}">
                                        <div class="flex items-center justify-between w-full">
                                            <span>Section ${i}</span>
                                            <svg class="w-5 h-5 shrink-0 transition-transform" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <input placeholder="Section title (required)" id="subtitle${i}" name="subtitle${i}"
                                            class="w-full mt-2 p-2 text-sm text-black dark:text-white bg-white border-2 border-dotted border-neutral-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all subtitlelession" />
                                    </button>
                                </h2>
                                <div id="accordion-body-${i}" class="hidden p-4 border border-t-0 border-neutral-200 rounded-b-xl bg-neutral-50 ">
                                    <!-- Tabs -->
                                    <ul class="hidden flex flex-wrap gap-2 text-sm font-medium text-center" data-tab-group="tabs-${i}">
                                        <li><button class="tab-button bg-neutral-100 p-2 px-4 rounded-lg" data-tab="lesson-${i}">Lesson</button></li>
                                        <li><button class="tab-button bg-green-100 p-2 px-4 rounded-lg" data-tab="quiz-${i}">Quiz</button></li>
                                        <li><button class="tab-button bg-yellow-100 p-2 px-4 rounded-lg hidden" data-tab="assignment-${i}">Assignment</button></li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div id="tabs-${i}">
                                        <div id="lesson-${i}" class="tab-content mt-4 hidden">
                                            <input type="text" placeholder="Enter Lesson title" class="w-full p-3 text-sm text-black dark:text-white bg-white rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all" />
                                        </div>
                                        <div id="quiz-${i}" class="tab-content mt-4 hidden">
                                            <input type="text" placeholder="Enter Quiz title" class="w-full p-3 text-sm text-black dark:text-white bg-white rounded-lg focus:ring-green-500 focus:border-green-500 transition-all" />
                                        </div>
                                        <div id="assignment-${i}" class="tab-content mt-4 hidden">
                                            <input type="text" placeholder="Enter Assignment title" class="w-full p-3 text-sm text-black dark:text-white bg-white rounded-lg focus:ring-yellow-500 focus:border-yellow-500 transition-all" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        accordionContainer.insertAdjacentHTML('beforeend', sectionHTML);


                    }
                }  else if (subtitleCount > 50) {
                    Swal.fire({
                        title: "{{ __('Level must be below 50') }}",
                        text: "{{ __('Please add a valid rank') }}",
                        icon: "warning",
                        width: 400,
                        heightAuto: false,
                        padding: '2.5rem',
                        buttonsStyling: false,
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        title: "{{ __('Invalid Level') }}",
                        text: "{{ __('Please enter a valid number') }}",
                        icon: "warning",
                        width: 400,
                        heightAuto: false,
                        padding: '2.5rem',
                        buttonsStyling: false,
                        confirmButtonText: "OK"
                    });
                }
            }else {
                accordionContainer.innerHTML = '';
            }

            // Initialize accordion functionality
            document.querySelectorAll("[data-accordion-target]").forEach(button => {
                button.addEventListener('click', function () {
                    const target = document.querySelector(this.getAttribute('data-accordion-target'));
                    target.classList.toggle('hidden');
                });
            });

            // Initialize tab switching functionality
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function (e) {
                    // Prevent default form submission or page refresh behavior
                    e.preventDefault();

                    const tabGroup = this.closest('ul').getAttribute('data-tab-group');
                    const tabName = this.getAttribute('data-tab');

                    // Hide all tab content in the current group
                    document.querySelectorAll(`#${tabGroup} .tab-content`).forEach(tabContent => {
                        tabContent.classList.add('hidden');
                    });

                    // Show the clicked tab content
                    document.getElementById(tabName).classList.remove('hidden');
                });
            });
        });



        // Crop and update the preview image
        cropButton.addEventListener("click", function() {
            if (cropper) {
                const croppedCanvas = cropper.getCroppedCanvas();
                if (croppedCanvas) {
                    const croppedImage = croppedCanvas.toDataURL("image/png");

                    // Update the main preview image
                    document.getElementById("banner").src = croppedImage;
                    document.getElementById('image_crop_file_hidd').value  =  croppedImage;
                    // Hide modal after cropping
                    document.getElementById("default-modal").classList.add("hidden");
                }
            }
        });
    });


    // Add Lesson Modal Scripts

    function changeLessonTab(value) {
        const lessonSettings = document.getElementById("lessonsettings");
        const content = document.getElementById("Content");

        if (value === 2) {
            lessonSettings.classList.remove("hidden");
            content.classList.add("hidden");
        } else if (value === 1) {
            lessonSettings.classList.add("hidden");
            content.classList.remove("hidden");
        }
    }
    function changeQuizTab(value) {
        const editLessonQuiz = document.getElementById("editlesson-quiz");
        const quizLessonSettings = document.getElementById("quizlessonsettings");
        const quizSettings = document.getElementById("quizsettings");
        if (value === 1) {
            editLessonQuiz.classList.remove("hidden");
            quizLessonSettings.classList.add("hidden");
            quizSettings.classList.add("hidden");
        } else if (value === 2) {
            editLessonQuiz.classList.add("hidden");
            quizLessonSettings.classList.remove("hidden");
            quizSettings.classList.add("hidden");
        } else if (value === 3) {
            editLessonQuiz.classList.add("hidden");
            quizLessonSettings.classList.add("hidden");
            quizSettings.classList.remove("hidden");
        }

    }

    function showvideos(val) {
        document.getElementById("show_dir_video").classList.toggle('hidden', val !== "1");
        document.getElementById("show_add_video").classList.toggle('hidden', val !== "2");
        document.getElementById("show_embed_video").classList.toggle('hidden', val !== "3");
    }

    function previewImageContent(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_containercontent');
        const imagePreview = document.getElementById('image_previewcontent');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
    }
    function previewImage_add_new(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_container_add_video');
        const imagePreview = document.getElementById('image_preview_add_video');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
    }
    function previewImage_document(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_container_document');
        const imagePreview = document.getElementById('image_preview_document');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.data = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.data = '';
            previewContainer.classList.add('hidden');
        }
    }
    function previewImage_audio(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_container_audio');
        const imagePreview = document.getElementById('image_preview_audio');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
    }
    function previewImage_image(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_container_image');
        const imagePreview = document.getElementById('image_preview_image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
    }

    function previewImage_quiz(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview_container_quiz');
        const imagePreview = document.getElementById('image_preview_quiz');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
    }
    function quizApp() {
        return {
            currentQuestion: '',
            questions: [],
            addQuestion() {
                if (this.currentQuestion.trim() !== '') {
                    submitquiz();
                    const questionIndex = this.questions.length + 1;
                    this.questions.push({ name: `quizanswer${questionIndex}`,
                    text: this.currentQuestion, answer: '' });
                    this.currentQuestion = ''; // Clear input
                }
            },
            removeQuestion(index) {
                this.questions.splice(index, 1);
            }
        }
    }


    function submitquiz() {
        var id = document.getElementById("course_id").value.trim();
        var quzvalues = document.getElementById("quzvalues").value;
        var errorElement = document.getElementById("error10");

        if (quzvalues === "") {
            errorElement.innerHTML = "{{ __('REQUIRED_ERROR') }}";
        } else {
            errorElement.innerHTML = "";
        }

        var quzvaluesError = errorElement.innerHTML;
        if (quzvaluesError === '') {
            var formData = new FormData();
            formData.append("quzvalues", quzvalues);

            fetch("{{$_ENV['BCPATH']}}/elearning/insertquiz/" + id.trim(), {
                method: "POST",
                body: formData,
            })
            .then(response => response.text()) // Assuming the response is plain text
            .then(data => {
                document.getElementById("quiz_id").value = data;
                document.getElementById("quzvalues").value = "";
                showquizcount();
            })
            .catch(error => console.error("Error:", error));
        }
    }


    function showquizcount() {
        const id = document.getElementById("course_id").value.trim(); // Assuming course_id exists


        fetch(`{{$_ENV['BCPATH']}}/elearning/showaddquiz/${id}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("contentquiz").innerHTML = data;
            })
            .catch(error => console.error("Error fetching quiz data:", error));
    }

    function submitQuizForm(){


         // Get the form element
        var form = document.getElementById('prequizlesson');
        var formData = new FormData(form);

        var id = document.getElementById('course_id_quiz').value;
        var lessid = document.getElementById('course_quiz_lesson_id').value;

        fetch(`{{$_ENV['BCPATH']}}/elearning/updatequizlession/${id}/${lessid}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Assuming the response is text/HTML
        .then(data => {
            // Hide modal by adding the 'hidden' class
            document.getElementById('editquiz').classList.add('hidden');

            var modal = document.getElementById('editquiz');
            modal.classList.add('hidden');  // Add the 'hidden' class to hide the modal

            // Ensure that the backdrop is also hidden
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.classList.add('hidden');
            }
            closeModal('editquiz')
            // Refresh lessons
            showlession();

            // Hide preloader
        })
        .catch(error => {
            console.error('Error updating quiz lesson:', error);
        });
    }
</script>
@endsection
