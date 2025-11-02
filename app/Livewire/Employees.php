<?php

namespace App\Livewire;

use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Employees extends Component
{
    use WithPagination;

    // public properties (state)
    public $q = '';
    public $perPage = 10;

    public $employee_id;
    public $employee_number;
    public $name;
    public $email;
    public $phone;
    public $position;
    public $status = 'active';
    public $address;
    public $hire_date;
    public $salary;

    public $showForm = false;
    public $isEdit = false;

    // keep query string for search
    protected $queryString = ['q' => ['except' => '']];

    // base rules (unique handled dynamically)
    protected $baseRules = [
        'employee_number' => 'required|string|max:50',
        'name'            => 'required|string|max:255',
        'email'           => 'nullable|email|max:255',
        'phone'           => 'nullable|string|max:30',
        'position'        => 'nullable|string|max:255',
        'status'          => 'required|in:active,inactive,resigned',
        'address'         => 'nullable|string',
        'hire_date'       => 'nullable|date',
        'salary'          => 'nullable|numeric|min:0',
    ];

    protected $paginationTheme = 'tailwind'; // gunakan tailwind pagination

    public function mount()
    {
        $this->q = request()->query('q', $this->q);
    }

    public function render()
    {
        $query = Employee::query()
            ->when($this->q, fn($q) => $q->where('name', 'like', "%{$this->q}%")
                ->orWhere('employee_number', 'like', "%{$this->q}%"));

        $employees = $query->orderBy('name')->paginate($this->perPage);

        return view('livewire.employees', compact('employees'));
    }

    // validate single field on update (realtime)
    public function updated($propertyName)
    {
        // build rules and then call validateOnly on that property
        $rules = $this->validationRulesFor();
        if (isset($rules[$propertyName])) {
            $this->validateOnly($propertyName, [$propertyName => $rules[$propertyName]]);
        }
    }

    protected function validationRulesFor()
    {
        $rules = $this->baseRules;

        if ($this->isEdit && $this->employee_id) {
            $rules['employee_number'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_number')->ignore($this->employee_id),
            ];
            $rules['email'] = [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($this->employee_id),
            ];
        } else {
            $rules['employee_number'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_number'),
            ];
            $rules['email'] = [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees', 'email'),
            ];
        }

        return $rules;
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showForm = true;
    }

    public function showEditForm($id)
    {
        $this->resetForm();
        $this->employee_id = $id;
        $employee = Employee::findOrFail($id);

        $this->employee_number = $employee->employee_number;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->position = $employee->position;
        $this->status = $employee->status;
        $this->address = $employee->address;
        $this->hire_date = $employee->hire_date ? $employee->hire_date->format('Y-m-d') : null;
        $this->salary = $employee->salary;

        $this->isEdit = true;
        $this->showForm = true;
    }

    public function save()
    {
        $validated = $this->validate($this->validationRulesFor());

        if ($this->isEdit && $this->employee_id) {
            $emp = Employee::findOrFail($this->employee_id);
            $emp->update($validated);
            session()->flash('success', 'Employee updated successfully.');
        } else {
            Employee::create($validated);
            session()->flash('success', 'Employee created successfully.');
        }

        $this->showForm = false;
        $this->resetPage();
        $this->resetForm();
    }

    public function delete($id)
    {
        $emp = Employee::findOrFail($id);
        $emp->delete();
        session()->flash('success', 'Employee deleted successfully.');
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset([
            'employee_id',
            'employee_number',
            'name',
            'email',
            'phone',
            'position',
            'status',
            'address',
            'hire_date',
            'salary',
            'isEdit'
        ]);
        $this->resetValidation();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
}
