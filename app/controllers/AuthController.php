<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('database');
        $this->call->library('api');
        $this->call->model('UserModel', 'usermodel');
    }

    // POST /auth/register
    public function register()
    {
        $body = $this->api->body();

        if (empty($body['username']) || empty($body['email']) || empty($body['password'])) {
            return $this->api->respond(['message' => 'username, email, and password are required'], 422);
        }

        $existing = $this->usermodel->get_by_username($body['username']);
        if ($existing) {
            return $this->api->respond(['message' => 'Username already taken'], 409);
        }

        $data = [
            'username' => $body['username'],
            'email'    => $body['email'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'role'     => $body['role'] ?? 'user',
            'is_active'=> 1,
        ];

        $this->usermodel->create($data);

        return $this->api->respond(['message' => 'User registered successfully'], 201);
    }

    // POST /auth/login
    public function login()
    {
        $body = $this->api->body();

        if (empty($body['username']) || empty($body['password'])) {
            return $this->api->respond(['message' => 'username and password are required'], 422);
        }

        $user = $this->usermodel->get_by_username($body['username']);

        if (!$user || !password_verify($body['password'], $user->password)) {
            return $this->api->respond(['message' => 'Invalid username or password'], 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'   => $user->id,
            'role' => $user->role,
        ]);

        return $this->api->respond([
            'message' => 'Login successful',
            'user'    => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
                'role'     => $user->role,
            ],
            'tokens' => $tokens,
        ], 200);
    }

    // POST /auth/refresh
    public function refresh()
    {
        $body = $this->api->body();

        if (empty($body['refresh_token'])) {
            return $this->api->respond(['message' => 'refresh_token is required'], 422);
        }

        $tokens = $this->api->refresh_access_token($body['refresh_token']);

        if (!$tokens) {
            return $this->api->respond(['message' => 'Invalid or expired refresh token'], 401);
        }

        return $this->api->respond(['tokens' => $tokens], 200);
    }

    // POST /auth/logout
    public function logout()
    {
        $body = $this->api->body();

        if (!empty($body['refresh_token'])) {
            $this->api->revoke_refresh_token($body['refresh_token']);
        }

        return $this->api->respond(['message' => 'Logged out successfully'], 200);
    }
}
