<?php

namespace Base\Http\Controllers\Api\Preference;

use Base\Http\Resources\PreferenceCollection;
use Base\Http\Resources\PreferenceResource;
use Base\Models\Preference;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Controllers\Controller;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Base\Http\Resources\PreferenceCollection
     */
    public function index()
    {
        $preferences = request()->user()->preferences;
        return new PreferenceCollection($preferences);
    }

    /**
     * Display the specified resource.
     *
     * @param $name
     *
     * @return \Base\Http\Resources\PreferenceResource
     */
    public function show($name)
    {
        $preference = request()->user()
            ->preferences()
            ->where("name", $name)
            ->first();

        throw_unless($preference, (new ModelNotFoundException())->setModel(Preference::class, $name));

        return new PreferenceResource($preference);
    }

    /**
     * Store the Preference.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param string                    $name
     *
     * @return \Base\Http\Resources\PreferenceResource
     */
    public function update(Request $request, $name)
    {
        $data = $request->validate([
            'category' => "bail|required|max:255",
            'value' => "bail|nullable|required",
        ]);

        $preference = request()->user()
            ->preferences()
            ->where("name", $name)
            ->first();

        if ($preference) {
            $preference->update($data);
        } else {
            $data['name'] = $name;
            $preference = request()->user()
                ->preferences()->create($data);
        }

        return new PreferenceResource($preference);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $name
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $preference = request()->user()
            ->preferences()
            ->where("name", $name)
            ->first();

        throw_unless($preference, (new ModelNotFoundException())->setModel(Preference::class, $name));

        $preference->delete();

        return response("");
    }
}
