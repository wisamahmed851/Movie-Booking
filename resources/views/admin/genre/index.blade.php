@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px; border-radius: 10px 10px 0 0;">
            <h4 class="card-title flex-grow-1">All Genre List</h4>
            <a href="{{ route('genres.create') }}" class="btn btn-sm btn-primary">
                Add Genre
            </a>
        </div>
        <table id="genreTable" class="table table-striped text-white"
            style="background-color: #3f424c; border-radius: 10px; margin-top: 20px;">
            <thead>
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
                                    @if ($genre->status === 1)
                                        <li>
                                            <a href="{{ route('genres.edit', ['id' => $genre->id]) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>

                                            <button class="dropdown-item change-status" data-id="{{ $genre->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Mark as Inactive
                                            </button>
                                        </li>
                                    @else
                                        <li>
                                            <button class="dropdown-item change-status" data-id="{{ $genre->id }}"
                                                data-status="1">
                                                <i class="fas fa-toggle-on"></i> Mark as Active
                                            </button>
                                        </li>
                                    @endif
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
            // Attach the event to all forms with the class 'statusUpdate'
            if ($.fn.DataTable.isDataTable('#genreTable')) {
                $('#userTgenreTableable').DataTable().destroy();
            }

            $('#genreTable').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search bar
                "ordering": true, // Enable column sorting
                "info": true, // Show table info (e.g., "Showing 1 to 10 of 20 entries")
                "autoWidth": false, // Prevent auto column width
                "responsive": true
            });
            // Initialize Bootstrap dropdown
            $(document).on('click', '.dropdown-toggle', function(e) {
                var $el = $(this).next('.dropdown-menu');
                var isVisible = $el.is(':visible');
                if (!isVisible) {
                    $(this).dropdown('toggle');
                }
                // Prevent the dropdown from closing immediately
                e.stopPropagation();
            });

            // Change status logic
            $(document).on('click', '.change-status', function(e) {
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
                                'td:nth-child(3)'); // Find the status cell (3rd column)

                            // Update the status text and button dynamically
                            if (newStatus == 1) {
                                statusCell.text('Active'); // Update status text
                                button.data('status', 0); // Update button data-status
                                // Update button text/icon
                            } else {
                                statusCell.text('InActive'); // Update status text
                                button.data('status', 1); // Update button data-status
                                // Update button text/icon
                            }
                            // Update the dropdown menu for Actions
                            const actionsDropdown = row.find(
                                '.dropdown-menu'); // Locate dropdown menu
                            if (newStatus == 1) {
                                actionsDropdown.html(`
                <li>
                    <a href="/movies/edit/${button.data('id')}" class="dropdown-item">
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
