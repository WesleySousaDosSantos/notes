<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function loginSave(Request $request) {
        $request->validate(
            [
                'email' => 'required|email',
                'text_password' => 'required|min:6|max:16',
            ],
            // mensagem de erros
            [
                'email.required' => 'O email é obrigatório',
                'email.email' => 'Username deve ser um email valido',
                'text_password.required' => 'A senha é obrigatório',
                'text_password.min' => 'A Senha deve ter pelo menos :min caracteres',
                'text_password.max' => 'A Senha deve ter no máximo :max caracteres',
            ]
        );

        $email = $request->input('email');
        $password = $request->input('text_password');

        //estou checando se o usuario existe
        $user = User::where('email', $email)
                ->where('deleted_at', null)
                ->first();

        if(!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'email ou senha incorreta');
        }

        //estou checando se a senha está correta.
        if(!password_verify($password, $user->password)) {
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'email ou senha incorreta');
        }

        // atualizar o valor do login
        $user->last_login = date('Y-m-d H:i:s'); 
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
            ]
            ]);

            return redirect()->to('/');
    }
    public function Logout() {
        session()->forget('user');
        return redirect()->to('/login');
    }

}
