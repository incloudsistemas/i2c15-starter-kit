<?php

namespace App\Policies\System;

use App\Models\System\Role;
use App\Models\System\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(permission: 'Visualizar Níveis de Acessos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(permission: 'Visualizar Níveis de Acessos');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(permission: 'Cadastrar Níveis de Acessos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        if (in_array($role->name, ['Superadministrador', 'Cliente'])) {
            return false;
        }

        return $user->hasPermissionTo(permission: 'Editar Níveis de Acessos');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        if (in_array($role->name, ['Superadministrador', 'Cliente', 'Administrador'])) {
            return false;
        }

        return $user->hasPermissionTo(permission: 'Deletar Níveis de Acessos');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }
}
