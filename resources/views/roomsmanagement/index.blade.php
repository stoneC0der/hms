@extends('adminlte::page')

@section('title_prefix')
    Viewing: Rooms |
@endsection

@section('content_header')
    Viewing all Rooms
@endsection

@section('content')
    <div class="row">
        <div class="@if ($layout === 'split') col-md-8 @else col-md-12 @endif">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div></div>
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Type</a>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-default table-sm table-bordered">
                        <caption class="px-4">List of rooms</caption>
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Room number</th>
                                <th>Room type</th>
                                <th>Status</th>
                                <th>Updated on</th>
                                <th colspan="3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($rooms)
                                @forelse ($rooms as $room)
                                    <tr>
                                        <td scope="row">{{ $room->id }}</td>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->type->type }}</td>
                                        <td>
                                            @if ($room->is_available == 1)
                                                <span class="badge badge-success d-block">Free</span>
                                            @elseif ($room->is_available == 0)
                                                <span class="badge badge-danger d-block">Full</span>
                                            @endif
                                        </td>
                                        <td>{{ $room->created_at->diffForHumans(null,false,true) }}</td>
                                        <td>
                                            <a href="{{ route('rooms.show', ['room' => $room->id]) }}" class="btn btn-info btn-block disabled">
                                                <i class="fas fa-eye fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('rooms.edit', ['room' => $room->id]) }}" class="btn btn-warning btn-block">
                                                <i class="fas fa-pen-fancy fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            {!! Form::open(['route' => ['rooms.destroy', 'room' => $room->id], 'method' => 'DELETE']) !!}
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
                    {!! Route::is('rooms.edit') ? 'Editing room: <span class="text-muted">' . $e_room->room_number ?? '' . '</span>' : 'Create new room' !!}
                </div>
                <div class="card-body">
                    {!! Form::open(
                        array('route' => (Route::is('rooms.edit')) ? ['rooms.update', 'room' => $e_room->id ?? null] : 'rooms.store', 'method' => (Route::is('rooms.edit')) ? 'PUT' : null)
                        ) !!}
                        <div class="form-group has-feedback @error('room_number') is-invalid @enderror">
                            {!! Form::label('room_number', 'Room number', ['class' => 'form-control-label']) !!}
                            {!! Form::text('room_number', Route::is('rooms.edit') ? $e_room->room_number ?? old('room_number') : '', ['class' => 'form-control', 'id' => 'room_number', 'aria-describedby' => 'room_number', 'placeholder' => 'The room number...']) !!}
                        </div>
                        @error('room_number')
                            <div class="invalid-feedback" id="room_number">
                                {{ $message }}
                            </div>    
                        @enderror

                        <div class="form-group has-feedback @error('roomType') is-invalid @enderror">
                            {!! Form::label('roomType', 'Room Type', ['class' => 'form-control-label']) !!}
                            {!! Form::select('room_type_id', $roomTypes ?? null, $e_room->room_type_id ?? old('room_type_id'), ['class' => 'custom-select', 'id' => 'roomType', 'aria-describedby' => 'roomType', 'placeholder' => 'Select type of room...']) !!}
                        </div>
                        @error('room_type_id')
                            <div class="invalid-feedback" id="roomType">
                                {{ $message }}
                            </div>    
                        @enderror
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a href="{{ route('rooms.index') }}" type="reset" class="btn btn-dark">Cancel</a>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection