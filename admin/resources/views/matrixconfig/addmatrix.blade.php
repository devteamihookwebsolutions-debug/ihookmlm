@extends('admin::components.common.main')

@section('content')
 <!-- Main Content Area -->
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
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Plans</span>
                  </div>
                </li>
                <li aria-current="page">
                  <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                      height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                    </svg>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Add Matrix</span>
                  </div>
                </li>
              </ol>
            </div>

<!-- STEP CONTENT -->
<div class="flex-1 " style="bottom: 20px;">
    @if($step == 1)
        {{-- STEP 1: Plan Name --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-4 border dark:border-gray-700 dark:bg-gray-900">
                <ul class="space-y-3 text-xs">
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-900 dark:bg-blue-500 text-white"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-white text-gray-900 font-bold mr-3">1</span><span class="font-medium">Plan Name</span></div></li>
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-300 text-gray-600"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-gray-700 font-bold mr-3">2</span><span class="font-medium">Plan Type</span></div></li>
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-gray-700 font-bold mr-3">3</span><span class="font-medium">Status</span></div></li>
                </ul>
            </div>
            <div class="md:col-span-3 bg-white rounded-lg border shadow-md p-6 dark:bg-gray-900 dark:border-gray-700">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4">Plan Name</h2>
                @if ($errors->any())
                    <div class="bg-red-100 text-xs border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form action="{{ route('matrix.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="step" value="1">
                    <div>
                        <label for="matrix_name" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Plan Name</label>
                        <input type="text" id="matrix_name" name="matrix_name" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" placeholder="Enter Plan Name" required value="{{ old('matrix_name', $matrixData['matrix_name'] ?? '') }}">
                    </div><br>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">Continue</button>
                    </div>
                </form>
            </div>
        </div>

    @elseif($step == 2)
        {{-- STEP 2: Plan Type --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-4 border dark:border-gray-700 dark:bg-gray-900 h-fit">
                <ul class="space-y-3 text-xs">
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-300 text-gray-600"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-gray-700 font-bold mr-3">1</span><span class="font-medium">Plan Name</span></div></li>
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-900 dark:bg-blue-500 text-white"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-white text-gray-900 font-bold mr-3">2</span><span class="font-medium">Plan Type</span></div></li>
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-300 text-gray-600"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-gray-700 font-bold mr-3">3</span><span class="font-medium">Status</span></div></li>
                </ul>
            </div>
            <div class="md:col-span-3 bg-white rounded-lg border shadow-md p-6 dark:bg-gray-900 dark:border-gray-700">
                @if ($errors->any())
                    <div class="text-xs bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form id="matrixForm" action="{{ route('matrix.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="step" value="2">
                    <div class="mb-6">
                        <label for="matrix_name" class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Plan Name</label>
                        <input type="text" id="matrix_name" name="matrix_name" value="{{ $matrixData['matrix_name'] ?? '' }}"
                            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300" readonly>
                    </div>
                    <h3 class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Choose Plan Type</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="matrix-options">
                        @foreach ($matrixTypes as $type)
                            @php
                                $imagePaths = [
                                    'Binary Plan' => 'assets/img/plans/binary-plan.png',
                                    'Forced Plan' => 'assets/img/plans/forced-plan.png',
                                    'Unilevel Plan' => 'assets/img/plans/unilevel-plan.png',
                                    'Linear Plan' => 'assets/img/plans/linear-plan.png',
                                    'X-up Plan' => 'assets/img/plans/xup-plan.png',
                                    'Stair Step Plan' => 'assets/img/plans/stair-pla.png',
                                ];
                                $imagePath = $imagePaths[$type->matrix_type_name] ?? '/assets/img/Plans/default.png';
                            @endphp
                            <label class="plan-card p-5 bg-white rounded-lg shadow-md cursor-pointer border border-gray-200 hover:border-gray-700 transition dark:bg-gray-300 dark:hover:border-blue-500">
                                <input type="radio" name="matrix_type_id" value="{{ $type->matrix_type_id }}" class="hidden"
                                    {{ old('matrix_type_id', $matrixData['matrix_type_id'] ?? '') == $type->matrix_type_id ? 'checked' : '' }}>
                                <div class="flex justify-center">
                                    <figure class="max-w-lg">
                                        <img class="h-auto max-w-full rounded-lg" src="{{ asset($imagePath) }}" alt="{{ $type->matrix_type_name }} image">
                                        <figcaption class="mt-2 text-sm text-center text-gray-500">{{ $type->matrix_type_name }} Image</figcaption>
                                    </figure>
                                </div>
                                <h4 class="text-md font-semibold text-gray-800 mb-3 text-center">{{ $type->matrix_type_name }}</h4>
                                <center><span class="choose-btn px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">Choose</span></center>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('admin.plans.create', 1) }}"><button type="button" class="px-4 py-2 rounded-lg text-xs text-white rounded-lg bg-red-600 hover:bg-red-700">Back</button></a>
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">Continue</button>
                    </div>
                </form>
            </div>
        </div>

    @elseif($step == 3)
        {{-- STEP 3: Status --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-4 border dark:border-gray-700 dark:bg-gray-900 h-fit">
                <ul class="space-y-3 text-xs">
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-300 text-gray-600"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-gray-700 font-bold mr-3">1</span><span class="font-medium">Plan Name</span></div></li>
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-gray-300 text-gray-600"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-300 text-gray-700 font-bold mr-3">2</span><span class="font-medium">Plan Type</span></div></li>
                    <li><div class="flex items-center p-3 rounded-lg bg-gray-900 dark:bg-blue-500 text-white"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-white text-gray-900 font-bold mr-3">3</span><span class="font-medium">Status</span></div></li>
                </ul>
            </div>
            <div class="md:col-span-3 bg-white rounded-lg border shadow-md p-6 dark:bg-gray-900 dark:border-gray-700">
                <h3 class="block mb-3 text-xs text-gray-600 dark:text-gray-300">Status</h3>
                @if ($errors->any())
                    <div class="text-xs bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form action="{{ route('matrix.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="step" value="3">
                    <input type="hidden" name="matrix_name" value="{{ $matrixData['matrix_name'] ?? '' }}">
                    <input type="hidden" name="matrix_type_id" value="{{ $matrixData['matrix_type_id'] ?? '' }}">
                    <div class="mb-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1" class="sr-only peer"
                                {{ old('status', $matrixData['matrix_status'] ?? '') === '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-xs font-medium text-gray-600 dark:text-gray-300">Status</span>
                        </label>
                    </div>
                    <div class="flex justify-between">
                        <a href="{{ route('admin.plans.create', 2) }}"><button type="button" class="px-4 py-2 rounded-lg text-xs text-white rounded-lg bg-red-600 hover:bg-red-700">Back</button></a>
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

{{-- Plan Selection Script --}}
@if($step == 2)
<script>
    const cards = document.querySelectorAll('.plan-card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            cards.forEach(c => c.classList.remove('border-blue-500', 'ring-2', 'ring-blue-200', 'bg-blue-100/70'));
            card.classList.add('border-blue-500', 'ring-2', 'ring-blue-200', 'bg-blue-100/70');
            card.querySelector('input').checked = true;
        });
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
@endsection
