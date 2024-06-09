 @push('scripts')
     <script>
         
         //listen to .form-api submit, then send ajax request
         $('.form-api').on('submit', function(e) {
             e.preventDefault();
             //get button
             var button = $(this).find('button[type="submit"]');
             //hide default text and show loading
             button.find('.default').hide();
             button.find('.loading').show();
             //disable button
             button.prop('disabled', true);
             var form = $(this);
             var url = form.attr('action');
             var method = form.attr('method');
             var data = new FormData(form[0]);
             $.ajax({
                 url: url,
                 method: method,
                 data: data,
                 processData: false,
                 contentType: false,
                 beforeSend: function(xhr) {
                     xhr.setRequestHeader('Authorization', 'Bearer ' + '{{ session('token') }}');
                 },
                 success: function(response) {

                     if (response.status == 'success') {

                         location.reload();
                     }
                     if (response.message != undefined) {
                         alert(response.message);
                     }
                 },
                 error: function(xhr, status, error) {
                     if (xhr.response != undefined && xhr.response.message != undefined) {
                         alert(xhr.response.message);
                     } else {
                         alert(error);
                     }
                     console.log(xhr.responseText);
                 },
                 complete: function() {
                     //hide loading and show default text
                     button.find('.default').show();
                     button.find('.loading').hide();
                     //enable button
                     button.prop('disabled', false);
                 }
             });
         });
     </script>
 @endpush
 <!-- Create modal -->
 <div id="createProductModal" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative p-4 w-full max-w-2xl max-h-full">
         <!-- Modal content -->
         <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
             <!-- Modal header -->
             <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                 <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Product</h3>
                 <button type="button"
                     class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                     data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                     <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd"
                             d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                             clip-rule="evenodd" />
                     </svg>
                     <span class="sr-only">Close modal</span>
                 </button>
             </div>
             <!-- Modal body -->
             <form action="{{ route('api.my-panel.product.store') }}" method="POST" class="form-api">
                 <div class="grid gap-4 mb-4 sm:grid-cols-2">
                     <div>
                         <label for="product_name"
                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                         <input type="text" name="product_name" id="product_name"
                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Type product name" required="">
                     </div>
                     <div>
                         <label for="product_price"
                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                         <input type="number" name="product_price" id="product_price"
                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Rp 1000" required="">
                     </div>
                     <div>

                         <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                             for="product_image">Image</label>
                         <input
                             class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                             id="product_image" type="file" name="product_image">

                     </div>


                     <div class="sm:col-span-2"><label for="product_description"
                             class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                         <textarea id="product_description" rows="4"
                             class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             placeholder="Write product description here" name="product_description"></textarea>
                     </div>
                 </div>
                 <button type="submit"
                     class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">

                     <span class="icon-[ph--plus-bold] mr-1 -ml-1 w-6 h-6 default"></span>
                     <div role="status" class="loading" style="display: none;">
                         <svg aria-hidden="true"
                             class="mr-1 -ml-1 w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                             viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path
                                 d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                 fill="currentColor" />
                             <path
                                 d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                 fill="currentFill" />
                         </svg>
                         <span class="sr-only">Loading...</span>
                     </div>
                     Add new product
                 </button>
             </form>
         </div>
     </div>
 </div>
