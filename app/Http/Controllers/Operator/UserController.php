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
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('operator.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
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
}
