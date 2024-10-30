<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\UserType;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{
    public string $username = '';
    public string $email_work = '';
    public string $email_personal = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $first_name = '';
    public string $last_name = '';
    public string $phone_number = '';

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email_work' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_personal' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'username' => $this->username,
            'email_work' => $this->email_work,
            'email_personal' => $this->email_personal,
            'password' => Hash::make($this->password),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'start_date' => now(),
            'user_type_id' => UserType::where('name', 'Registrant')->first()->id,
        ]);

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.auth');
    }
}