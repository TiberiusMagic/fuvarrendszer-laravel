<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index(Request $request)
    {
        $statusFilter = $request->query('status');

        $query = Job::query();

        if ($statusFilter && $statusFilter !== 'All') {
            $query->where('status', $statusFilter);
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();
        $drivers = User::query()->where('role', 'Driver')->get();

        $statuses = [
            'All' => 'Összes',
            'Assigned' => 'Kiosztva',
            'InProgress' => 'Folyamatban',
            'Successful' => 'Elvégezve',
            'Failed' => 'Sikertelen',
        ];

        return view('admin.dashboard', compact('jobs', 'statuses', 'statusFilter', 'drivers'));
    }

    public function createJob()
    {
        return view('admin.create-job');
    }

    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'start_address' => 'required|string|max:255',
            'destination_address' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:50',
            'driver_email' => 'nullable|email|exists:users,email',
        ]);

        $job = Job::create([
            'start_address' => $validated['start_address'],
            'destination_address' => $validated['destination_address'],
            'recipient_name' => $validated['recipient_name'],
            'recipient_phone' => $validated['recipient_phone'],
            'driver_email' => $validated['driver_email'],
            'status' => Job::STATUS_ASSIGNED,
        ]);

        return redirect()->back()->with('success', 'Munka sikeresen létrehozva!');
    }

    public function assignDriver(Request $request, Job $job)
    {
        $validated = $request->validate([
            'driver_email' => 'required|email|exists:users,email',
        ]);

        $job->update([
            'driver_email' => $validated['driver_email'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Fuvarozó hozzárendelve.');
    }

    public function editJob(Job $job)
    {
        $drivers = User::where('role', 'Driver')->get();
        return view('admin.edit-job', compact('job', 'drivers'));
    }

    public function updateJob(Request $request, Job $job)
    {
        $validated = $request->validate([
            'start_address' => 'required|string|max:255',
            'destination_address' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:50',
            'driver_email' => 'required|email|exists:users,email',
        ]);

        $job->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Munka frissítve!');
    }

    public function destroyJob(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Munka törölve!');
    }

}