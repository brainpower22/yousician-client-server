<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\SongAudio;
use App\Models\SongDerivedTag;
use App\Models\SongExercise;
use App\Models\SongExerciseInfo;
use App\Models\SongGenre;
use App\Models\SongMeta;
use App\Models\SongTag;
use App\Models\UserFavoriteSong;
use App\Support\Auth;
use App\Support\Mutator;
use Illuminate\Filesystem\Filesystem;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class SongController extends Controller
{

    public function auxdata(ServerRequest $request, Response $response)
    {
        $fileNameWithoutExtension = '251_slipknot-psychosocial-official-video-hd';

        $songs = Song::where('doc_id', $request->getAttribute('id'))
            ->where('instrument', $request->getParam('instrument'))
            ->with(['audios', 'exercise', 'derived_tags', 'tags', 'images', 'meta', 'genres', 'exercise_info'])
            ->get();
        $song = $songs->first();
        $objectJson = Mutator::song($song);
        return $response->withJson($objectJson);
    }

    public function mxl(ServerRequest $request, Response $response)
    {
        $path = public_path('assets/songs/mxl/' . $request->getAttribute('id'));

        return $response->withFile($path, 'application/octet-stream');
    }

    public function audio(ServerRequest $request, Response $response)
    {
        $path = storage_path('songs/audio/' . $request->getAttribute('file') . '.ogg');

        $filesystem = app()->resolve(Filesystem::class);
        $song = $filesystem->get($path);

        header_remove('Cache-Control');
        header_remove('Connection');
        header_remove('X-Powered-By');
        header_remove('Set-Cookie');

        header('Content-Type: audio/ogg');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . strlen($song));
        echo($song);
        exit(200);
    }

    public function filterFavoriteIds(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'songs' => Auth::user()->favoriteSongs()->get()->pluck('song_id')->unique(),
        ];
        return $response->withJson($objectJson);
    }

    public function favoriteAdd(ServerRequest $request, Response $response)
    {
        if (
            UserFavoriteSong::create([
                'user_id' => session()->get('user')['_id'],
                'song_id' => $request->getAttribute('id'),
                'instrument' => $request->getParam('instrument'),
                'syllabus' => $request->getParam('syllabus'),
            ])
        ) {
            return $response->withJson((object)[]);
        } else {
            abort(403);
        }
    }

    public function favoriteRemove(ServerRequest $request, Response $response)
    {
        if (
            UserFavoriteSong::where('song_id', $request->getAttribute('id'))
                ->where('user_id', session()->get('user')['_id'])
                ->where('instrument', $request->getParam('instrument'))
                ->where('syllabus', $request->getParam('syllabus'))
                ->delete()
        ) {
            return $response->withJson((object)[]);
        } else {
            abort(403);
        }
    }

    public function userSongs(ServerRequest $request, Response $response)
    {
        $assetsPath = base_path() . 'public/assets/';
        $requestParsedBody = $request->getParsedBody();
        $ids = $this->getIds(mongoObjectId(), mongoObjectId(), $requestParsedBody);
        $date = date("Y-m-d\TH:i:s\Z");
        $songArray = array_merge($ids, $requestParsedBody, [
            'stage' => $requestParsedBody['category'],
            'composers' => $requestParsedBody['artist'],
            'published_on' => $date,
            'original_publish_date' => $date,
        ]);
        if ($modelSong = Song::create($songArray)) {
            if (file_put_contents($assetsPath . 'songs/mxl/' . $modelSong->doc_id, base64_decode($requestParsedBody['mxl_data']))) {
                SongExercise::create([
                    'song_id' => $modelSong->id,
                    'type' => 'mxl',
                    'file_id' => mongoObjectId(),
                    'metadata' => json_encode($requestParsedBody['meta']),
                ]);
                SongExerciseInfo::create(['song_id' => $modelSong->id, 'description' => '']);
                foreach ($requestParsedBody['tags'] as $genre) {
                    SongGenre::create(['song_id' => $modelSong->id, 'genre' => $genre]);
                    SongDerivedTag::create(['song_id' => $modelSong->id, 'tag' => $genre]);
                    SongTag::create(['song_id' => $modelSong->id, 'tag' => $genre]);
                    if (isset($requestParsedBody['audio_link'])) {
                        $this->uploadSong($requestParsedBody['audio_link'], $modelSong);
                    }
                }
            }
        }
        return $response->withJson((object)[]);
    }

    public function userSongsModify(ServerRequest $request, Response $response)
    {

        $assetsPath = base_path() . 'public/assets';
        $modelSong = Song::where('doc_id', $request->getAttribute('doc_id'))->first();
        $requestParsedBody = $request->getParsedBody();
        file_put_contents($assetsPath . '/songs/mxl/' . $modelSong->doc_id, base64_decode($requestParsedBody['mxl_data']));
        $modelSong->update($requestParsedBody);
        SongExercise::where('song_id', $modelSong->id)->update(['metadata' => json_encode($requestParsedBody['meta'])]);
        SongGenre::where('song_id', $modelSong->id)->update(['genre' => $requestParsedBody['tags'][0]]);
        SongDerivedTag::where('song_id', $modelSong->id)->update(['tag' => $requestParsedBody['tags'][0]]);
        SongTag::where('song_id', $modelSong->id)->update(['tag' => $requestParsedBody['tags'][0]]);

        $songAudio = SongAudio::where('song_id', $modelSong->id)->first();
        if (isset($requestParsedBody['audio_link'])) {
            switch ($requestParsedBody['audio_link']['type']) {
                case 'compressedaudiofile':
                    $this->processCompressedAudioFile($requestParsedBody['audio_link'], $songAudio, $modelSong);
                    break;
                case 'youtube':
                    $this->processYoutube($requestParsedBody['audio_link'], $songAudio, $modelSong);
                    break;
            }
        }
        return $response->withJson((object)[]);
    }

    public function songsUserRemove(ServerRequest $request, Response $response)
    {
        $modelSong = Song::where('doc_id', $request->getAttribute('doc_id'))->first();
        SongExercise::where('song_id', $modelSong->id)->delete();
        SongGenre::where('song_id', $modelSong->id)->delete();
        SongDerivedTag::where('song_id', $modelSong->id)->delete();
        SongTag::where('song_id', $modelSong->id)->delete();
        $songAudio = SongAudio::where('song_id', $modelSong->id)->first();
        if ($songAudio) {
            $assetsPath = base_path() . 'public/assets';
            $songAudio->delete();
            unlink($assetsPath . $songAudio->getRawOriginal('url'));
        }
        $modelSong->delete();
        return $response->withJson((object)[]);
    }

    public function uploadSong($audio_link, $modelSong): void
    {
        $createSongAudio = true;
        $songAudioUrl = $audio_link['url'];
        $assetsPath = base_path() . 'public/assets/';
        $name = $original_file_name = $audio_link['type'];
        switch ($audio_link['type']) {
            case 'compressedaudiofile':
                $pathInfo = pathinfo($audio_link['url']);
                $name = $original_file_name = $pathInfo['basename'];
                $songAudioUrl = '/' . 'songs/audio/' . uuidV4() . '.' . $pathInfo['extension'];
                $fileName = $assetsPath . $songAudioUrl;
                $contents = file_get_contents($audio_link['url'], false, $this->getRequestContext());
                $createSongAudio = file_put_contents($fileName, $contents);
                break;
            case 'youtube':
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $songAudioUrl, $match);
                $original_file_name = $match[1];
                break;
        }

        if ($createSongAudio) {
            SongAudio::create(array_merge($audio_link, [
                'song_id' => $modelSong->id,
                '_id' => mongoObjectId(),
                'type' => $audio_link['type'],
                'url' => $songAudioUrl,
                'key' => $songAudioUrl,
                'name' => $name,
                'original_file_name' => $original_file_name,
            ]));
        }
    }

    /**
     * @param $_id
     * @param $doc_id
     * @return void
     */
    public function getIds($_id, $doc_id, $body)
    {
        if (Song::where('_id', $_id)->where('doc_id', $doc_id)->exists()) {
            $this->checkIds(mongoObjectId(), mongoObjectId(), $body);
        } else {
            $existSong = Song::where('artist', $body['artist'])->orWhere('title', $body['title'])->first();
            $existArtist = Song::where('artist', $body['artist'])->orWhere('composers', $body['artist'])->first();
            return [
                '_id' => $_id,
                'doc_id' => $doc_id,
                'owner' => session()->get('user')['_id'],
                'song' => $existSong ? $existSong['song'] : mongoObjectId(),
                'artist_id' => $existArtist ? $existArtist['artist_id'] : mongoObjectId(),
            ];
        }
    }

    public function getRequestContext()
    {
        // Create a stream
        $opts = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "method" => "GET",
                "header" =>
                    "accept: */*\r\n" .
                    "x-platform: Windows\r\n" .
                    "accept-encoding: gzip, identity\r\n" .
                    "user-agent: BestHTTP/2 v2.5.2\r\n"
            ]
        ];

        return stream_context_create($opts);
    }

    private function processCompressedAudioFile(mixed $audio_link, $songAudio, $modelSong): void
    {
        $needUpload = false;
        $assetsPath = base_path() . 'public/assets';
        if ($songAudio) {
            $songAudioPathInfo = pathinfo($songAudio->url);
            $audioLinkPathInfo = pathinfo($audio_link['url']);
            if ($songAudioPathInfo['basename'] !== $audioLinkPathInfo['basename']) {
                $songAudio->delete();
                $needUpload = true;
            }
            switch ($songAudio->type) {
                case 'compressedaudiofile':
                    if ($songAudioPathInfo['basename'] !== $audioLinkPathInfo['basename']) {
                        unlink($assetsPath . $songAudio->getRawOriginal('url'));
                    }
                    break;
                case 'youtube':
                    break;
            }
        } elseif (isset($audio_link)) {
            $needUpload = true;
        }
        if ($needUpload) {
            $this->uploadSong($audio_link, $modelSong);
        }
    }

    private function processYoutube(mixed $audio_link, $songAudio, $modelSong): void
    {
        $needUpload = false;
        $assetsPath = base_path() . 'public/assets';
        if ($songAudio) {
            $songAudioPathInfo = pathinfo($songAudio->url);
            $audioLinkPathInfo = pathinfo($audio_link['url']);
            if ($songAudioPathInfo['basename'] !== $audioLinkPathInfo['basename']) {
                $songAudio->delete();
                $needUpload = true;
            }
            switch ($songAudio->type) {
                case 'compressedaudiofile':
                    unlink($assetsPath . $songAudio->getRawOriginal('url'));
                    break;
                case 'youtube':
                    break;
            }
        } elseif (isset($audio_link)) {
            $needUpload = true;
        }
        if ($needUpload) {
            $this->uploadSong($audio_link, $modelSong);
        }
    }
}