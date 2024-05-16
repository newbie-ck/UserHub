@extends('layouts.app')

@section('content')
    <user-detail :user="{{ json_encode($user) }}"></user-detail>
@endsection