@extends('layouts.app')

@section('title', 'Add New Patient')

@section('content')
    <h2>Add New Patient</h2>

    <form method="POST" action="{{ route('patients.store') }}">
        @csrf

        <div class="form-group">
            @error('name')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            @error('age')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="0" max="150" value="{{ old('age') }}">
        </div>

        <div class="form-group">
            @error('sex')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="sex">Sex:</label>
            <select id="sex" name="sex">
                <option value="">-- Select --</option>
                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            @error('blood_type')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="blood_type">Blood Type:</label>
            <select id="blood_type" name="blood_type">
                <option value="">-- Select --</option>
                <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
            </select>
        </div>

        <div class="form-group">
            @error('phone')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
        </div>

        <button type="submit" class="btn btn-success">Add Patient</button>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
