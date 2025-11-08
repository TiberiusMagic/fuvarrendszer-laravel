@extends('layouts.app')

@section('title', 'Munka Módosítása')

@section('content')
<h2 class="text-2xl font-bold mb-4">Munka Módosítása</h2>

<form action="{{ route('admin.job.update', $job->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-2">
        <label>Kiindulási cím:</label>
        <input type="text" name="start_address" value="{{ $job->start_address }}" class="border p-1 w-full">
    </div>
    <div class="mb-2">
        <label>Érkezési cím:</label>
        <input type="text" name="destination_address" value="{{ $job->destination_address }}" class="border p-1 w-full">
    </div>
    <div class="mb-2">
        <label>Címzett neve:</label>
        <input type="text" name="recipient_name" value="{{ $job->recipient_name }}" class="border p-1 w-full">
    </div>
    <div class="mb-2">
        <label>Címzett telefonszáma:</label>
        <input type="text" name="recipient_phone" value="{{ $job->recipient_phone }}" class="border p-1 w-full">
    </div>
    <div class="mb-2">
        <label>Fuvarozó:</label>
        <select name="driver_email" class="border p-1 w-full">
            @foreach($drivers as $driver)
                <option value="{{ $driver->email }}" @if($driver->email == $job->driver_email) selected @endif>{{ $driver->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded" style="background-color: green;">Mentés</button>
</form>
@endsection