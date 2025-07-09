@extends('layouts.app')

@section('title', 'Employee List')

@section('content')

    <div id="alert-container"></div>

    <h1>Employee List</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>
    <table class="table table-bordered">
        <thead>     
            <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Description</th>
        <th>Active</th>
        <th>Gender</th>
        <th>Preferences</th>
        <th>Status</th>
        <th>User</th>
        <th>Profile Picture</th>
        <th>Actions</th>
    </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            @php
            $preferences = $employee->preferences;
            if (!is_array($preferences)) {
                $decoded = json_decode($preferences, true);
                $preferences = is_array($decoded) ? $decoded : [];
            }
            @endphp
                <tr id="employee-{{ $employee->id }}">
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->description ?? 'N/A' }}</td>
                    <td>{{ $employee->is_active ? 'Yes' : 'No' }}</td>
                    <td>{{ $employee->gender ?? 'N/A' }}</td>
                    <td>{{ implode(', ', $preferences) ?: 'None' }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>{{ $employee->user->name ?? 'N/A' }}</td>
                    <td>
                    @if ($employee->profile_picture)
                    <img src="{{ Storage::url($employee->profile_picture) }}" width="80" height="60" alt="Profile Picture">
                    @else
                    N/A
                    @endif
                   </td>
                    <td>
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-info btn-sm" title="View"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-danger btn-sm delete-employee" data-id="{{ $employee->id }}" title="Delete"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}
    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Are you sure you want to delete this employee?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>


<script>
    let employeeToDelete = null;

    $(document).ready(function () {
        // Setup CSRF for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Open modal on trash click
        $('.delete-employee').click(function () {
            employeeToDelete = $(this).data('id');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        });

        // Confirm delete in modal
        $('#confirmDeleteBtn').click(function () {
            if (!employeeToDelete) return;

            $.ajax({
                url: '/employees/' + employeeToDelete,
                type: 'DELETE',
                success: function (response) {
                    $('#employee-' + employeeToDelete).remove();

                    $('#alert-container').html(`
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            ${response.success}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);

                    setTimeout(() => {
                        $('.alert').fadeOut(500, function () { $(this).remove(); });
                    }, 3000);

                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal')).hide();
                },
                error: function () {
                    $('#alert-container').html(`
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            Error deleting employee.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            });
        });
    });
</script>

@endsection

