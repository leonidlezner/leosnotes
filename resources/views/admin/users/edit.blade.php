@extends('admin.layouts.app')

@section('title', 'Edit User "' . $item->name . '"')

@section('content')
    @include('admin.users.form', ['item' => $item])
@endsection