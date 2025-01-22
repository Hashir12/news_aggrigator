<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function bulkSavePreferences(Request $request)
    {
        $authUser = Auth::user();
        if ($request->category_ids) {
            $authUser->categories()->toggle($request->category_ids);
        }

        if ($request->source_ids) {
            $authUser->sources()->toggle($request->source_ids);
        }

        if ($request->author_ids) {
            $authUser->authors()->toggle($request->source_ids);
        }
        return response()->json(['message' => 'Preferences updated successfully']);
    }
}
