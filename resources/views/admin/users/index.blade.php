@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
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
            <td>{{ $item->id }}</td>
            <td><a href="{{ route('admin.users.show', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
            <td>x</td>
        </tr>
        @endforeach
    </table>
    
    @include('admin.inc.pagination')

    @else
        <p>No items found</p>
    @endif
@endsection