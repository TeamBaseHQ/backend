<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Base\Models\Team;
use Base\Models\Channel;
use Base\Http\Resources\MediaCollection;
use Base\Http\Requests\UploadMediaRequest;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UploadMedia extends APIController
{
    /**
     * @param \Base\Http\Requests\UploadMediaRequest      $request
     * @param                                             $slug
     * @param                                             $chSlug
     *
     * @return \Base\Http\Resources\MediaCollection
     */
    public function __invoke(UploadMediaRequest $request, $slug, $chSlug)
    {
        if ($request->files->count() < 1) {
            abort(400, "No file(s) selected.");
        }

        $currentUser = $request->user();

        $team = $currentUser
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channel = $team->channels()
            ->where("slug", $chSlug)
            ->first();

        throw_if(!$channel, (new ModelNotFoundException())->setModel(Channel::class, $chSlug));

        $fileCollection = $channel
            ->addAllMediaFromRequest();

        $mediaCollection = collect([]);

        foreach ($fileCollection as $media) {

            $mediaObj = $media
                ->toMediaCollection('channel_media');

            $mediaCollection->push($mediaObj);
        }

        return new MediaCollection($mediaCollection);
    }
}
