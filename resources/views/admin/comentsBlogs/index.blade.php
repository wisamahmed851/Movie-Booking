@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-1 text-white"
            style="background-color: #3f424c; padding-top: 25px; border-radius: 10px 10px 0 0;">
            <h4 class="card-title flex-grow-1">All Coments List</h4>
            <a href="{{ route('comments.create') }}" class="btn btn-sm btn-primary">
                Add Comment
            </a>
        </div>
        <div class="filter-container"
            style="margin-top: 20px; background-color: #3f424c; padding: 10px; border-radius: 10px;">
            <label for="blogFilter" style="color: white;">Select Blog:</label>
            <select id="blogFilter"
                style="width: 200px; margin-left: 10px; padding: 5px; border-radius: 5px; background-color: #4f545b; color: white; border: 1px solid #6c757d;">
                <option value="">Select a Blog</option>
                @foreach ($blogs as $blog)
                    <option value="{{ $blog->id }}">{{ $blog->title }}</option>
                @endforeach
            </select>
        </div>
        <table id="commentsTable" class="table" style="background-color: #3f424c; border-radius: 10px; margin-top: 20px;">
            <thead class="bg-light-subtle">
                <tr>
                    <th>#</th>
                    <th>Blog</th>
                    <th>Email</th>
                    <th>Coment</th>
                    <th>Status</th>
                    <th>Approve</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ComentBlogs as $ComentBlog)
                    <tr>
                        <th scope="row">{{ $ComentBlog->id }}</th>
                        <td class="truncate-text">{{ $ComentBlog->blog->title ?? 'No Blog Title' }}</td>
                        <!-- Show blog title -->
                        <td>{{ $ComentBlog->email }}</td>
                        <td class="truncate-text">{{ $ComentBlog->coment }}</td>
                        <td>{{ $ComentBlog->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $ComentBlog->approved == 1 ? 'Approved' : 'Unapproved' }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    @if ($ComentBlog->status === 1)
                                        <li>
                                            <a href="{{ route('comments.edit', ['id' => $ComentBlog->id]) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item change-status" data-id="{{ $ComentBlog->id }}"
                                                data-status="0">
                                                <i class="fas fa-toggle-off"></i> Mark as Inactive
                                            </button>
                                        </li>
                                    @else
                                        <li>
                                            <button class="dropdown-item change-status" data-id="{{ $ComentBlog->id }}"
                                                data-status="1">
                                                <i class="fas fa-toggle-on"></i> Mark as Active
                                            </button>
                                        </li>
                                    @endif
                                    <li>
                                        <button class="dropdown-item view-details" data-id="{{ $ComentBlog->id }}">
                                            <i class="fas fa-eye"></i> View Details
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No comments found.</td>
                    </tr>
                @endforelse

            </tbody>

        </table>
    </div>


    <!-- Comment Details Modal -->
    <!-- Comment Details Modal -->
    <div class="modal fade" id="commentDetailsModal" tabindex="-1" aria-labelledby="commentDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-gray-800 text-white rounded-2xl shadow-lg">
                <div class="modal-header border-b border-gray-700">
                    <h5 class="modal-title font-bold text-xl" id="commentDetailsModalLabel">Comment Details</h5>
                    <button type="button" class="btn-close text-white bg-gray-700 hover:bg-gray-600 rounded-full p-2"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3"><strong class="text-gray-400">Name:</strong> <span id="commentName"></span></p>
                    <p class="mb-3"><strong class="text-gray-400">Email:</strong> <span id="commentEmail"></span></p>
                    <p class="mb-3"><strong class="text-gray-400">Blog Title:</strong> <span id="blogTitle"></span></p>
                    <p class="mb-3"><strong class="text-gray-400">Message:</strong> <span id="commentMessage"></span></p>
                </div>
                <div class="modal-footer border-t border-gray-700">
                    <button type="button" class="btn bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 approve-comment"
                        data-id="">Approve</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .truncate-text {
            max-width: 120px;
            /* Set a max width for the cell */
            white-space: nowrap;
            /* Prevent text from wrapping */
            overflow: hidden;
            /* Hide overflowed text */
            text-overflow: ellipsis;
            /* Add ellipsis (...) for overflowed text */
        }

        .modal-content {
            background-color: #2d2f36;
            /* Dark background */
            color: #fff;
            /* Light text */
            border-radius: 1rem;
            /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            /* Soft shadow */
        }

        .modal-header,
        .modal-footer {
            border-color: #3a3d45;
            /* Subtle border for header and footer */
        }

        .btn-close {
            background-color: #3a3d45;
            border: none;
            padding: 0.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-close i {
            font-size: 1.2rem;
        }

        .btn:hover {
            opacity: 0.9;
            /* Slight hover effect */
        }

        .modal-footer .btn {
            transition: background-color 0.2s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <!-- jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function() {
            // Attach the event to all forms with the class 'statusUpdate'
            if ($.fn.DataTable.isDataTable('#commentsTable')) {
                $('#commentsTable').DataTable().destroy();
            }

            var table = $('#commentsTable').DataTable({
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
            // Filter comments by selected blog
            $('#blogFilter').on('change', function() {
                let filters = {
                    blogId: $(this).val(),
                };

                $.ajax({
                    url: '{{ route('comments.index') }}',
                    method: 'GET',
                    data: filters,
                    success: function(response) {
                        if (response.status === 'success') {
                            // Replace the table body with new rows
                            $('#commentsTable tbody').html(response.rowsHtml);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    },
                });
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
                const url = "{{ route('comments.status', ':id') }}".replace(':id', id);

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
                                'td:nth-child(4)'); // Find the status cell (3rd column)

                            // Update the status text and button dynamically
                            if (newStatus == 1) {
                                statusCell.text('Active'); // Update status text
                                button.data('status', 0); // Update button data-status

                            } else {
                                statusCell.text('InActive'); // Update status text
                                button.data('status', 1); // Update button data-status

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
                           <li>
                                        <button class="dropdown-item view-details" data-id="{{ $ComentBlog->id }}">
                                            <i class="fas fa-eye"></i> View Details
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
                                        <button class="dropdown-item view-details" data-id="{{ $ComentBlog->id }}">
                                            <i class="fas fa-eye"></i> View Details
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

            $(document).on('click', '.view-details', function() {
                const commentId = $(this).data('id');

                // Fetch comment details via AJAX
                $.ajax({
                    url: "{{ route('comments.show', ':id') }}".replace(':id', commentId),
                    type: "GET",
                    success: function(response) {
                        if (response.status === 'success') {
                            const comment = response.data.comment;
                            const blog = response.data.blog;

                            // Update modal fields
                            $('#commentName').text(comment.name);
                            $('#commentEmail').text(comment.email);
                            $('#blogTitle').text(blog ? blog.title : 'N/A');
                            $('#commentMessage').text(comment.coment);

                            // Set button text based on approval status
                            const approveButton = $('.approve-comment');
                            approveButton.text(comment.approved ? 'Unapprove' : 'Approve');
                            approveButton.data('id', comment.id);

                            // Show the modal
                            $('#commentDetailsModal').modal('show');
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Failed to fetch comment details.",
                            backgroundColor: "red",
                            duration: 3000
                        }).showToast();
                    }
                });
            });

            $(document).on('click', '.approve-comment', function() {
                const button = $(this);
                const commentId = button.data('id'); // Get the comment ID
                const newStatus = button.data('approved'); // Get the new approval status

                // Approve/Unapprove comment via AJAX
                $.ajax({
                    url: "{{ route('comments.approve', ':id') }}".replace(':id', commentId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Toastify({
                                text: response.message,
                                backgroundColor: "green",
                                duration: 3000
                            }).showToast();

                            // Find the closest table row
                            const row = button.closest('tr');

                            // Update the Approved column dynamically
                            const approvedCell = row.find('td:nth-child(5)');
                            if (newApprove == 1) {
                                statusCell.text('Active'); // Update status text
                                button.data('status', 0); // Update button data-status

                            } else {
                                statusCell.text('InActive'); // Update status text
                                button.data('status', 1); // Update button data-status

                            }

                            // Optionally hide the modal
                            $('#commentDetailsModal').modal('hide');
                        }
                    },
                    error: function() {
                        Toastify({
                            text: "Failed to approve/unapprove comment.",
                            backgroundColor: "red",
                            duration: 3000
                        }).showToast();
                    }
                });
            });




        });
    </script>
@endpush
