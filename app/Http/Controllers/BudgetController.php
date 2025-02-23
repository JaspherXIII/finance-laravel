<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    public function getBudgets()
    {
        $budgets = Budget::all();
        $totalBudget = $budgets->sum('amount');
    
        $budgets->each(function ($budget) use ($totalBudget) {
            $budget->percentage = number_format(($budget->amount / $totalBudget) * 100, 2) . '%';
        });
    
        return response()->json(['data' => $budgets]);
    }

    public function index(Request $request)
    {
        return view('dashboards.admins.budgets');
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        Budget::updateOrCreate(
            ['id' => $request->budget_id],
            [
                'name' => $request->name,
                'amount' => $request->amount,
            ]
        );
        return response()->json(['success' => 'Budget Added Successfully!']);
    }

    public function edit(string $id)
    {
        $budget = Budget::find($id);
        return response()->json($budget);
    }

    public function show(string $id)
    {
        $budget = Budget::find($id);
        return response()->json($budget);
    }

    public function destroy(string $id)
    {
        $budget = Budget::find($id)->delete();
        return response()->json(['success' => 'Budget Deleted Successfully!']);
    }
}
