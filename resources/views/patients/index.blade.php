@extends('layouts.app')

@section('title', 'All Patients')

@section('content')
    <h2>All Patients</h2>

    <form method="GET" action="{{ route('patients.index') }}" class="search-form">
        <div class="search-container">
            <input
                type="text"
                name="search"
                placeholder="Search by name, blood type, or phone..."
                value="{{ $search ?? '' }}"
                class="search-input"
            >

            <input type="hidden" name="sort_by" value="{{ $sortBy ?? 'id' }}">
            <input type="hidden" name="sort_order" value="{{ $sortOrder ?? 'asc' }}">

            <button type="submit" class="btn-search">Search</button>

            @if($search)
                <a href="{{ route('patients.index') }}" class="btn-clear">Clear</a>
            @endif
        </div>
    </form>

    <p class="table-instruction">💡 Click on any column header to sort</p>

    <table>
        <thead>
        <tr>
            @foreach($patientHeaders as $header)
                <x-sortable-table-header
                    :column="$header['column']"
                    :label="$header['label']"
                    :current-sort-by="$sortBy ?? 'id'"
                    :current-sort-order="$sortOrder ?? 'asc'"
                    :search="$search ?? null"
                />
            @endforeach

            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($patients as $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->sex }}</td>
                <td>{{ $patient->blood_type }}</td>
                <td>{{ $patient->phone }}</td>
                <td class="action-buttons">
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('patients.destroy', $patient->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this patient?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                    @if($search)
                        No patients found matching "{{ $search }}".
                        <a href="{{ route('patients.index') }}">Clear search</a>
                    @else
                        No patients found.
                        <a href="{{ route('patients.create') }}">Add your first patient</a>
                    @endif
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <x-pagination
        :paginator="$patients"
        :query-params="['search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]"
    />
@endsection
