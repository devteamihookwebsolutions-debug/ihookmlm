
@extends('admin::components.common.main')

@section('content')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                         <a href="admin/dashboard" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __('Marketing') }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <a href="admin/newsgroup"
                            class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Newsletter Template') }}</span>
                        </div>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->

        <main class="flex-grow">
            <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
       @include('components.common.info_message')
                <!--Row-1-->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-5 mb-5">
                    <!-- Example cards -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
                      <div class="w-full mx-auto p-4">

                        <div class="flex justify-end items-center mb-5" >
                            <ul class="flex space-x-2">
                                <li>
                                    <a  aria-label="link" href="{{route('addnewstemplate')}}" class="px-4 py-2 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105" >
                                        <span>{{ __('Add') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <!-- Data Table -->
                        <div class="overflow-x-auto pt-5">

                            <div class="relative overflow-x-auto">
                            <table id="data-table" class="w-full text-sm text-left rtl:text-right text-black dark:text-white">
                            <thead class="text-xs text-black uppercase bg-neutral-50 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
                                <tr>
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">{{ __('Name') }}</th>
                                    <th class="px-6 py-3">{{ __('Status') }}</th>
                                    <th class="px-6 py-3">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse ($records as $index => $row)
                              @php
                                $filename = $row->randomid;
                              @endphp
                                <tr>
                                    <td class="px-6 py-3">{{ $index + 1 }}</td>

                                    <td class="px-6 py-3">
                                        {{ $row->category_templates_name }}
                                    </td>

                                    <td class="px-6 py-3">
                                        @if ($row->category_templates_status == 1)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ __('Active') }}
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                {{ __('Suspend') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-3 flex">
                                        {{-- Edit --}}
                                        <a href="{{ route('newslettertemplate.edit', $row->category_templates_id) }}">
                                            ✏️
                                        </a>
                                        {{-- Delete --}}
                                        <a href="javascript:void(0);" onclick="deletenewstemplate('{{ $row->randomid }}')">
                                            🗑️
                                        </a>

                                        {{-- Document --}}
                                        <a href="{{ route('templatedocumentsnews.docu', [
                                                'filename' => $filename,
                                                'id' => $row->category_templates_id
                                            ]) }}"
                                        target="_blank">
                                            📄
                                        </a>
                                        {{-- Preview --}}
                                        <a href="javascript:void(0);" onclick="shownewsbuilderpagepreview('{{ $filename }}')">
                                            👁️
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-3 text-center text-gray-500">
                                        {{ __('No records found') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                            </table>
                            </div>

                        </div>
                    </div>

                    </div>

                </div>




            </div>

        </main>


<!-- Content area end-->

<!-- Footer -->

@include('components.common.footer_scripts')

<script>

function deletenewstemplate(val) {
    Swal.fire({
        title: 'Are you sure you want to delete this item?',
        icon: 'warning',
        width: 400,
        heightAuto: false,
        padding: '2.5rem',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg',
            cancelButton: 'bg-neutral-300 hover:bg-neutral-400 text-black font-medium py-2 px-4 rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {

            fetch("{{ route('newslettertemplate.delete', ':id') }}".replace(':id', val), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire(
                        'Deleted!',
                        'The template has been deleted successfully.',
                        'success'
                    );
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error();
                }
            })
            .catch(() => {
                Swal.fire(
                    'Error',
                    'There was an issue deleting the template.',
                    'error'
                );
            });

        } else {
            Swal.fire(
                'Cancelled',
                'The template was not deleted.',
                'info'
            );
        }
    });
}




function shownewsbuilderpagepreview(id) {
    window.open("/admin/newsletter/preview/" + id, "_blank");
}
</script>



@include('components.common.datatable_script')

@endsection
