<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Salary Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Salary Distribution</h3>
                        <div class="flex items-center space-x-4">
                            <select wire:model.live="salaryGroupBy" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="department">By Department</option>
                                <option value="team">By Team</option>
                                <option value="agency">By Agency</option>
                                <option value="role">By Role</option>
                            </select>
                            <label class="flex items-center">
                                <input wire:model.live="showAgencyFees" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Include Agency Fees</span>
                            </label>
                        </div>
                    </div>

                    <div x-data="salaryChart" x-init="initChart(@js($salaryData))" class="h-96">
                        <canvas x-ref="chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Department Cost Analysis -->
            <livewire:dashboard.department-cost-analysis />

            <!-- Employee Turnover -->
            <livewire:dashboard.turnover-metrics />

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Department Distribution</h3>
                        <ul class="space-y-3">
                            @foreach($departmentDistribution as $dept)
                                <li class="flex justify-between">
                                    <span class="text-gray-600">{{ $dept->name }}</span>
                                    <span class="font-medium">{{ $dept->users_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Team Distribution</h3>
                        <ul class="space-y-3">
                            @foreach($teamDistribution as $team)
                                <li class="flex justify-between">
                                    <span class="text-gray-600">{{ $team->name }}</span>
                                    <span class="font-medium">{{ $team->users_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Office Distribution</h3>
                        <ul class="space-y-3">
                            @foreach($officeDistribution as $office)
                                <li class="flex justify-between">
                                    <span class="text-gray-600">{{ $office->name }}</span>
                                    <span class="font-medium">{{ $office->users_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Team Members</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentUsers as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($user->photo_url)
                                                    <img class="h-8 w-8 rounded-full" src="{{ Storage::url($user->photo_url) }}" alt="">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-sm text-gray-500">{{ substr($user->first_name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->full_name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $user->email_work }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->roles->pluck('name')->join(', ') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->departments->pluck('name')->join(', ') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->teams->pluck('name')->join(', ') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->start_date->format('M d, Y') }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>