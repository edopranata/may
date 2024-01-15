<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{

    public function index()
    {
        return inertia('Data/Profile/ProfileIndex', [
            'user'  => auth()->user()
        ]);
    }

    public function update(User $profile, Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'min:3'],
            'username'  => ['required', 'string', 'min:3', Rule::unique('users')->whereNotIn('id', [$profile->id])],
            'email'     => ['required', 'email', Rule::unique('users')->whereNotIn('id', [$profile->id])],
        ]);

        DB::beginTransaction();
        try {

            $profile->update([
                'name'      => $request->name,
                'username'  => $request->username,
                'email'     => $request->email,
            ]);

            DB::commit();
            return redirect()->route('profile.index')->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Data pengguna berhasil di ubah"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Data pengguna gagal disimpan: " . $exception->getMessage()
            ]);
        }
    }

    public function password(User $user, Request $request)
    {
        $request->validate([
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'current_password'  => ['required', function ($attribute, $value, $fail) use ($user) {
                if (! Hash::check($value, $user->password)) {
                    $fail('Your current password doesnt match');
                }
            }],
        ]);


        DB::beginTransaction();
        try {

            $user->update([
                'password'  => Hash::make($request->password),
            ]);

            DB::commit();
            return redirect()->back()->with('alert', [
                'type'    => 'success',
                'title'   => 'Success',
                'message' => "Password login berhasil di ubah"
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Failed',
                'message' => "Password login gagal di ubah: " . $exception->getMessage()
            ]);
        }
    }
}
