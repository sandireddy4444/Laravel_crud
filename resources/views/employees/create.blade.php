@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
    <h1>Add Employee</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="employeeForm" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" value="{{ old('description') }}"></textarea>
        </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">Active</label>
            <input type="checkbox" id="is_active" name="is_active" value="1" value="{{ old('is_active') }}">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept=".jpg,.jpeg,.png">
        </div>
        <div class="mb-3">
            <label class="form-label">Preferences</label>
            <div>
                <input type="checkbox" name="preferences[]" value="newsletter" {{ is_array(old('preferences')) && in_array('newsletter', old('preferences')) ? 'checked' : '' }}> Newsletter
                <input type="checkbox" name="preferences[]" value="updates" {{ is_array(old('preferences')) && in_array('updates', old('preferences')) ? 'checked' : '' }}> Updates
                <input type="checkbox" name="preferences[]" value="promotions" {{ is_array(old('preferences')) && in_array('promotions', old('preferences')) ? 'checked' : '' }}> Promotions
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div>
                <input type="radio" name="status" value="full_time" {{ old('status') == 'full_time' ? 'checked' : '' }} checked> Full Time
                <input type="radio" name="status" value="part_time" {{ old('status') == 'part_time' ? 'checked' : '' }}> Part Time
                <input type="radio" name="status" value="contract" {{ old('status') == 'contract' ? 'checked' : '' }}> Contract
            </div>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-control" id="user_id" name="user_id">
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Close</a>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('#employeeForm').validate({
                rules: {
                    name: { required: true, maxlength: 255 },
                    email: { required: true, email: true },
                    profile_picture: { extension: "jpg|jpeg|png", filesize: 2048 },
                    status: { required: true },
                    user_id: { required: true }
                },
                messages: {
                    name: { required: "Please enter a name.", maxlength: "Name cannot exceed 255 characters." },
                    email: { required: "Please enter an email.", email: "Please enter a valid email." },
                    profile_picture: { extension: "Only JPG, JPEG, or PNG files are allowed.", filesize: "File size must be less than 2MB." },
                    status: { required: "Please select a status." },
                    user_id: { required: "Please select a user." }
                },
                errorElement: 'div',
                errorClass: 'text-danger',
                submitHandler: function(form) {
                    form.submit(); // Ensure form submits after validation
                }
            });

            $.validator.addMethod('filesize', function (value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000);
            }, 'File size must be less than {0} KB.');
        });
    </script>
@endsection