@extends('adminlte::page')

@section('title_prefix')
    Viewing: Tenants |
@endsection

@section('content_header')
    Viewing all Tenants
@endsection

@section('content')
    <div class="row">
        <div class="@if ($layout === 'split') col-md-8 @else col-md-12 @endif">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div></div>
                        <a href="{{ route('tenants.create') }}" class="btn btn-primary btn-sm disabled"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Type</a>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-default table-sm table-bordered">
                        <caption class="px-4">List of rooms</caption>
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Phone</th>
                                <th>Occupation</th>
                                <th>Updated on</th>
                                <th colspan="3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($tenants)
                                @forelse ($tenants as $tenant)
                                    <tr>
                                        <td scope="row">{{ $tenant->id }}</td>
                                        <td>{{ $tenant->first_name }}</td>
                                        <td>{{ $tenant->last_name }}</td>
                                        <td><a href="tel:+(233){{ $tenant->phone }}"></a></td>
                                        <td>{{ $tenant->occupation }}</td>
                                        <td>{{ $tenant->created_at->diffForHumans(null,false,true) }}</td>
                                        <td>
                                            <a href="{{ route('tenants.show', ['tenant' => $tenant->id]) }}" class="btn btn-info btn-block disabled">
                                                <i class="fas fa-eye fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('tenants.edit', ['tenant' => $tenant->id]) }}" class="btn btn-warning btn-block">
                                                <i class="fas fa-pen-fancy fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            {!! Form::open(['route' => ['tenants.destroy', 'tenant' => $tenant->id], 'method' => 'DELETE']) !!}
                                                <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-trash fa-sm fa-fw"></i> Delete</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td scope="row"></td>
                                    </tr>
                                @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if (Route::is('tenants.edit'))
            @include('tenantsmanagement.partials.form')
        @endif
    </div>
@endsection