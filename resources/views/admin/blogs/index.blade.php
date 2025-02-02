@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px; border-radius: 10px 10px 0 0;">
            <h4 class="card-title flex-grow-1">All Blogs List</h4>
            <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-primary">
                Add Blog
            </a>
        </div>

        <!-- Add margin-top to create space between header and table -->
        <table id="blogTable" class="table  text-white"
            style="background-color: #3f424c; border-radius: 10px; margin-top: 20px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Blog Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @foreach ($blogs as $blog)
                    <tr class="text-white">
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>
                            @if ($blog->blogDetails && $blog->blogDetails->cover_image)
                                <img src="{{ asset('storage/' . $blog->blogDetails->cover_image) }}"
                                    alt="{{ $blog->title }}"
                                    style="width: 100px; height: 70px; object-fit: cover; border-radius: 5px;" />
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>{{ $blog->status == '1' ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($blog->status === '1')
                                        <li>
                                            <a href="{{ route('blogs.edit', ['id' => $blog->id]) }}" class="dropdown-item">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item change-status" data-id="{{ $blog->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Mark as Inactive
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item destroy" data-id="{{ $blog->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Destroy
                                            </button>
                                        </li>
                                    @else
                                        <li>
                                            <button class="dropdown-item change-status" data-id="{{ $blog->id }}"
                                                data-status="1">
                                                <i class="fas fa-toggle-on"></i> Mark as Active
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item destroy" data-id="{{ $blog->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Destroy
                                            </button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
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
            // Initialize DataTable
            $('#blogTable').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search bar
                "ordering": true, // Enable column sorting
                "info": true, // Show table info (e.g., "Showing 1 to 10 of 20 entries")
                "autoWidth": false, // Prevent auto column width
                "responsive": true,
                "language": {
                    "search": "Search:", // Customize search bar label
                    "lengthMenu": "Show _MENU_ entries", // Customize the length menu label
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries", // Customize table info
                }
            });

            // Initialize Bootstrap dropdown
            $(document).on('click', '.dropdown-toggle', function(e) {
                var $el = $(this).next('.dropdown-menu');
                var isVisible = $el.is(':visible');
                if (!isVisible) {
                    $(this).dropdown('toggle');
                }
                e.stopPropagation();
            });

            // Change status logic
            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();

                const button = $(this);
                const id = button.data('id'); // Get the blog ID
                const newStatus = button.data('status'); // Get the new status
                const url = "{{ route('blogs.status', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: newStatus
                    },

                    success: function(response) {
                        if (response.status === 'success') {
                            // Show success toast
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();

                            // Update the status column dynamically
                            const row = button.closest(
                                'tr'); // Find the closest row to the button
                            const statusCell = row.find(
                                'td:nth-child(4)'); // Find the status cell

                            // Update the status text and button dynamically
                            if (newStatus == 1) {
                                statusCell.text('Active');
                                button.data('status', 0); // Update button data-status
                            } else {
                                statusCell.text('Inactive');
                                button.data('status', 1);
                            }

                            // Update the dropdown menu for Actions
                            const actionsDropdown = row.find('.dropdown-menu');
                            if (newStatus == 1) {
                                actionsDropdown.html(`
                                    <li>
                                        <a href="{{ route('blogs.edit', ['id' => $blog->id]) }}" class="dropdown-item">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item change-status" data-id="${button.data('id')}" data-status="0">
                                            <i class="fas fa-toggle-off"></i> Mark as Inactive
                                        </button>
                                    </li>
                                    <li>
                                            <button class="dropdown-item destroy" data-id="{{ $blog->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Destroy
                                            </button>
                                        </li>
                                `);
                            } else {
                                actionsDropdown.html(`
                                    <li>
                                        <button class="dropdown-item change-status" data-id="${button.data('id')}" data-status="1">
                                            <i class="fas fa-toggle-on"></i> Mark as Active
                                        </button>
                                    </li>
                                    <li>
                                            <button class="dropdown-item destroy" data-id="{{ $blog->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Destroy
                                            </button>
                                        </li>
                                `);
                            }
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

            setupDestroyHandler('Blog', "{{ route('blogs.destroy', ':id') }}");

        });
    </script>
@endpush
