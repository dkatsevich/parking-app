<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();

        /** @var User $user description */

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'accept-token' => $user->createToken($device)->plainTextToken
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {

        // 1 Way
        // $user = User::findOrFail($request->input('email'))->first();
        // if (!$user || Hash::check($request->input('password'), $user->password)) {
        //     throw ValidationException::withMessages([
        //         'message' => "Пароль чи пошта введені невірно"
        //     ]);
        // }

        // 2 Way
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => "Пароль чи пошта введені невірно"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var User $user */
        $user = Auth::user();
        // auth()->user()
        // auth()->attempt()

        $device = substr($request->userAgent() ?? '', 0, 255);
        $expirityAt = $request->remember ? null : now()->addMinutes(config('session.lifetime'));

        return response()->json([
            'access_token' => $user->createToken($device, expiresAt: $expirityAt)->plainTextToken
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
