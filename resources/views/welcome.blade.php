@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="welcome-container">
        <h2>Welcome to Patient Records Management</h2>
        <p class="welcome-description">A simple medical records management application for healthcare facilities.</p>

        <div class="welcome-actions">
            <a href="{{ route('patients.index') }}" class="btn btn-primary btn-large">View All Patients</a>
        </div>
    </div>
@endsection
