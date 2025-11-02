<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Employees</h1>
        <div class="flex gap-2">
            <input wire:model.debounce.300ms="q" type="text" placeholder="Search name or NIK" class="p-2 border rounded" />
            <button wire:click="showCreateForm" class="px-4 py-2 rounded bg-green-600 text-black">New</button>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Employee Number</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Position</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($employees as $employee)
                <tr wire:key="employee-{{ $employee->id }}">
                    <td class="px-4 py-2">{{ $employee->id }}</td>
                    <td class="px-4 py-2">{{ $employee->employee_number }}</td>
                    <td class="px-4 py-2">{{ $employee->name }}</td>
                    <td class="px-4 py-2">{{ $employee->position }}</td>
                    <td class="px-4 py-2 capitalize">{{ $employee->status }}</td>
                    <td class="px-4 py-2">
                        <button wire:click="showEditForm({{ $employee->id }})" class="text-sm mr-2">Edit</button>
                        <button wire:click="delete({{ $employee->id }})" onclick="confirm('Delete?') || event.stopImmediatePropagation()" class="text-sm text-red-600">Delete</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-4">No employees found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>

    <!-- Simple modal form -->
    @if($showForm)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded w-full max-w-2xl">
            <h2 class="text-xl font-semibold mb-4">{{ $isEdit ? 'Edit Employee' : 'Create Employee' }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm">Employee Number</label>
                    <input wire:model.defer="employee_number" class="mt-1 block w-full rounded p-2 border" />
                    @error('employee_number') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm">Name</label>
                    <input wire:model.defer="name" class="mt-1 block w-full rounded p-2 border" />
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm">Email</label>
                    <input wire:model.defer="email" class="mt-1 block w-full rounded p-2 border" />
                    @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm">Phone</label>
                    <input wire:model.defer="phone" class="mt-1 block w-full rounded p-2 border" />
                    @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm">Position</label>
                    <input wire:model.defer="position" class="mt-1 block w-full rounded p-2 border" />
                    @error('position') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm">Status</label>
                    <select wire:model.defer="status" class="mt-1 block w-full rounded p-2 border">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="resigned">Resigned</option>
                    </select>
                    @error('status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm">Address</label>
                    <textarea wire:model.defer="address" class="mt-1 block w-full rounded p-2 border"></textarea>
                    @error('address') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4 flex gap-2 justify-end">
                <button wire:click="save" class="px-4 py-2 rounded bg-blue-600 text-black">{{ $isEdit ? 'Update' : 'Create' }}</button>
                <button wire:click="$set('showForm', false)" class="px-4 py-2 rounded border">Cancel</button>
            </div>
        </div>
    </div>
    @endif
</div>
