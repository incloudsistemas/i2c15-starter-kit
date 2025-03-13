<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

abstract class BaseService
{
    public function __construct()
    {
        //
    }

    protected function getErrorException(\Throwable $e): array
    {
        // Check the class of the exception to handle it appropriately
        $message = match (get_class($e)) {
            ValidationException::class => $e->errors(),
            default => $e->getMessage(),
        };

        return [
            'success' => false,
            'message' => $message,
        ];
    }

    public function tableFilterByCreatedAt(Builder $query, array $data): Builder
    {
        return $query
            ->when(
                $data['created_from'],
                function (Builder $query, $date) use ($data) {
                    if (empty($data['created_until'])) {
                        return $query->whereDate('created_at', '=', $date);
                    }

                    return $query->whereDate('created_at', '>=', $date);
                }
            )
            ->when(
                $data['created_until'],
                fn(Builder $query, $date): Builder =>
                $query->whereDate('created_at', '<=', $date)
            );
    }

    public function tableFilterByUpdatedAt(Builder $query, array $data): Builder
    {
        return $query
            ->when(
                $data['updated_from'],
                function (Builder $query, $date) use ($data) {
                    if (empty($data['updated_until'])) {
                        return $query->whereDate('updated_at', '=', $date);
                    }

                    return $query->whereDate('updated_at', '>=', $date);
                }
            )
            ->when(
                $data['updated_until'],
                fn(Builder $query, $date): Builder =>
                $query->whereDate('updated_at', '<=', $date),
            );
    }
}
