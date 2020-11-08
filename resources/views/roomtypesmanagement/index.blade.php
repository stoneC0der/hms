@extends('adminlte::page')

@section('title_prefix')
    Viewing: Room Type |
@endsection

@section('content_header')
    Viewing all Room Types
@endsection

@section('content')
    <div class="row">
        <div class="@if ($layout === 'split') col-md-8 @else col-md-12 @endif">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div></div>
                        <a href="{{ route('roomTypes.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Type</a>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-default table-sm">
                        <caption class="px-4">List of room types</caption>
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Internal Bathroom</th>
                                <th>Added on</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($roomTypes)
                                @forelse ($roomTypes as $roomType)
                                    <tr>
                                        <td scope="row">{{ $roomType->id }}</td>
                                        <td>{{ $roomType->type }}</td>
                                        <td>{{ ($roomType->has_internal_bathroom) ? 'YES' : 'FALSE' }}</td>
                                        <td>{{ $roomType->created_at->diffForHumans(null,false,true) }}</td>
                                        <td>
                                            <a href="{{ route('roomTypes.edit', ['roomType' => $roomType->id]) }}" class="btn btn-warning btn-block">
                                                <i class="fas fa-pen-fancy fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            {!! Form::open(['route' => ['roomTypes.destroy', 'roomType' => $roomType->id], 'method' => 'DELETE']) !!}
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
        @if (Route::is('roomTypes.edit') || Route::is('roomTypes.create'))
            @include('roomtypesmanagement.partials.form')
        @endif
    </div>
@endsection