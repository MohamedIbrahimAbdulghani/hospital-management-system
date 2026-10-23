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
        $isAr = app()->getLocale() === 'ar';

        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($isAr) {
                    $parts = array_filter(preg_split('/\s+/u', trim((string) $value)));
                    if (count($parts) < 3) {
                        $fail($isAr
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
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^(\+?20|0)?1[0125][0-9]{8}$/',
                Rule::unique(User::class),
            ],
            'national_id' => [
                'required',
                'string',
                'digits:14',
                Rule::unique(Patient::class, 'national_id'),
            ],
            'gender' => ['required', 'in:male,female'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'blood_type' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'city' => ['nullable', 'string', 'max:100'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ], [
            'name.required' => $isAr ? 'حقل الاسم الكامل مطلوب.' : 'Full name is required.',
            'email.required' => $isAr ? 'حقل البريد الإلكتروني مطلوب.' : 'Email address is required.',
            'email.email' => $isAr ? 'يرجى إدخال بريد إلكتروني صحيح.' : 'Please enter a valid email address.',
            'email.unique' => $isAr ? 'هذا البريد الإلكتروني مسجل لدينا بالفعل.' : 'This email is already in use.',
            'phone.required' => $isAr ? 'رقم الهاتف المحمول مطلوب للتواصل وتأكيد الحجوزات.' : 'Mobile phone number is required.',
            'phone.regex' => $isAr ? 'يرجى إدخال رقم هاتف محمول صحيح (مثال: 01012345678).' : 'Please enter a valid phone number (e.g. 01012345678).',
            'phone.unique' => $isAr ? 'رقم الهاتف هذا مسجل لدينا بالفعل.' : 'This phone number is already registered.',
            'national_id.required' => $isAr ? 'الرقم القومي مطلوب لفتح السجل الطبي للمريض.' : 'National ID is required for medical registration.',
            'national_id.digits' => $isAr ? 'الرقم القومي يجب أن يتكون من 14 رقماً بالضبط.' : 'National ID must be exactly 14 digits.',
            'national_id.unique' => $isAr ? 'الرقم القومي هذا مسجل بالفعل لملف مريض سابق.' : 'This National ID is already registered.',
            'gender.required' => $isAr ? 'يرجى تحديد النوع (ذكر / أنثى).' : 'Please select gender.',
            'gender.in' => $isAr ? 'قيمة النوع غير صالحة.' : 'Invalid gender value.',
            'date_of_birth.required' => $isAr ? 'تاريخ الميلاد مطلوب لحساب العمر الطبي.' : 'Date of birth is required.',
            'date_of_birth.date' => $isAr ? 'يرجى إدخال تاريخ ميلاد صالح.' : 'Please enter a valid date.',
            'date_of_birth.before' => $isAr ? 'تاريخ الميلاد يجب أن يكون تاريخاً سابقاً لتاريخ اليوم.' : 'Date of birth must be a past date.',
            'blood_type.in' => $isAr ? 'فصيلة الدم غير صالحة.' : 'Invalid blood type.',
            'password.required' => $isAr ? 'حقل كلمة المرور مطلوب.' : 'Password is required.',
            'password.min' => $isAr ? 'كلمة المرور يجب ألا تقل عن 6 خانات.' : 'Password must be at least 6 characters.',
            'password.confirmed' => $isAr ? 'تأكيد كلمة المرور غير متطابق.' : 'Password confirmation does not match.',
        ])->validate();

        return DB::transaction(function () use ($input) {
            // Force role to 'patient' regardless of any request inputs
            $user = User::create([
                'name' => trim($input['name']),
                'email' => strtolower(trim($input['email'])),
                'phone' => trim($input['phone']),
                'password' => Hash::make($input['password']),
                'role' => 'patient',
                'is_active' => true,
                'must_change_password' => false,
            ]);

            // Assign Spatie Role 'patient'
            $user->assignRole('patient');

            // Initialize patient profile with health info
            Patient::create([
                'user_id' => $user->id,
                'national_id' => trim($input['national_id']),
                'gender' => $input['gender'],
                'date_of_birth' => $input['date_of_birth'],
                'blood_type' => !empty($input['blood_type']) ? $input['blood_type'] : null,
                'city' => !empty($input['city']) ? trim($input['city']) : null,
                'emergency_contact_phone' => !empty($input['emergency_contact_phone']) ? trim($input['emergency_contact_phone']) : null,
            ]);

            return $user;
        });
    }
}
