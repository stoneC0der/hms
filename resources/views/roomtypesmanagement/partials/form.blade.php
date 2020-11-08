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
                    {!! Form::text('type', Route::is('roomTypes.edit') ? $room_type->type ?? old('type') : '', ['class' => 'form-control', 'id' => 'type', 'aria-describedby' => 'type', 'placeholder' => 'single,double,tree']) !!}
                </div>
                @error('type')
                    <div class="invalid-feedback" id="type">
                        {{ $message }}
                    </div>    
                @enderror
                <div class="form-group has-feedback @error('price') is-invalid @enderror">
                    {!! Form::label('price', 'Price', ['class' => 'form-control-label']) !!}
                    {!! Form::number('price', Route::is('roomTypes.edit') ? $room_type->price ?? old('price') : '0', ['class' => 'form-control', 'id' => 'price', 'aria-describedby' => 'price', 'step' => 10, 'min' => 0, 'placeholder' => 'Gh¢ 0.00']) !!}
                </div>
                @error('price')
                    <div class="invalid-feedback" id="price">
                        {{ $message }}
                    </div>    
                @enderror
                <div class="custom-control custom-checkbox has-feedback @error('has_internal_bathroom') is-invalid @enderror">
                    {!! Form::checkbox('has_internal_bathroom', '1', ($room_type->has_internal_bathroom ?? old('has_internal_bathroom')) ? 'checked' : null , ['class' => 'custom-control-input', 'id' => 'has_internal_bathroom', 'aria-describedby' => 'has_internal_bathroom']) !!}
                    {!! Form::label('has_internal_bathroom', 'Internal Bathroom', ['class' => 'custom-control-label']) !!}
                    <p class="form-text text-muted small">
                        {{-- TODO:  extra should be editable --}}
                        Internal bathroom add Gh¢30 extra!
                    </p>
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