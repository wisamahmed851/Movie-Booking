@extends('admin.layouts.layouts')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded p-4">
                    <h4 class="mb-4">Create Languages</h4>
                    <form id="languageCreate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label">Language</label>
                            <input type="text" class="form-control" id="languageName" name="name"
                                placeholder="Enter genre name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Language</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Sign Up End -->
    <script>
      $(document).ready(function() {
          $('#languageCreate').on('submit', function(e) {
              e.preventDefault();
              var formData = $(this).serialize();

              $.ajax({
                  url: '{{ route('languages.store') }}',
                  method: 'POST',
                  data: formData,
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response) {
                      if (response.status === 'success') {
                          Toastify({
                              text: response.message,
                              backgroundColor: "green",
                              duration: 3000
                          }).showToast();
                          window.location.href = "{{ route('languages.index') }}";
                      } else if (response.status === 'error') {
                          let errors = response.message;
                          let errorMessages = '';
                          for (let field in errors) {
                              if (errors.hasOwnProperty(field)) {
                                  errorMessages += errors[field][0] + '\n';
                              }
                          }
                          Toastify({
                              text: errorMessages.trim(),
                              backgroundColor: "red",
                              duration: 5000
                          }).showToast();
                      }
                  },
              });
          });
      });
  </script>
@endpush
