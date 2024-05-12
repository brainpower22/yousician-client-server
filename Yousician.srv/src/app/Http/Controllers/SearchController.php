<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Support\Mutator;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use DB;

class SearchController extends Controller
{
    public function exercises(ServerRequest $request, Response $response)
    {
        $query = $request->getParam('query');
        $songs = Song::where('instrument', $request->getParam('instrument'))
            ->where('version', $request->getParam('syllabus_version'))
            ->where(function ($sql) use ($query) {
                $sql->where('composers', 'LIKE', '%' . $query . '%')
                    ->where('artist', 'LIKE', '%' . $query . '%')
                    ->orWhere('title', 'LIKE', '%' . $query . '%');
            })
            ->with(['audios', 'exercise', 'derived_tags', 'tags', 'images', 'meta', 'genres', 'exercise_info'])
            ->take($request->getParam('count'))
            ->skip($request->getParam('skip'))
            ->get();
        $songs = $songs->map(function ($song) {
            return Mutator::song($song);
        });
        $objectJson = [
            'next_skip' =>  $songs->count() < $request->getParam('count') ? -1 : $request->getParam('count'),
            'songs' => $songs,
            'total_count' => $songs->count(),
//            'log' => DB::getQueryLog()
        ];
        return $response->withJson($objectJson);
    }
}