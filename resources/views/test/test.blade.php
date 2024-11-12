<x-app-layout>
    <x-slot name="header">
        {{ __('Testing Page') }}
    </x-slot>

    <div class="mt-6">
        <x-display-panel>
            <div class="flex justify-center">
                <div class="mr-4">
                    <x-nav-link href="route('index')" active=''>
                        INDEX
                    </x-nav-link>
                </div>
                <div class="mr-4">
                    <x-nav-link href="route('create')" active=''>
                        CREATE
                    </x-nav-link>
                </div>
                <div class="mr-4">
                    <x-nav-link href="route('edit')" active=''>
                        EDIT
                    </x-nav-link>
                </div>
                <div class="mr-4">
                    <x-nav-link href="route('delete')" active=''>
                        DELETE
                    </x-nav-link>
                </div>
                <div class="mr-4">
                    <x-nav-link href="route('delete')" active=''>
                        DELETE
                    </x-nav-link>
                </div>
                <div class="mr-4">
                    <x-nav-link href="route('show')" active=''>
                        SHOW
                    </x-nav-link>
                </div>
            </div>

        </x-display-panel>
    </div>

    <div class="mt-6">
        <x-display-panel>
            <div class="w-1/2">
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <div style="width: 50%; margin: 0 auto;">
                    <!-- Thêm canvas để vẽ biểu đồ -->
                    <canvas id="myPieChart"></canvas>
                </div>

                <script>
                    // Lấy canvas để vẽ biểu đồ
                    var ctx = document.getElementById('myPieChart').getContext('2d');

                    // Tạo biểu đồ tròn
                    var myPieChart = new Chart(ctx, {
                        type: 'pie', // Loại biểu đồ (tròn)
                        data: {
                            labels: ['Red', 'Blue', 'Yellow'], // Các nhãn cho mỗi phần trong biểu đồ
                            datasets: [{
                                data: [100, 40, 50], // Dữ liệu cho mỗi phần (tỉ lệ phần trăm)
                                backgroundColor: ['red', 'blue', 'yellow'], // Màu sắc cho mỗi phần
                            }]
                        },
                        options: {
                            responsive: true, // Tự động thay đổi kích thước theo màn hình
                            plugins: {
                                legend: {
                                    position: 'right', // Vị trí của legend (chú thích)
                                },
                                tooltip: {
                                    enabled: true, // Hiển thị tooltip khi hover vào phần biểu đồ
                                }
                            }
                        }
                    });
                </script>
            </div>
        </x-display-panel>
    </div>

</x-app-layout>