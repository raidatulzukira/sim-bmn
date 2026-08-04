<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $users = User::when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('operator.pengguna.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        return view('operator.pengguna.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        
        $passwordRaw = $validated['password'];
        $validated['password'] = Hash::make($passwordRaw);
        
        // Akun aktif secara status, tapi belum diverifikasi emailnya (email_verified_at = null bawaan database)

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $passwordRaw) {
                $user = User::create($validated);

                // Buat signed URL yang berlaku 48 jam untuk aktivasi
                $activationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                    'activation.verify',
                    now()->addHours(48),
                    ['user' => $user->id]
                );

                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountActivationMail($user, $passwordRaw, $activationUrl));
            });
            
            return redirect()->route('operator.pengguna.index')
                ->with('success', 'Pengguna berhasil ditambahkan. Email aktivasi telah dikirim ke pengguna.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat pengguna. Pastikan email yang dimasukkan aktif dan konfigurasi email benar. Pesan error: ' . $e->getMessage());
        }
    }

    public function edit(User $pengguna)
    {
        return view('operator.pengguna.edit', compact('pengguna'));
    }

    public function update(UpdateUserRequest $request, User $pengguna)
    {
        $validated = $request->validated();

        if (filled($validated['password'] ?? null)) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pengguna->update($validated);

        return redirect()->route('operator.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return redirect()->route('operator.pengguna.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();

        return redirect()->route('operator.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function toggleActive(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return redirect()->route('operator.pengguna.index')
                ->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $pengguna->update(['is_active' => !$pengguna->is_active]);

        $status = $pengguna->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('operator.pengguna.index')
            ->with('success', "Akun pengguna berhasil {$status}.");
    }
}
