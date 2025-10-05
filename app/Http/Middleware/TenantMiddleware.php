<?php

namespace App\Http\Middleware;

use App\Services\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para gestionar el multitenancy
 * 
 * Extrae el tenant ID del header X-Tenant-ID y lo almacena en el contexto
 * todas las peticiones luego usaran este tenant para filtrar los datos
 */
class TenantMiddleware
{
    public function __construct(
        private readonly TenantContext $tenantContext
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->header('X-Tenant-ID');

        if (!$tenantId) {
            return response()->json([
                'error' => 'Tenant ID obligatorio',
                'message' => 'Por favor proporciona el header X-Tenant-ID'
            ], 400);
        }

        // validar que sea un numero valido
        if (!is_numeric($tenantId) || $tenantId <= 0) {
            return response()->json([
                'error' => 'Tenant ID invalido',
                'message' => 'El X-Tenant-ID debe ser un numero entero positivo'
            ], 400);
        }

        // establecer el tenant en el contexto
        $this->tenantContext->setTenant((int) $tenantId);

        // tambien agregarlo al request para usarlo mas facil
        $request->merge(['tenant_id' => (int) $tenantId]);

        return $next($request);
    }
}
