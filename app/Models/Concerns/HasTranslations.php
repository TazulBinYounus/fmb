<?php

namespace App\Models\Concerns;

/**
 * Bilingual columns: a column "name" may have a Bangla twin "name_bn".
 * tr('name') returns the Bangla value when the site is in Bangla and it is filled,
 * otherwise the English value.
 */
trait HasTranslations
{
    public function tr(string $field): mixed
    {
        if (app()->getLocale() === 'bn') {
            $bn = $this->getAttribute($field.'_bn');
            if ($bn !== null && $bn !== '') {
                return $bn;
            }
        }

        return $this->getAttribute($field);
    }
}
