<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Node;
use App\Models\Song;
use App\Models\Task;
use App\Support\Mutator;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use DB;

class SyllabusController extends Controller
{

    public function instrument(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'missions' => (object)[],
            'songs' => [],
            'version' => 'main',
        ];
        return $response->withJson($objectJson);
    }


    public function versions(ServerRequest $request, Response $response) //v1
    {

        $objectJson = [
            "versions" => [
                "nowyoucanplay",
                "main_nycp",
                "collection_tasks",
                "collection_tasks_v_2",
                "spotlight_jason_mraz",
                "level_2_v_1",
                "level_2_v_2",
                "level_1_remove_knowledge",
                "longer_static_tabs",
                "level_1_shorter_songs",
                "level_0_nycp",
                "mission_zero_task_one_autoplay",
                "level_0_licensed_song_alternatives_2",
                "extended_basics_with_chords",
                "metallica_riff_life",
                "metallica_rhythm_guitar",
                "metallica_lead_guitar",
                "new_onboarding_flow_variant_b",
                "level_1_smoke_riff",
                "0_to_1_unchained",
                "level_0_licensed_song_alternatives",
                "basics_with_chords_v_1",
                "main_level_4_chords_first",
                "practice_mode_on_level_4",
                "unchained_v_2",
                "warmups_playground",
                "fun_songs_v_1_reverse",
                "fun_songs_v_1",
                "new_song_xp",
                "fun_songs_v_2",
                "fun_songs_v_3",
                "fun_songs_v_3_variant",
                "choosability_experiment",
                "fun_songs_v_4",
                "session_prototyping",
                "main",
                "course_jason_mraz",
                "course_juanes",
                "practice_approach_v_1",
            ],
        ];

        return $response->withJson($objectJson);
    }


}