<form action="update_item.php" method="POST" class="space-y-4 p-4 border border-gray-300 rounded-lg shadow-sm">
    <div>
        <label for="label1" class="block text-gray-700">Label 1</label>
        <input type="text" id="label1" name="label1"
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
    </div>

    <div>
        <label for="label2" class="block text-gray-700">Label 2</label>
        <input type="text" id="label2" name="label2"
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
    </div>

    <div>
        <label for="label3" class="block text-gray-700">Label 3</label>
        <input type="text" id="label3" name="label3"
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
    </div>

    <div class="flex space-x-4 justify-end">
        <button type="submit" name="edit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Edit
        </button>
        <button type="submit" name="delete"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
            Delete
        </button>
    </div>
</form>
