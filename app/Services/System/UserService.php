<?php

namespace App\Services\System;

use App\Enums\ProfileInfos\UserStatusEnum;
use App\Models\System\User;
use App\Services\BaseService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserService extends BaseService
{
    public function __construct(protected User $user)
    {
        parent::__construct();
    }

    public function tableSearchByNameAndCpf(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $query) use ($search): Builder {
            return $query->where('cpf', 'like', "%{$search}%")
                ->orWhereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), '/', '') LIKE ?", ["%{$search}%"])
                ->orWhere('name', 'like', "%{$search}%");
        });
    }

    public function tableSearchByMainPhone(Builder $query, string $search): Builder
    {
        return $query->whereRaw("JSON_EXTRACT(phones, '$[0].number') LIKE ?", ["%$search%"]);
    }

    public function tableSearchByStatus(Builder $query, string $search): Builder
    {
        $statuses = UserStatusEnum::getAssociativeArray();

        $matchingStatuses = [];
        foreach ($statuses as $index => $status) {
            if (stripos($status, $search) !== false) {
                $matchingStatuses[] = $index;
            }
        }

        if ($matchingStatuses) {
            return $query->whereIn('status', $matchingStatuses);
        }

        return $query;
    }

    public function tableSortByStatus(Builder $query, string $direction): Builder
    {
        $statuses = UserStatusEnum::getAssociativeArray();

        $caseParts = [];
        $bindings = [];

        foreach ($statuses as $key => $status) {
            $caseParts[] = "WHEN ? THEN ?";
            $bindings[] = $key;
            $bindings[] = $status;
        }

        $orderByCase = "CASE status " . implode(' ', $caseParts) . " END";

        return $query->orderByRaw("$orderByCase $direction", $bindings);
    }

    /**
     * $action can be:
     * Filament\Tables\Actions\DeleteAction;
     * Filament\Actions\DeleteAction;
     */
    public function preventDeleteIf($action, User $user): void
    {
        $title = __('Ação proibida: Exclusão de usuário');

        if ($this->isUserHimself(user: $user)) {
            Notification::make()
                ->title($title)
                ->warning()
                ->body(__('Você não pode excluir seu próprio usuário do sistema por questões de segurança.'))
                ->send();

            // $action->cancel();
            $action->halt();
        }
    }

    public function deleteBulkAction(Collection $records): void
    {
        $blocked = [];
        $allowed = [];

        foreach ($records as $user) {
            if ($this->isUserHimself(user: $user)) {
                $blocked[] = $user->name;
                continue;
            }

            $allowed[] = $user;
        }

        if (!empty($blocked)) {
            $displayBlocked = array_slice($blocked, 0, 5);
            $extraCount = count($blocked) - 5;

            $message = __('Os seguintes usuários não podem ser excluídos: ') . implode(', ', $displayBlocked);

            if ($extraCount > 0) {
                $message .= " ... (+$extraCount " . __('outros') . ")";
            }

            Notification::make()
                ->title(__('Alguns usuários não puderam ser excluídos'))
                ->warning()
                ->body($message)
                ->send();
        }

        collect($allowed)->each->delete();

        if (!empty($allowed)) {
            Notification::make()
                ->title(__('Excluído'))
                ->success()
                ->send();
        }
    }

    protected function isUserHimself(User $user): bool
    {
        return auth()->id() === $user->id;
    }
}
