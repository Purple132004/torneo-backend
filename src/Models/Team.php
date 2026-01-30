<?php

namespace App\Models;

use App\Traits\WithValidate;

class Team extends BaseModel
{
    use WithValidate;

    public ?string $name = null;
    public ?string $city = null;
    public ?int $founded_year = null;
    public ?string $deleted_at = null;

    protected static ?string $table = 'teams';

    protected static function validationRules(): array
    {
        return [
            'name' => ['required', 'min:1', 'max:150'],
            'city' => ['sometimes', 'min:1', 'max:100'],
            'founded_year' => ['sometimes', 'numeric']
        ];
    }
}
