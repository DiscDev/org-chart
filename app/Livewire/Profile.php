<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public User $user;
    public $photo;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected function rules()
    {
        return [
            'user.username' => ['required', 'string', 'max:255', 'unique:users,username,' . $this->user->id],
            'user.email_work' => ['required', 'string', 'email', 'max:255', 'unique:users,email_work,' . $this->user->id],
            'user.email_personal' => ['required', 'string', 'email', 'max:255', 'unique:users,email_personal,' . $this->user->id],
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name' => ['required', 'string', 'max:255'],
            'user.phone_number' => ['nullable', 'string', 'max:255'],
            'user.profile' => ['nullable', 'string'],
            'user.activities' => ['nullable', 'string'],
            'user.slack' => ['nullable', 'string', 'max:255'],
            'user.skype' => ['nullable', 'string', 'max:255'],
            'user.telegram' => ['nullable', 'string', 'max:255'],
            'user.whatsapp' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:1024'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ];
    }

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function save()
    {
        $this->validate();

        if ($this->photo) {
            $this->user->photo_url = $this->photo->store('photos', 'public');
        }

        if ($this->new_password) {
            if (!Hash::check($this->current_password, $this->user->password)) {
                $this->addError('current_password', 'The provided password does not match your current password.');
                return;
            }
            $this->user->password = Hash::make($this->new_password);
        }

        $this->user->updated_by = auth()->id();
        $this->user->save();

        session()->flash('message', 'Profile successfully updated.');
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('livewire.profile')->layout('layouts.app');
    }
}