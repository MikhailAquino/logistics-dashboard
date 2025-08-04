@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-10 w-[500px] max-w-full flex flex-col items-center">
    <h1 class="text-4xl font-bold mb-4 text-[#3b167c] text-center">Welcome to the Logistics Dashboard</h1>
    <p class="text-lg text-gray-700 mb-8 text-center">
        Optimize your delivery tracking and proximity alerts with ease.
    </p>
    <a href="{{ url('/proximity-form') }}"
        class="inline-block px-6 py-3 rounded-lg bg-[#3b167c] text-white font-semibold shadow hover:bg-purple-800 transition">
        Go to Proximity Form
    </a>
</div>
@endsection