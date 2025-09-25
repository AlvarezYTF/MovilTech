<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repair;
use App\Models\Customer;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Repair::with('customer');

        // Filtros
        if ($request->filled('search')) {
            $query->where('phone_model', 'like', '%' . $request->search . '%')
                  ->orWhere('imei', 'like', '%' . $request->search . '%')
                  ->orWhereHas('customer', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->filled('repair_status')) {
            $query->where('repair_status', $request->repair_status);
        }

        if ($request->filled('date_from')) {
            $query->where('repair_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('repair_date', '<=', $request->date_to);
        }

        $repairs = $query->orderBy('repair_date', 'desc')->paginate(15);

        return view('repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('repairs.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'phone_model' => 'required|string|max:255',
            'imei' => 'required|string|unique:repairs|max:255',
            'issue_description' => 'required|string',
            'repair_status' => 'required|in:pending,in_progress,completed,delivered',
            'repair_cost' => 'required|numeric|min:0',
            'repair_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Repair::create($request->all());

        return redirect()->route('repairs.index')
            ->with('success', 'Reparación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        $repair->load('customer');
        return view('repairs.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        $customers = Customer::orderBy('name')->get();
        return view('repairs.edit', compact('repair', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repair $repair)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'phone_model' => 'required|string|max:255',
            'imei' => 'required|string|max:255|unique:repairs,imei,' . $repair->id,
            'issue_description' => 'required|string',
            'repair_status' => 'required|in:pending,in_progress,completed,delivered',
            'repair_cost' => 'required|numeric|min:0',
            'repair_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $repair->update($request->all());

        return redirect()->route('repairs.index')
            ->with('success', 'Reparación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        $repair->delete();

        return redirect()->route('repairs.index')
            ->with('success', 'Reparación eliminada exitosamente.');
    }
}
