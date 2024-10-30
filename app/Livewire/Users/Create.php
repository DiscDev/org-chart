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

class Create extends Component
{
    use WithFileUploads;

    public $username;
    public $email_work;
    public $email_personal;
    public $password;
    public $password_confirmation;
    public $first_name;
    public $last_name;
    public $start_date;
    public $phone_number;
    public $profile;
    public $activities;
    public $job_title;
    public $job_description;
    public $timezone_id;
    public $location;
    public $manager_id;
    public $photo;
    public $agency_id;
    public $salary;
    public $salary_including_agency_fees;
    public $bonus_structure;
    public $slack;
    public $skype;
    public $telegram;
    public $whatsapp;
    public $user_type_id;
    
    public $selectedDepartments = [];
    public $selectedOffices = [];
    public $selectedRoles = [];
    public $selectedTeams = [];

    protected function rules()
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email_work' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_personal' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'profile' => ['nullable', 'string'],
            'activities' => ['nullable', 'string'],
            'job_title' => ['required', 'string', 'max:255'],
            'job_description' => ['nullable', 'string'],
            'timezone_id' => ['required', 'exists:timezones,id'],
            'location' => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'photo' => ['nullable', 'image', 'max:1024'],
            'agency_id' => ['required', 'exists:agencies,id'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'salary_including_agency_fees' => ['nullable', 'numeric', 'min:0'],
            'bonus_structure' => ['nullable', 'string'],
            'slack' => ['nullable', 'string', 'max:255'],
            'skype' => ['nullable', 'string', 'max:255'],
            'telegram' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'user_type_id' => ['required', 'exists:user_types,id'],
            'selectedDepartments' => ['array'],
            'selectedOffices' => ['array'],
            'selectedRoles' => ['array'],
            'selectedTeams' => ['array'],
        ];
    }

    public function save()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('photos', 'public');
        }

        $user = User::create([
            'username' => $this->username,
            'email_work' => $this->email_work,
            'email_personal' => $this->email_personal,
            'password' => Hash::make($this->password),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'start_date' => $this->start_date,
            'phone_number' => $this->phone_number,
            'profile' => $this->profile,
            'activities' => $this->activities,
            'job_title' => $this->job_title,
            'job_description' => $this->job_description,
            'timezone_id' => $this->timezone_id,
            'location' => $this->location,
            'manager_id' => $this->manager_id,
            'photo_url' => $photoPath,
            'agency_id' => $this->agency_id,
            'salary' => $this->salary,
            'salary_including_agency_fees' => $this->salary_including_agency_fees,
            'bonus_structure' => $this->bonus_structure,
            'slack' => $this->slack,
            'skype' => $this->skype,
            'telegram' => $this->telegram,
            'whatsapp' => $this->whatsapp,
            'user_type_id' => $this->user_type_id,
            'created_by' => auth()->id(),
        ]);

        if (!empty($this->selectedDepartments)) {
            $user->departments()->attach($this->selectedDepartments);
        }
        if (!empty($this->selectedOffices)) {
            $user->offices()->attach($this->selectedOffices);
        }
        if (!empty($this->selectedRoles)) {
            $user->roles()->attach($this->selectedRoles);
        }
        if (!empty($this->selectedTeams)) {
            $user->teams()->attach($this->selectedTeams);
        }

        session()->flash('message', 'User successfully created.');
        return redirect()->route('users');
    }

    public function render()
    {
        return view('livewire.users.create', [
            'timezones' => Timezone::orderBy('name')->get(),
            'agencies' => Agency::orderBy('name')->get(),
            'userTypes' => UserType::orderBy('name')->get(),
            'managers' => User::where('id', '!=', auth()->id())->orderBy('first_name')->get(),
            'departments' => Department::orderBy('name')->get(),
            'offices' => Office::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}