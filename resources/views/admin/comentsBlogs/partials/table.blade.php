@forelse ($ComentBlogs as $ComentBlog)
    <tr>
        <th scope="row">{{ $ComentBlog->id }}</th>
        <td class="truncate-text">{{ $ComentBlog->blog->title ?? 'No Blog Title' }}</td> <!-- Show blog title -->
        <td>{{ $ComentBlog->name }}</td>
        <td>{{ $ComentBlog->email }}</td>
        <td>{{ $ComentBlog->status == 1 ? 'Active' : 'Inactive' }}</td>
        <td>{{ $ComentBlog->approved == 1 ? 'Approved' : 'Unapproved' }}</td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu">
                    @if ($ComentBlog->status === 1)
                        <li>
                            <a href="{{ route('comments.edit', ['id' => $ComentBlog->id]) }}" class="dropdown-item">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item change-status" data-id="{{ $ComentBlog->id }}" data-status="0">
                                <i class="fas fa-toggle-off"></i> Mark as Inactive
                            </button>
                        </li>
                    @else
                        <li>
                            <button class="dropdown-item change-status" data-id="{{ $ComentBlog->id }}" data-status="1">
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
