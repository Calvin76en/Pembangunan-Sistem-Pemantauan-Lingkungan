<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Monthly;
use App\Models\Approval;
use App\Models\Signature;
use Carbon\Carbon;

class ApprovalMonthlyController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua monitoring types dari tabel monitoring_types
        $monitoringTypes = DB::table('monitoring_types')->orderBy('monitoring_id')->get();

        // Check if there's data in session (from execute redirect)
        if ($request->session()->has('records')) {
            $monitoringId = $request->session()->get('monitoringId');
            $month = $request->session()->get('month');
            $records = $request->session()->get('records');
            $reportTypeName = $request->session()->get('reportTypeName');
            $reportId = $request->session()->get('reportId');
            
            // Clear session data
            $request->session()->forget(['monitoringId', 'month', 'records', 'reportTypeName', 'reportId']);
            
            return view('supervisor.monthly', compact(
                'monitoringTypes',
                'monitoringId',
                'month',
                'records',
                'reportTypeName',
                'reportId'
            ));
        }

        // Check for signature form flag
        $showSignatureForm = $request->session()->get('showSignatureForm', false);
        $reportId = $request->session()->get('reportId');
        
        if ($showSignatureForm) {
            $request->session()->forget(['showSignatureForm', 'reportId']);
        }

        return view('supervisor.monthly', compact('monitoringTypes', 'showSignatureForm', 'reportId'));
    }

    /**
     * Execute/generate laporan bulanan sesuai tipe monitoring dan bulan yang dipilih
     */
    public function execute(Request $request)
    {
        $request->validate([
            'report_type' => 'required|integer',
            'month' => 'required|date_format:Y-m',
        ]);

        $monitoringId = $request->input('report_type');
        $month = $request->input('month');

        $monitoringTypes = DB::table('monitoring_types')->orderBy('monitoring_id')->get();

        $date = Carbon::createFromFormat('Y-m', $month);
        $year = $date->year;
        $monthNum = $date->month;

        // Get approved daily reports for this month and monitoring type
        $approvedDailyReports = DB::table('daily')
            ->where('monitoring_id', $monitoringId)
            ->whereYear('report_date', $year)
            ->whereMonth('report_date', $monthNum)
            ->where('status', 'approved')
            ->get();

        if ($approvedDailyReports->isEmpty()) {
            return redirect()->route('supervisor.approval.monthly')
                ->with('error', 'No approved daily reports found for the selected month and monitoring type. Please ensure daily reports are approved first.');
        }

        $approvedLocationIds = $approvedDailyReports->pluck('location_id');

        // Query data based on monitoring type and approved locations
        switch ($monitoringId) {
            case 22000001: // Air Limbah Tambang
                $records = DB::table('air_limbah_tambang as alt')
                    ->join('locations as l', 'alt.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        DB::raw("DATE_FORMAT(alt.created_at, '%d-%m-%Y') as Tanggal"),
                        'alt.ph_inlet as pH_Inlet',
                        'alt.ph_outlet_1 as pH_Outlet_1',
                        'alt.ph_outlet_2 as pH_Outlet_2',
                        'alt.treatment_kapur as Treatment_Kapur_kg',
                        'alt.treatment_pac as Treatment_PAC_kg',
                        'alt.treatment_tawas as Treatment_Tawas_kg',
                        'alt.tss_inlet as TSS_Inlet_mg/L',
                        'alt.tss_outlet as TSS_Outlet_mg/L',
                        'alt.fe_outlet as Fe_Outlet_mg/L',
                        'alt.mn_outlet as Mn_Outlet_mg/L',
                        'alt.debit as Debit_m3/s',
                        'alt.velocity as Velocity_m/s',
                        'alt.keterangan as Keterangan'
                    )
                    ->where('alt.monitoring_id', $monitoringId)
                    ->whereIn('alt.location_id', $approvedLocationIds)
                    ->whereYear('alt.created_at', $year)
                    ->whereMonth('alt.created_at', $monthNum)
                    ->orderBy('l.location_name')
                    ->orderBy('alt.created_at')
                    ->get();
                break;
            case 22000002: // Oil Trap & Fuel Trap
                $records = DB::table('oil_trap_fuel_trap as otft')
                    ->join('locations as l', 'otft.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        DB::raw("DATE_FORMAT(otft.created_at, '%d-%m-%Y') as Tanggal"),
                        'otft.ph as pH'
                    )
                    ->where('otft.monitoring_id', $monitoringId)
                    ->whereIn('otft.location_id', $approvedLocationIds)
                    ->whereYear('otft.created_at', $year)
                    ->whereMonth('otft.created_at', $monthNum)
                    ->orderBy('l.location_name')
                    ->orderBy('otft.created_at')
                    ->get();
                break;
            case 22000003: // Curah Hujan
                $records = DB::table('curah_hujan as ch')
                    ->join('locations as l', 'ch.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        DB::raw("DATE_FORMAT(ch.created_at, '%d-%m-%Y') as Tanggal"),
                        'ch.CH as Curah_Hujan_mm',
                        DB::raw("IFNULL(TIME_FORMAT(ch.jam_mulai, '%H:%i'), '-') as Jam_Mulai"),
                        DB::raw("IFNULL(TIME_FORMAT(ch.jam_selesai, '%H:%i'), '-') as Jam_Selesai")
                    )
                    ->where('ch.monitoring_id', $monitoringId)
                    ->whereIn('ch.location_id', $approvedLocationIds)
                    ->whereYear('ch.created_at', $year)
                    ->whereMonth('ch.created_at', $monthNum)
                    ->orderBy('l.location_name')
                    ->orderBy('ch.created_at')
                    ->get();
                break;
            case 22000004: // Debu
                $records = DB::table('debu as d')
                    ->join('locations as l', 'd.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        DB::raw("DATE_FORMAT(d.created_at, '%d-%m-%Y') as Tanggal"),
                        'd.waktu as Waktu_Pengukuran',
                        DB::raw("IFNULL(d.status_debu, '-') as Status_Debu")
                    )
                    ->where('d.monitoring_id', $monitoringId)
                    ->whereIn('d.location_id', $approvedLocationIds)
                    ->whereYear('d.created_at', $year)
                    ->whereMonth('d.created_at', $monthNum)
                    ->orderBy('l.location_name')
                    ->orderBy('d.created_at')
                    ->get();
                break;
            case 22000005: // Kebisingan
                $records = DB::table('kebisingan as k')
                    ->join('locations as l', 'k.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        DB::raw("DATE_FORMAT(k.created_at, '%d-%m-%Y') as Tanggal"),
                        'k.spl_db as SPL_dB',
                        'k.second as Titik_Pengukuran'
                    )
                    ->where('k.monitoring_id', $monitoringId)
                    ->whereIn('k.location_id', $approvedLocationIds)
                    ->whereYear('k.created_at', $year)
                    ->whereMonth('k.created_at', $monthNum)
                    ->orderBy('l.location_name')
                    ->orderBy('k.created_at')
                    ->get();
                break;
            default:
                $records = collect();
        }

        if ($records->isEmpty()) {
            return redirect()->route('supervisor.approval.monthly')
                ->with('error', 'No data found for approved daily reports in the selected month.');
        }

        $reportTypeName = $monitoringTypes->where('monitoring_id', $monitoringId)->first()->monitoring_types ?? 'Unknown';

        // Check if monthly reports already exist for these locations and month
        $existingMonthlyReports = DB::table('monthly')
            ->whereIn('daily_id', $approvedDailyReports->pluck('id'))
            ->where('month', $month)
            ->get();

        if ($existingMonthlyReports->isEmpty()) {
            // Create monthly report entries for each approved daily report
            foreach ($approvedDailyReports as $dailyReport) {
                DB::table('monthly')->insertGetId([
                    'daily_id' => $dailyReport->id,
                    'location_id' => $dailyReport->location_id,
                    'NIK_user' => Auth::user()->NIK_user,
                    'status' => 'pending', // Use string value for ENUM
                    'month' => $month,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            // Re-fetch the created monthly reports
            $existingMonthlyReports = DB::table('monthly')
                ->whereIn('daily_id', $approvedDailyReports->pluck('id'))
                ->where('month', $month)
                ->get();
        }

        // Get the first monthly report ID for reference
        $reportId = $existingMonthlyReports->first()->id ?? null;

        // Store data in session and redirect (Post-Redirect-Get pattern)
        return redirect()->route('supervisor.approval.monthly')
            ->with([
                'monitoringId' => $monitoringId,
                'month' => $month,
                'records' => $records,
                'reportTypeName' => $reportTypeName,
                'reportId' => $reportId
            ]);
    }

    /**
     * Approve monthly report
     */
    public function approve(Request $request)
    {
        // Validasi input - comment optional untuk approve
        $request->validate([
            'report_id' => 'required|integer',
            'comment' => 'nullable|string',
            'action' => 'required|in:approve,reject'
        ]);

        $reportId = $request->input('report_id');
        $comment = $request->input('comment', 'Approved'); // Default comment if empty
        $action = $request->input('action');

        // If action is reject, call reject method
        if ($action === 'reject') {
            return $this->reject($request);
        }

        DB::beginTransaction();
        try {
            // Find the main monthly report
            $report = Monthly::findOrFail($reportId);
            
            // Get all related monthly reports (same month and from same monitoring type)
            $dailyIds = DB::table('monthly as m')
                ->join('daily as d', 'm.daily_id', '=', 'd.id')
                ->where('m.month', $report->month)
                ->where('d.monitoring_id', function($query) use ($report) {
                    $query->select('monitoring_id')
                        ->from('daily')
                        ->where('id', $report->daily_id)
                        ->limit(1);
                })
                ->pluck('m.id');
            
            // Update status for all related reports
            DB::table('monthly')
                ->whereIn('id', $dailyIds)
                ->where('status', '!=', 'approved')
                ->update([
                    'status' => 'approved',
                    'updated_at' => now()
                ]);
            
            // Create approval records
            foreach ($dailyIds as $monthlyId) {
                DB::table('approval')->insert([
                    'approval_name' => 'supervisor', // Using role name as per existing data
                    'approval_type' => 'monthly',
                    'approval_date' => now(),
                    'status' => 'approved',
                    'notes' => $comment,
                    'NIK_user' => Auth::user()->NIK_user,
                    'daily_report_id' => null,
                    'monthly_report_id' => $monthlyId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            
            // Redirect with showSignatureForm flag in session
            return redirect()->route('supervisor.approval.monthly')
                ->with('success', 'Monthly report approved successfully. Please provide your signature.')
                ->with('showSignatureForm', true)
                ->with('reportId', $reportId);
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to approve monthly report: ' . $e->getMessage());
        }
    }

    /**
     * Reject monthly report
     */
    public function reject(Request $request)
    {
        // Validasi input - comment required untuk reject
        $request->validate([
            'report_id' => 'required|integer',
            'comment' => 'required|string',
        ]);

        $reportId = $request->input('report_id');
        $comment = $request->input('comment');

        DB::beginTransaction();
        try {
            // Find the main monthly report
            $report = Monthly::findOrFail($reportId);
            
            // Get all related monthly reports (same month and from same monitoring type)
            $dailyIds = DB::table('monthly as m')
                ->join('daily as d', 'm.daily_id', '=', 'd.id')
                ->where('m.month', $report->month)
                ->where('d.monitoring_id', function($query) use ($report) {
                    $query->select('monitoring_id')
                        ->from('daily')
                        ->where('id', $report->daily_id)
                        ->limit(1);
                })
                ->pluck('m.id');
            
            // Update status for all related reports
            DB::table('monthly')
                ->whereIn('id', $dailyIds)
                ->where('status', '!=', 'rejected')
                ->update([
                    'status' => 'rejected',
                    'updated_at' => now()
                ]);
            
            // Create approval records
            foreach ($dailyIds as $monthlyId) {
                DB::table('approval')->insert([
                    'approval_name' => 'supervisor', // Using role name as per existing data
                    'approval_type' => 'monthly',
                    'approval_date' => now(),
                    'status' => 'rejected',
                    'notes' => $comment,
                    'NIK_user' => Auth::user()->NIK_user,
                    'daily_report_id' => null,
                    'monthly_report_id' => $monthlyId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            
            return redirect()->route('supervisor.approval.monthly')
                ->with('success', 'Monthly report rejected successfully. The report can be reviewed and approved again if needed.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to reject monthly report: ' . $e->getMessage());
        }
    }

    /**
     * Save signature for monthly report
     */
    public function saveSignature(Request $request)
    {
        $request->validate([
            'report_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'company_position' => 'required|string|max:255',
            'signature_data' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $reportId = $request->input('report_id');

            // Find the main monthly report
            $report = Monthly::findOrFail($reportId);
            
            // Get all related approved monthly reports (same month and monitoring type)
            $approvedMonthlyReports = DB::table('monthly as m')
                ->join('daily as d', 'm.daily_id', '=', 'd.id')
                ->where('m.month', $report->month)
                ->where('m.status', 'approved')
                ->where('d.monitoring_id', function($query) use ($report) {
                    $query->select('monitoring_id')
                        ->from('daily')
                        ->where('id', $report->daily_id)
                        ->limit(1);
                })
                ->select('m.*', 'd.monitoring_id')
                ->get();
            
            // Save signatures for each daily report
            foreach ($approvedMonthlyReports as $monthlyReport) {
                // Check if signature already exists for this daily report
                $existingSignature = Signature::where('report_id', $monthlyReport->daily_id)->first();
                
                if (!$existingSignature && $monthlyReport->daily_id) {
                    $signature = new Signature();
                    $signature->report_id = $monthlyReport->daily_id;
                    $signature->name = $request->input('name');
                    $signature->date = $request->input('date');
                    $signature->company_position = $request->input('company_position');
                    $signature->signature_data = $request->input('signature_data');
                    $signature->save();
                }
            }

            DB::commit();
            
            return redirect()->route('supervisor.approval.monthly')
                ->with('success', 'Monthly report signature saved successfully. Approval process completed.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to save signature: ' . $e->getMessage());
        }
    }
}