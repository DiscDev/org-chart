<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <div class="flex items-center space-x-4">
        <div class="flex items-center">
            <input wire:model="selectAll" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <span class="ml-2 text-sm text-gray-600">Select All</span>
        </div>

        <select wire:model="action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="">Select Action</option>
            <option value="add_to_department">Add to Department</option>
            <option value="add_to_team">Add to Team</option>
            <option value="deactivate">Deactivate Users</option>
        </select>

        @if($action === 'add_to_department')
            <select wire:model="targetDepartment" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        @endif

        @if($action === 'add_to_team')
            <select wire:model="targetTeam" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">Select Team</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        @endif

        <button 
            wire:click="executeAction"
            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
            @if(empty($selected) || empty($action)) disabled @endif
        >
            Execute Action
        </button>
    </div>

    @if(session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif
</div>