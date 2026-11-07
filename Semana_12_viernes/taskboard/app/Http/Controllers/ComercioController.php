<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComercioController extends Controller
{
    /**
     * GET /comercios
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $comercios = $user
            ->comercios()
            ->when(
                $request->buscar,
                fn($q) => $q->where(
                    'nombre_comercio',
                    'like',
                    "%{$request->buscar}%"
                )
            )
            ->when(
                $request->rubro,
                fn($q) => $q->where('rubro', $request->rubro)
            )
            ->withCount('transacciones')
            ->orderByDesc('transacciones_count')
            ->get();

        return view('comercios.index', compact('comercios'));
    }

    /**
     * GET /comercios/{comercio}
     */
    public function show(Comercio $comercio): View
    {
        // Seguridad: Verifica que el comercio pertenezca al usuario de la sesión, si no, devuelve 404
        abort_unless($comercio->user_id === Auth::id(), 404);

        $comercio->load('transacciones');

        return view('comercios.show', compact('comercio'));
    }
}
