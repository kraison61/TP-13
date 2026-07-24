<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = User::query()->orderBy('id');

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('tel', 'like', "%{$q}%");
            });
        }

        return response()->json([
            'users' => $query->get()->map(fn (User $user) => $this->formatUser($user)),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateUser($request);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'tel' => $data['tel'] ?? null,
            'address' => $data['address'] ?? null,
            'other_contact' => $data['other_contact'] ?? null,
        ]);

        return response()->json([
            'message' => 'เพิ่มผู้ใช้เรียบร้อย',
            'user' => $this->formatUser($user),
        ], 201);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = $this->validateUser($request, $user->id);

        if (
            $user->id === $request->user()->id
            && ($data['role'] ?? $user->role) !== 'admin'
        ) {
            return response()->json([
                'message' => 'ไม่สามารถลดสิทธิ์บัญชีของตัวเองได้',
            ], 422);
        }

        if (
            $user->role === 'admin'
            && ($data['role'] ?? $user->role) !== 'admin'
            && $this->adminCount() <= 1
        ) {
            return response()->json([
                'message' => 'ต้องมีผู้ดูแลระบบอย่างน้อย 1 คน',
            ], 422);
        }

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'tel' => $data['tel'] ?? null,
            'address' => $data['address'] ?? null,
            'other_contact' => $data['other_contact'] ?? null,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        $user->update($payload);

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'user' => $this->formatUser($user->fresh()),
        ]);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        if ($user->id === $request->user()->id) {
            return response()->json([
                'message' => 'ไม่สามารถลบบัญชีของตัวเองได้',
            ], 422);
        }

        if ($user->role === 'admin' && $this->adminCount() <= 1) {
            return response()->json([
                'message' => 'ต้องมีผู้ดูแลระบบอย่างน้อย 1 คน',
            ], 422);
        }

        $user->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function validateUser(Request $request, ?int $ignoreId = null): array
    {
        $passwordRules = $ignoreId
            ? ['nullable', 'string', Password::defaults()]
            : ['required', 'string', Password::defaults()];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($ignoreId),
            ],
            'password' => $passwordRules,
            'role' => ['required', Rule::in(['admin', 'customer'])],
            'tel' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:2000'],
            'other_contact' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    private function formatUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'tel' => $user->tel,
            'address' => $user->address,
            'other_contact' => $user->other_contact,
            'created_at' => optional($user->created_at)?->format('Y-m-d'),
        ];
    }

    private function adminCount(): int
    {
        return User::query()->where('role', 'admin')->count();
    }
}
