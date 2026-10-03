<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 4
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
|--------------------------------------------------------------------------
| Enable/Disable API Helper
|--------------------------------------------------------------------------
| Must be TRUE for the api library to work at all.
*/
$config['api_helper_enabled'] = TRUE;

/*
|--------------------------------------------------------------------------
| Payload Token Expiration (seconds) - access token lifetime
|--------------------------------------------------------------------------
*/
$config['payload_token_expiration'] = 900; // 15 minutes

/*
|--------------------------------------------------------------------------
| Refresh Token Expiration (seconds)
|--------------------------------------------------------------------------
*/
$config['refresh_token_expiration'] = 604800; // 7 days

/*
|--------------------------------------------------------------------------
| JWT Secret Token
|--------------------------------------------------------------------------
| REQUIRED. No default - must be 32+ random characters, set via .env
| (or Render Environment Variables when deployed).
| Generate both secrets at once with: php lava jwt:generate
*/
$config['jwt_secret'] = getenv('JWT_SECRET') ?: '';

/*
|--------------------------------------------------------------------------
| Refresh Token Key
|--------------------------------------------------------------------------
| REQUIRED. Must be different from jwt_secret above.
*/
$config['refresh_token_key'] = getenv('REFRESH_TOKEN_KEY') ?: '';

/*
|--------------------------------------------------------------------------
| Verify User On Each Request
|--------------------------------------------------------------------------
| TRUE = require_jwt() re-checks the users table every request and pulls
| role fresh from the database instead of trusting the token. Keep TRUE.
*/
$config['jwt_verify_user'] = TRUE;

/*
|--------------------------------------------------------------------------
| Users Table
|--------------------------------------------------------------------------
| Needs at least "id" and "role" columns. This is the same users table
| your migration activity created.
*/
$config['users_table'] = 'users';

/*
|--------------------------------------------------------------------------
| Access-Control-Allow-Origin
|--------------------------------------------------------------------------
| Which frontend URLs are allowed to call this API from a browser.
| Add your React dev server AND your deployed React Render URL.
*/
$config['allow_origin'] = [
    'http://localhost:5173',          // Vite React dev server
    'http://localhost:3000',          // Create-React-App dev server
    getenv('FRONTEND_URL') ?: '',     // your deployed React URL (set on Render)
];

/*
|--------------------------------------------------------------------------
| Refresh Token Table
|--------------------------------------------------------------------------
*/
$config['refresh_token_table'] = 'refresh_tokens';

/*
|--------------------------------------------------------------------------
| JWT Issuer / Audience
|--------------------------------------------------------------------------
*/
$config['jwt_issuer']   = 'lavalust-api';
$config['jwt_audience'] = 'lavalust-client';

/*
|--------------------------------------------------------------------------
| Rate Limiting
|--------------------------------------------------------------------------
*/
$config['rate_limit_enabled']  = true;
$config['rate_limit_requests'] = 60;
$config['rate_limit_seconds']  = 60;