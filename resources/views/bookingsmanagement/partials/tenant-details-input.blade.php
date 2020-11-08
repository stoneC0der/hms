<div class="form-group has-feedback @error('first_name') is-invalid @enderror">
    {!! Form::label('first_name', 'First name', ['class' => 'form-control-label']) !!}
    {!! Form::text('first_name', Route::is('bookings.edit') ? $booked->tenant->first_name ?? old('first_name') : '', ['class' => 'form-control', 'id' => 'first_name', 'aria-describedby' => 'first_name', 'placeholder' => 'The book first name...']) !!}
</div>
@error('first_name')
    <div class="invalid-feedback" id="first_name">
        {{ $message }}
    </div>    
@enderror
<div class="form-group has-feedback @error('last_name') is-invalid @enderror">
    {!! Form::label('last_name', 'Last name', ['class' => 'form-control-label']) !!}
    {!! Form::text('last_name', Route::is('bookings.edit') ? $booked->tenant->last_name ?? old('last_name') : '', ['class' => 'form-control', 'id' => 'last_name', 'aria-describedby' => 'last_name', 'placeholder' => 'The book last name...']) !!}
</div>
@error('last_name')
    <div class="invalid-feedback" id="last_name">
        {{ $message }}
    </div>    
@enderror

<div class="form-group has-feedback @error('phone') is-invalid @enderror">
    {!! Form::label('phone', 'Phone number', ['class' => 'form-control-label']) !!}
    {!! Form::tel('phone', Route::is('bookings.edit') ? $booked->tenant->phone ?? old('phone') : '', ['class' => 'form-control', 'id' => 'phone', 'aria-describedby' => 'phone', 'placeholder' => 'The book phone number...']) !!}
</div>
@error('phone')
    <div class="invalid-feedback" id="phone">
        {{ $message }}
    </div>    
@enderror

<div class="form-group has-feedback @error('email') is-invalid @enderror">
    {!! Form::label('email', 'E-mail', ['class' => 'form-control-label']) !!}
    {!! Form::email('email', Route::is('bookings.edit') ? $booked->tenant->email ?? old('email') : '', ['class' => 'form-control', 'id' => 'email', 'aria-describedby' => 'email', 'placeholder' => 'The book email address...']) !!}
</div>
@error('email')
    <div class="invalid-feedback" id="email">
        {{ $message }}
    </div>    
@enderror

<div class="form-group has-feedback @error('occupation') is-invalid @enderror">
    {!! Form::label('occupation', 'Occupation', ['class' => 'form-control-label']) !!}
    {!! Form::select('occupation', $occupations ?? null, $booked->tenant->occupation ?? old('occupation'), ['class' => 'custom-select', 'id' => 'occupation', 'aria-describedby' => 'occupation', 'placeholder' => 'Select type of room...']) !!}
</div>
@error('occupation')
    <div class="invalid-feedback" id="occupation">
        {{ $message }}
    </div>    
@enderror

<div class="form-group has-feedback @error('where') is-invalid @enderror">
    {!! Form::label('where', 'Location', ['class' => 'form-control-label']) !!}
    {!! Form::text('where', Route::is('bookings.edit') ? $booked->tenant->where ?? old('where') : '', ['class' => 'form-control', 'id' => 'where', 'aria-describedby' => 'where', 'placeholder' => 'The school/company name...']) !!}
</div>
@error('where')
    <div class="invalid-feedback" id="where">
        {{ $message }}
    </div>    
@enderror