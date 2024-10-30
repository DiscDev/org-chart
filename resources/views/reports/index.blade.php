<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reports</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Department Costs Report -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Department Costs Report</h3>
                            <form action="{{ route('reports.department-costs.export') }}" method="GET" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Time Period</label>
                                    <select name="period" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="3m">Last 3 months</option>
                                        <option value="6m">Last 6 months</option>
                                        <option value="12m">Last 12 months</option>
                                        <option value="ytd">Year to date</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Format</label>
                                    <select name="format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="xlsx">Excel</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    Export Report
                                </button>
                            </form>
                        </div>

                        <!-- Employee Directory -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Directory</h3>
                            <form action="{{ route('reports.employee-directory.export') }}" method="GET" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Format</label>
                                    <select name="format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="xlsx">Excel</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    Export Directory
                                </button>
                            </form>
                        </div>

                        <!-- Turnover Report -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Turnover Report</h3>
                            <form action="{{ route('reports.turnover.export') }}" method="GET" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Time Period</label>
                                    <select name="period" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="3m">Last 3 months</option>
                                        <option value="6m">Last 6 months</option>
                                        <option value="12m">Last 12 months</option>
                                        <option value="ytd">Year to date</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Group By</label>
                                    <select name="group_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">None</option>
                                        <option value="department">Department</option>
                                        <option value="team">Team</option>
                                        <option value="office">Office</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Format</label>
                                    <select name="format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="xlsx">Excel</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    Export Report
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>