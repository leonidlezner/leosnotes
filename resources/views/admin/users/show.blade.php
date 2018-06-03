@extends('admin.layouts.app')

@section('title', $item)

@section('content')
    

    <p>Name: {{ $item->name }}</p>
    <p>E-Mail: {{ $item->email }}</p>

    @include('admin.inc.res-action', ['item' => $item, 'route_prefix' => 'admin.users.'])
    
@endsection