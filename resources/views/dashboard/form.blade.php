@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-xl p-10 w-[600px] max-w-full">
        <h2 class="text-3xl font-bold mb-6 text-[#3b167c] text-center">Proximity Alert Form</h2>
        <form method="POST" action="{{ route('check.proximity') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium mb-1">Delivery Latitude</label>
                <input type="text" name="lat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3b167c]" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Longitude</label>
                <input type="text" name="lng" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3b167c]" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Alert Radius (m)</label>
                <select name="radius" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3b167c]">
                    <option value="100">100m</option>
                    <option value="250" selected>250m</option>
                    <option value="500">500m</option>
                </select>
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-[#3b167c] text-white font-semibold rounded-lg shadow hover:bg-purple-800 transition">
                Check Proximity
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-[#3b167c] hover:underline">← Back to Welcome</a>
        </div>
    </div>

    {{-- Modal for Alerts, merged logic, with blurred background --}}
    @if(session('alertData'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition.opacity
            class="fixed inset-0 flex items-center justify-center z-50 bg-white/40 backdrop-blur"
            style="display: none;"
        >
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm relative">
                <button @click="show = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                @php $data = session('alertData') @endphp
                @if (isset($data['within_range']) && isset($data['distance']))
                    @if ($data['within_range'])
                        <p class="text-green-600 font-semibold">Delivery is within {{ $data['distance'] }} meters!</p>
                    @else
                        <p class="text-red-600 font-semibold">Delivery is {{ $data['distance'] }} meters away.</p>
                    @endif
                @elseif (isset($data['error']))
                    <p class="text-red-600 font-semibold">Error: {{ $data['error'] }}</p>
                @else
                    <p class="text-gray-500">No result received from the API.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection