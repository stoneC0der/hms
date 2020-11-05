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
        <div class="@if ($layout === 'full') d-none @else col-md-4 @endif">
            <div class="card">
                <div class="card-header">
                    {!! Route::is('roomTypes.edit') ? 'Editing type: <span class="text-muted">' . $room_type->type ?? '' . '</span>' : 'Create new type' !!}
                </div>
                <div class="card-body">
                    {!! Form::open(
                        array('route' => Route::is('roomTypes.edit') ? ['roomTypes.update', 'roomType' => $room_type->id ?? ''] : 'roomTypes.store', 'method' => Route::is('roomTypes.edit') ? 'PUT' : null)
                        ) !!}
                        <div class="form-group has-feedback @error('type') is-invalid @enderror">
                            {!! Form::label('type', 'Type', ['class' => 'form-control-label']) !!}
                            {!! Form::text('type', Route::is('roomTypes.edit') ? $room_type->type ?? old('type') : '', ['class' => 'form-control', 'id' => 'type', 'aria-describedby' => 'type']) !!}
                        </div>
                        @error('type')
                            <div class="invalid-feedback" id="type">
                                {{ $message }}
                            </div>    
                        @enderror
                        <div class="custom-control custom-checkbox has-feedback @error('has_internal_bathroom') is-invalid @enderror">
                            {!! Form::checkbox('has_internal_bathroom', '1', ($room_type->has_internal_bathroom ?? old('has_internal_bathroom')) ? 'checked' : null , ['class' => 'custom-control-input', 'id' => 'has_internal_bathroom', 'aria-describedby' => 'has_internal_bathroom']) !!}
                            {!! Form::label('has_internal_bathroom', 'Internal Bathroom', ['class' => 'custom-control-label']) !!}
                        </div>
                        @error('has_internal_bathroom')
                            <div class="invalid-feedback" id="has_internal_bathroom">
                                {{ $message }}
                            </div>    
                        @enderror
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a href="{{ route('roomTypes.index') }}" type="reset" class="btn btn-dark">Cancel</a>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection