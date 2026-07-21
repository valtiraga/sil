<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ForumTopic;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumTopicPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ForumTopic');
    }

    public function view(AuthUser $authUser, ForumTopic $forumTopic): bool
    {
        return $authUser->can('View:ForumTopic');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ForumTopic');
    }

    public function update(AuthUser $authUser, ForumTopic $forumTopic): bool
    {
        return $authUser->can('Update:ForumTopic');
    }

    public function delete(AuthUser $authUser, ForumTopic $forumTopic): bool
    {
        return $authUser->can('Delete:ForumTopic');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ForumTopic');
    }

    public function restore(AuthUser $authUser, ForumTopic $forumTopic): bool
    {
        return $authUser->can('Restore:ForumTopic');
    }

    public function forceDelete(AuthUser $authUser, ForumTopic $forumTopic): bool
    {
        return $authUser->can('ForceDelete:ForumTopic');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ForumTopic');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ForumTopic');
    }

    public function replicate(AuthUser $authUser, ForumTopic $forumTopic): bool
    {
        return $authUser->can('Replicate:ForumTopic');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ForumTopic');
    }

}