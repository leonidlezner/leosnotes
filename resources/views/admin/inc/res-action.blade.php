<div class="res-action" role="group">
    <a href="{{ route($route_prefix.'edit', ['id' => $item->id]) }}" class="edit btn btn-secondary">Edit</a>

    {!! Form::open(['route' => [$route_prefix.'destroy', 'id' => $item->id], 'class' => 'd-inline-block']) !!}
        {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::submit('Delete', ['class' => 'delete btn btn-danger confirm']) }}
    {!! Form::close() !!}
</div>