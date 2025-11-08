@extends('layouts.app')

@section('title', 'Fuvarozó Felület')

@section('content')
<h2 class="text-2xl font-bold mb-4">Fuvarozó Dashboard</h2>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="p-4 border rounded bg-white">
    <h3 class="font-semibold mb-2">Kiosztott munkák</h3>
    <table class="w-full border">
        <thead>
            <tr class="border-b">
                <th class="p-2">Kiindulási cím</th>
                <th class="p-2">Érkezési cím</th>
                <th class="p-2">Címzett</th>
                <th class="p-2">Címzett elérhetősége</th>
                <th class="p-2">Státusz</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr class="border-b">
                    <td class="p-2">{{ $job->start_address }}</td>
                    <td class="p-2">{{ $job->destination_address }}</td>
                    <td class="p-2">{{ $job->recipient_name }}</td>
                    <td class="p-2">{{ $job->recipient_phone }}</td>
                    <td class="p-2">
                        <form action="{{ route('driver.job.updateStatus', $job->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="border p-1 rounded">
                                <option value="Assigned" style="background-color: lightblue;" @if($job->status=='Assigned') selected @endif>Kiosztva</option>
                                <option value="InProgress" style="background-color: orange;" @if($job->status=='InProgress') selected @endif>Folyamatban</option>
                                <option value="Successful" style="background-color: lightgreen;" @if($job->status=='Successful') selected @endif>Elvégezve</option>
                                <option value="Failed" style="background-color: red;" @if($job->status=='Failed') selected @endif>Sikertelen</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded mt-1" style="background-color: blue;">Frissít</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection