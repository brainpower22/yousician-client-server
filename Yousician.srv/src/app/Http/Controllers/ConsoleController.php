<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionImage;
use App\Models\Node;
use App\Models\Song;
use App\Models\SongAudio;
use App\Models\SongDerivedTag;
use App\Models\SongExercise;
use App\Models\SongExerciseInfo;
use App\Models\SongGenre;
use App\Models\SongImage;
use App\Models\SongMeta;
use App\Models\SongTag;
use App\Models\SongVideo;
use App\Models\Task;
use App\Models\TaskAlternativeSong;
use App\Models\TaskAlternativeSongGenre;
use App\Models\TaskAudio;
use App\Models\TaskFilter;
use App\Models\TaskFilterKeyword;
use App\Models\TaskFilterName;
use App\Models\TaskImage;
use App\Models\TaskPinnedExercise;
use App\Models\TaskQuestion;
use App\Models\TaskQuestionAnswer;
use App\Models\TaskScore;
use App\Models\TaskSubtask;
use App\Models\TaskVideo;
use App\Models\TaskVideoLocalised;
use App\Models\TaskVideoSubtitle;
use App\Models\TaskVoiceOver;
use App\Models\TaskVoiceOverLocalised;
use App\Models\UserProgressMission;
use App\Models\UserProgressSong;
use App\Models\UserProgressTask;

class ConsoleController extends Controller
{
    public function fillDB()
    {
//        $this->seedSyllabus();
//        $this->seedSyllabusProgress();
//        $this->supplementSyllabusProgress();
        echo 'OK';
        exit;
    }

    public function supplementSyllabusProgress()
    {
        $jsonDate = json_decode(file_get_contents('guitar.json'), true);
        foreach ($jsonDate["missions"] as $missionKey => $mission) {
            $test = 'ok';
        }
    }

    public function seedSyllabus()
    {
        /*
        Mission::truncate();
        Task::truncate();
        TaskVideo::truncate();
        TaskVideoSubtitle::truncate();
        TaskVideoLocalised::truncate();
        TaskAudio::truncate();
        TaskScore::truncate();
        MissionImage::truncate();
        Node::truncate();
        TaskFilterKeyword::truncate();
        TaskPinnedExercise::truncate();
        TaskFilter::truncate();
        TaskQuestion::truncate();
        TaskQuestionAnswer::truncate();
        TaskImage::truncate();
        TaskSubtask::truncate();
        TaskVoiceOver::truncate();
        TaskVoiceOverLocalised::truncate();
        TaskAlternativeSong::truncate();
        TaskAlternativeSongGenre::truncate();
*/

        Song::truncate();
        SongAudio::truncate();
        SongExercise::truncate();
        SongDerivedTag::truncate();
        SongTag::truncate();
        SongImage::truncate();
        SongMeta::truncate();
        SongGenre::truncate();
        SongVideo::truncate();
        SongExerciseInfo::truncate();

        $jsonDate = json_decode(file_get_contents('d:\Projects\yousician\materials\guitar_only_songs.json'), true);
        /*foreach ($jsonDate["missions"] as $missionKey => $mission) {
            if (Mission::updateOrCreate([
                '_id' => $missionKey,
                'doc_id' => $missionKey,
            ], $mission)) {
                foreach ($mission['tasks'] as $taskKey => $task) {
                    $this->processTask($task, $taskKey, $missionKey);
                }
                /*if (isset($mission['images'])) {
                    foreach ($mission['images'] as $missionImageKey => $missionImage) {
                        $missionImage['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $missionImage['url']);
                        MissionImage::updateOrCreate([
                            'mission_id' => $missionKey,
                            'type' => $missionImageKey
                        ], array_merge($missionImage, ['mission_id' => $missionKey, 'type' => $missionImageKey]));
                    }
                }
            }
        }
        foreach ($jsonDate["nodes"] as $node) {
            Node::updateOrCreate(['mission_id' => $node['mission_id']], array_merge($node, ['instrument' => 'guitar']));
        }*/
        $tags = [];
        foreach ($jsonDate["songs"] as $song) {
            if ($song['artist'] !== 'The Yousicians' && $song['artist'] !== 'Traditional') {
                $needAdd = false;
                foreach ($song["tags"] as $tag){
                    if(!in_array($tag, $tags)){
                        $needAdd = true;
                    }
                }
                if($needAdd) {
            $this->processSong($song, 'syllabus');
        }
                $tags = array_merge($tags, $song["tags"]);
            }
        }

        print "Syllabus - end\r\n";

        /*$levels = 15;

        for ($i = 0; $i <= $levels; $i++) {
            $dir = 'd:/Projects/yousician/proxy/';
            $levelFileName = $dir . 'cache/level' . $i . '.json';
            if (file_exists($levelFileName) && $levelData = file_get_contents($levelFileName)) {
                $levelData = json_decode($levelData, JSON_OBJECT_AS_ARRAY);
                foreach ($levelData['songs'] as $keySongs => $song) {
                    $this->processSong($song);
                }
            }
            print "Level " . $i . " - end\r\n";
        }*/
    }

