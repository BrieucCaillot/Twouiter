@extends('layouts.app')

@section('content')
    <user-component :user-id-connected="{{ Auth::user()->id }}"></user-component>
@endsection