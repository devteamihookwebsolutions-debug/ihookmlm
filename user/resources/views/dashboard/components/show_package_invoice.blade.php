
@extends('user::components.common.main')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2  dark:text-white">Invoice</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">

                    <li class="inline-flex items-center">
                         <a href="/user/dashboard" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            Home
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
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">Invoice</span>
                        </div>
                    </li>
                  

                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3 space-y-5">

   <!--Success and Failure Messge-->
    @include('components.common.info_message')
    <!--Success and Failure Messge-->
        <!--Row-1-->
            <!-- card -->
            <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 "
>

                    <button type="button" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-black dark:text-white focus:outline-none bg-white rounded-lg border border-neutral-200 hover:bg-neutral-100  focus:z-10 focus:ring-4 focus:ring-neutral-100 dark:focus:ring-neutral-700 dark:bg-neutral-900  dark:hover:text-white dark:hover:bg-neutral-700" id="downloadBtn"  >Download Invoice</button>

                            <!-- Left side: Form content -->
                        <div class="p-0 md:p-4 rounded-lg overflow-x-auto md:overflow-x-visible mt-4 md:mt-0 border md:border-0">
                            <div class="col-span-1 md:col-span-1 lg:col-span-1 mb-5" bis_skin_checked="1" id="invoice">
                               
                              {!!$invoiceselect!!}

                            </div>
                        </div>    

                </div>

                <!-- card -->

    </div>
</main>
<div id="hidden-clone-container" class="absolute -left-[9999px] -top-[9999px] opacity-0 pointer-events-none"></div>

<!-- Include html2canvas and jsPDF -->
<!-- Include dom-to-image-more for rendering the element into an image -->
<script src="/public/assets/js/dom-to-image-more.min.js"></script>
<script src="/public/assets/js/jspdf.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const downloadBtn = document.getElementById('downloadBtn');
  
    if (!downloadBtn) {
      console.error('Download button not found!');
      return;
    }
  
    downloadBtn.addEventListener('click', async () => {
  
      const invoiceElement = document.getElementById('invoice');
      if (!invoiceElement) {
        console.log('Invoice element not found!');
        return;
      }
  
      // // Replace unsupported color functions (like "oklch")
      // const replaceUnsupportedColors = (element) => {
      //   const style = window.getComputedStyle(element);
      //   const colorProperties = ['color', 'background-color', 'border-color'];
  
      //   colorProperties.forEach(property => {
      //     const color = style.getPropertyValue(property);
      //     if (color.includes('oklch')) {
      //       const replacedColor = color.replace(/oklch\([^)]+\)/, 'rgb(255, 0, 0)');
      //       element.style[property] = replacedColor;
      //     }
      //   });
  
      //   Array.from(element.children).forEach(replaceUnsupportedColors);
      // };
  
      // replaceUnsupportedColors(invoiceElement);
  
      // Clone the invoice content into a hidden container for rendering
      const hiddenContainer = document.getElementById('hidden-clone-container');
      hiddenContainer.innerHTML = ''; // Clear previous content
      const clone = invoiceElement.cloneNode(true);
      hiddenContainer.appendChild(clone);
      

      try {
        // Use dom-to-image-more to convert the HTML element into an image
        domtoimage.toPng(clone)
          .then(function (dataUrl) {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'pt', 'a4');
  
            const imgWidth = pdf.internal.pageSize.getWidth();
            const imgHeight = (clone.offsetHeight * imgWidth) / clone.offsetWidth;
  
            // Add the generated image to the PDF
            pdf.addImage(dataUrl, 'PNG', 0, 0, imgWidth, imgHeight);
  
            // Save the PDF
            pdf.save('invoice.pdf');
          })
          .catch(function (error) {
            console.error('Error generating image:', error);
            alert('Failed to generate PDF due to style compatibility issues.');
          });
      } catch (error) {
        console.error('Error during cloning or PDF generation:', error);
        alert('Failed to generate PDF.');
      }
    
    });
});
</script>
