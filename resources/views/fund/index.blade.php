<x-app-layout>

    <!-- Navigation Links -->
    <div class="mt-6">
        <div class="flex justify-center">
            <div class="space-x-8 my-px ms-10 flex">
                <x-nav-link :href="route('fund.index')" :active="request()->routeIs('fund.index')">
                    INDEX
                </x-nav-link>
            </div>
            <div class="space-x-8 my-px ms-10 flex">
                <x-nav-link :href="route('fund.create')" :active="request()->routeIs('fund.create')">
                    CREATE
                </x-nav-link>
            </div>
        </div>
    </div>

    <!-- Display Panel -->
    <div class="mt-6">
        <x-display-panel>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 border rounded dark:border-gray-600">
                <!-- Tiêu đề -->
                <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">ALL FUND</h2>

                <!-- Grid hiển thị quỹ -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($funds as $fund)
                        <div id="{{ $fund->id }}" class="p-4 bg-white dark:bg-gray-700 shadow-md rounded-lg border-l-4 
                            {{ $fund->is_freemoney ? 'border-green-500' : 'border-blue-500' }}">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $fund->name }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <strong>Balance:</strong> {{ number_format($fund->balance) }} VND
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                <strong>Created at:</strong> {{ $fund->created_at->format('d/m/Y') }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                <strong>Type:</strong> {{ $fund->is_freemoney ? 'Free Money' : 'General' }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('fund.edit', $fund->id) }}" 
                                    class="px-4 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                                    Edit
                                </a>
                                <form id="deleteForm-{{ $fund->id }}" action="{{ route('fund.destroy', $fund->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="ml-2 px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-red-600 dark:hover:bg-red-700">
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- <!-- Phân trang -->
                <div class="mt-6">
                    {{ $funds->links() }}
                </div> --}}
            </div>
        </x-display-panel>
    </div>

</x-app-layout>

<script>
    $(document).ready(function () {
        $('form[id^="deleteForm"]').on('submit', function (e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            formData.append('_method', 'DELETE');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            var fundId = this.id.split('-')[1];

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 'success') {
                        $('#' + fundId).remove();
                        alert(response.message);
                    } else {
                        alert(response.message)
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            })
        })
    });
</script>