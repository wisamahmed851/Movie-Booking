@extends('admin.layouts.layouts')

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card bg-dark text-light">
                        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
                            style="background-color: #3f424c; padding-top: 25px; border-radius: 10px 10px 0 0;">
                            <h4 class="card-title flex-grow-1">All Users List</h4>
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                                Add User
                            </a>
                        </div>

                        <div class="card-body">
                            <!-- Responsive Table Wrapper -->
                            <div class="table-responsive">
                                <table id="userTable" class="table table-striped"
                                    style="background-color: #3f424c; border-radius: 10px; margin-top: 20px;">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th> <!-- Consolidated Actions -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th scope="row">{{ $user->id }}</th>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role == 0 ? 'Admin' : 'User' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->status == 1 ? 'success' : 'warning' }}">
                                                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-sm btn-secondary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <!-- Edit -->
                                                            {{-- <li>
                                                                <a href="{{ route('users.edit', ['id' => $user->id]) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            </li> --}}
                                                            <!-- Toggle Status -->
                                                            <li>
                                                                <button class="dropdown-item change-status"
                                                                    data-id="{{ $user->id }}"
                                                                    data-status="{{ $user->status == 1 ? 0 : 1 }}">
                                                                    <i
                                                                        class="fas {{ $user->status == 1 ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                                    {{ $user->status == 1 ? 'Mark as Inactive' : 'Mark as Active' }}
                                                                </button>
                                                            </li>
                                                            <!-- Toggle Role -->
                                                            <li>
                                                                <button class="dropdown-item change-role"
                                                                    data-id="{{ $user->id }}"
                                                                    data-role="{{ $user->role == 0 ? 1 : 0 }}">
                                                                    <i
                                                                        class="fas {{ $user->role == 0 ? 'fa-user' : 'fa-user-shield' }}"></i>
                                                                    {{ $user->role == 0 ? 'Demote to User' : 'Promote to Admin' }}
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
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
                // Initialize DataTable for the userTable
                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy();
                }
                $('#userTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: true,
                    language: {
                        search: "Search:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    },
                });

                // Change Status Logic
                $(document).on('click', '.change-status', function(e) {
                    e.preventDefault();
                    const button = $(this);
                    const userId = button.data('id');
                    const newStatus = button.data('status');
                    const url = "{{ route('user.toggleStatus', ':id') }}".replace(':id', userId);

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: newStatus,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000,
                                }).showToast();
                                const row = button.closest('tr');
                                const statusBadge = row.find('td:nth-child(5) .badge');
                                statusBadge
                                    .removeClass(newStatus == 1 ? 'bg-warning' : 'bg-success')
                                    .addClass(newStatus == 1 ? 'bg-success' : 'bg-warning')
                                    .text(newStatus == 1 ? 'Active' : 'Inactive');

                                button.data('status', newStatus == 1 ? 0 : 1);
                                button.html(`
                        <i class="fas ${newStatus == 1 ? 'fa-toggle-off' : 'fa-toggle-on'}"></i>
                        ${newStatus == 1 ? 'Mark as Inactive' : 'Mark as Active'}
                    `);
                            }
                        },
                        error: function() {
                            Toastify({
                                text: 'Failed to update status',
                                backgroundColor: "red",
                                duration: 3000,
                            }).showToast();
                        },
                    });
                });

                // Change Role Logic
                $(document).on('click', '.change-role', function(e) {
                    e.preventDefault();
                    const button = $(this);
                    const userId = button.data('id');
                    const newRole = button.data('role');
                    const url = "{{ route('user.togglerole', ':id') }}".replace(':id', userId);

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            role: newRole,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Toastify({
                                    text: response.message,
                                    backgroundColor: "green",
                                    duration: 3000,
                                }).showToast();
                                const row = button.closest('tr');
                                const roleCell = row.find('td:nth-child(4)');
                                roleCell.text(newRole == 0 ? 'Admin' : 'User');

                                button.data('role', newRole == 0 ? 1 : 0);
                                button.html(`
                        <i class="fas ${newRole == 0 ? 'fa-user' : 'fa-user-shield'}"></i>
                        ${newRole == 0 ? 'Promote to User' : 'Demote to Admin'}
                    `);
                            }
                        },
                        error: function() {
                            Toastify({
                                text: 'Failed to update role',
                                backgroundColor: "red",
                                duration: 3000,
                            }).showToast();
                        },
                    });
                });
            });
        </script>
        <!-- End Container Fluid -->
    @endpush
@endsection
