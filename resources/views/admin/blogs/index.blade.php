@extends('layouts.admin')

@section('content')
<div class="card p-3">
    <div class="card-header d-flex justify-content-between">
        <h1>{{ __('lang.blog_list') }}</h1>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">{{ __('lang.add_blog') }}</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('lang.image') }}</th>
                <th>{{ __('lang.ar_title') }}</th>
                <th>{{ __('lang.en_title') }}</th>
                <th>{{ __('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody id="blogs-tbody">
            @foreach ($blogs as $blog)
                <tr data-id="{{ $blog->id }}">
                    <td>
                        @if ($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->en_title }}" class="img-thumbnail" width="100">
                        @else
                            <span>{{ __('lang.no_image') }}</span>
                        @endif
                    </td>
                    <td>{{ $blog->ar_title }}</td>
                    <td>{{ $blog->en_title }}</td>
                    <td>
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning btn-sm">{{ __('lang.edit') }}</a>
                        <button class="btn btn-secondary btn-sm move-to-top" data-id="{{ $blog->id }}">{{ __('lang.move_to_top') }}</button>
                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('lang.confirm_delete') }}')">{{ __('lang.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $blogs->links() !!}
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    $(function() {
        try {
            var el = document.getElementById('blogs-tbody');
            if (el) {
                new Sortable(el, {
                    animation: 150,
                    onEnd: function () {
                        var ids = [];
                        $('#blogs-tbody tr').each(function() {
                            ids.push($(this).data('id'));
                        });

                        $.ajax({
                            url: '{{ route('admin.blogs.reorder') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: ids,
                                page: {{ $blogs->currentPage() }},
                                per_page: {{ $blogs->perPage() }}
                            },
                            success: function(res) {},
                            error: function() { alert('Failed to save blog order.'); }
                        });
                    }
                });
            }
        } catch (e) { console.error('Sortable init error', e); }
    });

    // Move to top handler
    $(document).on('click', '.move-to-top', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!confirm('Move this blog to the top of the list?')) return;

        $.ajax({
            url: '{{ route('admin.blogs.move') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                position: 1
            },
            success: function() { location.reload(); },
            error: function() { alert('Failed to move blog.'); }
        });
    });
</script>
@endpush
