<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Daily;
use App\Models\Approval;
use App\Models\Signature;
use Carbon\Carbon;

class ApprovalDailyController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua monitoring types dari tabel monitoring_types
        $monitoringTypes = DB::table('monitoring_types')->orderBy('monitoring_id')->get();

        // Ambil riwayat approval dengan pagination
        $approvalHistory = $this->getApprovalHistory($request);

        // Check if there's data in session (from execute redirect)
        if ($request->session()->has('reportData')) {
            $reportType = $request->session()->get('reportType');
            $date = $request->session()->get('date');
            $reportData = $request->session()->get('reportData');
            $reportId = $request->session()->get('reportId');
            $monitoringTypeName = $request->session()->get('monitoringTypeName');
            
            // Clear session data
            $request->session()->forget(['reportType', 'date', 'reportData', 'reportId', 'monitoringTypeName']);
            
            return view('supervisor.daily', compact(
                'monitoringTypes',
                'reportType',
                'date',
                'reportData',
                'reportId',
                'monitoringTypeName',
                'approvalHistory'
            ));
        }

        // Check for signature form flag
        $showSignatureForm = $request->session()->get('showSignatureForm', false);
        $reportId = $request->session()->get('reportId');
        
        if ($showSignatureForm) {
            $request->session()->forget(['showSignatureForm', 'reportId']);
        }

        return view('supervisor.daily', compact('monitoringTypes', 'showSignatureForm', 'reportId', 'approvalHistory'));
    }

    /**
     * Get approval history with pagination and filters
     */
    private function getApprovalHistory(Request $request)
    {
        $query = DB::table('approval as a')
            ->join('daily as d', 'a.daily_report_id', '=', 'd.id')
            ->join('locations as l', 'd.location_id', '=', 'l.location_id')
            ->join('monitoring_types as mt', 'd.monitoring_id', '=', 'mt.monitoring_id')
            ->join('users as u', 'a.NIK_user', '=', 'u.NIK_user')
            ->select(
                'a.approval_id',
                'a.approval_name',
                'a.approval_date',
                'a.status',
                'a.notes',
                'a.created_at',
                'd.report_date',
                'l.location_name',
                'mt.monitoring_types',
                'u.name as user_name',
                'd.id as daily_id'
            )
            ->where('a.approval_type', 'daily')
            ->orderBy('a.created_at', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->has('status_filter') && $request->status_filter !== '') {
            $query->where('a.status', $request->status_filter);
        }

        // Filter berdasarkan monitoring type jika ada
        if ($request->has('monitoring_filter') && $request->monitoring_filter !== '') {
            $query->where('d.monitoring_id', $request->monitoring_filter);
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('d.report_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('d.report_date', '<=', $request->date_to);
        }

        // Pagination
        return $query->paginate(10)->appends($request->query());
    }

    /**
     * Execute/generate laporan harian sesuai tipe monitoring dan tanggal yang dipilih
     */
    public function execute(Request $request)
    {
        $request->validate([
            'report_type' => 'required|integer',
            'date' => 'required|date',
        ]);

        $reportType = $request->input('report_type');
        $date = $request->input('date');

        // Get monitoring type name
        $monitoringType = DB::table('monitoring_types')
            ->where('monitoring_id', $reportType)
            ->first();
        
        $monitoringTypeName = $monitoringType->monitoring_types ?? 'Unknown';

        // Get all daily reports for this monitoring type and date
        $dailyReports = Daily::where('monitoring_id', $reportType)
            ->whereDate('report_date', $date)
            ->get();

        // Debug: Log untuk melihat apa yang dicari
        \Log::info('Looking for daily reports', [
            'monitoring_id' => $reportType,
            'date' => $date,
            'found_count' => $dailyReports->count()
        ]);

        if ($dailyReports->isEmpty()) {
            // Cek apakah ada data di tabel monitoring terkait untuk tanggal ini
            $hasMonitoringData = false;
            $dataCount = 0;
            
            switch ($reportType) {
                case 22000001: // Air Limbah Tambang
                    $dataCount = DB::table('air_limbah_tambang')
                        ->where('monitoring_id', $reportType)
                        ->whereDate('created_at', $date)
                        ->count();
                    $hasMonitoringData = $dataCount > 0;
                    break;
                    
                case 22000002: // Oil Trap & Fuel Trap
                    $dataCount = DB::table('oil_trap_fuel_trap')
                        ->where('monitoring_id', $reportType)
                        ->whereDate('created_at', $date)
                        ->count();
                    $hasMonitoringData = $dataCount > 0;
                    break;
                    
                case 22000003: // Curah Hujan
                    $dataCount = DB::table('curah_hujan')
                        ->where('monitoring_id', $reportType)
                        ->whereDate('created_at', $date)
                        ->count();
                    $hasMonitoringData = $dataCount > 0;
                    break;
                    
                case 22000004: // Debu
                    $dataCount = DB::table('debu')
                        ->where('monitoring_id', $reportType)
                        ->whereDate('created_at', $date)
                        ->count();
                    $hasMonitoringData = $dataCount > 0;
                    break;
                    
                case 22000005: // Kebisingan
                    $dataCount = DB::table('kebisingan')
                        ->where('monitoring_id', $reportType)
                        ->whereDate('created_at', $date)
                        ->count();
                    $hasMonitoringData = $dataCount > 0;
                    break;
            }
            
            if ($hasMonitoringData) {
                // Ada data monitoring tapi belum ada daily report
                // Buat daily report otomatis untuk semua lokasi yang memiliki data
                $locations = collect();
                
                switch ($reportType) {
                    case 22000001:
                        $locations = DB::table('air_limbah_tambang')
                            ->where('monitoring_id', $reportType)
                            ->whereDate('created_at', $date)
                            ->distinct()
                            ->pluck('location_id');
                        break;
                    case 22000002:
                        $locations = DB::table('oil_trap_fuel_trap')
                            ->where('monitoring_id', $reportType)
                            ->whereDate('created_at', $date)
                            ->distinct()
                            ->pluck('location_id');
                        break;
                    case 22000003:
                        $locations = DB::table('curah_hujan')
                            ->where('monitoring_id', $reportType)
                            ->whereDate('created_at', $date)
                            ->distinct()
                            ->pluck('location_id');
                        break;
                    case 22000004:
                        $locations = DB::table('debu')
                            ->where('monitoring_id', $reportType)
                            ->whereDate('created_at', $date)
                            ->distinct()
                            ->pluck('location_id');
                        break;
                    case 22000005:
                        $locations = DB::table('kebisingan')
                            ->where('monitoring_id', $reportType)
                            ->whereDate('created_at', $date)
                            ->distinct()
                            ->pluck('location_id');
                        break;
                }
                
                foreach ($locations as $locationId) {
                    Daily::create([
                        'location_id' => $locationId,
                        'monitoring_id' => $reportType,
                        'NIK_user' => Auth::user()->NIK_user,
                        'status' => 'pending',
                        'report_date' => $date,
                    ]);
                }
                
                // Re-fetch daily reports
                $dailyReports = Daily::where('monitoring_id', $reportType)
                    ->whereDate('report_date', $date)
                    ->get();
                    
                if ($dailyReports->isNotEmpty()) {
                    // Continue with the normal flow
                    goto continue_execution;
                }
            }
            
            return redirect()->route('supervisor.approval.daily')
                ->with('error', 'No daily reports found for the selected monitoring type and date.');
        }

        continue_execution:

        // Get location IDs from daily reports
        $locationIds = $dailyReports->pluck('location_id');

        // Query data based on monitoring type
        switch ($reportType) {
            case 22000001: // Air Limbah Tambang
                $reportData = DB::table('air_limbah_tambang as alt')
                    ->join('locations as l', 'alt.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        'alt.ph_inlet as pH_Inlet',
                        'alt.ph_outlet_1 as pH_Outlet_1', 
                        'alt.ph_outlet_2 as pH_Outlet_2',
                        'alt.treatment_kapur as Treatment_Kapur',
                        'alt.treatment_pac as Treatment_PAC',
                        'alt.treatment_tawas as Treatment_Tawas',
                        'alt.tss_inlet as TSS_Inlet',
                        'alt.tss_outlet as TSS_Outlet',
                        'alt.fe_outlet as Fe_Outlet',
                        'alt.mn_outlet as Mn_Outlet',
                        'alt.debit as Debit',
                        'alt.velocity as Velocity',
                        'alt.keterangan as Keterangan',
                        DB::raw("DATE_FORMAT(alt.created_at, '%d-%m-%Y %H:%i') as Tanggal_Input")
                    )
                    ->where('alt.monitoring_id', $reportType)
                    ->whereIn('alt.location_id', $locationIds)
                    ->whereDate('alt.created_at', $date)
                    ->orderBy('l.location_name')
                    ->orderBy('alt.created_at')
                    ->get();
                break;
                
            case 22000002: // Oil Trap & Fuel Trap
                $reportData = DB::table('oil_trap_fuel_trap as otft')
                    ->join('locations as l', 'otft.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        'otft.ph as pH',
                        DB::raw("DATE_FORMAT(otft.created_at, '%d-%m-%Y %H:%i') as Tanggal_Input")
                    )
                    ->where('otft.monitoring_id', $reportType)
                    ->whereIn('otft.location_id', $locationIds)
                    ->whereDate('otft.created_at', $date)
                    ->orderBy('l.location_name')
                    ->orderBy('otft.created_at')
                    ->get();
                break;
                
            case 22000003: // Curah Hujan
                $reportData = DB::table('curah_hujan as ch')
                    ->join('locations as l', 'ch.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        'ch.CH as Curah_Hujan_mm',
                        DB::raw("TIME_FORMAT(ch.jam_mulai, '%H:%i') as Jam_Mulai"),
                        DB::raw("TIME_FORMAT(ch.jam_selesai, '%H:%i') as Jam_Selesai"),
                        DB::raw("DATE_FORMAT(ch.created_at, '%d-%m-%Y %H:%i') as Tanggal_Input")
                    )
                    ->where('ch.monitoring_id', $reportType)
                    ->whereIn('ch.location_id', $locationIds)
                    ->whereDate('ch.created_at', $date)
                    ->orderBy('l.location_name')
                    ->orderBy('ch.created_at')
                    ->get();
                break;
                
            case 22000004: // Debu
                $reportData = DB::table('debu as d')
                    ->join('locations as l', 'd.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        'd.waktu as Waktu_Pengukuran',
                        'd.status_debu as Status_Debu',
                        DB::raw("DATE_FORMAT(d.created_at, '%d-%m-%Y %H:%i') as Tanggal_Input")
                    )
                    ->where('d.monitoring_id', $reportType)
                    ->whereIn('d.location_id', $locationIds)
                    ->whereDate('d.created_at', $date)
                    ->orderBy('l.location_name')
                    ->orderBy('d.created_at')
                    ->get();
                break;
                
            case 22000005: // Kebisingan
                $reportData = DB::table('kebisingan as k')
                    ->join('locations as l', 'k.location_id', '=', 'l.location_id')
                    ->select(
                        'l.location_name as Lokasi',
                        'k.spl_db as SPL_dB',
                        'k.second as Titik_Pengukuran',
                        DB::raw("DATE_FORMAT(k.created_at, '%d-%m-%Y %H:%i') as Tanggal_Input")
                    )
                    ->where('k.monitoring_id', $reportType)
                    ->whereIn('k.location_id', $locationIds)
                    ->whereDate('k.created_at', $date)
                    ->orderBy('l.location_name')
                    ->orderBy('k.created_at')
                    ->get();
                break;
                
            default:
                $reportData = collect();
        }

        // Get the first daily report ID for reference
        $reportId = $dailyReports->first()->id ?? null;

        // Store data in session and redirect (Post-Redirect-Get pattern)
        return redirect()->route('supervisor.approval.daily')
            ->with([
                'reportType' => $reportType,
                'date' => $date,
                'reportData' => $reportData,
                'reportId' => $reportId,
                'monitoringTypeName' => $monitoringTypeName
            ]);
    }

    /**
     * Approve daily report
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
            // Find the main daily report
            $report = Daily::findOrFail($reportId);
            
            // Get all daily reports for the same date and monitoring type
            $relatedReports = Daily::where('report_date', $report->report_date)
                ->where('monitoring_id', $report->monitoring_id)
                ->where('status', '!=', 'approved')
                ->get();
            
            // Update status for all related reports
            foreach ($relatedReports as $relatedReport) {
                $relatedReport->status = 'approved';
                $relatedReport->save();
                
                // Create approval record for each
                DB::table('approval')->insert([
                    'approval_name' => 'supervisor', // Using role name as per existing data
                    'approval_type' => 'daily',
                    'approval_date' => now(),
                    'status' => 'approved',
                    'notes' => $comment,
                    'NIK_user' => Auth::user()->NIK_user,
                    'daily_report_id' => $relatedReport->id,
                    'monthly_report_id' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            
            // Redirect with showSignatureForm flag in session
            return redirect()->route('supervisor.approval.daily')
                ->with('success', 'Daily report approved successfully. Please provide your signature.')
                ->with('showSignatureForm', true)
                ->with('reportId', $reportId);
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to approve daily report: ' . $e->getMessage());
        }
    }

    /**
     * Reject daily report
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
            // Find the main daily report
            $report = Daily::findOrFail($reportId);
            
            // Get all daily reports for the same date and monitoring type
            $relatedReports = Daily::where('report_date', $report->report_date)
                ->where('monitoring_id', $report->monitoring_id)
                ->where('status', '!=', 'rejected')
                ->get();
            
            // Update status for all related reports
            foreach ($relatedReports as $relatedReport) {
                $relatedReport->status = 'rejected';
                $relatedReport->save();
                
                // Create approval record for each
                DB::table('approval')->insert([
                    'approval_name' => 'supervisor', // Using role name as per existing data
                    'approval_type' => 'daily',
                    'approval_date' => now(),
                    'status' => 'rejected',
                    'notes' => $comment,
                    'NIK_user' => Auth::user()->NIK_user,
                    'daily_report_id' => $relatedReport->id,
                    'monthly_report_id' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            
            return redirect()->route('supervisor.approval.daily')
                ->with('success', 'Daily report rejected successfully. The report can be reviewed and approved again if needed.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to reject daily report: ' . $e->getMessage());
        }
    }

    /**
     * Save signature for daily report
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

            // Find the main daily report
            $report = Daily::findOrFail($reportId);
            
            // Get all approved daily reports for the same date and monitoring type
            $approvedReports = Daily::where('report_date', $report->report_date)
                ->where('monitoring_id', $report->monitoring_id)
                ->where('status', 'approved')
                ->get();
            
            // Save signatures for each approved report
            foreach ($approvedReports as $approvedReport) {
                // Check if signature already exists for this report
                $existingSignature = Signature::where('report_id', $approvedReport->id)->first();
                
                if (!$existingSignature) {
                    $signature = new Signature();
                    $signature->report_id = $approvedReport->id;
                    $signature->name = $request->input('name');
                    $signature->date = $request->input('date');
                    $signature->company_position = $request->input('company_position');
                    $signature->signature_data = $request->input('signature_data');
                    $signature->save();
                }
            }

            DB::commit();
            
            return redirect()->route('supervisor.approval.daily')
                ->with('success', 'Daily report signature saved successfully. Approval process completed.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to save signature: ' . $e->getMessage());
        }
    }
}