    public function seedSyllabusProgress()
    {
        $userId = '74685faa25b4639ff1fc85e5';
        $progress = json_decode(file_get_contents('syllabus_progress.json'), true);

        foreach ($progress["currentSyllabusData"]["tasks"] as $task_id => $task) {
            $tasksQuery[] = array_merge($task, ['user_id' => $userId, 'task_id' => $task_id, 'instrument' => 'guitar', 'version' => 'main',]);
        }
        UserProgressTask::upsert($tasksQuery, ['user_id', 'task_id', 'instrument', 'version'], ['completion', 'stars']);

        foreach ($progress["currentSyllabusData"]["songs"] as $song_id => $song) {
            $songsQuery[] = ['user_id' => $userId, 'song_id' => $song_id, 'instrument' => 'guitar', 'version' => 'main', 'data' => json_encode($song)];
        }
        UserProgressSong::upsert($songsQuery, ['user_id', 'song_id', 'instrument', 'version'], ['data']);

        foreach ($progress["currentSyllabusData"]["missions"] as $mission_id => $mission) {
            $missionsQuery[] = array_merge($mission, ['user_id' => $userId, 'mission_id' => $mission_id, 'instrument' => 'guitar', 'version' => 'main',]);
        }
        UserProgressMission::upsert($missionsQuery, ['user_id', 'mission_id', 'instrument', 'version'], ['stars', 'completion', 'level']);
    }

    public function processSong($song, $stage = null)
    {
        $needMXLfile = 'https://api.yousician.com/songs/mxl/' . $song['doc_id'];
        if ($this->downloadContent($needMXLfile)) {

            if ($modelSong = Song::firstOrCreate([
                '_id' => $song['_id'],
                'doc_id' => $song['doc_id'],
                'song' => $song['song'],
            ], array_merge($song, ['locale' => 'ru', 'stage' => $stage]))) {

                if (isset($song['audios'])) {
                    foreach ($song['audios'] as $audioKey => $audio) {
                        $audio['url'] = $this->downloadContent($audio['url']);
                        SongAudio::updateOrCreate(['_id' => $audio['_id'], 'song_id' => $modelSong->id, 'type' => $audioKey], array_merge($audio, ['song_id' => $modelSong->id]));
                    }
                }

                if (isset($song['exercise'])) {
                    SongExercise::updateOrCreate(['song_id' => $modelSong->id], array_merge($song['exercise'], ['song_id' => $modelSong->id, 'metadata' => json_encode($song['exercise']['metadata'])]));
                }

                if (isset($song['derived_tags'])) {
                    foreach ($song['derived_tags'] as $derivedTag) {
                        if (!SongDerivedTag::where('song_id', $modelSong->id)->where('tag', $derivedTag)->exists()) {
                            SongDerivedTag::create(['song_id' => $modelSong->id, 'tag' => $derivedTag]);
                        }
                    }
                }

                if (isset($song['tags'])) {
                    foreach ($song['tags'] as $tag) {
                        if (!SongTag::where('song_id', $modelSong->id)->where('tag', $tag)->exists()) {
                            SongTag::create(['song_id' => $modelSong->id, 'tag' => $tag]);
                        }
                    }
                }

                if (isset($song['images'])) {
                    foreach ($song['images'] as $imageKey => $image) {
                        $image['url'] = $this->downloadContent($image['url']);
                        SongImage::updateOrCreate(['song_id' => $modelSong->id, 'type' => $imageKey], array_merge($image, ['song_id' => $modelSong->id, 'type' => $imageKey]));
                    }
                }

                if (isset($song['videos'])) {
                    foreach ($song['videos'] as $videoKey => $video) {
                        $video['url'] = $this->downloadContent($video['url']);
                        $video['img_url'] = $this->downloadContent($video['img_url']);
                        SongVideo::updateOrCreate(['song_id' => $modelSong->id, 'type' => $videoKey], array_merge($video, ['song_id' => $modelSong->id, 'type' => $videoKey]));
                    }
                }

                if (isset($song['meta'])) {
                    SongMeta::updateOrCreate(['song_id' => $modelSong->id], array_merge($song['meta'], ['song_id' => $modelSong->id]));
                }

                if (isset($song['genres'])) {
                    foreach ($song['genres'] as $genre) {
                        if (!SongGenre::where('song_id', $modelSong->id)->where('genre', $genre)->exists()) {
                            SongGenre::create(['song_id' => $modelSong->id, 'genre' => $genre]);
                        }
                    }
                }
                if (isset($song['exercise_info'])) {
                    if (!SongExerciseInfo::where('song_id', $modelSong->id)->exists()) {
                        SongExerciseInfo::create(['song_id' => $modelSong->id, 'description' => $song['exercise_info']['description']]);
                    }
                }
            }
        }
    }

