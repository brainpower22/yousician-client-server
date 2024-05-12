<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class FeaturesController extends Controller
{

    public function unauthenticated(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'features' => [
                'ys_monetization_signup_survey_2023' => [
                    'active' => true,
                    'payload' => [
                        'type' => 'string',
                        'value' => 'true',
                    ],
                ],
                'ys_monetization_signup_survey_loading_2023' => [
                    'active' => true,
                    'payload' => [
                        'type' => 'string',
                        'value' => 'false',
                    ],
                ],
            ],
        ];
        return $response->withJson($objectJson);
    }

    public function authenticated(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "features" => [
                "ys1_attribution_screen_2022" => ["active" => false],
                "ys1_terms_of_service_text_2022" => ["active" => false],
                "ys1_basics_certificate_flow_2022" => ["active" => false],
                "ys_badges_2023" => ["active" => false],
                "ys1_course_id_to_show_red_dot_2022" => ["active" => false],
                "ys1_activity_session_minutes_2023" => [
                    "active" => true,
                    "payload" => ["type" => "string", "value" => "480"],
                ],
                "ys1_warmup_enabled_2023" => [
                    "active" => true,
                    "payload" => ["type" => "string", "value" => "false"],
                ],
            ],
        ];
        return $response->withJson($objectJson);
    }

    public function syllabusName(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "syllabus_name" => "main",
        ];

        $songs = [
            "songs" => (object)[
                "5384aba17cef0c6dc155b240" => [
                    "0" => ["stars" => 4],
                    "1" => ["stars" => 4],
                    "2" => ["stars" => 4],
                ],
                "5f4dc5058cef742c3d11e6a4" => [
                    "0" => ["stars" => 4],
                    "1" => ["stars" => 4],
                    "2" => ["stars" => 4],
                ],
            ],
            "features" => []
        ];

        return $response->withJson($objectJson);
    }


}