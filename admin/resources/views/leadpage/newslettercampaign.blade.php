@extends('admin::components.common.main')

@section('content')
       <!-- Breadcrumb -->
                        <div class="flex mb-4" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="admint-board.html"
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
                                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Marketing</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m10 16 4-4-4-4" />
                                        </svg>
                                        <span
                                            class="text-xs font-medium text-gray-500 dark:text-gray-400">Campaign</span>
                                    </div>
                                </li>
                            </ol>
                        </div>



                        <!-- Main content -->
                        <main class="flex-grow">
                            <!-- Card -->
                                    @include('components.common.info_message')
                            <div
                                class="bg-white rounded-lg shadow-sm p-5 mb-5 dark:border-gray-800 dark:bg-gray-900 border">
                                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10 mb-5">

                                    <!--form-->
                                    <div class="customer-form">
                                        <form name="newlist" method="POST" action="{{ route('newsletter.sendnews') }}" class="mb-5 pt-4" novalidate>
                                                @csrf
                                            <input type="hidden" name="cate_temp_id" id="cate_temp_id" value="">

                                            <div class="col-span-2">
                                                   {!! $show_newsletter !!}
                                                <div class="hidden flex items-center space-x-4" id="showimagenews">

                                                    <label for=""
                                                        class="block mb-3 text-xs text-gray-600 dark:text-gray-300">News
                                                        Content
                                                    </label>
                                                    <div class="w-full lg:w-2/3 md:w-3/4 sm:w-full" id="showimage">
                                                    </div>
                                                </div>

                                            </div>
                                            <input type="hidden" name="tets[][email]" value="4">

                                            <div class="flex justify-end p-4">
                                                <div class="form-submit">
                                                    <button type="submit" name="submit" id="submit"
                                                        class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-xs px-4 py-2 dark:bg-blue-500 dark:hover:bg-blue-600">Submit</button>
                                                    <button aria-label="link" href="javascript:void(0);"
                                                        onclick="window.history.back();"><button type="button"
                                                            class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-xs px-4 py-2 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">Cancel</button></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="flex flex-col">
                                        <!--image-space-->
                                        <img src=""
                                            alt="comp-img" class="w-full sticky top-0 overflow-hidden">
                                        <!--image-space-->
                                    </div>
                                </div>
                            </div>
                        </main>



        
    <script type="text/javascript">
       
    const FORM_CONFIG = {
        REQUIRED_PATTERNS: {
          email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
          phone: /^\d{10}$/,
          // Add more fields as needed
        },
      };
      
      class FormHandler {
        constructor() {
          this.initializeElements();
          this.attachEventListeners();
        }
      
        initializeElements() {
          this.elements = {
            form: document.querySelector('#newlist') // Ensure this selects the actual form
        };

        }
      
        attachEventListeners() {
          this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));
      
          // Real-time validation
          document.querySelectorAll('input[required], textarea[required], select[required]').forEach((input) => {
            input.addEventListener('input', () => this.validateInput(input));
          });
        }
      
        validateInput(input) {
          const value = input.value.trim();
          const pattern = FORM_CONFIG.REQUIRED_PATTERNS[input.name];
          const errorElement = document.getElementById(input.getAttribute('aria-describedby'));
      
          let isValid = true;
      
          if (!value && input.hasAttribute('required')) {
            isValid = false;
            this.showError(input, errorElement, 'This field is required.');
          } else if (pattern && !pattern.test(value)) {
            isValid = false;
            this.showError(input, errorElement);
          } else {
            this.clearError(input, errorElement);
          }
      
          return isValid;
        }
      
        showError(input, errorElement, message) {
          input.classList.add('border-red-500');
          if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
          }
        }
      
      
        clearError(input, errorElement) {
          input.classList.remove('border-red-500');
          if (errorElement) {
            errorElement.classList.add('hidden');
          }
        }
      
      
        handleSubmit(e) {
          e.preventDefault();
          const inputs = Array.from(this.elements.form.querySelectorAll('input[required], select[required]'));
          const allValid = inputs.every((input) => this.validateInput(input));
      
          if (allValid) {     
            HTMLFormElement.prototype.submit.call(this.elements.form);

          } else {
            console.error('Form validation failed.');
          }
        }
      }
      
      document.addEventListener('DOMContentLoaded', () => {
        new FormHandler();
      });

        function selectUsers(id) {
            fetch("{{ route('newsletter.userlists') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: new URLSearchParams({
                    usertype: id
                })
            })
            .then(response => response.text())
            .then(resp => {
                document.getElementById('showuseremail').innerHTML = resp;
            })
            .catch(error => console.error('Error:', error));
        }
        const BCPATH = '/admin';
        function showPay(val) {
            document.getElementById('cate_temp_id').value = val;

            const url = `${BCPATH}/newsletter/selecttemplate/${val}`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('showimagenews').style.display = 'block';

                const iframe = document.getElementById('templateFrame');
                const doc = iframe.contentDocument || iframe.contentWindow.document;

                doc.open();
                doc.write(html);
                doc.close();
            })
            .catch(error => console.error('Error:', error));
        }


            function creatmaillist(){
                var totalgift = document.getElementById("totallevel").value;
                if(totalgift!=""){
                        var levelinput='';
                        for(var i=1;i<=totalgift;i++){
                            levelinput+='<input aria-label="label" type="email" required class="form-control m-input" id="user_list'+i+'" name="user_list[]"><br>';
                        }
                        $('#nolevelinputgift').html(levelinput);
                }
            }
                
           function deletemaillist(){
                var totalgift1 = document.getElementById("totallevel").value;
                if(totalgift1!=""){
                        var levelinput1='';
                        for(var j=1;j<=totalgift1;j++){
                            console.log(j);
                            $('#user_list' + j).hide();
                        }
                }
            }
    </script>
@endsection