    public function processTask($task, $taskKey, $missionKey, $stage = 'main'): void
    {

        $task['order'] = $taskKey;
        $task['stage'] = $stage;
        $task['locale'] = 'ru';
        $task['mission_id'] = $missionKey;
        $modelTask = Task::updateOrCreate([
            'id' => $task['id'],
            'mission_id' => $task['mission_id'],
            'stage' => $task['stage'],
            'locale' => $task['locale'],
            'type' => $task['type'],
        ], $task);

        /*
        if (isset($task['video'])) {
            $task['video']['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $task['video']['url']);
            $video = TaskVideo::updateOrCreate(['task_id' => $modelTask->_id], array_merge($task['video'], ['task_id' => $modelTask->_id]));
            if (isset($task['video']['subtitles'])) {
                foreach ($task['video']['subtitles'] as $taskVideoSubtitleLang => $taskVideoSubtitles) {
                    $taskVideoSubtitles['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $taskVideoSubtitles['url']);
                    TaskVideoSubtitle::updateOrCreate([
                        'video_id' => $video->id,
                        'locale' => $taskVideoSubtitleLang,
                    ], array_merge($taskVideoSubtitles, ['video_id' => $video->id, 'locale' => $taskVideoSubtitleLang]));
                }
            }
            if (isset($task['video']['localised'])) {
                foreach ($task['video']['localised'] as $taskVideoLocalisedLang => $taskVideoLocalised) {
                    $taskVideoLocalised['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $taskVideoLocalised['url']);
                    TaskVideoLocalised::updateOrCreate([
                        'video_id' => $video->id,
                        'locale' => $taskVideoLocalisedLang,
                    ], array_merge($taskVideoLocalised, ['video_id' => $video->id, 'locale' => $taskVideoLocalisedLang]));
                }
            }
        }

        if (isset($task['voice_overs'])) {
            foreach ($task['voice_overs'] as $voiceOver) {
                $voiceOver['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $voiceOver['url']);
                $modelVoiceOver = TaskVoiceOver::updateOrCreate(['task_id' => $modelTask->_id, 'key' => $voiceOver['key']], array_merge($voiceOver, ['task_id' => $modelTask->_id]));
                if (isset($voiceOver['localised'])) {
                    foreach ($voiceOver['localised'] as $voiceOverLocalisedLang => $voiceOverLocalised) {
                        $voiceOverLocalised['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $voiceOverLocalised['url']);
                        TaskVoiceOverLocalised::updateOrCreate([
                            'voice_over_id' => $modelVoiceOver->id,
                            'locale' => $voiceOverLocalisedLang,
                        ], array_merge($voiceOverLocalised, ['voice_over_id' => $modelVoiceOver->id, 'locale' => $voiceOverLocalisedLang]));
                    }
                }
            }
        }

        if (isset($task['audio'])) {
            $task['audio']['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $task['audio']['url']);
            TaskAudio::updateOrCreate(['task_id' => $modelTask->_id], array_merge($task['audio'], ['task_id' => $modelTask->_id]));
        }

        if (isset($task['score'])) {
            if (isset($task['score']['metadata'])) $task['score']['metadata'] = json_encode($task['score']['metadata']);
            TaskScore::updateOrCreate(['task_id' => $modelTask->_id], array_merge($task['score'], ['task_id' => $modelTask->_id]));
        }

        if (isset($task['image'])) {
            $task['image']['url'] = preg_replace('%https://.*\.cloudfront.net%i', '', $task['image']['url']);
            TaskImage::updateOrCreate([
                'task_id' => $modelTask->_id,
                'key' => $task['image']['key']
            ], array_merge($task['image'], ['task_id' => $modelTask->_id]));
        }

        if (isset($task['filter_keywords'])) {
            foreach ($task['filter_keywords'] as $filterKeyword) {
                if (!TaskFilterKeyword::where('task_id', $modelTask->_id)->where('keyword', $filterKeyword)->exists()) {
                    TaskFilterKeyword::create(['task_id' => $modelTask->_id, 'keyword' => $filterKeyword]);
                }
            }
        }

        if (isset($task['alternative_songs'])) {
            foreach ($task['alternative_songs'] as $alternativeSong) {
                if (!TaskAlternativeSong::where('task_id', $modelTask->_id)->where('song', $alternativeSong['song'])->exists()) {
                    $modelAlternativeSong = TaskAlternativeSong::create(array_merge($alternativeSong, ['task_id' => $modelTask->_id]));
                    foreach ($alternativeSong['genres'] as $alternativeSongGenre) {
                        if (!TaskAlternativeSongGenre::where('song_id', $modelAlternativeSong->id)->where('genre', $alternativeSongGenre)->exists()) {
                            TaskAlternativeSongGenre::create(['song_id' => $modelAlternativeSong->id, 'genre' => $alternativeSongGenre]);
                        }
                    }
                }
            }
        }

        if (isset($task['subtasks'])) {
            foreach ($task['subtasks'] as $subtask) {
                if (isset($task['subtasks_data'][$subtask]) && !TaskSubtask::where('task_id', $modelTask->_id)->where('subtask_id', $subtask)->exists()) {
                    TaskSubtask::create(['task_id' => $modelTask->_id, 'subtask_id' => $subtask]);
                    $this->processTask($task['subtasks_data'][$subtask], null, $missionKey, 'sub');
                }
            }
        }

        if (isset($task['questions'])) {
            foreach ($task['questions'] as $question) {
                if (!TaskQuestion::where('task_id', $modelTask->_id)->where('question', $question['question'])->exists()) {
                    $modelTaskQuestions = TaskQuestion::create(array_merge(['task_id' => $modelTask->_id], $question));
                    if (isset($question['answers'])) {
                        foreach ($question['answers'] as $answer) {
                            TaskQuestionAnswer::create(array_merge(['question_id' => $modelTaskQuestions->id], $answer));
                        }
                    }
                }
            }
        }

        if (isset($task['pinned_exercises'])) {
            foreach ($task['pinned_exercises'] as $pinnedExercise) {
                if (!TaskPinnedExercise::where('task_id', $modelTask->_id)->where('pinned_exercise', $pinnedExercise)->exists()) {
                    TaskPinnedExercise::create(['task_id' => $modelTask->_id, 'pinned_exercise' => $pinnedExercise]);
                }
            }
        }

        if (isset($task['filters'])) {
            if (!TaskFilter::where('task_id', $modelTask->_id)->exists()) {
                $filterModel = TaskFilter::create(array_merge(['task_id' => $modelTask->_id], $task['filters']));
                if (isset($task['filters']['names'])) {
                    foreach ($task['filters']['names'] as $filterNames) {
                        if (!TaskFilterName::where('filter_id', $filterModel->id)->where('name', $filterNames)->exists()) {
                            TaskFilterName::create(['filter_id' => $filterModel->id, 'name' => $filterNames]);
                        }
                    }
                }
            }
        }
        */
    }

