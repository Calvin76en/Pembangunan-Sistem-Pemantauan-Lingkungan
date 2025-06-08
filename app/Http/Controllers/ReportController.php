<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirLimbahTambang;
use App\Models\Monthly;
use App\Models\Daily;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Define specific report types for Air Limbah Tambang
        $reportTypes = collect([
            (object)[
                'id' => 'ph',
                'name' => 'pH Analysis',
                'monitoring_id' => 22000001
            ],
            (object)[
                'id' => 'debit',
                'name' => 'Debit Analysis',
                'monitoring_id' => 22000001
            ],
            (object)[
                'id' => 'tss',
                'name' => 'TSS Analysis',
                'monitoring_id' => 22000001
            ]
        ]);
        
        return view('mip.print-report', compact('reportTypes'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:ph,debit,tss',
            'month_value' => 'required|string',
            'year_value' => 'required|string',
        ]);

        $reportType = $request->input('report_type');
        $month = $request->input('month_value');
        $year = $request->input('year_value');
        
        // Format month-year for monthly table
        $monthYear = $year . '-' . $month;

        // Define report types
        $reportTypes = collect([
            (object)[
                'id' => 'ph',
                'name' => 'pH Analysis',
                'monitoring_id' => 22000001
            ],
            (object)[
                'id' => 'debit',
                'name' => 'Debit Analysis',
                'monitoring_id' => 22000001
            ],
            (object)[
                'id' => 'tss',
                'name' => 'TSS Analysis',
                'monitoring_id' => 22000001
            ]
        ]);

        // Always use Air Limbah Tambang monitoring ID
        $monitoringId = 22000001;

        // Get monitoring type name
        $monitoringType = DB::table('monitoring_types')
            ->where('monitoring_id', $monitoringId)
            ->first();
        
        $baseReportTypeName = $monitoringType ? $monitoringType->monitoring_types : 'Unknown';
        $specificReportName = $reportTypes->where('id', $reportType)->first()->name ?? '';
        $reportTypeName = $baseReportTypeName . ' - ' . $specificReportName;

        // Get approved monthly reports for the selected month and monitoring type
        $approvedMonthlyReports = DB::table('monthly as m')
            ->join('daily as d', 'm.daily_id', '=', 'd.id')
            ->where('m.month', $monthYear)
            ->where('m.status', 'approved')
            ->where('d.monitoring_id', $monitoringId)
            ->select('m.*', 'd.location_id', 'd.monitoring_id')
            ->get();

        if ($approvedMonthlyReports->isEmpty()) {
            return view('mip.print-report', [
                'data' => collect(),
                'reportType' => $reportType,
                'reportTypeName' => $reportTypeName,
                'reportTypes' => $reportTypes,
                'message' => 'No approved monthly reports found for the selected period and monitoring type.'
            ]);
        }

        // Get location IDs from approved monthly reports
        $approvedLocationIds = $approvedMonthlyReports->pluck('location_id')->unique();

        // Query specific data based on report type
        $data = collect();
        
        switch ($reportType) {
            case 'ph':
                $data = DB::table('air_limbah_tambang as alt')
                    ->join('locations as l', 'alt.location_id', '=', 'l.location_id')
                    ->select(
                        'alt.created_at',
                        'l.location_name',
                        'alt.location_id',
                        'alt.ph_inlet',
                        'alt.ph_outlet_1',
                        'alt.ph_outlet_2'
                    )
                    ->whereIn('alt.location_id', $approvedLocationIds)
                    ->whereYear('alt.created_at', $year)
                    ->whereMonth('alt.created_at', $month)
                    ->orderBy('l.location_name')
                    ->orderBy('alt.created_at')
                    ->get();
                break;
                
            case 'debit':
                $data = DB::table('air_limbah_tambang as alt')
                    ->join('locations as l', 'alt.location_id', '=', 'l.location_id')
                    ->select(
                        'alt.created_at',
                        'l.location_name',
                        'alt.location_id',
                        'alt.debit',
                        'alt.velocity'
                    )
                    ->whereIn('alt.location_id', $approvedLocationIds)
                    ->whereYear('alt.created_at', $year)
                    ->whereMonth('alt.created_at', $month)
                    ->orderBy('l.location_name')
                    ->orderBy('alt.created_at')
                    ->get();
                break;
                
            case 'tss':
                $data = DB::table('air_limbah_tambang as alt')
                    ->join('locations as l', 'alt.location_id', '=', 'l.location_id')
                    ->select(
                        'alt.created_at',
                        'l.location_name',
                        'alt.location_id',
                        'alt.tss_inlet',
                        'alt.tss_outlet'
                    )
                    ->whereIn('alt.location_id', $approvedLocationIds)
                    ->whereYear('alt.created_at', $year)
                    ->whereMonth('alt.created_at', $month)
                    ->orderBy('l.location_name')
                    ->orderBy('alt.created_at')
                    ->get();
                break;
        }

        // Get approval information
        $approvalInfo = DB::table('approval')
            ->whereIn('monthly_report_id', $approvedMonthlyReports->pluck('id'))
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('mip.print-report', compact(
            'data', 
            'reportType',
            'reportTypeName',
            'reportTypes',
            'approvalInfo',
            'month',
            'year'
        ));
    }
}