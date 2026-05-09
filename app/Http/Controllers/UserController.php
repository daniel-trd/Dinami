<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request, $configuracao)
    {
        $status = $request->get('status');
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');

        $usuarios = User::query()

            ->when($status === 'ativo', function ($q) {
                $q->where('status', 'ativo');
            })

            ->when($status === 'inativo', function ($q) {
                $q->where('status', 'inativo');
            })

            ->when(!$status, function ($q) {
                $q->where('status', 'ativo');
            })

            ->when($search, function ($q) use ($search) {

                $q->where(function ($query) use ($search) {

                    $query->where('name', 'ILIKE', "%{$search}%")
                        ->orWhere('email', 'ILIKE', "%{$search}%");
                });
            })

            ->paginate($perPage)
            ->appends($request->query());

        return view('configuracao.usuarios.index', compact('usuarios', 'status', 'search', 'configuracao'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($configuracao)
    {
        return view('configuracao.usuarios.create', compact('configuracao'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>  'required|max:255',
            'email' => 'unique:users,email',
            'password' => 'required|min:6',
        ]);

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()
            ->route('configuracao.usuarios.index', $configuracao)
            ->with('success', 'Usuário cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show($configuracao, $id)
    {
        $usuario = User::findOrFail($id);
        return view('configuracao.usuarios.show', compact('usuario', 'configuracao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($configuracao, $id)
    {
        $usuario = User::findOrFail($id);
        return view('configuracao.usuarios.edit', compact('usuario', 'configuracao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $configuracao, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'password' => [
                'nullable',
                'min:6'
            ],
        ]);

        $usuario = User::findOrFail($id);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()
            ->route('configuracao.usuarios.index', $configuracao)
            ->with('success', 'Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function toggleStatus($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->status = $usuario->status === 'ativo' ? 'inativo' : 'ativo';
        $usuario->save();

        return back()->with(
            'success',
            $usuario->status === 'ativo'
                ? 'Usuário ativado com sucesso'
                : 'Usuário inativado com sucesso'
        );
    }
}
