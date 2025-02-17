@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card p-4">
        <h1 class="mb-3">{{ __('lang.view_message') }}</h1>

        <div class="mb-3">
            <label class="fw-bold">{{ __('lang.contact_form_name_label') }}:</label>
            <p class="form-control">{{ $message->name }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">{{ __('lang.contact_form_email_label') }}:</label>
            <p class="form-control">{{ $message->email }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">{{ __('lang.contact_form_message_label') }}:</label>
            <p class="form-control">{{ $message->message }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-bold">{{ __('lang.status') }}:</label>
            <span class="badge {{ $message->is_read ? 'bg-success' : 'bg-warning' }}">
                {{ $message->is_read ? __('lang.read') : __('lang.unread') }}
            </span>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">{{ __('lang.back_to_list') }}</a>
            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('{{ __('lang.confirm_delete') }}')">
                    {{ __('lang.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
