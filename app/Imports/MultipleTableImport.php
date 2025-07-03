<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\ImportLog;
use App\Models\MobileNumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class MultipleTableImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            $rows->chunk(1000)->each(function ($chunk) {
                // Process Departments
                $departmentData = $chunk->whereNotNull('name')
                    ->map(function ($row) {
                        return [
                            'name' => $row['name'],
                            'status' => $row['status'] ?? null,
                            'created_by' => $row['created_by'] ?? null,
                            'updated_by' => $row['updated_by'] ?? null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    })->toArray();

                if (!empty($departmentData)) {
                    Department::insert($departmentData);
                }

                // Process Designations
                $designationData = $chunk->whereNotNull('designation_name')
                    ->map(function ($row) {
                        return [
                            'company_id' => $row['company_id'] ?? null,
                            'department_id' => $row['department_id'] ?? null,
                            'designation_name' => $row['designation_name'],
                            'short_name' => $row['short_name'] ?? null,
                            'sort_order' => $row['sort_order'] ?? null,
                            'status' => $row['status'] ?? null,
                            'created_by' => $row['created_by'] ?? null,
                            'updated_by' => $row['updated_by'] ?? null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    })->toArray();

                if (!empty($designationData)) {
                    Designation::insert($designationData);
                }

                // Process Employees
                $employeeData = $chunk->whereNotNull('emp_id')
                    ->map(function ($row) {
                        return [
                            'emp_name' => $row['emp_name'] ?? 'Unknown',
                            'emp_id' => $row['emp_id'],
                            'job_location' => $row['job_location'] ?? null,
                            'dob' => $row['dob'] ?? null,
                            'company_id' => $row['company_id'] ?? 1,
                            'organogram_id' => $row['organogram_id'] ?? null,
                            'division_id' => $row['division_id'] ?? null,
                            'department_id' => $row['department_id'] ?? null,
                            'section_id' => $row['section_id'] ?? null,
                            'desk_id' => $row['desk_id'] ?? null,
                            'designation_id' => $row['designation_id'] ?? null,
                            'edu_degree_id' => $row['edu_degree_id'] ?? null,
                            'custodian_id' => $row['custodian_id'] ?? null,
                            'sub_custodian_id' => $row['sub_custodian_id'] ?? null,
                            'emp_category_id' => $row['emp_category_id'] ?? null,
                            'is_head_of_dept' => $row['is_head_of_dept'] ?? false,
                            'blood_group' => $row['blood_group'] ?? null,
                            'gender' => $row['gender'] ?? null,
                            'made_of_recruitment' => $row['made_of_recruitment'] ?? null,
                            'religion' => $row['religion'] ?? null,
                            'gross_salary' => $row['gross_salary'] ?? null,
                            'joining_date' => $row['joining_date'] ?? null,
                            'telephone_ext_no' => $row['telephone_ext_no'] ?? null,
                            'nid' => $row['nid'] ?? null,
                            'phone_number' => $row['phone_number'] ?? null,
                            'personal_phone_number' => $row['personal_phone_number'] ?? null,
                            'status' => $row['status'] ?? 1,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    })->toArray();

                if (!empty($employeeData)) {
                    Employee::insert($employeeData);
                }

                // Process Mobile Numbers
                $mobileData = $chunk->whereNotNull('mobile_no')
                    ->map(function ($row) {
                        return [
                            'employee_id' => $row['employee_id'] ?? null,
                            'designation_id' => $row['designation_id'] ?? null,
                            'department_id' => $row['department_id'] ?? null,
                            'division_id' => $row['division_id'] ?? null,
                            'company_id' => $row['company_id'] ?? null,
                            'assign_date' => $row['assign_date'] ?? null,
                            'mobile_operator' => $row['mobile_operator'] ?? null,
                            'mobile_no' => $row['mobile_no'],
                            'mobile_calling' => $row['mobile_calling'] ?? null,
                            'status' => $row['status'] ?? 1,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    })->toArray();

                if (!empty($mobileData)) {
                    MobileNumber::insert($mobileData);
                }
            });
        });
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
