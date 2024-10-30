<div class="org-chart-node" style="margin-left: {{ $level * 40 }}px">
    <div class="bg-white rounded-lg shadow-md p-4 mb-4 border border-gray-200 max-w-md">
        <div class="flex items-center space-x-4">
            @if($node['photo'])
                <img src="{{ Storage::url($node['photo']) }}" alt="{{ $node['name'] }}" class="w-12 h-12 rounded-full">
            @else
                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">{{ substr($node['name'], 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h3 class="text-lg font-semibold">{{ $node['name'] }}</h3>
                <p class="text-gray-600">{{ $node['title'] }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($node['departments'] as $department)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $department }}
                        </span>
                    @endforeach
                    @foreach($node['teams'] as $team)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            {{ $team }}
                        </span>
                    @endforeach
                    @foreach($node['roles'] as $role)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $role }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if(!empty($node['children']))
        <div class="org-chart-children">
            @foreach($node['children'] as $child)
                @include('livewire.org-chart-node', ['node' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>