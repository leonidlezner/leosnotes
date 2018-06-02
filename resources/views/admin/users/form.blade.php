@if(isset($item))
    {!! Form::model($item, ['route' => ['admin.users.update', 'id' => $item->id]]) !!}
@else
    {!! Form::open(['route' => 'admin.users.store']) !!}
@endif

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'E-Mail') }}
        {{ Form::text('email', null, ['class' => 'form-control']) }}
    </div>
    
    @if(isset($item))
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
    @else
        {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
    @endif

    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
{!! Form::close() !!}