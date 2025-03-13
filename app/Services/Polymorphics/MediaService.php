<?php

namespace App\Services\Polymorphics;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaService extends BaseService
{
    public function __construct(protected Media $media)
    {
        //
    }

    public function mutateFormDataToCreate(Model $ownerRecord, array $data): array
    {
        $data['model_type'] = MorphMapByClass(model: $ownerRecord::class);
        $data['model_id'] = $ownerRecord->id;

        return $data;
    }

    public function createAction(array $data, Model $ownerRecord): Model
    {
        return DB::transaction(function () use ($data, $ownerRecord): Model {
            foreach ($data['attachments'] as $attachment) {
                $filePath = Storage::disk('public')
                    ->path($attachment);

                $ownerRecord->addMedia($filePath)
                    ->usingName($data['name'] ?? basename($attachment))
                    ->toMediaCollection($data['collection_name'] ?? 'attachments');
            }

            return $ownerRecord;
        });
    }
}
