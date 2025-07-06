@extends('layouts.app')

@section('title', 'Employee List')

@section('content')
    <h1>Employee List</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr id="employee-{{ $employee->id }}">
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-employee" data-id="{{ $employee->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.delete-employee').click(function () {
            if (confirm('Are you sure you want to delete this employee?')) {
                var employeeId = $(this).data('id');
                $.ajax({
                    url: '/employees/' + employeeId,
                    type: 'DELETE',
                    success: function (response) {
                        $('#employee-' + employeeId).remove();

                        // Show success message in DOM
                        $('#alert-container').html(`
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                ${response.success}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);

                        // Auto dismiss after 3 seconds
                        setTimeout(() => {
                            $('.alert').fadeOut(500, function () { $(this).remove(); });
                        }, 3000);
                    },
                    error: function () {
                        $('#alert-container').html(`
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                Failed to delete employee.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                });
            }
        });
    });
</script>
@endsection