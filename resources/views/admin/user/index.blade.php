@extends('admin.layouts.layouts')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card bg-dark text-light">
                        <div
                            class="card-header d-flex justify-content-between align-items-center gap-1 bg-secondary text-white">
                            <h4 class="card-title flex-grow-1">All Users List</h4>
                            <a href="{{route ('users.create')}}" class="btn btn-sm btn-primary">
                                Add User
                            </a>
                        </div>

                        <div class="card-body">
                            <!-- Responsive Table Wrapper -->
                            <div class="table-responsive">
                                <table id="userTable" class="table table-bordered table-hover text-light">
                                    <thead class="bg-dark-subtle">
                                        <tr class="text-light">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Status Change</th>
                                            <th>Role Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th scope="row" class="text-white">{{ $user->id }}</th>
                                                <td class="text-white">{{ $user->name }}</td>
                                                <td class="text-white">{{ $user->email }}</td>
                                                <td class="text-white">{{ $user->role == 0 ? 'Admin' : 'User' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->status == 1 ? 'success' : 'warning' }}">
                                                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form id="statusUpdate{{ $user->id }}" class="statusUpdateForm"
                                                        data-user-id="{{ $user->id }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-{{ $user->status == 1 ? 'danger' : 'success' }}">
                                                            {{ $user->status == 1 ? 'Deactivate' : 'Activate' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form id="roleUpdateForm{{ $user->id }}" class="roleUpdateForm"
                                                        data-user-id="{{ $user->id }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-{{ $user->role == '0' ? 'danger' : 'success' }}">
                                                            {{ $user->role == '0' ? 'Demote' : 'Promote' }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer border-top">
                            <div id="paginationControls" class="pagination-controls">
                                <!-- Custom pagination HTML -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <style>
        /* Dark theme for table */
        .table {
            background-color: #343a40;
            /* Dark background for table */
        }

        .table th {
            background-color: #495057;
            /* Slightly lighter dark color for headers */
            color: #ffffff;
            /* White text */
        }

        .table td {
            background-color: #343a40;
            /* Keep table cells matching theme */
            color: #ffffff;
            /* White text for readability */
        }

        .badge {
            font-size: 0.9em;
            padding: 0.3em 0.6em;
        }

        .table-hover tbody tr:hover {
            background-color: #495057;
            /* Highlight rows on hover */
        }

        /* Pagination and card footer styling */
        .card-footer {
            background-color: #495057;
            /* Match the card footer with the theme */
            color: #ffffff;
        }

        .pagination-controls {
            margin: 0 auto;
        }
    </style>

    @push('scripts')
        {{-- jQuery and DataTables --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                // Attach the event to all forms with the class 'statusUpdate'
                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy();
                }

                $('#userTable').DataTable({
                    "paging": true, // Enable pagination
                    "searching": true, // Enable search bar
                    "ordering": true, // Enable column sorting
                    "info": true, // Show table info (e.g., "Showing 1 to 10 of 20 entries")
                    "autoWidth": false, // Prevent auto column width
                    "responsive": true
                });

                $('.statusUpdateForm').on('click', 'button', function(e) {
                    e.preventDefault();

                    var form = $(this).closest('form'); // Get the closest form element
                    var userId = form.data('user-id'); // Get the user ID from the data attribute

                    var url = "{{ route('user.toggleStatus', ':id') }}".replace(':id', userId);
                    var formData = form.serialize(); // Serialize form data

                    $.ajax({
                        url: url, // The dynamic URL based on the user ID
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // If status is successfully updated, show success message
                            if (response.status === 'success') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000
                                }).showToast();
                                location.reload();
                                // Update button and status badge
                                var button = form.find('button');
                                var badge = form.closest('tr').find('.badge');
                                // Toggle button text and colors
                                if (response.data.newStatus === 1) {
                                    button.removeClass('btn-success').addClass('btn-danger').text(
                                        'Deactivate');
                                    badge.removeClass('bg-warning').addClass('bg-success').text(
                                        'Active');
                                    console.log("hello");
                                }
                                if (response.data.newStatus === 0) {
                                    button.removeClass('btn-danger').addClass('btn-success').text(
                                        'Activate');
                                    badge.removeClass('bg-success').addClass('bg-warning').text(
                                        'Inactive');
                                }
                            }
                        },
                        error: function(xhr) {
                            // Handle errors
                            var errors = xhr.responseJSON
                                .errors; // Assuming errors are in 'errors' object
                            var errorMessages = '';
                            console.log("hello");

                            // Loop through errors and append them
                            for (var field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessages += errors[field][0] +
                                        '\n'; // Collect all error messages
                                }
                            }

                            // Show error messages in a Toastify popup
                            Toastify({
                                text: errorMessages.trim(),
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    });
                });
            });
            $(document).ready(function() {
                // Attach the event to all forms with the class 'statusUpdate'
                $('.roleUpdateForm').on('click', 'button', function(e) {
                    e.preventDefault();

                    var form = $(this).closest('form'); // Get the closest form element
                    var userId = form.data('user-id'); // Get the user ID from the data attribute

                    var url = "{{ route('user.togglerole', ':id') }}".replace(':id', userId);
                    var formData = form.serialize(); // Serialize form data

                    $.ajax({
                        url: url, // The dynamic URL based on the user ID
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // If status is successfully updated, show success message
                            if (response.status === 'success') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000
                                }).showToast();
                                location.reload();
                                // Update button and status badge
                                var button = form.find('button');
                                // Toggle button text and colors

                                if (response.data.newRole === '1') {
                                    console.log("helawd");
                                    button.removeClass('btn-success').addClass('btn-danger').text(
                                        'Demote');
                                }
                                if (response.data.newRole === '0') {
                                    button.removeClass('btn-danger').addClass('btn-success').text(
                                        'Promote');
                                }
                                var roleColumn = form.closest('tr').find(
                                    'td:nth-child(4)'); // 4th <td> for role
                                roleColumn.text(response.data.newRole === '1' ? 'Admin' : 'User');
                            }
                        },
                        error: function(xhr) {
                            // Handle errors
                            var errors = xhr.responseJSON
                                .errors; // Assuming errors are in 'errors' object
                            var errorMessages = '';
                            console.log("hello");

                            // Loop through errors and append them
                            for (var field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessages += errors[field][0] +
                                        '\n'; // Collect all error messages
                                }
                            }

                            // Show error messages in a Toastify popup
                            Toastify({
                                text: errorMessages.trim(),
                                backgroundColor: "red",
                                duration: 5000
                            }).showToast();
                        }
                    });
                });
            });
        </script>
        <!-- End Container Fluid -->
    @endpush
@endsection
