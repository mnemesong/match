<?php

namespace Mnemesong\Match\conditions\abstracts;

use Webmozart\Assert\Assert;

trait SimpleOperationsComparableTrait
{
    use OperatorContainsConditionTrait;

    /**
     * @return string[]
     */
    public static function allowedOperators(): array
    {
        return [
            '=', '!=', '>', '>=', '!>', '<', '<=', '!<', 'like'
        ];
    }
}