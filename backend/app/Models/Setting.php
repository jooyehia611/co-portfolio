<?php

namespace App\Models;

use App\Support\Translator;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public function isBilingual(): bool
    {
        $decoded = json_decode($this->value, true);

        return is_array($decoded)
            && array_key_exists('ar', $decoded)
            && array_key_exists('en', $decoded);
    }

    public function bilingualValue(): array
    {
        return Translator::splitForForm(
            $this->isBilingual() ? json_decode($this->value, true) : $this->value
        );
    }
}
