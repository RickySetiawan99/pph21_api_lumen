<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Employee;

class EmployeeRepository
{
    public function getAllEmployee($workingUnitId = null)
    {
        if (!empty($workingUnitId)) {
            $getEmployee = Employee::where('current_working_unit_id', $workingUnitId)->get();
        } else {
            $getEmployee = Employee::all();
        }

        $dataEmployee = $this->dataEmployee($getEmployee);

        $result = Helper::setResultsRepository($dataEmployee);

        return $result;
    }

    public function dataEmployee($getEmployee)
    {
        if(count($getEmployee) > 0)
        {
            $dataEmployee = $getEmployee->map(function($employee) {
                $array_data = $this->arrayData($employee);
                return $array_data;
            });
        } else {
            $dataEmployee = [];
        }

        return $dataEmployee;
    }

    public function getEmployee($param)
    {
        $workingUnitId = $param['current_working_unit_id'] ?? null;
        $employeeId  = $param['employee_id'];

        if (!empty($workingUnitId)) {
            $getEmployee = Employee::where('current_working_unit_id', $workingUnitId)->where('id', $employeeId)->first();
        } else {
            $getEmployee = Employee::where('id', $employeeId)->first();
        }

        $dataEmployee = $this->arrayData($getEmployee);

        $result = Helper::setResultsRepository($dataEmployee);

        return $result;
    }

    public function arrayData($getEmployee)
    {
        if (!empty($getEmployee)) {
            $dataEmployee = [
                'id' => $getEmployee->id,
                'employee_no' => $getEmployee->employee_no,
                'name' => $getEmployee->name,
                'npwp' => $getEmployee->npwp,
                'nik_ktp' => $getEmployee->nik_ktp,
                'current_working_unit_id' => $getEmployee->current_working_unit_id,
                'email' => $getEmployee->email,
                'ptkp_id' => $getEmployee->ptkp_id,
                'is_marriage' => $getEmployee->is_marriage,
                'is_permanent_employee' => $getEmployee->is_permanent_employee,
                'jumlah_tanggungan' => $getEmployee->jumlah_tanggungan,
                'no_rekening' => $getEmployee->no_rekening,
                'status_id' => $getEmployee->status_id,
                'type_id' => $getEmployee->type_id,
                'position_id' => $getEmployee->position_id,
                'address' => $getEmployee->address,
                'gender' => $getEmployee->gender,
            ];
        } else {
            $dataEmployee = [];
        }

        return $dataEmployee;
    }

    public function createEmployee($data)
    {
        $createEmployee = Employee::create($data);

        return $createEmployee;
    }
}
