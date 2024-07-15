<?php

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ProductMovimentationTypeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {

        if ($value === 'in' || $value === 'In' || $value === 'IN') {
            return 'in';
        }

        if ($value === 'out' || $value === 'Out' || $value === 'OUT') {
            return 'out';
        }
    }

    public function set($model, string $key, $value, array $attributes)
    {

        if ($value === 'in' || $value === 'In' || $value === 'IN') {
            return 'in';
        }

        if ($value === 'out' || $value === 'Out' || $value === 'OUT') {
            return 'out';
        }
    }
}
