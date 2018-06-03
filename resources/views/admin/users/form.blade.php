@if(isset($item))
    {!! Form::model($item, ['route' => ['admin.users.update', 'id' => $item->id], 'method' => 'put']) !!}
@else
    {!! Form::open(['route' => 'admin.users.store']) !!}
@endif

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'E-Mail') }}
        {{ Form::email('email', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>
    
    @if(isset($item))
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
    @else
        {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
    @endif

    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>

{!! Form::close() !!}