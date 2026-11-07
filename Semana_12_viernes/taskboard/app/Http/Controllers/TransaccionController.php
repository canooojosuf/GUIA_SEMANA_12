<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comercio;
use App\Models\Transaccion;
use Illuminate\View\View;
use App\Http\Requests\GuardarTransaccionRequest;
use Illuminate\Support\Facades\Auth;

class TransaccionController extends Controller
{
    public function create(Comercio $comercio): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $comercios = $user->comercios()->orderBy('nombre_comercio')->get();

        return view('transacciones.create', compact('comercios'));
    }


    public function store(GuardarTransaccionRequest $request)
    {


        $transaccion = Transaccion::create($request->only([
            'comercio_id',
            'cliente_nombre',
            'monto',
        ]));

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción registrada con éxito.');
    }

    private function autorizar(Transaccion $t): void
    {
        abort_unless($t->comercio->user_id === Auth::id(), 404);
    }

    public function edit(Transaccion $transaccion)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->autorizar($transaccion);
        $comercios = $user->comercios()->orderBy('nombre_comercio')->get();
        return view('transacciones.edit', compact('transaccion', 'comercios'));
    }
    public function update(Request $request, Transaccion $transaccion)
    {
        $this->autorizar($transaccion); // <--- También al inicio de update

        // ... lógica de actualización ...
    }

    public function destroy(Transaccion $transaccion)
    {
        $this->autorizar($transaccion); // <--- También al inicio de destroy

        // ... lógica de eliminación ...
    }

    public function moverEstado(Transaccion $transaccion)
    {
        $this->autorizar($transaccion); // <--- También al inicio de moverEstado

        // ... lógica de cambio de estado ...
    }



    /* public function duplicarUltima(GuardarTransaccionRequest $request)
    {
        dd($request->validated());
    }*/
}
