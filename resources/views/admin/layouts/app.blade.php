@include('admin.inc.header')

<main class="py-4">
    <div class="container">
        @include('admin.inc.messages')
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a class="list-group-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="list-group-item" href="{{ route('admin.users.index') }}">Users</a>
                </div>
            </div>
            <div class="col-9">
                <h1>@yield('title')</h1>

                @yield('content')
            </div>
        </div>
    </div>
</main>

@include('admin.inc.footer')