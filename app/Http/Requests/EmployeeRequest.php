<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee') ? $this->route('employee')->id : null;

        return [
            'employee_number' => ['required', 'string', 'max:50', Rule::unique('employees')->ignore($employeeId)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('employees')->ignore($employeeId)],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'birth_date' => ['nullable', 'date'],
            'hire_date' => ['nullable', 'date'],
            'position_id' => ['nullable', 'exists:position,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'address' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive', 'resigned'])],
            'salary' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
