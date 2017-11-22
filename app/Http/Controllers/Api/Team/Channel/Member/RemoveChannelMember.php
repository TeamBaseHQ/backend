<?php

namespace Base\Http\Controllers\Api\Team\Channel\Member;

use Base\Models\Team;
use Base\Models\User;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Base\Events\Team\Channel\ChannelMemberWasRemoved;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RemoveChannelMember extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug, $id)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channel = $team
            ->channels()
            ->where("slug", $chSlug)
            ->first();

        throw_if(!$channel, (new ModelNotFoundException())->setModel(Channel::class, $chSlug));

        $user_id = $id;
        $userToRemove = User::findOrFail($user_id);

        // If the Channel is Private
        if ($channel->isPrivate()) {
            $currentUserIsChannelOwner = $request->user()->id === $channel->user_id;
            abort_unless($currentUserIsChannelOwner, 403, "You are not allowed to join or add members to this channel.");
        }

        $member = $channel->members->find($user_id);

        // Already a member
        abort_unless($member, 500, "User is not a member of this channel.");

        // Remove User from the Channel
        $channel->members()->detach($user_id);

        broadcast(new ChannelMemberWasRemoved($userToRemove, $channel, $team));

        return response("");
    }
}
