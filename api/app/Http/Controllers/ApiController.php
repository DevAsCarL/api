<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class ApiController extends Controller
{
    /** 
     * Authenticate
     * @OA\Post(
     *     path="/api/register",
     *     summary="register user",
     * tags={"Authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
        @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YmQ1NWQ1OS05OWY4LTQxYTMtOGZmMS0zNDQ1ZmFkYjllODciLCJqdGkiOiI0NzNiZDRhZmUyNTQwNjJjZmM2ZDJiMjIzNWNlMTdhNzdmOGYwNmYzZjhmNzc1OTk2MTZmNmNjZjg0ZjAwN2M0ZGM5MmExZDI0ZGJkMTgyNSIsImlhdCI6MTcxMzQyNTczMS4xNDk4MjksIm5iZiI6MTcxMzQyNTczMS4xNDk4MzEsImV4cCI6MTc0NDk2MTczMS4xNDQ4MjksInN1YiI6IjMiLCJzY29wZXMiOltdfQ.mDGrQ86tmlitdTHPhLjaZHDtl_NoXDZVUxYH8f_hVIs1-ATEZjso3ICOS9yVyoAUV5M8cn3rkB8PISNcr4pxCivNbgbdEndezUZ2lBuuO3dUQ-YPdVf7tyiATAkSQqlGPN71bXnSBeNT1yWx1zvTQnmkOqcYI48MeDQHwEnt41IWpUFpjcSqjavP8_A7d9KuE9XSZ0ggwsVtSERWub8Cqa1VhYsVyLIVfVeIfT0jaYK1uA2g05Kl9fTK72DF6L0D2hUJxvNGuoOs1CzQWdxjHLENIUFcbsZwT2ugwyk1ce7N7Kgoi7EFDwLceVdogGe9yPWrWiKCfokk44h4rugPROdTp4oSHVPo_FtQv8do_MUYFTbRZs6vZUarKgQc1F6hkZImRLEUouXFWsfXS-P_jAraNkuV7YwI14VKPYqWTRZzL0FNWXblfyvpi-Zwu5fD4hCgrpC8-8JHHB_1eXHcOUZEH7I1US0Mt8uz6mw6ezJR4CURapILyMj5r423xoDfHxRmFwv7qLAN-LXOeMGG0qqo-J7hvbvlAK7ZqeB686rXCGPnHku_1tBY1cThQ7z0Avi8V-kXcY2kU2Pasjvc-LRZqcDib5CDVggqypcEbJJSETXbu_UPQwloNYXCAyLYy12vWrgwijJgBJEmttGR4hRkfWC0gSxFMMw0f_WlVVU"),
     *         )
     *     )
     * )
     */
    // POST [ name, email, password ]
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required"
        ]);

        // Create User
        $user = User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $token = $user->createToken("mytoken")->accessToken;

        return response()->json([
            "status" => true,
            "message" => "Login successful",
            "token" => $token,
            "data" => []
        ]);
    }
    /** @OA\Post(
     *     path="/api/login",
     *     summary="login user",
     *tags={"Authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
        @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YmQ1NWQ1OS05OWY4LTQxYTMtOGZmMS0zNDQ1ZmFkYjllODciLCJqdGkiOiI0NzNiZDRhZmUyNTQwNjJjZmM2ZDJiMjIzNWNlMTdhNzdmOGYwNmYzZjhmNzc1OTk2MTZmNmNjZjg0ZjAwN2M0ZGM5MmExZDI0ZGJkMTgyNSIsImlhdCI6MTcxMzQyNTczMS4xNDk4MjksIm5iZiI6MTcxMzQyNTczMS4xNDk4MzEsImV4cCI6MTc0NDk2MTczMS4xNDQ4MjksInN1YiI6IjMiLCJzY29wZXMiOltdfQ.mDGrQ86tmlitdTHPhLjaZHDtl_NoXDZVUxYH8f_hVIs1-ATEZjso3ICOS9yVyoAUV5M8cn3rkB8PISNcr4pxCivNbgbdEndezUZ2lBuuO3dUQ-YPdVf7tyiATAkSQqlGPN71bXnSBeNT1yWx1zvTQnmkOqcYI48MeDQHwEnt41IWpUFpjcSqjavP8_A7d9KuE9XSZ0ggwsVtSERWub8Cqa1VhYsVyLIVfVeIfT0jaYK1uA2g05Kl9fTK72DF6L0D2hUJxvNGuoOs1CzQWdxjHLENIUFcbsZwT2ugwyk1ce7N7Kgoi7EFDwLceVdogGe9yPWrWiKCfokk44h4rugPROdTp4oSHVPo_FtQv8do_MUYFTbRZs6vZUarKgQc1F6hkZImRLEUouXFWsfXS-P_jAraNkuV7YwI14VKPYqWTRZzL0FNWXblfyvpi-Zwu5fD4hCgrpC8-8JHHB_1eXHcOUZEH7I1US0Mt8uz6mw6ezJR4CURapILyMj5r423xoDfHxRmFwv7qLAN-LXOeMGG0qqo-J7hvbvlAK7ZqeB686rXCGPnHku_1tBY1cThQ7z0Avi8V-kXcY2kU2Pasjvc-LRZqcDib5CDVggqypcEbJJSETXbu_UPQwloNYXCAyLYy12vWrgwijJgBJEmttGR4hRkfWC0gSxFMMw0f_WlVVU"),
     *         )
     *     )
     * )
     */
    // POST [ email, password ]
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        // User object
        $user = User::where("email", $request->email)->first();

        if (!empty($user)) {

            // User exists
            if (Hash::check($request->password, $user->password)) {

                // Password matched
                $token = $user->createToken("mytoken")->accessToken;

                return response()->json([
                    "status" => true,
                    "message" => "Login successful",
                    "token" => $token,
                    "data" => []
                ]);
            } else {

                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                    "data" => []
                ]);
            }
        } else {

            return response()->json([
                "status" => false,
                "message" => "Invalid Email value",
                "data" => []
            ]);
        }
    }

    // GET [Auth: Token]
    public function logout()
    {

        $token = auth()->user()->token();

        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "User Logged out successfully"
        ]);
    }
}
