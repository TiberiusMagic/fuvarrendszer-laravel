@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-12">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>
@endsection
