<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginForm extends Component
{
    public string $email_or_phone = '';
    public string $password = '';
    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($this->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $this->email_or_phone,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();
            
            $role = Auth::user()->role;
            if ($role === 'patient') {
                return redirect()->intended('/patient/dashboard');
            } elseif ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'doctor') {
                return redirect()->intended('/doctor/dashboard');
            }
        }

        throw ValidationException::withMessages([
            'email_or_phone' => trans('auth.failed'),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login-form')->layout('layouts.auth');
    }
}
