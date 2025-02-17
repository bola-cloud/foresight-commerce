@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card p-4">
        <h1 class="mb-3">{{ __('lang.messages_list') }}</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>{{ __('lang.name') }}</th>
                    <th>{{ __('lang.email') }}</th>
                    <th>{{ __('lang.message') }}</th>
                    <th>{{ __('lang.status') }}</th>
                    <th>{{ __('lang.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                <tr>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ Str::limit($message->message, 50) }}</td>
                    <td>
                        <span class="badge {{ $message->is_read ? 'bg-success' : 'bg-warning' }}">
                            {{ $message->is_read ? __('lang.read') : __('lang.unread') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-info btn-sm">{{ __('lang.view') }}</a>
                        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('lang.confirm_delete') }}')">{{ __('lang.delete') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $messages->links() }}
    </div>
</div>
@endsection
