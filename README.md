# Patient Records Management System

## Introduction

This repo is a patient management system that collects patient data of name, age, sex, blood type, and phone number.

Users can create, retrieve, update, and delete records, and also search through the records. All patient records are stored in single nominal form in one database table.

## Installation
1. Run `composer install` to install dependencies
2. Copy `.env.example` to `.env`
3. Configure your database credentials in `.env`
4. Run `php artisan key:generate` to generate the application key
5. Run `php artisan migrate:fresh --seed` to create and populate the database
6. Run `php artisan serve` to start the development server

## MVC Design Pattern Implementation

This is quite a simple Laravel app which follows the MVC framework, MVC separates concerns and makes the codebase maintainable.

### Model Layer

Models are like objects that are created in OOP but there are a few key differences. 

When using a framework like Laravel a model is like and active record pattern that is linked to the database entry columns of which it represents.

They also have object relational mapping or ORM which lets you interact more easily with the database. Instead of using raw SQL, you can use commands like find or save and it will magically happen in the background.

```php
// App/Models/Patient.php
class Patient extends Model
{
    protected $fillable = [
        'name', 'age', 'sex', 'blood_type', 'phone'
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('blood_type', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        return $query;
    }
}
```

In the example above I also use the scopeSearch query in the model to make it reusable across the app and also keep the controllers thin.

### View Layer

Views in a Laravel app are what you will see on the screen rendering the html, css, and php. Laravel uses the Blade templating engine for views which takes out the pain of raw PHP and instead creates blade directives that can be used instead.

```php
<!-- resources/views/patients/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h2>All Patients</h2>
    
    <table>
        <thead>
            <tr>
                @foreach($patientHeaders as $header)
                    <x-sortable-table-header
                        :column="$header['column']"
                        :label="$header['label']"
                        :current-sort-by="$sortBy ?? 'id'"
                        :current-sort-order="$sortOrder ?? 'asc'"
                    />
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->blood_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
```

In this example I have used two different for loops and also a component which is in a separate file. The data for the component comes from a view service provider. 

Another thing to note is the {{ }} which is blade syntax that automatically put the php into the HTML and automatically escapes it preventing XSS vulnerabilities

### Controller Layer

The controller layer is like the middle man of the set up, it communicates between the view and the model.

```php
// App/Http/Controllers/PatientController.php
class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        $patients = $this->patientService->getFilteredPatients(
            $search, $sortBy, $sortOrder
        );

        return view('patients.index', compact(
            'patients', 'search', 'sortBy', 'sortOrder'
        ));
    }

    public function store(PatientRequest $request)
    {
        Patient::create($request->validated());
        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient created successfully!');
    }
}
```

Above we have a snippet controller class, it consists of a constructor which uses dependency injection via Laravel service container. Meaning the controller doesn't have to bother creating the patientService, Laravel handles it automatically.

Underneath that, is the index function which takes in a HTTP request as a parameter, takes out the search and sorting parameters, passes the data to the service class for processing, and then returns the filtered data to the view.

The store function receives the request, but this time because we have a PatientRequest form request class and not Patient, Laravel sends the request to the PatientRequest input validation class first.

If all is good returns with a success message, if there is an error the PatientRequest class handles the errors and redirects with error messages for the user.

### MVC Data Flow Example

When a user searches for a patient:

1. A GET request is sent to web.php which then delegates it to the correct route PatientController::index

2. The controller takes in the request and deals with sorting parameters etc.

3. That particular controller then calls on the PatientService which calls on the Patient Models scopeSearch method

4. The Model then queries the database using Eloquent and returns it to the controller

5. The controller then passes the data using the compact method to the view which then renders the HTML table with the results


## Good Practice Implementation

### 1. Service Layer Pattern

Service layers are created to take business logic out of the main controllers and encapsulate them in their own class and maintain separation of concerns.

```php
// App/Services/PatientService.php
class PatientService
{
    public function getFilteredPatients(
        $search = null, 
        $sortBy = 'id', 
        $sortOrder = 'asc', 
        $perPage = 10
    ) {
        return Patient::search($search)
            ->sortBy($sortBy, $sortOrder)
            ->paginate($perPage);
    }
}
```

### 2. Form Request Validation

These are used again to keep validation out of controllers and keep separation of concerns. Doing this also gives room to add custom error messages.

```php
// App/Http/Requests/PatientRequest.php
class PatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s\-\']+$/',
            'phone' => [
                'required',
                'regex:/^(?:(?:\+44\s?|0)(?:\d\s?){10})$/',
            ],
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ];
    }
}
```

### 3. Blade Components for Reusability

Creating components for blade templates lets you insert and reuse them easily across the application

```php
// App/View/Components/SortableTableHeader.php
class SortableTableHeader extends Component
{
    public $column;
    public $label;
    public $currentSortBy;
    public $currentSortOrder;
    
    public function render()
    {
        return view('components.sortable-table-header');
    }
}
```

**Usage:**
```php
<x-sortable-table-header 
    column="name" 
    label="Patient Name"
    :current-sort-by="$sortBy"
/>
```

### 4. Database Optimisation

Creating indexes in the database for searching improves latency and performance.

```php
Schema::create('patients', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('blood_type');
    $table->string('phone');
    
    // Performance indexes
    $table->index('name');
    $table->index('blood_type');
    $table->index('phone');
});
```

### 5. Eloquent Query Scopes

Query scopes are used for separation of concerns and also keep database operations in one place and also make them reusable

```php
public function scopeSortBy($query, $column, $order = 'asc')
{
    $allowedColumns = ['id', 'name', 'age', 'sex', 'blood_type', 'phone'];
    $column = in_array($column, $allowedColumns) ? $column : 'id';
    $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

    return $query->orderBy($column, $order);
}
```

### 6. State Preservation in Pagination

This has been used to preserve search results so they are not lost through pagination usage by the user

```php
<a href="{{ $patients->appends([
    'search' => $search, 
    'sort_by' => $sortBy, 
    'sort_order' => $sortOrder
])->nextPageUrl() }}">
    Next »
</a>
```

### 7. Dependency Injection

Dependency injection is used to automatically resolve dependencies and follows the SOLID principle.

```php
public function __construct(PatientService $patientService)
{
    $this->patientService = $patientService;
}
```
