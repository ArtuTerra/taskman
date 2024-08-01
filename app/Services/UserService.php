<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;

class UserService
{
    /**
     * Formats user data, can be used for relational searches
     * @param \App\Models\User $user
     * @param string|string[] $relationships
     * @return array
     */
    public function formatUserData($user, $relationships = [])
    {
        $data = (new UserResource($user))->toArray(request());

        foreach ($relationships as $relationship) {
            if ($user->relationLoaded($relationship)) {
                $relatedItems = $user->{$relationship};
                $data[$relationship] = TaskResource::collection($relatedItems)->toArray(request());
            }
        }

        return $data;
    }
}
