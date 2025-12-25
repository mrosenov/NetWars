<?php

namespace App\Http\Controllers;

use App\Models\UserNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserNetworkController extends Controller
{
    public static function generateUsername() {
        do {
            $username = Str::random(6);
        } while (UserNetwork::where('user', $username)->exists());

        return $username;
    }

    public static function generateIp() {
        do {
            $ip = rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
        } while (UserNetwork::where('ip', $ip)->exists());

        return $ip;
    }
}
