<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patient Records')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header>
    <h1>Patient Records System</h1>
    @if(Request::route()->getName() !== 'welcome')
        <nav>
            <a href="{{ route('patients.index') }}">All Patients</a>
            <a href="{{ route('patients.create') }}">Add New Patient</a>
        </nav>
    @endif
</header>

<main>
    {{-- Success Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if (session('error'))
        <div class="alert alert-error">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<footer>
    <p>&copy; 2025 Patient Records System</p>
</footer>
</body>
</html>
