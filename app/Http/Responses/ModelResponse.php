<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\Responses\Concerns\HasResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use JustSteveKing\Tools\Http\Enums\Status;

final class ModelResponse implements Responsable
{
    use HasResponse;

    public function __construct(
        protected readonly JsonResource $data,
        protected readonly Status $status = Status::OK,
    ) {
    }
}
