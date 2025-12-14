<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerTaxProfile;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::withCount(['sales', 'repairs']);

        // Filtros
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $customers = $query->orderBy('name')->paginate(15);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $identificationDocuments = \App\Models\DianIdentificationDocument::orderBy('id')->get();
        $legalOrganizations = \App\Models\DianLegalOrganization::orderBy('id')->get();
        $tributes = \App\Models\DianCustomerTribute::orderBy('id')->get();
        
        return view('customers.create', compact(
            'identificationDocuments',
            'legalOrganizations',
            'tributes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') || true; // Por defecto activo

        $customer = Customer::create($data);

        // Si es una petición AJAX, devolver JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                ],
                'message' => 'Cliente creado exitosamente.'
            ]);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->loadCount(['sales', 'repairs']);
        $customer->load(['sales' => function($query) {
            $query->latest()->limit(5);
        }, 'repairs' => function($query) {
            $query->latest()->limit(5);
        }]);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $customer->load(['taxProfile']);
        $customer->loadCount(['sales', 'repairs']);
        
        $identificationDocuments = \App\Models\DianIdentificationDocument::orderBy('id')->get();
        $legalOrganizations = \App\Models\DianLegalOrganization::orderBy('id')->get();
        $tributes = \App\Models\DianCustomerTribute::orderBy('id')->get();
        
        return view('customers.edit', compact(
            'customer',
            'identificationDocuments',
            'legalOrganizations',
            'tributes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? true : false;
        $requiresElectronicInvoice = $request->boolean('requires_electronic_invoice');

        // Update customer
        $customer->update($data);

        // Handle tax profile
        if ($requiresElectronicInvoice) {
            if ($customer->taxProfile) {
                // Update existing profile
                $customer->taxProfile->update([
                    'identification_document_id' => $request->input('identification_document_id'),
                    'identification' => $request->input('identification'),
                    'dv' => $request->input('dv'),
                    'legal_organization_id' => $request->input('legal_organization_id'),
                    'company' => $request->input('company'),
                    'trade_name' => $request->input('trade_name'),
                    'tribute_id' => $request->input('tribute_id'),
                    'municipality_id' => $request->input('municipality_id'),
                ]);
            } else {
                // Create new profile
                CustomerTaxProfile::create([
                    'customer_id' => $customer->id,
                    'identification_document_id' => $request->input('identification_document_id'),
                    'identification' => $request->input('identification'),
                    'dv' => $request->input('dv'),
                    'legal_organization_id' => $request->input('legal_organization_id'),
                    'company' => $request->input('company'),
                    'trade_name' => $request->input('trade_name'),
                    'tribute_id' => $request->input('tribute_id'),
                    'municipality_id' => $request->input('municipality_id'),
                ]);
            }
        } else {
            // Remove tax profile if exists
            if ($customer->taxProfile) {
                $customer->taxProfile->delete();
            }
        }

        return redirect()->route('customers.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Verificar si el cliente tiene ventas o reparaciones asociadas
        if ($customer->sales()->exists() || $customer->repairs()->exists()) {
            return back()->with('error', 'No se puede eliminar el cliente porque tiene ventas o reparaciones asociadas.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
