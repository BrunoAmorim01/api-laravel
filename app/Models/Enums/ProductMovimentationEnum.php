<?php

namespace App\Models\Enums;

enum ProductMovimentationTypeEnum: string
{
    case in = 'in';
    case out = 'out';
}

enum ProductMovimentationReasonEnum: string
{
    case sell = 'sell';
    case buy = 'buy';
    case adjustment = 'adjustment';
    case transfer = 'transfer';
}
