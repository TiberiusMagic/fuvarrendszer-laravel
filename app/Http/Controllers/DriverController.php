<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Driver');
    }

    public function index()
    {
        $jobs = Job::where('user_id', Auth::id())->get();
        return view('driver.dashboard', compact('jobs'));
    }

    public function updateStatus(Request $request, Job $job)
    {
    
    if ($job->driver_email !== Auth::user()->email) {
        abort(403, 'Nem módosíthatod más munkáját.');
    }

    $request->validate([
        'status' => [
            'required',
            Rule::in([
                Job::STATUS_ASSIGNED,
                Job::STATUS_INPROGRESS,
                Job::STATUS_SUCCESSFUL,
                Job::STATUS_FAILED,
            ]),
        ],
    ]);

    $job->update([
        'status' => $request->status,
    ]);

    return redirect()->route('driver.dashboard')->with('success', 'Státusz frissítve.');
}

}
