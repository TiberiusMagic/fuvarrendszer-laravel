@extends('layouts.app')

@section('title', 'Admin Felület')

@section('content')
<h2 class="text-2xl font-bold mb-4">Admin Felület</h2>

<div class="mb-6 p-4 border rounded bg-white">
    <h3 class="font-semibold mb-2">Új munka létrehozása</h3>
    <form action="{{ route('admin.job.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label>Kiindulási cím:</label>
            <input type="text" name="start_address" class="border p-1 w-full">
        </div>
        <div class="mb-2">
            <label>Érkezési cím:</label>
            <input type="text" name="destination_address" class="border p-1 w-full">
        </div>
        <div class="mb-2">
            <label>Címzett neve:</label>
            <input type="text" name="recipient_name" class="border p-1 w-full">
        </div>
        <div class="mb-2">
            <label>Címzett elérhetősége:</label>
            <input type="text" name="recipient_phone" class="border p-1 w-full">
        </div>
        <div class="mb-2">
            <label>Fuvarozó:</label>
            <select name="driver_email" class="border p-1 w-full">
                @foreach($drivers as $driver)
                    <option value="{{ $driver->email }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 block mt-2" style="background-color:green">Létrehozás</button>
    </form>
</div>

<div class="p-4 border rounded bg-white">
    <h3 class="font-semibold mb-2">Összes munka</h3>

    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4 flex items-center gap-2">
        <label for="status" class="font-semibold">Szűrés státusz szerint:</label>
        <select name="status" id="status" class="border rounded p-1">
            @foreach($statuses as $value => $label)
                <option value="{{ $value }}" {{ $statusFilter === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded" style="background-color: blue;">Szűrés</button>
    </form>

    <table class="w-full border">
        <thead>
            <tr class="border-b">
                <th class="p-2">Kiindulási cím</th>
                <th class="p-2">Érkezési cím</th>
                <th class="p-2">Címzett</th>
                <th class="p-2">Címzett elérhetősége</th>
                <th class="p-2">Fuvarozó</th>
                <th class="p-2">Státusz</th>
                <th class="p-2">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr class="border-b">
                    <td class="p-2">{{ $job->start_address }}</td>
                    <td class="p-2">{{ $job->destination_address }}</td>
                    <td class="p-2">{{ $job->recipient_name }}</td>
                    <td class="p-2">{{ $job->recipient_phone }}</td>
                    <td class="p-2">{{ $job->driver->name ?? '-' }}</td>
                    <td class="p-2">{{ $job->status }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('admin.job.edit', $job->id) }}"
                            class="bg-yellow-500 text-white px-2 py-1 rounded" style="background-color: orange;">Módosítás</a>

                        <form action="{{ route('admin.job.destroy', $job->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded"
                            onclick="return confirm('Biztos törölni akarod ezt a munkát?')" style="background-color: red;">Törlés</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection