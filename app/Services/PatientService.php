<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
    public function getFilteredPatients($search = null, $sortBy = 'id', $sortOrder = 'asc', $perPage = 10)
    {
        return Patient::search($search)
            ->sortBy($sortBy, $sortOrder)
            ->paginate($perPage);
    }
}
