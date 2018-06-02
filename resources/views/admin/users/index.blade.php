@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <div class="crud-navbar pt-2 pb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">New user</a>
    </div>

    @if(count($items) > 0)

    @include('admin.inc.pagination')

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        
        @foreach($items as $item)
        <tr class="item-{{ $item->id }}">
            <td class="align-middle">{{ $item->id }}</td>
            <td class="align-middle"><a href="{{ route('admin.users.show', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
            <td>@include('admin.inc.res-action', ['item' => $item, 'route_prefix' => 'admin.users.'])</td>
        </tr>
        @endforeach
    </table>
    
    @include('admin.inc.pagination')

    @else
        <p>No users were found</p>
    @endif
@endsection