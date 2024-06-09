@extends('my-panel.layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css">
    <style>
        .dt-search {
            display: none;
        }

        .pagination {
            justify-items: end;
            justify-content: end;
            align-items: end;
            display: flex;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>
    <script>
        const options = {
            placement: 'bottom-right',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {
                console.log('modal is hidden');
            },
            onShow: () => {
                console.log('modal is shown');
            },
            onToggle: () => {
                console.log('modal has been toggled');
            },
        };




        const myTable = new DataTable('#example', {
            "serverSide": true,
            "columns": [{
                    "data": "product_name",
                    "name": "product_name",
                    "searchable": true
                },
                {
                    "data": "product_image",
                    "name": "product_image",
                    "searchable": true,
                    "mRender": function(data, type, row) {
                        return `<img src="/storage/${row.product_image}" class=" h-24 rounded-lg" alt="${row.product_name}">`;
                    }
                },
                {
                    "data": "product_description",
                    "name": "product_description",
                    "searchable": true
                },
                {
                    "data": "product_price",
                    "name": "product_price",
                    "searchable": true
                },
                {
                    "data": "id",
                    "searchable": false,
                    "orderable": false,
                    "mRender": function(data, type, row) {
                        return `
                                <button id="${row.id}-dropdown-button"
                                    data-target="${row.id}-dropdown" old-data-dropdown-toggle="${row.id}-dropdown"
                                    class="button-dropdown inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                    type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div id="${row.id}-dropdown"
                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm" aria-labelledby="${row.id}-dropdown-button">
                                        <li>
                                            <button type="button" data-id="${row.id}" old-data-modal-target="updateProductModal"
                                                old-data-modal-toggle="updateProductModal"
                                                class="edit-data flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <span class="icon-[bxs--edit] w-4 h-4 mr-2"></span>
                                                Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" data-id="${row.id}" old-data-modal-target="readProductModal"
                                                old-data-modal-toggle="readProductModal"
                                                class="preview-data flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <span class="icon-[ph--eye-fill] w-4 h-4 mr-2"></span>
                                                Preview
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" data-id="${row.id}" old-data-modal-target="deleteModal"
                                                old-data-modal-toggle="deleteModal"
                                                class="delete-data flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                <span class="icon-[ic--baseline-delete] w-4 h-4 mr-2"></span>
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            `;

                    }
                }

            ],
            "ajax": {
                "url": '{{ route('api.my-panel.product.index') }}',
                "type": 'GET',

                "beforeSend": function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + '{{ session('token') }}');
                },

            },
            "drawCallback": function(settings) {
                console.log(settings.json);
                //do whatever   


                const $readProductModal = document.getElementById('readProductModal');
                if ($readProductModal) {
                    const readProductModal = new Modal($readProductModal, options, {
                        id: "readProductModal",
                        override: true
                    });
                }

                const $updateProductModal = document.getElementById('updateProductModal');
                if ($updateProductModal) {
                    const updateProductModal = new Modal($updateProductModal, options, {
                        id: "updateProductModal",
                        override: true
                    });
                }

                const $deleteModal = document.getElementById('deleteModal');
                if ($deleteModal) {
                    const deleteModal = new Modal($deleteModal, options, {
                        id: "deleteModal",
                        override: true
                    });
                }

                //re init all .button-dropdown
                const dropdowns = document.querySelectorAll('.button-dropdown');


                dropdowns.forEach(dropdown => {
                    // options with default values
                    const dropDownOptions = {
                        placement: 'bottom',
                        triggerType: 'click',
                        offsetSkidding: 0,
                        offsetDistance: 10,
                        delay: 300,
                        ignoreClickOutsideClass: false,
                        onHide: () => {
                            console.log('dropdown has been hidden');
                        },
                        onShow: () => {
                            console.log('dropdown has been shown');
                        },
                        onToggle: () => {
                            console.log('dropdown has been toggled');
                        },
                    };
                    const dataTarget = dropdown.getAttribute('data-target');
                    const $targetEl = document.getElementById(dataTarget);
                    const $triggerEl = document.getElementById(dataTarget + '-button');
                    console.log($triggerEl);
                    if ($triggerEl) {
                        const dropdownModal = new Dropdown($targetEl, $triggerEl, dropDownOptions, {
                            id: dataTarget,
                            override: true
                        });
                    }
                });



            },
        });

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, timeout);
            };
        }

        function customSearch(e) {
            console.log(e.target.value);
            myTable.search(e.target.value).draw();
        }

        //simple-search
        $('#simple-search').on('input', debounce(customSearch));
    </script>
@endpush

@push('modals')
    @include('my-panel.product.modals.add')
    @include('my-panel.product.modals.edit')
    @include('my-panel.product.modals.view')
    @include('my-panel.product.modals.delete')
@endpush

@section('content')
    <!-- Start block -->
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
        <div class="mx-auto w-full px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal"
                            data-modal-toggle="createProductModal"
                            class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add product
                        </button>
                        
                    </div>
                </div>
                <div class="overflow-x-auto p-4">
                    <table id="example" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-4">Product name</th>
                                <th scope="col" class="px-4 py-3">Image</th>
                                <th scope="col" class="px-4 py-3">Description</th>
                                <th scope="col" class="px-4 py-3">Price</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
    <!-- End block -->
@endsection
