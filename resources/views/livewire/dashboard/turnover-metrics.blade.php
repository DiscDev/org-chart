<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium text-gray-900">Employee Turnover Metrics</h3>
        <div class="flex items-center space-x-4">
            <select wire:model.live="timeframe" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="3m">Last 3 months</option>
                <option value="6m">Last 6 months</option>
                <option value="12m">Last 12 months</option>
                <option value="ytd">Year to date</option>
            </select>
            <select wire:model.live="groupBy" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Overall</option>
                <option value="department">By Department</option>
                <option value="team">By Team</option>
                <option value="office">By Office</option>
            </select>
        </div>
    </div>

    @if(!$groupBy)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-gray-500">Turnover Rate</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ number_format($turnoverData['turnover_rate'], 1) }}%
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-gray-500">Total Departures</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ $turnoverData['departures'] }}
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-gray-500">Average Employees</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ $turnoverData['average_employees'] }}
                </div>
            </div>
        </div>
    @else
        <div class="mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ ucfirst($groupBy) }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Turnover Rate
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departures
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Average Employees
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($turnoverData as $data)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $data['name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($data['turnover_rate'], 1) }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $data['departures'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $data['average_employees'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Turnover Trend Chart -->
    <div>
        <h4 class="text-base font-medium text-gray-900 mb-4">Turnover Trend</h4>
        <div x-data="turnoverTrendChart" x-init="initChart(@js($trendData))" class="h-64">
            <canvas x-ref="chart"></canvas>
        </div>
    </div>
</div>