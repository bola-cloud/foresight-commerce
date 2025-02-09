@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card p-4">
        <h1>{{ __('lang.create_user') }}</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('lang.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('lang.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('lang.password') }}</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">{{ __('lang.category') }}</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="admin">{{ __('lang.admin') }}</option>
                    <option value="user">{{ __('lang.user') }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">{{ __('lang.save') }}</button>
        </form>
    </div>
</div>
@endsection
