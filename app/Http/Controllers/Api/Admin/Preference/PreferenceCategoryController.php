<?php

namespace Base\Http\Controllers\Api\Admin\Preference;

use Base\Http\Resources\PreferenceCategoryCollection;
use Base\Http\Resources\PreferenceCategoryResource;
use Illuminate\Http\Request;
use Base\Models\PreferenceCategory;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Validation\Rule;

class PreferenceCategoryController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Base\Http\Resources\PreferenceCategoryCollection
     */
    public function index()
    {
        $preferenceCategories = PreferenceCategory::all();
        return new PreferenceCategoryCollection($preferenceCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Base\Http\Resources\PreferenceCategoryResource
     */
    public function store(Request $request)
    {
        $data = $request->validate(['name' => "bail|required|min:4|max:255|unique:preference_categories"]);
        $preferenceCategory = PreferenceCategory::create($data);
        return new PreferenceCategoryResource($preferenceCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Base\Models\PreferenceCategory $preferenceCategory
     *
     * @return \Base\Models\PreferenceCategory
     */
    public function show(PreferenceCategory $preferenceCategory)
    {
        return $preferenceCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request        $request
     * @param  \Base\Models\PreferenceCategory $preferenceCategory
     *
     * @return \Base\Http\Resources\PreferenceCategoryResource
     */
    public function update(Request $request, PreferenceCategory $preferenceCategory)
    {
        $data = $request->validate([
            'name' => [
                "bail", "required", "min:4", "max:255",
                Rule::unique('preference_categories')->ignore($preferenceCategory->id)
            ],
        ]);

        $preferenceCategory->update($data);
        return new PreferenceCategoryResource($preferenceCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Base\Models\PreferenceCategory $preferenceCategory
     *
     * @return \Response
     */
    public function destroy(PreferenceCategory $preferenceCategory)
    {
        $preferenceCategory->delete();
        return response("");
    }
}
