<div class="@if ($layout === 'full') d-none @else col-md-4 @endif">
    <div class="card">
        <div class="card-header">
            {!! Route::is('tenants.edit') ? 'Editing tenant: <span class="text-muted">' . $e_tenant->full_name ?? '' . '</span>' : 'Create new tenant' !!}
        </div>
        <div class="card-body">
            {!! Form::open(
                array('route' => (Route::is('tenants.edit')) ? ['tenants.update', 'tenant' => $e_tenant->id ?? null] : 'tenants.store', 'method' => (Route::is('tenants.edit')) ? 'PUT' : null)
                ) !!}
                <div class="form-group has-feedback @error('first_name') is-invalid @enderror">
                    {!! Form::label('first_name', 'First name', ['class' => 'form-control-label']) !!}
                    {!! Form::text('first_name', Route::is('tenants.edit') ? $e_tenant->first_name ?? old('first_name') : '', ['class' => 'form-control', 'id' => 'first_name', 'aria-describedby' => 'first_name', 'placeholder' => 'The tenant first name...']) !!}
                </div>
                @error('first_name')
                    <div class="invalid-feedback" id="first_name">
                        {{ $message }}
                    </div>    
                @enderror
                <div class="form-group has-feedback @error('last_name') is-invalid @enderror">
                    {!! Form::label('last_name', 'Last name', ['class' => 'form-control-label']) !!}
                    {!! Form::text('last_name', Route::is('tenants.edit') ? $e_tenant->last_name ?? old('last_name') : '', ['class' => 'form-control', 'id' => 'last_name', 'aria-describedby' => 'last_name', 'placeholder' => 'The tenant last name...']) !!}
                </div>
                @error('last_name')
                    <div class="invalid-feedback" id="last_name">
                        {{ $message }}
                    </div>    
                @enderror

                <div class="form-group has-feedback @error('phone') is-invalid @enderror">
                    {!! Form::label('phone', 'Phone number', ['class' => 'form-control-label']) !!}
                    {!! Form::tel('phone', Route::is('tenants.edit') ? $e_tenant->phone ?? old('phone') : '', ['class' => 'form-control', 'id' => 'phone', 'aria-describedby' => 'phone', 'placeholder' => 'The tenant phone number...']) !!}
                </div>
                @error('phone')
                    <div class="invalid-feedback" id="phone">
                        {{ $message }}
                    </div>    
                @enderror

                <div class="form-group has-feedback @error('email') is-invalid @enderror">
                    {!! Form::label('email', 'E-mail', ['class' => 'form-control-label']) !!}
                    {!! Form::email('email', Route::is('tenants.edit') ? $e_tenant->email ?? old('email') : '', ['class' => 'form-control', 'id' => 'email', 'aria-describedby' => 'email', 'placeholder' => 'The tenant email address...']) !!}
                </div>
                @error('email')
                    <div class="invalid-feedback" id="email">
                        {{ $message }}
                    </div>    
                @enderror

                <div class="form-group has-feedback @error('occupation') is-invalid @enderror">
                    {!! Form::label('occupation', 'Occupation', ['class' => 'form-control-label']) !!}
                    {!! Form::select('occupation', $occupations ?? null, $e_tenant->occupation ?? old('occupation'), ['class' => 'custom-select', 'id' => 'occupation', 'aria-describedby' => 'occupation', 'placeholder' => 'Select type of room...']) !!}
                </div>
                @error('occupation')
                    <div class="invalid-feedback" id="occupation">
                        {{ $message }}
                    </div>    
                @enderror

                <div class="form-group has-feedback @error('where') is-invalid @enderror">
                    {!! Form::label('where', 'Location', ['class' => 'form-control-label']) !!}
                    {!! Form::text('where', Route::is('tenants.edit') ? $e_tenant->where ?? old('where') : '', ['class' => 'form-control', 'id' => 'where', 'aria-describedby' => 'where', 'placeholder' => 'The school/company name...']) !!}
                </div>
                @error('where')
                    <div class="invalid-feedback" id="where">
                        {{ $message }}
                    </div>    
                @enderror

                {{-- Button Group --}}
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <a href="{{ route('tenants.index') }}" type="reset" class="btn btn-dark">Cancel</a>
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>