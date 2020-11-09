<div class="card">
    <div class="card-header">
        {!! Route::is('bookings.edit') ? 'Editing book of: <span class="text-muted">' . $booked->tenant->full_name ?? '' . '</span>' : 'Create new booking' !!}
    </div>
    <div class="card-body">
        {!! Form::open(
            array('route' => (Route::is('bookings.edit')) ? ['bookings.update', 'booking' => $booked->id ?? null] : 'bookings.store', 'method' => (Route::is('bookings.edit')) ? 'PUT' : null)
            ) !!}

            {{-- Add when creating booking, this give the ability to directly create a tenant with a booking instead of first creating a tenant and then select him when creating a booking --}}
            @includeWhen(Route::is('bookings.create'), 'bookingsmanagement.partials.tenant-details-input')

            {{-- Booking Part --}}
            @if(Route::is('bookings.edit'))
                <div class="form-group has-feedback @error('tenant') is-invalid @enderror">
                    {!! Form::label('tenant', 'tenant', ['class' => 'form-control-label']) !!}
                    {!! Form::text('tenant', Route::is('bookings.edit') ? $booked->tenant->full_name ?? old('tenant') : '', ['class' => 'form-control', 'id' => 'tenant', 'aria-describedby' => 'tenant', 'placeholder' => 'Number of months...', 'disabled' => true]) !!}
                </div>
                @error('tenant')
                    <div class="invalid-feedback" id="tenant">
                        {{ $message }}
                    </div>    
                @enderror
            @endif
            
            <div class="form-group has-feedback @error('room_type') is-invalid @enderror">
                {!! Form::label('room_type', 'Type of room', ['class' => 'form-control-label']) !!}
                {!! Form::select('room_type', $roomTypes ?? null, $booked->room_type->price ?? old('room_type'), ['class' => 'custom-select', 'id' => 'room_type', 'data-bookedRoomId' => $booked->room_id ?? '', 'aria-describedby' => 'room_type', 'placeholder' => 'Select type of room...']) !!}
            </div>
            <div class="text-danger small" id="room_typeError"></div>
            @error('room_type')
                <div class="invalid-feedback" id="room_type">
                    {{ $message }}
                </div>    
            @enderror

            <div class="form-group has-feedback @error('room_id') is-invalid @enderror">
                {!! Form::label('room_id', 'Room number', ['class' => 'form-control-label']) !!}
                {!! Form::select('room_id', $rooms ?? null, $booked->room_id ?? old('room_id'), ['class' => 'custom-select', 'id' => 'room_id', 'aria-describedby' => 'room_id', 'placeholder' => 'Select type of room...']) !!}
            </div>
            <div class="text-danger small" id="room_idError"></div>
            @error('room_id')
                <div class="invalid-feedback" id="room_id">
                    {{ $message }}
                </div>    
            @enderror
            {{-- TODO:  Remove me (already done in backend) --}}
            <div class="form-group has-feedback @error('duration') is-invalid @enderror">
                {!! Form::label('duration', 'duration', ['class' => 'form-control-label']) !!}
                {!! Form::text('duration', Route::is('bookings.edit') ? $booked->duration ?? old('duration') : '', ['class' => 'form-control', 'id' => 'duration', 'aria-describedby' => 'duration', 'placeholder' => 'Number of months...']) !!}
            </div>
            @error('duration')
                <div class="invalid-feedback" id="duration">
                    {{ $message }}
                </div>    
            @enderror

            <div class="form-group has-feedback @error('from') is-invalid @enderror">
                {!! Form::label('from', 'from', ['class' => 'form-control-label']) !!}
                {!! Form::date('from', Route::is('bookings.edit') ? $booked->from ?? old('from') : Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'from', 'aria-describedby' => 'from', 'placeholder' => '2020-12-09...']) !!}
            </div>
            @error('from')
                <div class="invalid-feedback" id="from">
                    {{ $message }}
                </div>    
            @enderror

            <div class="form-group has-feedback @error('to') is-invalid @enderror">
                {!! Form::label('to', 'to', ['class' => 'form-control-label']) !!}
                {!! Form::date('to', Route::is('bookings.edit') ? $booked->to ?? old('to') : '', ['class' => 'form-control', 'id' => 'to', 'aria-describedby' => 'to', 'placeholder' => '2020-12-25...']) !!}
            </div>
            @error('to')
                <div class="invalid-feedback" id="to">
                    {{ $message }}
                </div>    
            @enderror

            <div class="form-row">
                
                <div class="col">
                    {{-- TODO:  add amount with javascript base on duration when creating & editing --}}
                    {!! Form::label('amount', 'Total Amount', ['class' => 'form-control-label']) !!}
                    <div class="input-group has-feedback @error('amount') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon">Gh¢</div>
                        </div>
                        {!! Form::text('amount', Route::is('bookings.edit') ? $booked->amount ?? old('amount') : '', ['class' => 'form-control', 'id' => 'amount', 'aria-describedby' => 'amount', 'placeholder' => 'Amount to pay']) !!}
                    </div>
                    @error('amount')
                        <div class="invalid-feedback" id="amount">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                {{-- <div class="col-lg-4">
                    <div class="form-group has-feedback @error('balance') is-invalid @enderror">
                        {!! Form::label('balance', 'Balance', ['class' => 'form-control-label']) !!}
                        {!! Form::text('balance', Route::is('bookings.edit') ? $booked->balance ?? old('balance') : '', ['class' => 'form-control', 'id' => 'balance', 'aria-describedby' => 'balance', 'placeholder' => 'The school/company name...']) !!}
                    </div>
                    @error('balance')
                        <div class="invalid-feedback" id="balance">
                            {{ $message }}
                        </div>    
                    @enderror
                </div> --}}
            </div>

            {{-- Button Group --}}
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('bookings.index') }}" type="reset" class="btn btn-dark">Cancel</a>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>