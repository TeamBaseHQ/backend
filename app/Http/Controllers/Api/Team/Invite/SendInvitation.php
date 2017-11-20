<?php

namespace Base\Http\Controllers\Api\Team\Invite;

use Base\Events\Team\Invite\InvitationWasCreated;
use Base\Http\Resources\InputError;
use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SendInvitation extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        // Validate Request
        $request->validate([
            "email" => "bail|required|email",
            "message" => "bail|max:255"
        ]);

        $user = $request->user();
        $email = $request->get("email");
        $message = $request->get("message");

        $team = $user
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $existingInvitation = $team
            ->invitations()
            ->where('email', $email)
            ->first();

        if ($existingInvitation) {
            $errorMessage = $this->getErrorMessageForUser($existingInvitation);
            return InputError::build(["email" => [$errorMessage]]);
        }

        $invitation = $team
            ->invitations()
            ->create(['email' => $email, 'message' => $message]);

        $invitation->load('team', 'team.owner');

        // Fire event
        event(new InvitationWasCreated($invitation));

        return response("");
    }

    private function getErrorMessageForUser($existingInvitation)
    {
        if ($existingInvitation->is_accepted) {
            return "A User with this email is already a member of this team.";
        }

        return "An invitation has already been sent to this email.";
    }
}
