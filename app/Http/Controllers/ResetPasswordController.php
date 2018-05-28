<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        if(!$this->validateEmail($request->email)) {
            return $this->failedResponse();
        }

        $this->send($request->email);
        return $this->successResponse();
    }

    /**
     * @param $email
     * @return bool
     */
    private  function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    private function failedResponse()
    {
        return response()->json([
            'error' => 'email not found'
        ], Response::HTTP_NOT_FOUND);
    }

    private function send($email)
    {
        $token = $this->createToken($email);

        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    private function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();

        if($oldToken) {
            return $oldToken->token;
        }

        $token = str_random(60);

        $this->saveToken($token, $email);

        return $token;
    }

    private function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    private function successResponse()
    {
        return response()->json([
            'data' => 'email sent successfully, please check your inbox'
        ], Response::HTTP_OK);
    }
}
