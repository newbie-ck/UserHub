@extends('layouts.app')

@section('content')
    <div id="app">
        <not-admin-message></not-admin-message>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush