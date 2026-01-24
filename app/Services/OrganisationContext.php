<?php

namespace App\Services;

use App\Models\Organisation;
use Illuminate\Support\Facades\Session;

class OrganisationContext
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function set(Organisation $organization): void
    {
        Session::put('current_organisation_id', $organization->id);
    }

    public function forget(): void
    {
        Session::forget('current_organisation_id');
    }

    public function current(): ?Organisation
    {
        $id = Session::get('current_organisation_id');

        if (! $id) {
            return null;
        }

        return Organisation::find($id);
    }
}
