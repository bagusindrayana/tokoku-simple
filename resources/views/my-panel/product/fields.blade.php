<div>
    <label for="product_name"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
    <input type="text" name="product_name" id="product_name"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        placeholder="Type product name" required="">
        <span class="error-message-product_name text-red-500"></span>
</div>
<div>
    <label for="product_price"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
    <input type="number" name="product_price" id="product_price"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        placeholder="Rp 1000" required="">
    <span class="error-message-product_price text-red-500"></span>
</div>
<div>

    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        for="product_image">Image</label>
    <input
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        id="product_image" type="file" name="product_image" accept="image/*">
        <span class="error-message-product_image text-red-500"></span>

</div>


<div class="sm:col-span-2"><label for="product_description"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
    <textarea id="product_description" rows="4"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        placeholder="Write product description here" name="product_description"></textarea>
        <span class="error-message-product_description text-red-500"></span>
</div>