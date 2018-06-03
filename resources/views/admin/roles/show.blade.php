@extends('admin.layouts.app')

@section('title', $item)

@section('content')
    

    <p>Name: {{ $item->name }}</p>
    <p>Title: {{ $item->title }}</p>

    @include('admin.inc.res-action', ['item' => $item, 'route_prefix' => 'admin.roles.'])
    
@endsection