<?php

namespace App\Services;

/**
 * Servicio para gestionar el contexto del tenant
 * Principio de responsabilidad unica
 */
class TenantContext
{
    private ?int $currentTenantId = null;

    /**
     * establece el tenant
     */
    public function setTenant(int $tenantId): void
    {
        $this->currentTenantId = $tenantId;
    }

    /**
     * obtiene el tenant
     */
    public function getTenant(): ?int
    {
        return $this->currentTenantId;
    }

    /**
     * verifica si hay un tenant por defecto
     */
    public function hasTenant(): bool
    {
        return $this->currentTenantId !== null;
    }

    public function clear(): void
    {
        $this->currentTenantId = null;
    }
}