    public function downloadBundles()
    {
        $downloads = base_path() . 'public/assets/bundle/';
        $apiHost = 'api.yousician.com';
        $apiUrl = 'https://' . $apiHost;

        $context = $this->getRequestContext();

        $songs = Song::all();
        foreach ($songs as $song) {
            $file = $downloads . $song['song'];
            $this->chkDir($file);
            if (!file_exists($file) || !filesize($file)) {
                $url = $apiUrl . '/bundle/' . $song['song'] . '?instrument=' . $song['instrument'] . '&syllabus_version=' . $song['version'];
                if ($content = @file_get_contents($url, false, $context)) {
                    file_put_contents($file, $content);
                } else {
                    echo $song['artist'] . ' - ' . $song['title'] . ' - ' . $song['song'] . '<br>';
                }
            }
        }
        exit;
    }

    public function downloadContent($url)
    {
        $parsedUrl = parse_url($url);
        $filledAssetsPath = 'd:/Projects/yousician/server/files/src/public/assets/';
        $assetsPath = base_path() . 'public/assets/';
        if (!file_exists(realpath($assetsPath) . $parsedUrl['path'])) {
            $this->chkDir(realpath($assetsPath) . $parsedUrl['path']);
            if (file_exists($filledAssetsPath . substr($parsedUrl['path'], 1))) {
                copy($filledAssetsPath . substr($parsedUrl['path'], 1), realpath($assetsPath) . $parsedUrl['path']);
            } else {
                $context = $this->getRequestContext();
                if ($data = file_get_contents($url, false, $context)) {
                    file_put_contents(realpath($assetsPath) . $parsedUrl['path'], $data);
                } else {
                    return false;
                }
            }
        }
        return $parsedUrl['path'];
    }

