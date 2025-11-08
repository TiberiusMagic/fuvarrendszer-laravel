<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin'])->only(['create', 'store', 'destroy', 'edit', 'update']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'start_address' => 'required|string|max:255',
            'end_address' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:50',
            'users_id' => 'nullable|exists:users,id',
        ]);

        $data['status'] = 'Assigned';
        Job::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Munka létrehozva.');
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Új munka létrehozva!');
    }
}
