@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <h1>Employee Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $employee->id }}</p>
            <p><strong>Name:</strong> {{ $employee->name }}</p>
            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Description:</strong> {{ $employee->description ?? 'N/A' }}</p>
            <p><strong>Active:</strong> {{ $employee->is_active ? 'Yes' : 'No' }}</p>
            <p><strong>Gender:</strong> {{ $employee->gender ?? 'N/A' }}</p>

            <p><strong>Profile Picture:</strong>
                @if ($employee->profile_picture)
                    <img src="{{ Storage::url($employee->profile_picture) }}" alt="Profile Picture" width="100">
                @else
                    N/A
                @endif
            </p>

            @php
                $preferences = $employee->preferences;

                // Safeguard: Convert string to array if necessary
                if (!is_array($preferences)) {
                    $decoded = json_decode($preferences, true);
                    $preferences = is_array($decoded) ? $decoded : [];
                }
            @endphp

            <p><strong>Preferences:</strong> {{ implode(', ', $preferences) ?: 'None' }}</p>

            <p><strong>Status:</strong> {{ $employee->status }}</p>
            <p><strong>User:</strong> {{ $employee->user->name ?? 'N/A' }}</p>

            <a href="{{ route('employees.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection