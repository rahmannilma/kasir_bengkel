<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\DistributorNote;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index(Request $request)
    {
        $query = Distributor::withCount('categories');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%');
            });
        }

        $distributors = $query->with(['categories', 'notes'])->orderBy('name')->paginate(20);

        return view('admin.distributors.index', compact('distributors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        Distributor::create($request->all());

        return redirect()->back()->with('success', 'Distributor berhasil ditambahkan');
    }

    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        $distributor->update($request->all());

        return redirect()->back()->with('success', 'Distributor berhasil diperbarui');
    }

    public function destroy(Distributor $distributor)
    {
        if ($distributor->categories()->count() > 0) {
            return redirect()->back()->with('error', 'Distributor tidak dapat dihapus karena masih memiliki kategori');
        }

        $distributor->delete();

        return redirect()->back()->with('success', 'Distributor berhasil dihapus');
    }

    public function notes(Request $request)
    {
        $query = DistributorNote::with('distributor');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->distributor_id) {
            $query->where('distributor_id', $request->distributor_id);
        }

        if ($request->filter === 'overdue') {
            $query->where('due_date', '<', now())->where('status', '!=', 'paid');
        } elseif ($request->filter === 'due_soon') {
            $query->whereBetween('due_date', [now(), now()->addDays(7)])->where('status', '!=', 'paid');
        }

        $notes = $query->orderBy('due_date')->paginate(20);
        $distributors = Distributor::orderBy('name')->get();

        return view('admin.distributor-notes.index', compact('notes', 'distributors'));
    }

    public function createNote(Request $request)
    {
        $distributors = Distributor::orderBy('name')->get();
        return view('admin.distributor-notes.create', compact('distributors'));
    }

    public function storeNote(Request $request)
    {
        $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'note_number' => 'required|string|max:50|unique:distributor_notes,note_number',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DistributorNote::create($request->all());

        return redirect()->route('admin.distributor-notes.index')->with('success', 'Nota berhasil ditambahkan');
    }

    public function editNote(DistributorNote $distributorNote)
    {
        $distributors = Distributor::orderBy('name')->get();
        return view('admin.distributor-notes.edit', compact('distributorNote', 'distributors'));
    }

    public function updateNote(Request $request, DistributorNote $distributorNote)
    {
        $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'note_number' => 'required|string|max:50|unique:distributor_notes,note_number,' . $distributorNote->id,
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $distributorNote->update($request->all());

        if ($distributorNote->paid_amount >= $distributorNote->total_amount) {
            $distributorNote->update(['status' => 'paid']);
        } elseif ($distributorNote->paid_amount > 0) {
            $distributorNote->update(['status' => 'partial']);
        }

        return redirect()->route('admin.distributor-notes.index')->with('success', 'Nota berhasil diperbarui');
    }

    public function destroyNote(DistributorNote $distributorNote)
    {
        $distributorNote->delete();

        return redirect()->route('admin.distributor-notes.index')->with('success', 'Nota berhasil dihapus');
    }

    public function payNote(Request $request, DistributorNote $distributorNote)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $distributorNote->remaining_amount,
        ]);

        $newPaidAmount = $distributorNote->paid_amount + $request->amount;

        $distributorNote->update([
            'paid_amount' => $newPaidAmount,
            'status' => $newPaidAmount >= $distributorNote->total_amount ? 'paid' : 'partial',
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat');
    }
}
