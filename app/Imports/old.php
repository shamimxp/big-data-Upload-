<?php
namespace App\Imports;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\MobileNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class etfghty implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row)) {
            return null;
        }

        $importedModels = [];

        // Department import
        if (!empty($row['name'])) {
            $importedModels[] = Department::create([
                'name' => $row['name'],
                'status' => $row['status'] ?? null,
                'created_by' => $row['created_by'] ?? null,
                'updated_by' => $row['updated_by'] ?? null
            ]);
        }

        // Designation import
        if (!empty($row['designation_name'])) {
            $importedModels[] = Designation::create([
                'company_id' => $row['company_id'] ?? null,
                'department_id' => $row['department_id'] ?? null,
                'designation_name' => $row['designation_name'],
                'short_name' => $row['short_name'] ?? null,
                'sort_order' => $row['sort_order'] ?? null,
                'status' => $row['status'] ?? null,
                'created_by' => $row['created_by'] ?? null,
                'updated_by' => $row['updated_by'] ?? null
            ]);
        }

        // Employee import
        if (!empty($row['emp_id'])) {
            $importedModels[] = Employee::create([
                'emp_name' => $row['emp_name'] ?? null,
                'emp_id' => $row['emp_id'],
                'job_location' => $row['job_location'] ?? null,
                'dob' => $row['dob'] ?? null,
                'company_id' => $row['company_id'] ?? null,
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
                'status' => $row['status'] ?? null
            ]);
        }

        // Mobile Number import
        if (!empty($row['mobile_no'])) {
            $importedModels[] = MobileNumber::create([
                'employee_id' => $row['employee_id'] ?? null,
                'designation_id' => $row['designation_id'] ?? null,
                'department_id' => $row['department_id'] ?? null,
                'division_id' => $row['division_id'] ?? null,
                'company_id' => $row['company_id'] ?? null,
                'assign_date' => $row['assign_date'] ?? null,
                'mobile_operator' => $row['mobile_operator'] ?? null,
                'mobile_no' => $row['mobile_no'],
                'mobile_calling' => $row['mobile_calling'] ?? null,
                'status' => $row['status'] ?? null
            ]);
        }

        // Return the first successfully imported model
        return $importedModels[0] ?? null;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
