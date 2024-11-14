<div class="mt-6">
    <x-display-panel>
        <!-- Gọi component form-create-fund -->
        <form id="fundForm" action="{{ route('fund.store') }}" method="POST" class="w-full h-full max-w-full mx-auto p-6 border rounded shadow-lg bg-white dark:bg-gray-800 dark:border-gray-600">
            @csrf
            <!-- Tiêu đề -->
            <h2 class="text-center text-2xl font-bold mb-6 text-gray-900 dark:text-white">ADD FUND</h2>

            <!-- Fund Name -->
            <div class="mb-4">
                <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Fund Name:</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <!-- Monthly -->
            <div class="mb-4">
                <label for="monthly" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Monthly:</label>
                <input type="number" id="monthly" name="monthly" value="0" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <input type="submit" value="Submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                </input>
            </div>
        </form>
    </x-display-panel>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('fundForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngừng hành động mặc định (reload trang)

            // Lấy dữ liệu từ form
            const formData = new FormData(form);

            // Lấy CSRF token từ meta tag (nếu có)
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Gửi dữ liệu bằng fetch API
            fetch('/funds/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // Gửi CSRF token
                    'Accept': 'application/json', // Đảm bảo server trả về JSON
                },
                body: formData // Dữ liệu gửi đi dưới dạng FormData
            })
            .then(response => {
                if (response.ok) {
                    // Nếu phản hồi thành công, reset lại form
                    form.reset();
                } else {
                    console.error('Lỗi xảy ra trong quá trình gửi');
                }
            })
            .catch(error => {
                // Xử lý khi có lỗi
                console.error('Error:', error);
                alert('Có lỗi xảy ra!');
            });
        });
    });
</script>