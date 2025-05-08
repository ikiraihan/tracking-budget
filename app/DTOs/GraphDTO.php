<?php

namespace App\DTOs;

use Carbon\Carbon;

class GraphDTO
{
    public function __construct(
        public readonly Carbon|null $startDate = null,
        public readonly Carbon|null $endDate = null,
        public readonly string|null $userId = null,
        public readonly string|null $supirId = null,
    ) {
    }
}