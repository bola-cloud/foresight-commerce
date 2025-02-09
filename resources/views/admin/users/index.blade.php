@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card p-4">
        <div class="card-header d-flex justify-content-between">
            <h1 class="mb-3">{{ __('lang.user_management') }}</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">{{ __('lang.create_user') }}</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('lang.name') }}</th>
                    <th>{{ __('lang.email') }}</th>
                    <th>{{ __('lang.category') }}</th>
                    <th>{{ __('lang.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->category }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">{{ __('lang.edit') }}</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('lang.confirm_delete') }}')">
                                    {{ __('lang.delete') }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">{{ __('lang.no_users_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
