<?php

namespace App\Http\Controllers;

use App\Http\Resources\SourceResource;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function SourcesList(Request $request)
    {
        $sources = Source::query();

        if ($request->has('name')) {
            $sources = $sources->where('name','like', '%' . $request->get('name') . '%')
                ->orWhere('website','like','%'. $request->get('name') .'%');
        }

        $sources = $sources->orderByDesc('id')->paginate(10);
        return SourceResource::collection($sources);
    }
}
