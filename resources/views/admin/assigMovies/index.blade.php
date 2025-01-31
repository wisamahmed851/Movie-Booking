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

        <table id="assignMoviesTable" class="table text-white"
            style="background-color: #3f424c; border-radius: 10px; margin-top: 20px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Movie</th>
                    <th>Cinema Name</th>
                    <th>No of Shows</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @foreach ($assignMovies as $assignMovie)
                    @php
                        $details = $assignMovie->details;
                        $count = $details->count();
                        $startDate = $count ? $details->min('show_date') : null;
                        $endDate = $count ? $details->max('show_date') : null;
                    @endphp
                    <tr class="text-white">
                        <td>{{ $assignMovie->id }}</td>
                        <td>
                            @if($assignMovie->movie->coverImage->cover_image_path)
                                <img src="{{ asset('storage/' . $assignMovie->movie->coverImage->cover_image_path) }}"
                                    alt="" width="50" height="50">
                            @else
                                📷
                            @endif
                            {{ $assignMovie->movie->title }}
                        </td>
                        <td>{{ $assignMovie->cinema->name }}</td>
                        <td>{{ $count }}</td>
                        <td>
                            @if($startDate)
                                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($endDate)
                                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
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
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#assignMoviesTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                }
            });

            // Status change handling
            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();
                const button = $(this);
                const id = button.data('id');
                const newStatus = button.data('status');
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
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();

                            const row = button.closest('tr');
                            const statusCell = row.find('td:nth-child(7)'); // Updated column index

                            // Update status text
                            statusCell.text(newStatus == 1 ? 'Active' : 'Inactive');

                            // Update dropdown menu
                            const actionsDropdown = row.find('.dropdown-menu');
                            if (newStatus == 1) {
                                actionsDropdown.html(`
                                    <li>
                                        <a href="{{ route('assign.movies.edit', ['id' => $assignMovie->id]) }}" class="dropdown-item">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item change-status" data-id="${id}" data-status="0">
                                            <i class="fas fa-toggle-off"></i> Mark as Inactive
                                        </button>
                                    </li>
                                `);
                            } else {
                                actionsDropdown.html(`
                                    <li>
                                        <button class="dropdown-item change-status" data-id="${id}" data-status="1">
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
                        Toastify({
                            text: errors.join('\n'),
                            backgroundColor: "red",
                            duration: 5000
                        }).showToast();
                    }
                });
            });
        });
    </script>
@endpush