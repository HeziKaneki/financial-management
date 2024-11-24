<x-category-nav-bar>
    <!-- Display Panel -->
    <div class="mt-6">
        <x-display-panel>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 border rounded dark:border-gray-600">
                <!-- Tiêu đề -->
                <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">CATEGORY INDEX</h2>

                <!-- Thanh tìm kiếm -->
                <div class="mt-6 flex justify-between">
                    <div class="w-1/2">
                        <form method="GET" action="{{ route('category.index') }}" class="flex">
                            <input type="text" name="search" value="{{ request()->input('search') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Search transactions...">
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                                {{ __('Search') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bảng category -->
                <div class="overflow-x-auto mt-6" style="max-height: 200px;">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Category ID') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Date') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Name') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Description') }}</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 overflow-y-auto" >
                            @foreach ($categories as $category)
                                <tr id="{{ $category->id }}">
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $category->id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $category->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $category->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $category->description }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="deleteForm inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="delete" class="text-red-500 hover:text-red-700 cursor-pointer">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="mt-4">
                    {{ $categories->appends(['search' => $search])->links() }}
                </div>
            </div>
        </x-display-panel>
    </div>
</x-category-nav-bar>