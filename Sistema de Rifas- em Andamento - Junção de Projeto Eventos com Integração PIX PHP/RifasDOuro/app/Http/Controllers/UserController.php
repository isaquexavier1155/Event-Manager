<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rifa;
use App\Models\User;

class UserController extends Controller
{
    // Exemplo de método de exibição
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', ['user' => $user]);
    }

    // Exemplo de método de atualização
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Atualiza os campos com os dados do formulário
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->chave_pix = $request->input('chave_pix');

        //dd($user->email);
        // Salva as alterações no banco de dados
        $user->save();

        // Redireciona de volta à página de exibição ou para onde for apropriado
        //return redirect()->route('rifas.dashboard-minhas-configuracoes');
        return redirect()->back();
    }
}