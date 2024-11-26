<x-app-layout>
    <div class="sm:overflow-x-auto mt-3" style="max-height: 600px;">
        <div class="bg-gray-100 dark:bg-gray-900 min-h-screen p-6">
            <!-- Header Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Total Balance</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">50,000,000 VND</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Total Income</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">15,000,000 VND</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Total Expense</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">10,000,000 VND</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Net Change</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">+5,000,000 VND</p>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="space-x-2">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded">Monthly</button>
                        <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-300 rounded">Weekly</button>
                    </div>
                    <select class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-300 rounded">
                        <option>Week 1</option>
                        <option>Week 2</option>
                        <option>Week 3</option>
                        <option>Week 4</option>
                    </select>
                    <div class="space-x-2">
                        <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-300 rounded">Expenses</button>
                        <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-300 rounded">Income</button>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded">Both</button>
                    </div>
                </div>
                <div>
                    <canvas id="lineChart" class="max-h-64"></canvas>
                </div>
            </div>

            <!-- Analysis Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pie Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Category Analysis</h3>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded">Switch to Income</button>
                    </div>
                    <div>
                        <canvas id="pieChart" class="max-h-64"></canvas>
                    </div>
                </div>

                <!-- Overspending Analysis -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-gray-600 dark:text-gray-300 text-sm font-semibold mb-4">Overspending Analysis</h3>
                    <table class="w-full text-left text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="py-2 px-4">Date</th>
                                <th class="py-2 px-4">Exceed Amount</th>
                                <th class="py-2 px-4">% Over Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="py-2 px-4">2024-11-15</td>
                                <td class="py-2 px-4 text-red-500">300,000 VND</td>
                                <td class="py-2 px-4 text-red-500">30%</td>
                            </tr>
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="py-2 px-4">2024-11-18</td>
                                <td class="py-2 px-4 text-red-500">600,000 VND</td>
                                <td class="py-2 px-4 text-red-500">60%</td>
                            </tr>
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="py-2 px-4">2024-11-21</td>
                                <td class="py-2 px-4 text-red-500">1,200,000 VND</td>
                                <td class="py-2 px-4 text-red-500">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Line Chart (Mock Data)
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [
                        {
                            label: 'Income',
                            data: [5000, 4000, 6000, 3000],
                            borderColor: '#4CAF50',
                            tension: 0.4,
                        },
                        {
                            label: 'Expense',
                            data: [3000, 2000, 4000, 5000],
                            borderColor: '#F44336',
                            tension: 0.4,
                        }
                    ]
                }
            });

            // Pie Chart (Mock Data)
            const ctx = document.getElementById('pieChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Food', 'Transport', 'Shopping', 'Other'],
                    datasets: [{
                        label: 'Expenses',
                        data: [5000000, 2000000, 3000000, 1000000],
                        backgroundColor: ['#f87171', '#34d399', '#60a5fa', '#fbbf24'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#6b7280', // Text color
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw.toLocaleString();
                                    return `${context.label}: ${value} VND`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</x-app-layout>