@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="container px-5">
        <div class="row justify-content-between">
            <div class="col-md-8">
                {{-- Logo --}}
                <div class="{{ $auth_type ?? 'login' }}-logo text-left">
                    <a href="{{ $dashboard_url }}">
                        <span class="h1">
                            <img src="{{ asset(config('adminlte.logo_img')) }}" height="50">
                            {!! config('adminlte.logo', '<b>HMS</b>') !!}
                        </span>
                    </a>
                </div>
                <h1 class="display-4 font-weight-bolder text-primary">
                    {{ config('adminlte.title') }}
                </h1>
                <p class="h3">
                    @yield('auth_header')
                </p>
            </div>
            <div class="col-md-4">
                <div class="{{ $auth_type ?? 'login' }}-box">
                
                    {{-- Card Box --}}
                    <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">
                
                        {{-- Card Header --}}
                        @hasSection('auth_header')
                        <!--
                            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                                <h3 class="card-title float-none text-center">
                                    @yield('auth_header')
                                </h3>
                            </div>
                            -->
                        @endif
                
                        {{-- Card Body --}}
                        <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                            @yield('auth_body')
                        </div>
                
                        {{-- Card Footer --}}
                        @hasSection('auth_footer')
                            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                                @yield('auth_footer')
                            </div>
                        @endif
                
                    </div>
                
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
<footer style="position: fixed; bottom: 0; min-width: 100%">
    <div class="p-4 text-center bg-white">
        Made with <i class="fas fa-heart text-danger fa-fw"></i> by <a href="https://github.com/Stonec0der">StoneC0der</a> with <a href="https://adminlte.io">AdminLTE</a>  & <a href="https://laravel.com">Laravel</a>
    </div>    
</footer>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
