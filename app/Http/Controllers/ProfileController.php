<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user()->fill($request->validated());

        $rules = [
            'name' => 'required|max:50',
            'photo' => 'image|file|max:1024',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'username' => 'required|min:4|max:25|alpha_dash:ascii|unique:users,username,' . $user->id
        ];

        $validatedData = $request->validate($rules);

        if ($validatedData['email'] != $user->email) {
            $validatedData['email_verified_at'] = null;
        }

        /**
         * Handle upload image
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/profile/';

            /**
             * Delete an image if exists.
             */
            if ($user->photo) {
                Storage::delete($path . $user->photo);
            }

            /**
             * Store an image to Storage.
             */
            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        User::where('id', $user->id)->update($validatedData);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diedit!');
    }

    public function settings(Request $request)
    {
        return view('profile.settings', [
            'user' => $request->user(),
        ]);
    }

    public function store_settings_store(Request $request)
{
    $request->validate(
        [
            'store_name' => 'required|max:50',
            'store_address' => 'required|max:50',
            'store_phone' => 'required|min:10',
            'store_email' => 'required|email|max:50|unique:users,store_email,' . auth()->id(),
        ],
        [
            'store_name.required' => 'Nama perusahaan wajib diisi.',
            'store_name.max' => 'Nama perusahaan tidak boleh lebih dari 50 karakter.',
            'store_address.required' => 'Alamat perusahaan wajib diisi.',
            'store_address.max' => 'Alamat perusahaan tidak boleh lebih dari 50 karakter.',
            'store_phone.required' => 'Nomor telepon perusahaan wajib diisi.',
            'store_phone.min' => 'Nomor telepon perusahaan harus memiliki setidaknya 10 angka.',
            'store_email.required' => 'Email perusahaan wajib diisi.',
            'store_email.email' => 'Email perusahaan harus berupa alamat email yang valid.',
            'store_email.max' => 'Email perusahaan tidak boleh lebih dari 50 karakter.',
            'store_email.unique' => 'Email perusahaan sudah terdaftar.',
        ]
    );

    User::find(auth()->id())->update([
        'store_name' => $request->store_name,
        'store_address' => $request->store_address,
        'store_phone' => $request->store_phone,
        'store_email' => $request->store_email,
    ]);

    return redirect()
        ->route('profile.store.settings')
        ->with('success', 'Informasi perusahaan berhasil diperbarui!');
}


    public function store_settings()
    {
        return view('profile.store-settings', [
            'user' => auth()->user(),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->to('/');
    }
}
