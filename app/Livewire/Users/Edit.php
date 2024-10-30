<?php

namespace App\Livewire\Users;

use App\Models\Agency;
use App\Models\Department;
use App\Models\Office;
use App\Models\Role;
use App\Models\Team;
use App\Models\Timezone;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;
    public $photo;
    public $password;
    public $password_confirmation;
    public $selectedDepartments = [];
    public $selectedOffices = [];
    public $selectedRoles = [];
    public $selectedTeams = [];

    protected function rules()
    {
        return [
            'user.username' => ['required', 'string', 'max:255', 'unique:users,username,' . $this->user->id],
            'user.email_work' => ['required', 'string', 'email', 'max:255', 'unique:users,email_work,' . $this->user->id],
            'user.email_personal' => ['required', 'string', 'email', 'max:255', 'unique:users,email_personal,' . $this->user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name' => ['required', 'string', 'max:255'],
            'user.start_date' => ['required', 'date'],
            'user.end_date' => ['nullable', 'date'],
            'user.phone_number' => ['nullable', 'string', 'max:255'],
            'user.profile' => ['nullable', 'string'],
            'user.activities' => ['nullable', 'string'],
            'user.job_title' => ['required', 'string', 'max:255'],
            'user.job_description' => ['nullable', 'string'],
            'user.timezone_id' => ['required', 'exists:timezones,id'],
            'user.location' => ['required', 'string', 'max:255'],
            'user.manager_id' => ['nullable', 'exists:users,id'],
            'photo' => ['nullable', 'image', 'max:1024'],
            'user.agency_id' => ['required', 'exists:agencies,id'],
            'user.salary' => ['nullable', 'numeric', 'min:0'],
            'user.salary_including_agency_fees' => ['nullable', 'numeric', 'min:0'],
            'user.bonus_structure' => ['nullable', 'string'],
            'user.slack' => ['nullable', 'string', 'max:255'],
            'user.skype' => ['nullable', 'string', 'max:255'],
            'user.telegram' => ['nullable', 'string', 'max:255'],
            'user.whatsapp' => ['nullable', 'string', 'max:255'],
            'user.user_type_id' => ['required', 'exists:user_types,id'],
            'selectedDepartments' => ['array'],
            'selectedOffices' => ['array'],
            'selectedRoles' => ['array'],
            'selectedTeams' => ['array'],
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->selectedDepartments = $user->departments->pluck('id')->toArray();
        $this->selectedOffices = $user->offices->pluck('id')->toArray();
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->selectedTeams = $user->teams->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        if ($this->photo) {
            $this->user->photo_url = $this->photo->store('photos', 'public');
        }

        $this->user->updated_by = auth()->id();
        $this->user->save();

        $this->user->departments()->sync($this->selectedDepartments);
        $this->user->offices()->sync($this->selectedOffices);
        $this->user->roles()->sync($this->selectedRoles);
        $this->user->teams()->sync($this->selectedTeams);

        session()->flash('message', 'User successfully updated.');
        return redirect()->route('users');
    }

    public function render()
    {
        return view('livewire.users.edit', [
            'timezones' => Timezone::orderBy('name')->get(),
            'agencies' => Agency::orderBy('name')->get(),
            'userTypes' => UserType::orderBy('name')->get(),
            'managers' => User::where('id', '!=', $this->user->id)->orderBy('first_name')->get(),
            'departments' => Department::orderBy('name')->get(),
            'offices' => Office::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}