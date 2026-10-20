<?php

namespace App\Actions\Fortify;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Create a newly registered user (Strictly Patients Only).
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $parts = array_filter(preg_split('/\s+/u', trim((string) $value)));
                    if (count($parts) < 3) {
                        $fail(app()->getLocale() === 'ar'
                            ? 'يرجى إدخال الاسم ثلاثياً على الأقل (مثال: محمد أحمد علي).'
                            : 'Please enter your full name (at least 3 parts, e.g. first, middle, and last name).');
                    }
                },
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => app()->getLocale() === 'ar' ? 'حقل الاسم الكامل مطلوب.' : 'The name field is required.',
        ])->validate();

        return DB::transaction(function () use ($input) {
            // Force role to 'patient' regardless of any request inputs
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'] ?? null,
                'password' => Hash::make($input['password']),
                'role' => 'patient',
                'is_active' => true,
                'must_change_password' => false,
            ]);

            // Assign Spatie Role 'patient'
            $user->assignRole('patient');

            // Initialize patient profile
            Patient::create([
                'user_id' => $user->id,
            ]);

            return $user;
        });
    }
}
