<!DOCTYPE html>
<html>

<head>
    <title>Form Example</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Edit form inputs will be populated here -->
                    <form id="editForm">
                        @csrf
                        <input type="hidden" id="userId" name="userId">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="editEmail">
                        </div>
                        <div class="form-group">
                            <label for="editGender">Gender</label>
                            <input type="text" class="form-control" id="editGender" name="editGender">
                        </div>
                        <div class="form-group">
                            <label for="editLanguage">Language</label>
                            <input type="text" class="form-control" id="editLanguage" name="editLanguage">
                        </div>
                        <div class="form-group">
                            <label for="editImage">Upload New Image:</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="currentImage">Current Image:</label>
                            <span id="currentImageName"></span>
                        </div>
                        <input type="hidden" id="currentImage" name="currentImage">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h1 class="mb-4">User Information</h1>
        <a href="{{ route('form-view') }} " class="btn btn-primary">add user</a>
        <table border="1">
            <tr>
                <td>id</td>
                <td>name</td>
                <td>email</td>
                <td>gender</td>
                <td>language</td>
                <td>image</td>
                <td>action</td>
            </tr>
            @foreach ($user as $users)
                <tr>
                    <td>{{ $users->id }}</td>
                    <td>{{ $users->name }}</td>
                    <td>{{ $users->email }}</td>
                    <td>{{ $users->gender }}</td>
                    <td>{{ $users->language }}</td>
                    <td><img src="{{ asset('main_image/' . $users->image) }}" alt="Image" class="img-thumbnail"
                            style="max-width: 50px; max-height: 50px;"></td>
                    <td><button class="btn btn-primary editBtn" data-id="{{ $users->id }}">Edit</button></td>
                </tr>
            @endforeach
        </table>

    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).on('click', '.editBtn', function(e) {
        e.preventDefault();
        var edit_id = $(this).data('id');
        var url = "{{ route('edit-user', ':edit_id') }}";
        url = url.replace(':edit_id', edit_id);
        $('#editModal').modal('show');

        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                // Populate input fields
                $('#userId').val(response.user.id);
                $('#editName').val(response.user.name);
                $('#editEmail').val(response.user.email);
                $('#editLanguage').val(response.user.language);
                $('#editGender').val(response.user.gender);

                // Populate current image name and input
                $('#currentImageName').text('Current Image: ' + response.user.image);
                $('#currentImage').val(response.user.image); // Set hidden input value

                // Show the modal
                $('#editModal').modal('show');
            }
        });
    });

    $(document).ready(function() {
        $('#editForm').submit(function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            console.log(formData);
            formData.append('image', $('#image')[0].files[0]); // Append the file input data

            $.ajax({
                type: 'POST',
                url: "{{ route('update-user') }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#editModal').modal('hide');
                    window.location.href = "{{ route('user-data') }}";
                    
                },
                error: function(error) {
                    // Handle error
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
