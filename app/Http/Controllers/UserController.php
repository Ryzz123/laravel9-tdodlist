<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "tittle" => "Login"
            ]);
    }

    public function doLogin(Request $request): Response| RedirectResponse
    {
        $user = $request->input("user");
        $password = $request->input("password");

        // Validate input
        if(empty($user) || empty($password)) {
            return \response()->view('user.login', [
                "tittle" => "Login",
                "error" => "User or password is required"
            ]);
        }

        if($this->userService->login($user, $password)) {
            $request->session()->put("user", $user);
            return redirect('/');
        }

        return \response()->view('user.login', [
            "tittle" => "Login",
            "error" => "User or password wrong"
        ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}