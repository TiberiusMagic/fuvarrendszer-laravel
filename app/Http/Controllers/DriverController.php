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
        $jobs = Job::where('driver_email', Auth::user()->email)->get();
        return view('driver.dashboard', compact('jobs'));
    }

    public function updateStatus(Request $request, Job $job)
    {
        if ($job->driver_email !== Auth::user()->email) {
            abort(403, 'Ehhez nincs jogosultságod.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Assigned,InProgress,Successful,Failed',
        ]);

        $job->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Státusz frissítve!');
    }

}
