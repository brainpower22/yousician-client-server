<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class BundleController extends Controller
{
    public function bundle(ServerRequest $request, Response $response)
    {
        $songs = Song::where('song', $request->getAttribute('id'))
            ->where('instrument', $request->getParam('instrument'))
            ->where('version', $request->getParam('syllabus_version'))
            ->with(['genres', 'images'])
            ->select(['id', 'song as _id', 'title', 'artist', 'is_licensed', 'level'])
            ->get();
        $song = $songs->first();
        foreach ($song->images as $imageKey => $image){
            switch ($image->type){
                case 'preview':
                    $song->background_image = $image->url;
                    break;
                case 'bundle':
                    $song->image = $image->url;
                    break;
            }
        }
        $song->levels = $songs->pluck('level');
        $song->count = $song->levels->count();
        if ($genres = $song->getRelation('genres')) {
            $song->setRelation('genres', $genres->pluck('genre'));
        }
        unset($song->images);
        unset($song->level);
        return $response->withJson($song);
    }
}