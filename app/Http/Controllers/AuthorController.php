<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function AuthorList(Request $request)
    {
        $authors = Author::query();

        if ($request->has('name')) {
            $authors = $authors->where('name','like','%' . $request->get('name') . '%');
        }

        $authors = $authors->orderByDesc('id')
            ->paginate(10);
        return AuthorResource::collection($authors);
    }

    public function userFavoriteAuthors()
    {
        $data['userAuthor'] = Auth::user()->authors();
        $data['authors'] = Author::get();

        return ['data' => $data];
    }

    public function toggleUserAuthor($id)
    {
        Auth::user()->authors()->toggle([$id]);
        return true;
    }
}
