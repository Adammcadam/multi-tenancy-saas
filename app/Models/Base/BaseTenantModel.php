<?php

namespace App\Models\Base;

use App\Services\OrganisationContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseTenantModel extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('organisation', function (Builder $builder) {
            $org = app(OrganisationContext::class)->current();

            if ($org) {
                $builder->where(
                    $builder->getModel()->getTable() . '.organisation_id',
                    $org->id
                );
            }
        });

        static::creating(function ($model) {
            if (! $model->organisation_id) {
                $model->organisation_id = app(OrganisationContext::class)
                    ->current()?->id;
            }
        });
    }
}
