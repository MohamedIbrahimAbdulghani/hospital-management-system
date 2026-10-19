<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('تغيير كلمة المرور المؤقتة')]
class ForceChangePassword extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'confirmed', Password::min(6)],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->forceFill([
            'password' => Hash::make($this->password),
            'must_change_password' => false,
        ])->save();

        session()->flash('status', __('messages.password_changed_successfully'));

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'hr' => redirect()->route('hr.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    public function render()
    {
        return view('livewire.auth.force-change-password');
    }
}
