@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
    <div class="detail-card">
        <h2>Patient Details</h2>

        <div class="detail-item">
            <strong>ID:</strong>
            <span>{{ $patient->id }}</span>
        </div>

        <div class="detail-item">
            <strong>Name:</strong>
            <span>{{ $patient->name }}</span>
        </div>

        <div class="detail-item">
            <strong>Age:</strong>
            <span>{{ $patient->age }}</span>
        </div>

        <div class="detail-item">
            <strong>Sex:</strong>
            <span>{{ $patient->sex }}</span>
        </div>

        <div class="detail-item">
            <strong>Blood Type:</strong>
            <span>{{ $patient->blood_type }}</span>
        </div>

        <div class="detail-item">
            <strong>Phone:</strong>
            <span>{{ $patient->phone }}</span>
        </div>

        <div class="form-buttons">
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">Edit Patient</a>
            <a href="{{ route('patients.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
@endsection
