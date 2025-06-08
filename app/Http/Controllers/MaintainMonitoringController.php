<?php

namespace App\Http\Controllers;

use App\Models\MonitoringType;
use Illuminate\Http\Request;

class MaintainMonitoringController extends Controller
{
    // Show all monitoring types
    public function index()
    {
        $monitoringTypes = MonitoringType::all();
        return view('admin.tipemonitoring', compact('monitoringTypes'));
    }

    // Show edit form for monitoring type
    public function edit($monitoring_id)
    {
        // Use 'monitoring_id' as the primary key
        $monitoringType = MonitoringType::findOrFail($monitoring_id);
        return view('admin.edit-tipemonitoring', compact('monitoringType'));
    }

    public function update(Request $request, $monitoring_id)
    {
        $request->validate([
            'monitoring_types' => 'required|string|max:255',
        ]);

        // Use 'monitoring_id' as the primary key
        $monitoringType = MonitoringType::findOrFail($monitoring_id);
        $monitoringType->update([
            'monitoring_types' => $request->monitoring_types,
        ]);

        return redirect()->route('admin.tipemonitoring')->with('success', 'Monitoring Type updated successfully.');
    }
}
