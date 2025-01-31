@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px; border-radius: 10px 10px 0 0;">
            <h4 class="card-title flex-grow-1">All Assigned Movies</h4>
            <a href="{{ route('assign.movies.create') }}" class="btn btn-sm btn-primary">
                Assign Movie
            </a>
        </div>

        <!-- Add margin-top to create space between header and table -->
        <table id="assignMoviesTable" class="table text-white"
            style="background-color: #3f424c; border-radius: 10px; margin-top: 20px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Movie Name</th>
                    <th>Cinema Name</th>
                    <th>Show Timings</th>
                    <th>Show Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @foreach ($assignMovies as $assignMovie)
                    @foreach ($assignMovie->details as $detail)
                        <tr class="text-white">
                            <td>{{ $assignMovie->id }}</td>
                            <td>{{ $assignMovie->movie->title }}</td>
                            <td>{{ $assignMovie->cinema->name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($detail->cinemaTiming->start_time)->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($detail->cinemaTiming->end_time)->format('g:i A') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($detail->show_date)->format('d M Y') }}</td>
                            <td>{{ $assignMovie->status == 1 ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if ($assignMovie->status === 1)
                                            <li>
                                                <a href="{{ route('assign.movies.edit', ['id' => $assignMovie->id]) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item change-status" data-id="{{ $assignMovie->id }}"
                                                    data-status="0">
                                                    <i class="fas fa-toggle-off"></i> Mark as Inactive
                                                </button>
                                            </li>
                                        @else
                                            <li>
                                                <button class="dropdown-item change-status" data-id="{{ $assignMovie->id }}"
                                                    data-status="1">
                                                    <i class="fas fa-toggle-on"></i> Mark as Active
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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
            $('#assignMoviesTable').DataTable({
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
                const id = button.data('id'); // Get the assigned movie ID
                const newStatus = button.data('status'); // Get the new status
                const url = "{{ route('assign.movies.status', ':id') }}".replace(':id', id);

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
                            'td:nth-child(6)'); // Find the status cell

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
                                        <a href="/assign/movies/edit/${button.data('id')}" class="dropdown-item">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item change-status" data-id="${button.data('id')}" data-status="0">
                                            <i class="fas fa-toggle-off"></i> Mark as Inactive
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
        });
    </script>
@endpush