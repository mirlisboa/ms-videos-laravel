<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    private $rules = [
        'name' => 'required|max:100',
        'is_active' => 'boolean',
    ];

    public function index(Request $request)
    {
        return Genre::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        return Genre::create($request->all());
    }


    public function show(Genre $genre)
    {
        return $genre;
    }

    public function update(Request $request, Genre $genre)
    {
        $this->validate($request, $this->rules);

        return $genre->update($request->all());
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->noContent();
    }
}