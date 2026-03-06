<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class FirebaseAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // protected FirebaseAuth $auth;

    // public function __construct(FirebaseAuth $auth)
    // {
    //     $this->auth = $auth;
    // }

    public function handle(Request $request, Closure $next): Response
    {
        $idToken = $request->bearerToken();

        if (!$idToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $auth = Firebase::auth();
            $verifiedIdToken = $auth->verifyIdToken($idToken);

            $uid = $verifiedIdToken->claims()->get('sub');
            $name = $verifiedIdToken->claims()->get('name');
            $email = $verifiedIdToken->claims()->get('email');

            $user = User::where('email', $email)->first();

            if ($user) {
                if (!$user->firebase_uid) {
                    $user->firebase_uid = $uid;
                    $user->save();
                }
            } else {
                $user = User::create([
                    'firebase_uid' => $uid,
                    'name' => $name ?? $email,
                    'email' => $email,
                ]);
            }

            $request->setUserResolver(fn() => $user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
