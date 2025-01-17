@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <table id="genreTable" class="table table-striped">
            <thead class="bg-light-subtle">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated via AJAX -->
                @foreach ($genres as $genre)
                    <tr>
                        <th scope="row">{{ $genre->id }}</th>
                        <td>{{ $genre->name }}</td>
                        <td>{{ $genre->status == 1 ? 'Active' : 'InActive' }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('genres.edit', $genre->id) }}" class="dropdown-item">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        @if ($genre->status === 1)
                                            <button class="dropdown-item change-status" data-id="{{ $genre->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Mark as Inactive
                                            </button>
                                        @else
                                            <button class="dropdown-item change-status" data-id="{{ $genre->id }}"
                                                data-status="1">
                                                <i class="fas fa-toggle-on"></i> Mark as Active
                                            </button>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </td>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <!-- jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


    <script>
       $(document).ready(function() {
    // Initialize Bootstrap dropdown
    $(document).on('click', '.dropdown-toggle', function (e) {
        var $el = $(this).next('.dropdown-menu');
        var isVisible = $el.is(':visible');
        if (!isVisible) {
            $(this).dropdown('toggle');
        }
        // Prevent the dropdown from closing immediately
        e.stopPropagation();
    });

    // Change status logic
    $(document).on('click', '.change-status', function (e) {
        e.preventDefault();

        const button = $(this);
        const id = button.data('id'); // Get the genre ID
        const newStatus = button.data('status'); // Get the new status

        const url = "{{ route('genres.status', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },

            success: function(response) {
                if (response.status === 'success') {
                    Toastify({
                        text: response.message,
                        backgroundColor: "green",
                        duration: 3000
                    }).showToast();
                    window.location.reload();
                } else {
                    Toastify({
                        text: response.message,
                        backgroundColor: "red",
                        duration: 3000
                    }).showToast();
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors || ['An error occurred.'];
                const errorMessages = Object.values(errors).join('\n');

                Toastify({
                    text: errorMessages,
                    backgroundColor: "red",
                    duration: 5000
                }).showToast();
            }
        });
    });
});

    </script>
@endpush
