<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread\Message;

use Base\Events\Team\Channel\Thread\MessageWasSent;
use Base\Models\Team;
use Base\Models\Thread;
use Base\Models\Channel;
use Base\Http\Resources\MessageResource;
use Base\Http\Controllers\Api\APIController;
use Base\Http\Requests\CreateMessageRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateThreadMessage extends APIController
{
    public function __invoke(CreateMessageRequest $request, $slug, $chSlug, $thSlug)
    {
        $user = $request->user();

        $team = $user
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channel = $team
            ->channels()
            ->where("slug", $chSlug)
            ->first();

        throw_if(!$channel, (new ModelNotFoundException())->setModel(Channel::class, $chSlug));

        $thread = $channel
            ->threads()
            ->where("slug", $thSlug)
            ->first();

        throw_if(!$thread, (new ModelNotFoundException())->setModel(Thread::class, $thSlug));

        // Prepare Data
        $data = $request->only(['content', 'type']);
        $data['thread_id'] = $thread->id;

        $message = $user
            ->messages()
            ->create($data);

        $mediaIds = $request->get('media_ids');

        if ($mediaIds) {
            $message->attachments()->attach($mediaIds);
            $message->loadMissing(['attachments']);
        }

        broadcast(new MessageWasSent($channel, $thread, $message))->toOthers();

        return new MessageResource($message);
    }
}
