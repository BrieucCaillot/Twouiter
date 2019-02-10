@extends('layouts.app')

@section('content')
    <profile-component :user-id-connected="{{ Auth::user()->id }}"></profile-component>
@endsection