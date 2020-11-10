@extends('adminlte::page')

@section('title_prefix')
    Viewing: Rents |
@endsection

@section('content_header')
    Viewing all Rents
@endsection

@section('content')
    <div class="row">
        <div class="@if ($layout === 'split') col-md-8 col-lg-9 @else col-sm-12 @endif">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div></div>
                        <a href="{{ route('rents.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add to Rent</a>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-default table-sm table-bordered">
                        <caption class="px-4">List of rooms</caption>
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Tenant</th>
                                <th>Duration</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Expires in</th>
                                <th>Amount</th>
                                {{-- <th>Balance</th> --}}
                                <th>Updated on</th>
                                <th colspan="3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($rents)
                                @forelse ($rents as $rent)
                                    <tr class="@if ($rent->expires_in < 0) bg-danger @elseif ($rent->expires_in < 5) bg-warning @endif">
                                        <td scope="row">{{ $rent->id }}</td>
                                        <td>{{ $rent->room->room_number }}</td>
                                        <td>{{ $rent->tenant->full_name }}</td>
                                        <td>{{ $rent->duration . ' month(s)' }}</td>
                                        <td>{{ $rent->from->toDateString() }}</td>
                                        <td>{{ $rent->to->toDateString() }}</td>
                                        <td>
                                            @if ($rent->expires_in == 0 )
                                                {!! __('Tomorrow') !!}
                                            @elseif ($rent->expires < 0 ) 
                                                {!! __('expired') !!}
                                            @else
                                                {{ $rent->expires_in . ' days' }}
                                            @endif
                                        </td>
                                        <td>{{ 'Gh¢'.$rent->amount }}</td>
                                        {{-- <td>{{ 'Gh¢'.$rent->balance }}</td> --}}
                                        <td>{{ $rent->updated_at->diffForHumans(null,false,true) }}</td>
                                        <td>
                                            <a href="{{ route('rents.show', ['rent' => $rent->id]) }}" class="btn btn-info btn-block shadow disabled">
                                                <i class="fas fa-eye fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('rents.edit', ['rent' => $rent->id]) }}" class="btn btn-warning btn-block shadow">
                                                <i class="fas fa-pen-fancy fa-sm fa-fw"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            {!! Form::open(['route' => ['rents.destroy', 'rent' => $rent->id], 'method' => 'DELETE']) !!}
                                                <button type="submit" class="btn btn-danger btn-block shadow"><i class="fas fa-trash fa-sm fa-fw"></i> Delete</button>
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
        <div class="@if ($layout === 'full') d-none @else col-md-4 col-lg-3 @endif">
            @include('rentsmanagement.partials.form')
        </div>
    </div>
@endsection

@includeWhen((Route::is('rents.create') || Route::is('rents.edit')), 'scripts.rent-script')