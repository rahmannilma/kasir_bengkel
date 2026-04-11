<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\MechanicSalary;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MechanicSalaryController extends Controller
{
    public function index(Request $request)
    {
        $mechanics = Mechanic::active()->orderBy('name')->get();
        
        $selectedMechanic = $request->mechanic_id 
            ? Mechanic::find($request->mechanic_id) 
            : null;
        
        $salaries = collect();
        $totalEarnings = 0;
        
        if ($selectedMechanic) {
            $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
            $dateTo = $request->date_to ?? now()->endOfMonth()->format('Y-m-d');
            
            // Get salary records from MechanicSalary table
            $salaryRecords = MechanicSalary::with(['transaction'])
                ->where('mechanic_id', $selectedMechanic->id)
                ->whereBetween('period_start', [$dateFrom, $dateTo])
                ->where('status', 'pending')
                ->get();
            
            $salaries = $salaryRecords->map(function ($salary) {
                return [
                    'salary_id' => $salary->id,
                    'transaction' => $salary->transaction,
                    'service_amount' => $salary->service_amount,
                    'service_amount_per_mechanic' => $salary->service_amount,
                    'mechanic_count' => 1,
                    'commission_rate' => $salary->commission_rate,
                    'commission_amount' => $salary->commission_amount,
                    'is_paid' => $salary->status === 'paid',
                ];
            });
            
            $totalEarnings = $salaryRecords->sum('commission_amount');
        }
        
        return view('admin.mechanics.salary', compact(
            'mechanics',
            'selectedMechanic',
            'salaries',
            'totalEarnings'
        ));
    }

    public function updateCommission(Request $request, Mechanic $mechanic)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);
        
        $mechanic->update([
            'commission_rate' => $request->commission_rate,
        ]);
        
        return redirect()->back()->with('success', 'Persen komisi berhasil diperbarui');
    }

    public function markAsPaid(Request $request, Mechanic $mechanic)
    {
        $salaryIds = $request->input('salary_ids', []);
        
        if (empty($salaryIds)) {
            return redirect()->back()->with('error', 'Pilih salary yang akan dibayar');
        }
        
        MechanicSalary::where('mechanic_id', $mechanic->id)
            ->whereIn('id', $salaryIds)
            ->update(['status' => 'paid']);
        
        return redirect()->back()->with('success', 'Salary berhasil ditandai sebagai lunas');
    }
}
