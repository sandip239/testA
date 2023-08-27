<!DOCTYPE html>
<html>

<head>
    <title>Form Example</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Submit Your Information</h1>
        <form method="POST" enctype="multipart/form-data" style="width: 50%" id="registerForm">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="language">Select Language:</label>
                <select class="form-control" id="language" name="language">
                    <option value="english">English</option>
                    <option value="spanish">Spanish</option>
                    <option value="french">French</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="male" name="gender" value="male"
                        required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="female" name="gender" value="female"
                        required>
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="other" name="gender" value="other"
                        required>
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#registerForm').submit(function(event) {
            event.preventDefault(); 
            var formData = new FormData(this);  
            
            $.ajax({
                type: 'POST',
                url: "{{ route('form-data') }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    window.location.href = "{{ route('user-data') }}";
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
