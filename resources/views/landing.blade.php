@extends('layouts.app')

@section('content')
    @include('partials.navbar')
    <main class="overflow-x-hidden">
        @include('partials.hero')
        @include('partials.about')
        @include('partials.route')
        @include('partials.facilities')
        @include('partials.registration-flow')
        @include('partials.regulations')
        @include('partials.footer')
    </main>
@endsection
