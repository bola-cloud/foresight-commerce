@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('lang.category_list') }}</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">{{ __('lang.add_category') }}</button>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Category Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('lang.ar_category_name') }}</th>
                <th>{{ __('lang.en_category_name') }}</th>
                <th>{{ __('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody id="categories-sortable">
            @foreach ($categories as $category)
                <tr data-id="{{ $category->id }}" style="cursor:move;">
                    <td>{{ $category->ar_name }}</td>
                    <td>{{ $category->en_name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                            {{ __('lang.edit') }}
                        </button>
                        <button class="btn btn-secondary btn-sm move-to-top" data-id="{{ $category->id }}">{{ __('lang.move_to_top') }}</button>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('lang.confirm_delete') }}')">
                                {{ __('lang.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Category Modal -->
                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">{{ __('lang.edit_category') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="ar_name" class="form-label">{{ __('lang.ar_name') }}</label>
                                        <input type="text" name="ar_name" class="form-control" value="{{ $category->ar_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="en_name" class="form-label">{{ __('lang.en_name') }}</label>
                                        <input type="text" name="en_name" class="form-control" value="{{ $category->en_name }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('lang.submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">{{ __('lang.add_category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ar_name" class="form-label">{{ __('lang.ar_name') }}</label>
                            <input type="text" name="ar_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="en_name" class="form-label">{{ __('lang.en_name') }}</label>
                            <input type="text" name="en_name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('lang.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('categories-sortable');
        if (!el) return;

        const sortable = new Sortable(el, {
            animation: 150,
            handle: 'td',
            onEnd: function () {
                // collect ordered ids
                const ids = Array.from(el.querySelectorAll('tr')).map(r => r.getAttribute('data-id'));
                fetch("{{ route('admin.categories.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: ids })
                }).then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                }).then(data => {
                    // optionally show a toast / message
                    console.log(data.message || 'Order saved');
                }).catch(err => {
                    console.error('Failed to save order', err);
                    alert('Failed to save order');
                });
            }
        });
    });

    // Move to top handler
    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('move-to-top')) return;
        e.preventDefault();
        var id = e.target.getAttribute('data-id');
        if (!confirm('Move this category to the top of the list?')) return;

        fetch("{{ route('admin.categories.move') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, position: 1 })
        }).then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            location.reload();
        }).catch(err => {
            console.error('Failed to move category', err);
            alert('Failed to move category');
        });
    });
</script>
@endpush
