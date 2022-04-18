@extends('layout')

@section('content')

    <!-- component -->
    <div class="flex items-center justify-center mt-10">

        <!-- Card -->
        <div class="w-96 h-20 rounded-xl shadow-md p-5 border border-gray-50 bg-white" id="file-upload-list">

            <div id="resumable-drop" style="display: none">
                <!-- Quota -->
                <p class="text-gray-700 text-lg"><button id="resumable-browse" class="w-full h-10" data-url="{{ url('store') }}" >Click to upload</button></p>
                <p class="text-gray-700 text-lg"></p>
            </div>

            <!-- Quota Bar -->
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-4" id="progress" style="display: none">
                <div class="bg-blue-500 h-1.5 rounded-full progress-bar" style="width: 0%"></div>
            </div>

            <!-- Description -->

        </div>
    </div>

@endsection
@section('orders')
    <div id="orders">
        @include('orders')
    </div>
@endsection
