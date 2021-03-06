<?php

namespace Base\Http\Controllers\Api\Team\Channel\Member;

use Base\Models\Team;
use Base\Models\User;
use Illuminate\Http\Request;
use Base\Http\Resources\InputError;
use Base\Http\Controllers\Api\APIController;
use Base\Events\Team\Channel\ChannelMemberWasAdded;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddChannelMember extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug)
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

        $user_id = $request->get("user_id");
        $userToAdd = User::findOrFail($user_id);

        // If the Channel is Private
        if ($channel->isPrivate()) {
            $currentUserIsChannelOwner = $request->user()->id === $channel->user_id;
            abort_unless($currentUserIsChannelOwner, 403, "You are not allowed to join or add members to this channel.");
        }

        $member = $channel->members->find($user_id);

        if ($member) {
            // Already a member
            $errorMessage = "User is already a member of this channel.";
            return InputError::build(["user_id" => [$errorMessage]]);
        }

        // Add User to the Channel
        $channel->members()->attach($user_id);

        broadcast(new ChannelMemberWasAdded($userToAdd, $channel, $team));

        return response("");
    }
}
