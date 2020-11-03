<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteTenantRequest;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Tenant;

class TenantsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::paginate(25);

        return view('tenantsmanagement.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tenants = Tenant::paginate(25);
        $layout = 'split';

        return view('tenantsmanagement.index', compact('layout', 'tenants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenantRequest $request)
    {
        $newTenant = $request->processData();
        $newTenant->save();

        return redirect()->route('tenants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Tenant $tenant)
    {
        $tenants = Tenant::paginate(25);
        $layout = 'split';

        return view('tenantsmanagement.index', compact('layout', 'tenant', 'tenants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        $tenants = Tenant::paginate(25);
        $layout = 'split';

        return view('tenantsmanagement.index', compact('layout', 'tenant', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        $updatedTenant = $request->processData($tenant);
        $updatedTenant->save();

        return redirect()->route('tenants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteTenantRequest $request, Tenant $tenant)
    {
        $tenant->delete();

        return redirect()->route('tenants.index');
    }
}
