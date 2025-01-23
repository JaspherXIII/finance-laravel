<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function getFinancialReports(): JsonResponse
    {
        $reports = Report::where('type', 'Financial')->orderBy('id')->get();
        return response()->json(['data' => $reports]);
    }

    public function getRevenueReports(): JsonResponse
    {
        $reports = Report::where('type', 'Revenue')->orderBy('id')->get();
        return response()->json(['data' => $reports]);
    }

    public function financial(Request $request)
    {
        return view('dashboards.admins.reports.financial');
    }

    public function revenue(Request $request)
    {
        return view('dashboards.admins.reports.revenue');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric',
            'month' => 'required',
            'year' => 'required|digits:4|integer',
            'status' => 'required|in:Pending,Approved,Rejected',
        ], [
            'name.required' => 'The title field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        Report::updateOrCreate(
            ['id' => $request->report_id],
            [
                'type' => $request->type,
                'name' => $request->name,
                'amount' => $request->amount,
                'month' => $request->month,
                'year' => $request->year,
                'status' => $request->status,
            ]
        );

        return response()->json(['success' => 'Report Added Successfully!']);
    }


    public function edit(string $id)
    {
        $report = Report::find($id);
        return response()->json($report);
    }

    public function show(string $id)
    {
        $report = Report::find($id);
        return response()->json($report);
    }

    public function destroy(string $id)
    {
        $report = Report::find($id)->delete();
        return response()->json(['success' => 'Report Deleted Successfully!']);
    }
}
