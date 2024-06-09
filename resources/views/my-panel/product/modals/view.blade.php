@push('scripts')
    <script>
        const readProductModal = $("#readProductModal");
        //on preview-data button click
        $(document).on('click', '.preview-data', function() {
            //show modal
            // readProductModal.removeClass('hidden');
            // readProductModal.addClass('flex');
            window
                .FlowbiteInstances
                .getInstance('Modal', 'readProductModal').show();
            readProductModal.find(".relative .loading").show();
            $('#readProductModal').find('#name').text('Loading...');
            $('#readProductModal').find('#price').text('Rp Loading...');
            $('#readProductModal').find('#description').text('Loading...');
            $('#readProductModal').find('#image').attr('src', '');
            //get id
            var id = $(this).data('id');
            //get data
            $.ajax({
                url: '{{ route('api.my-panel.product.show', 0) }}'.replace('0', id),
                method: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + '{{ session('token') }}');
                },
                success: function(response) {
                    //fill modal with data
                    $('#readProductModal').find('#name').text(response.data.product_name);
                    $('#readProductModal').find('#price').text('Rp ' + response.data.product_price);
                    $('#readProductModal').find('#description').text(response.data.product_description);
                    $('#readProductModal').find('#image').attr('src', '/storage/' + response.data
                        .product_image);

                    $('#readProductModal').find('.edit-data').attr('data-id', response.data.id);
                    $('#readProductModal').find('.delete-data').attr('data-id', response.data.id);
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
                    //hide loading
                    readProductModal.find(".relative .loading").hide();
                }
            });
        });
    </script>
@endpush


<!-- Read modal -->
<div id="readProductModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <div
                class="loading absolute m-auto top-0 bottom-0 left-0 right-0  flex justify-center items-center bg-black bg-opacity-50">
                <div role="status">
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
            </div>
            <!-- Modal header -->
            <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                    <h3 class="font-semibold " id="name">Loading...</h3>
                    <img src="" alt="" id="image">
                    <p class="font-bold" id="price">Rp Loading...</p>
                </div>
                <div>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-target="readProductModal"
                        data-modal-toggle="readProductModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
            </div>
            <dl>
                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Details</dt>
                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400" id="description">
                    Loading...
                </dd>

            </dl>
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <button type="button" data-modal-toggle="readProductModal" data-id="0"
                        class="edit-data text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <span class="icon-[bxs--edit] w-5 h-5 mr-1.5 -ml-1"></span>
                        Edit
                    </button>
                    <button type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Preview</button>
                </div>
                <button type="button" data-modal-toggle="readProductModal" data-id="0"
                    class="delete-data inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                    <span class="icon-[ic--baseline-delete] w-5 h-5 mr-1.5 -ml-1"></span>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
