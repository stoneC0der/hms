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
                                    <tr class="@if ($rent->expires_in == 0) bg-danger @elseif ($rent->expires_in < 5) bg-warning @endif">
                                        <td scope="row">{{ $rent->id }}</td>
                                        <td>{{ $rent->room->room_number }}</td>
                                        <td>{{ $rent->tenant->full_name }}</td>
                                        <td>{{ $rent->duration . ' month(s)' }}</td>
                                        <td>{{ $rent->from }}</td>
                                        <td>{{ $rent->to }}</td>
                                        <td>
                                            {{ 
                                                ($rent->expires_in > 0 ) ? $rent->expires_in . 
                                                ' days' : 'expired' 
                                            }} 
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

@push('js')
    <script>
        (function () {
            'use strict';
            window.addEventListener('DOMContentLoaded', (e) => {
                let room_type = document.getElementById('room_type');
                let duration = document.getElementById('duration');
                // display total to pay
                calculateTotalPriceOfRent(room_type, duration);

                /**
                 * 
                 * @param method The request method (POST,PUT,PATCH,GET,DELETE)
                 * @param url The route/path to file/action
                 * @param data Optional, The data to be process
                 */
                function ajax (method, url, data, async = true) {
                    data = JSON.stringify(data);
                    let xCsrfToken = document.getElementsByName('csrf-token')[0].content;
                    const xhr = new XMLHttpRequest;
                    xhr.open(method, url, async);
                    xhr.onreadystatechange = () => {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            status = xhr.status;
                            if (status >= 200 && status < 400) {
                                let rooms = JSON.parse(xhr.responseText).data;
                                displayAvailableRooms(rooms);
                            }else if (status == 412) {
                                const errors = JSON.parse(xhr.responseText).data.errors
                                showErrorMessages(errors);
                            }else if (status == 400) {
                                const error_message = JSON.parse(xhr.responseText).data.message;
                                window.alert(error_message)
                                // console.log('An error has occured!', error_message);
                            } else {
                                window.alert('Server error!');
                            }
                        }
                    };
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', xCsrfToken);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.send(data);
                }
                /**
                 * Calculate price of rent based on duration
                 * 
                 * @param mixed room_type The price
                 * @param mixed duration The number of month(s)
                 * 
                 * @return void
                 */
                function calculateTotalPriceOfRent (room_type, duration) {
                    let total_amount = document.getElementById('amount');

                    room_type.addEventListener('change', (event) => {
                        // console.log(room_type.value * duration.value);
                        const method = 'post',
                            url = '/admin/rent/available-rooms',
                            data = {
                                room_price : event.target.value,
                                room_id : room_type.dataset.bookedroomid
                            };
                        if (room_type.value == 0) {
                            return clearErrorMessages();
                        }
                        ajax(method, url, data, true);
                        if (duration.value == 0) {
                            total_amount.value = 0;
                            return;
                        }
                        total_amount.value = room_type.value * duration.value;
                    });
                    duration.addEventListener('focusout', (event) => {
                        // console.log(room_type.value * duration.value);
                        total_amount.value = room_type.value * duration.value;
                        if (duration == undefined) {
                            return;
                        }
                        total_amount.value = room_type.value * duration.value;
                    });
                }

                function displayAvailableRooms(rooms) {
                    clearErrorMessages();
                    const available_rooms = rooms.rooms;
                    let html = '<option value="" selected>--Select room type--</span>';
                    for (const room in available_rooms) {
                            html += `<option value="${room}">${available_rooms[room]}</span>`;
                    }
                    const select_rooms = document.getElementById('room_id');
                    select_rooms.innerHTML = html;
                    // console.log(rooms.message, html,rooms,rooms.rooms);
                }

                function showErrorMessages(errors) {
                    for(const error in errors) {
                        const error_output = document.getElementById(`${error}Error`);
                        error_output.innerText = errors[error];
                        // console.log('An error has occured!', `${error} : ${errors[error]}`);
                    }
                }
                function clearErrorMessages() {
                    const room_typeError = document.getElementById('room_typeError').innerText = '';
                    const room_idError = document.getElementById('room_idError').innerText = '';
                }

                // function fetchAvailableRooms (method,url,data) {
                //     const request_method = '',
                //         reques_url = '',
                //         request_data = ''; 
                //     if (typeof(method) == 'string' && method.length < 6) {
                //         request_method = method;
                //     }
                //     if (typeof(url) == 'string' && url.length < 6) {
                //         request_url = url;
                //     }
                //     if (typeof(data) == 'object' && data.length < 6) {
                //         request_data = data;
                //     }
                //     fetch(reques_url, {
                //         method : request_method,
                //         body : JSON.stringify(request_data)
                //     }).then(response => {
                //         let rooms = JSON.parse(response).data;
                //         const available_rooms = rooms.rooms;
                //         let html = '<option value="" selected>--Select room type--</span>';
                //         for (const room in available_rooms) {
                //             html += `<option value="${room}">${available_rooms[room]}</span>`;
                //         }
                //         const select_rooms = document.getElementById('room_id');
                //         select_rooms.innerHTML = html;
                //     });

                // }
            });
        })();
    </script>
@endpush