    public function downloadAssets()
    {
        $this->downloadCollectionsAssets();
//        $this->allFileLinks();
//        $this->tasksMXL();
        echo 'OK';
        exit;
    }

    public function downloadCollectionsAssets()
    {
        $genresData = [];
        $jsonDate = json_decode(file_get_contents('d:\Projects\yousician\materials\content_guitar_collection_groups-homescreen.json'), true);
        foreach ($jsonDate["groups"][1]["collections"] as $collection){
            $genresData[slug($collection["details"]["title"])] = [
                'title' => $collection["details"]["title"],
                'description' => $collection["details"]["description"],
                'thumb_image' => $this->downloadContent($collection['details']['thumb_image']),
                'cover_image' => $this->downloadContent($collection['details']['cover_image']),
                'featured_image' => $this->downloadContent($collection['details']['featured_image']),
            ];
        }
        file_put_contents('genresData.json', json_encode($genresData));
    }

    public function tasksMXL()
    {
        $assetsFolder = realpath(base_path() . 'public/assets/');
        $context = $this->getRequestContext();

        $tasks = Task::where('type', 'lick_trainer')->get()->pluck('id');

        foreach ($tasks as $task) {
            $key = 'task/' . $task . '/mxl';
            $file = $assetsFolder . '/' . $key;
            $this->chkDir($file);
            if (!file_exists($file) || !filesize($file)) {
                $data = file_get_contents('https://api.yousician.com/' . $key, false, $context);
                if ($data) {
                    file_put_contents($file, $data);
                }
            }
        }
    }

    public function allFileLinks()
    {
        $assetsFolder = realpath(base_path() . 'public/assets/');
        $home = base_path() . 'guitar.json';
        $homeData = file_get_contents($home);

        $context = $this->getRequestContext();

        preg_match_all('%"url": "(.*)"%iUm', $homeData, $links);

        foreach ($links[1] as $link) {
            $assetsFile = preg_replace('%https://.*\.cloudfront.net%i', '', $link);
            $file = $assetsFolder . $assetsFile;
            $this->chkDir($file);
            if (!file_exists($file) || !filesize($file)) {
                file_put_contents($file, file_get_contents($link, false, $context));
            }
        }
    }

    public function chkDir($file)
    {
        $dirname = pathinfo($file)['dirname'];
        if (!file_exists($dirname)) {
            mkdir($dirname, 777, true);
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
                    "x-application-version: 4.87.0\r\n" .
                    "x-application-name: Yousician\r\n" .
                    "x-platform: Windows\r\n" .
                    "accept-encoding: gzip, identity\r\n" .
                    "user-agent: BestHTTP/2 v2.5.2\r\n" .
                    "cookie: session=" . file_get_contents('d:\Projects\yousician\proxy\session') . "\r\n"
            ]
        ];

        return stream_context_create($opts);
    }
}