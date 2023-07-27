<?php

namespace App\Repositories\Atlet\Auth;

use App\Models\User;
use App\Models\UserPersonal;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterHandling
{
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $rules = [
            'fullname' => [
                'required',
                'string',
                'min:5',
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{6,13}$/'
            ],
            'date_of_birth' => [
                'required',
                'date_format:Y-m-d',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:6',             // must be at least 6 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                // 'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ];

        $messages = [
            // 'email.required' => ':attribute is required',
            'password.regex' => 'The :attribute must contain at least one lowercase letter & one digit number.',
            'phone_number.regex' => "The :attribute not valid.",
        ];
        $validated = Validator::make($this->request->all(), $rules, $messages)->validate();

        // check uniqueness of phone number that already verified
        $countExistingVerifiedPhoneNumber = UserPersonal::where('pnumber', $validated['phone_number'])->whereNotNull('pnumber_verified_at')->count();
        if ($countExistingVerifiedPhoneNumber > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'phone_number' => ['The phone number is already registered.'],
            ]);
        }

        return $validated;
    }

    public function handle()
    {
        $validated = $this->validate();
        $result = [];

        DB::beginTransaction();
        try {
            // create user data
            $uname = $this->__getUniqueName($validated['fullname']);
            $userData = User::create([
                'uname' => $uname,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // create user personal data
            $userPersonalData = UserPersonal::create([
                'fullname' => $validated['fullname'],
                'pnumber' => $validated['phone_number'],
                'user_uuid' => $userData->id,
            ]);

            // assign a "Member" role to newly created user
            $userData->assignRole('Member');

            // create user verification code
            $code = $this->__getUniqueVerificationCode(6);
            UserVerification::create([
                'code' => $code,
                'sent_via' => 0, // 0: email,
                'status' => 0, // 0: pending
                'valid_until' => strtotime('+ 15 minutes'),
                'user_uuid' => $userData->id,
            ]);

            // TODO:
            // 1. DONE: Kirim email verifikasi ke email user yang baru saja mendaftar
            // 2. Gunakan queue job biar fungsi kirim email berjalan di background (tidak ngeblock proses / bikin loading lama)

            $sent = Mail::send('email/simple', [
                'content' => "<p>Halo $userPersonalData->fullname!</p>
                <p>Untuk memulai perjalanan kamu di Real Masjid website, harap verifikasi emailmu terlebih dahulu dengan melakukan klik pada tautan dibawah:</p>
                <p style='text-align: center'><a href='#' style='background-color: blue; display: inline-block; padding: 5px 30px; border-radius: 25px; color: #fff; font-weight: 600; text-decoration: none'>Verifikasi Email</a></p>
                <p>atau kamu juga bisa gunakan kode dibawah untuk dimasukkan pada kolom verifikasi kode OTP di halaman pendaftaran:</p>
                <p style='text-align: center'><strong style='font-size: 25px'>$code</strong></p>
                <br/>
                <p>Jika kamu merasa tidak melakukannya, harap abaikan email ini.</p>
                <br/>
                <p>Sehat selalu..</p>
                <p>Real Masjid teams.</p>
                "
            ], function ($message) use ($validated) {
                $message->to($validated['email']);
                $message->subject('Verifikasi dulu email kamu yuk!');
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $result = User::with(['personal'])->find($userData->id);
        $result['message'] = 'User registered succesfully!';


        return $result;
    }

    private function __getUniqueName($fullname)
    {
        $isUnique = false;
        $uname = strtolower(str_replace(' ', '', $fullname));
        do {
            $checkExistingData = User::where('uname', $uname)->latest('created_at')->first();
            if ($checkExistingData !== null) {
                $lastID = $checkExistingData->id + 1;
                $uname = strtolower(str_replace(' ', '', $fullname)) . $lastID;
            } else {
                $isUnique = true;
            }
        } while ($isUnique === false);

        return $uname;
    }

    private function __getUniqueVerificationCode($digits = 5)
    {
        $isUnique = false;
        do {
            $code = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $countExistingData = UserVerification::where('code', $code)->count();
            if ($countExistingData < 1) {
                $isUnique = true;
            }
        } while ($isUnique === false);

        return $code;
    }
}
