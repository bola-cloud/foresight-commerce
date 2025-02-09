@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card p-4">
        <h1>{{ __('lang.edit_user') }}</h1>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('lang.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('lang.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">{{ __('lang.category') }}</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="admin" {{ $user->category === 'admin' ? 'selected' : '' }}>{{ __('lang.admin') }}</option>
                    <option value="user" {{ $user->category === 'user' ? 'selected' : '' }}>{{ __('lang.user') }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('lang.password') }}</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('lang.leave_blank_if_not_changing') }}">
            </div>

            <button type="submit" class="btn btn-success">{{ __('lang.update') }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('lang.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
