<?php

namespace App\Http\Controllers;

use App\Models\UserProgressSong;
use App\Models\UserProgressTask;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use App\Support\View;

class HomeController extends Controller
{

    public function index(View $view)
    {
        return $view('dashboard.home');
    }


public function phpInfo(ServerRequest $request, Response $response)
    {
        phpinfo();
        exit;
    }

    public function version(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'required_version' => '4.85.0',
            'client_version' => '4.85.0',
            'client_version_valid' => true,
        ];

        return $response->withJson($objectJson);
    }

    public function home(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'rows' => [
                [
                    "item_id" => "624e89cd566f0cb8b4286b55",
                    "item_type" => "quick_links",
                    "collections" => [
                        [
                            "_id" => "626266c7671a65bf62e4a336",
                            "title" => "Недавно играли",
                            "thumb_image" =>
                                "http://127.0.0.1:8535/assets/songs/image/5644f3d0-290c-41e9-bbee-e65b255c85ba.jpg",
                            "description" =>
                                "Здесь появятся песни, которые вы играете или разучиваете. Давайте найдем вам песни!",
                        ],
                        [
                            "_id" => "626266c7671a65bf62e4a335",
                            "title" => "Избранное",
                            "thumb_image" =>
                                "http://127.0.0.1:8535/assets/artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                            "description" =>
                                "Чтобы сохранить песню в избранное, нажмите на символ сердца.",
                        ],
                    ],
                ],
                [
                    "title" => "Вы недавно играли",
                    "item_id" => "626266c7671a65bf62e4a336",
                    "item_type" => "collection",
                    "identifier" => "History",
                    "algorithm_id" => "exercise_bundle",
                    "algorithm_params" => (object)[],
                    "items" => [
                        [
                            "id" => "625e90caaf02dbdf58b0aa47",
                            "type" => "song",
                            "details" => [
                                "_id" => "6476de406d4b314bc6b927ba",
                                "doc_id" => "625e90caaf02dbdf58b0aa47",
                                "exercise_info" => ["description" => ""],
                                "derived_tags" => ["blues", "rock"],
                                "play_count" => 219295,
                                "preview" => false,
                                "public" => true,
                                "artist" => "The Yousicians",
                                "instrument" => "guitar",
                                "published_on" => "2023-05-31T05:42:29Z",
                                "tags" => ["blues", "rock"],
                                "type" => 0,
                                "composers" => "Markus Pajakkala",
                                "original_publish_date" => "2022-04-19T10:36:58Z",
                                "track_id" => 1,
                                "hidden" => true,
                                "genres" => ["blues", "rock"],
                                "meta" => (object)[],
                                "name" => "melody (short)",
                                "level" => 1,
                                "exercise" => [
                                    "file_id" => "6476de436d4b314bc6b927bb",
                                    "metadata" => [
                                        "time_info" => [
                                            "exercise_length" => 159.7058749,
                                            "average_tempo" => [
                                                "beats_per_minute" => 68.00000317333348,
                                                "quarter_notes_per_minute" => 68.00000317333348,
                                            ],
                                        ],
                                        "song_key" => [
                                            "fifths" => 0,
                                            "root_name" => "C",
                                            "mode" => "major",
                                        ],
                                        "tuning" => [
                                            "capo" => 0,
                                            "notes" => [64, 59, 55, 50, 45, 40],
                                        ],
                                        "track_names" => [
                                            "simplified melody 00",
                                            "basic melody 01",
                                            "cowboy chords 04",
                                            "rhythm 08",
                                            "rhythm & lead 09",
                                        ],
                                        "part_names" => [
                                            "Вступление",
                                            "Куплет",
                                            "Бридж",
                                            "Соло",
                                        ],
                                        "time_signature" => [
                                            "denominator" => 8,
                                            "numerator" => 6,
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 67],
                                            "lowest" => ["pitch" => 59],
                                        ],
                                        "annotations" => [],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "type" => "mxl",
                                ],
                                "owner" => "60b735c9f0e066b4b43c01c5",
                                "videos" => [
                                    "gameplay_preview" => [
                                        "img_id" => "626b914ecd39ac053ae5fbb9",
                                        "file_id" => "626b914ecd39ac053ae5fbb8",
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/exercises/video/6861111d-df08-4d6f-8044-fcfd1316cc6b.mp4",
                                        "img_url" =>
                                            "http://127.0.0.1:8535/assets/exercises/image/5a7b5766-ff47-44ed-b3b3-9d2d36b20fc4.jpg",
                                    ],
                                ],
                                "title" => "A Ladder To The Sky",
                                "playable_parts" => [2, 3],
                                "audios" => [
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/bc4b9f38-f131-4ce9-b648-87815b076a49.ogg",
                                        "key" =>
                                            "songs/audio/bc4b9f38-f131-4ce9-b648-87815b076a49.ogg",
                                        "original_file_name" =>
                                            "bc4b9f38-f131-4ce9-b648-87815b076a49",
                                        "_id" => "5c81251eb3984c64d6ac9183",
                                        "type" => "main",
                                        "name" => "main",
                                    ],
                                ],
                                "artist_id" => "5af59217e8dec32194f2af91",
                                "search" =>
                                    "the yousicians|blues|5af59217e8dec32194f2af91|rock|melody (short)|5b8e46afb3984c68ed819225|625e90caaf02dbdf58b0aa47|6476de406d4b314bc6b927ba|the yousicians a ladder to the sky|a ladder to the sky",
                                "arrangement" => "мелодия",
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/image/5644f3d0-290c-41e9-bbee-e65b255c85ba.jpg",
                                        "key" =>
                                            "songs/image/5644f3d0-290c-41e9-bbee-e65b255c85ba.jpg",
                                        "original_file_name" => "dark_hounds_560x560.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/image/99033cbf-cd0e-41ba-904e-fed139ddb94b.jpg",
                                        "key" =>
                                            "songs/image/99033cbf-cd0e-41ba-904e-fed139ddb94b.jpg",
                                        "original_file_name" =>
                                            "bundle-dark_hounds_560x560.jpg",
                                    ],
                                ],
                                "thumbnail_square" => "http://127.0.0.1:8535/assets/songs/image/5644f3d0-290c-41e9-bbee-e65b255c85ba.jpg",
                                "image_medium" => "http://127.0.0.1:8535/assets/songs/image/99033cbf-cd0e-41ba-904e-fed139ddb94b.jpg",
                                "version" => "main",
                                "is_licensed" => false,
                                "song" => "5b8e46afb3984c68ed819225",
                                "is_clear_premium" => true,
                                "ef_type" => 1
                            ],
                        ],
                        [
                            "id" => "6316053a553f2a75525b6a20",
                            "type" => "song",
                            "details" => [
                                "_id" => "6476e4c20c2d6051b60ffe0d",
                                "exercise_info" => ["description" => ""],
                                "name" => "Chorus (preview)",
                                "version" => "main",
                                "public" => true,
                                "genres" => ["pop", "folk"],
                                "artist" => "Ed Sheeran",
                                "tags" => ["acoustic", "singer-songwriter"],
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/7a07b580-01f6-4203-97bd-a940f8d08789.jpg",
                                        "key" =>
                                            "artists/image/7a07b580-01f6-4203-97bd-a940f8d08789.jpg",
                                        "original_file_name" => "Ed_Sheeran-560x560.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/cf3bc1e1-5b12-41d4-8748-55fa8940a66c.jpg",
                                        "key" =>
                                            "artists/image/cf3bc1e1-5b12-41d4-8748-55fa8940a66c.jpg",
                                        "original_file_name" => "bundle-Ed_Sheeran-560x560.jpg",
                                    ],
                                ],
                                "restriction_mode" => 2,
                                "videos" => (object)[],
                                "restricted_countries" => ["JP", "AR"],
                                "meta" => [
                                    "preview_video_processing_requested" => true,
                                    "preview_video_processing_failure" => "Tutorial/trainer",
                                ],
                                "arrangement" => "Chorus (preview)",
                                "artist_id" => "618cb121c0e2a0c834fa24b8",
                                "play_count" => 3305935,
                                "composers" => "Ed Sheeran",
                                "type" => 0,
                                "hidden" => true,
                                "is_licensed" => false,
                                "doc_id" => "6316053a553f2a75525b6a20",
                                "instrument" => "guitar",
                                "derived_tags" => ["acoustic", "singer-songwriter"],
                                "song" => "618cc04ec0e2a0c834fa24c3",
                                "original_publish_date" => "2022-09-08T13:00:57Z",
                                "audios" => [
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/89b0ae13-2d95-4fe4-95fa-a9f45566ddad.ogg",
                                        "key" =>
                                            "songs/audio/89b0ae13-2d95-4fe4-95fa-a9f45566ddad.ogg",
                                        "original_file_name" =>
                                            "Ed Sheeran - I See Fire - preview fix.ogg",
                                        "_id" => "63160325553f2a75525b6a13",
                                        "type" => "main",
                                        "name" => "level 0 preview",
                                    ],
                                ],
                                "exercise" => [
                                    "type" => "mxl",
                                    "metadata" => [
                                        "part_names" => ["Припев"],
                                        "time_signature" => [
                                            "denominator" => 4,
                                            "numerator" => 4,
                                        ],
                                        "song_key" => [
                                            "fifths" => 0,
                                            "root_name" => "C",
                                            "mode" => "major",
                                        ],
                                        "tuning" => [
                                            "capo" => 0,
                                            "notes" => [64, 59, 55, 50, 45, 40],
                                        ],
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 45],
                                            "lowest" => ["pitch" => 41],
                                        ],
                                        "time_info" => [
                                            "exercise_length" => 32.3684176,
                                            "average_tempo" => [
                                                "beats_per_minute" => 76.00000810666754,
                                                "quarter_notes_per_minute" => 76.00000810666754,
                                            ],
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "annotations" => [],
                                        "track_names" => ["I See Fire - Preview"],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "file_id" => "6476e4c40c2d6051b60ffe0e",
                                ],
                                "owner" => "60b735c9f0e066b4b43c01c5",
                                "preview" => true,
                                "title" => "I See Fire",
                                "search" =>
                                    "6316053a553f2a75525b6a20|618cb121c0e2a0c834fa24b8|6476e4c20c2d6051b60ffe0d|618cc04ec0e2a0c834fa24c3|pop|chorus (preview)|folk|i see fire|ed sheeran|ed sheeran i see fire|acoustic|singer-songwriter",
                                "published_on" => "2023-05-31T06:10:14Z",
                                "level" => 0,
                                "track_id" => 0,
                                "is_clear_premium" => true,
                            ],
                        ],
                        [
                            "id" => "631605d04859a3ba355ac915",
                            "type" => "song",
                            "details" => [
                                "_id" => "6476e4cc0c2d6051b60ffe17",
                                "exercise_info" => ["description" => ""],
                                "name" => "Chorus (preview)",
                                "version" => "main",
                                "public" => true,
                                "genres" => ["alternative", "rock"],
                                "artist" => "Soul Asylum",
                                "tags" => [],
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/4d8b0589-2eba-435f-b647-8643e16834d6.jpg",
                                        "key" =>
                                            "artists/image/4d8b0589-2eba-435f-b647-8643e16834d6.jpg",
                                        "original_file_name" => "GettyImages-1337389352.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/e0ab1f07-0662-4978-9330-ce32648ca58b.jpg",
                                        "key" =>
                                            "artists/image/e0ab1f07-0662-4978-9330-ce32648ca58b.jpg",
                                        "original_file_name" =>
                                            "bundle-GettyImages-1337389352.jpg",
                                    ],
                                ],
                                "restriction_mode" => 2,
                                "videos" => (object)[],
                                "restricted_countries" => ["AR", "JP"],
                                "meta" => [
                                    "preview_video_processing_requested" => true,
                                    "preview_video_processing_failure" => "Tutorial/trainer",
                                ],
                                "arrangement" => "Chorus (preview)",
                                "artist_id" => "62b074a06b2b44b3504c562b",
                                "play_count" => 2391894,
                                "composers" => "David Pirner",
                                "type" => 0,
                                "hidden" => true,
                                "is_licensed" => false,
                                "doc_id" => "631605d04859a3ba355ac915",
                                "instrument" => "guitar",
                                "derived_tags" => [],
                                "song" => "6136123c6e0868ed42f1a41c",
                                "original_publish_date" => "2022-09-08T13:00:57Z",
                                "audios" => [
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/197c3426-fb4a-4037-9037-c268839dcf17.ogg",
                                        "key" =>
                                            "songs/audio/197c3426-fb4a-4037-9037-c268839dcf17.ogg",
                                        "original_file_name" =>
                                            "Soul Asylum - Runaway Train - preview.ogg",
                                        "_id" => "63160256553f2a75525b6a10",
                                        "type" => "main",
                                        "name" => "level 0 preview",
                                    ],
                                ],
                                "exercise" => [
                                    "type" => "mxl",
                                    "metadata" => [
                                        "part_names" => ["Припев"],
                                        "time_signature" => [
                                            "denominator" => 4,
                                            "numerator" => 4,
                                        ],
                                        "song_key" => [
                                            "fifths" => 0,
                                            "root_name" => "C",
                                            "mode" => "major",
                                        ],
                                        "tuning" => [
                                            "capo" => 0,
                                            "notes" => [64, 59, 55, 50, 45, 40],
                                        ],
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 48],
                                            "lowest" => ["pitch" => 40],
                                        ],
                                        "time_info" => [
                                            "exercise_length" => 29.2307685,
                                            "average_tempo" => [
                                                "beats_per_minute" => 117.00000292500006,
                                                "quarter_notes_per_minute" => 117.00000292500006,
                                            ],
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "annotations" => [],
                                        "track_names" => ["Switching strings"],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "file_id" => "6476e4ce0c2d6051b60ffe18",
                                ],
                                "owner" => "60b735c9f0e066b4b43c01c5",
                                "preview" => true,
                                "title" => "Runaway Train",
                                "search" =>
                                    "rock|soul asylum|soul asylum runaway train|62b074a06b2b44b3504c562b|6476e4cc0c2d6051b60ffe17|alternative|6136123c6e0868ed42f1a41c|chorus (preview)|runaway train|631605d04859a3ba355ac915",
                                "published_on" => "2023-05-31T06:10:24Z",
                                "level" => 0,
                                "track_id" => 0,
                                "is_clear_premium" => true,
                            ],
                        ],
                        [
                            "id" => "5391ae5c7cef0c2d9c40f27b",
                            "type" => "song",
                            "details" => [
                                "_id" => "64709b39e29ea918970c2416",
                                "doc_id" => "5391ae5c7cef0c2d9c40f27b",
                                "owner" => "5b8fb221b3984c25e3e1f4f4",
                                "level" => 1,
                                "artist" => "The Yousicians",
                                "public" => true,
                                "is_licensed" => false,
                                "instrument" => "guitar",
                                "name" => "basic riff",
                                "videos" => [
                                    "gameplay_preview" => [
                                        "file_id" => "5fc4a52caf79a5cd8c2c1d41",
                                        "img_id" => "5fc4a52caf79a5cd8c2c1d42",
                                        "img_url" =>
                                            "http://127.0.0.1:8535/assets/exercises/image/6a0fc4fa-dcc8-4375-a9e2-038fd2d0d24b.jpg",
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/exercises/video/81765e1d-ba3a-42f8-81a9-f24d7672751c.mp4",
                                    ],
                                ],
                                "original_publish_date" => "2014-06-06T12:04:44Z",
                                "search" =>
                                    "ballad|the yousicians|up in the air|rock|64709b39e29ea918970c2416|5391ae5c7cef0c2d9c40f27b|5af59217e8dec32194f2af91|5b8fa486b3984c209a0ac967|basic riff|the yousicians up in the air",
                                "composers" => "Markus Pajakkala",
                                "published_on" => "2023-05-26T11:42:52Z",
                                "play_count" => 5912565.5,
                                "type" => 0,
                                "audios" => [
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/afacfbad-b897-435b-aaab-1c7cc9940e44.ogg",
                                        "key" =>
                                            "songs/audio/afacfbad-b897-435b-aaab-1c7cc9940e44.ogg",
                                        "original_file_name" =>
                                            "bm-UpInTheAir110-2020version-v2.ogg",
                                        "_id" => "5c81251cb3984c64d6ac8c5c",
                                        "type" => "main",
                                        "name" => "bm-UpInTheAir110-2020version-v2.ogg",
                                    ],
                                ],
                                "exercise" => [
                                    "type" => "mxl",
                                    "file_id" => "64709b3be29ea918970c2417",
                                    "metadata" => [
                                        "time_info" => [
                                            "exercise_length" => 76.9090845,
                                            "average_tempo" => [
                                                "beats_per_minute" => 110.00000916666744,
                                                "quarter_notes_per_minute" => 110.00000916666743,
                                            ],
                                        ],
                                        "tuning" => [
                                            "capo" => 0,
                                            "notes" => [64, 59, 55, 50, 45, 40],
                                        ],
                                        "annotations" => [],
                                        "time_signature" => [
                                            "denominator" => 4,
                                            "numerator" => 4,
                                        ],
                                        "song_key" => [
                                            "root_name" => "C",
                                            "fifths" => 0,
                                            "mode" => "major",
                                        ],
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 48],
                                            "lowest" => ["pitch" => 40],
                                        ],
                                        "track_names" => ["Riff LVL01", "Bass"],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "part_names" => [
                                            "Часть 1",
                                            "Часть 2",
                                            "Часть 3",
                                            "Часть 4",
                                        ],
                                        "annotation_texts" => (object)[],
                                    ],
                                ],
                                "complexity" => "базовые",
                                "song" => "5b8fa486b3984c209a0ac967",
                                "track_id" => 0,
                                "arrangement" => "рифф",
                                "derived_tags" => ["rock", "ballad"],
                                "tags" => ["rock", "ballad"],
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/image/d6860dff-811e-4da2-bc3f-44434054dcbd.png",
                                        "key" =>
                                            "songs/image/d6860dff-811e-4da2-bc3f-44434054dcbd.png",
                                        "original_file_name" => "Up In The Air 560x560.png",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/image/532800dd-ae4b-4357-a5f0-7d7f32d5e720.png",
                                        "key" =>
                                            "songs/image/532800dd-ae4b-4357-a5f0-7d7f32d5e720.png",
                                        "original_file_name" =>
                                            "bundle-Up In The Air 560x560.png",
                                    ],
                                ],
                                "hidden" => false,
                                "title" => "Up In The Air",
                                "part_count" => 4,
                                "meta" => [
                                    "simplePlayCount" => 3836869,
                                    "avgRating" => 4.002162162162157,
                                    "ratingsCount" => 1850,
                                ],
                                "artist_id" => "5af59217e8dec32194f2af91",
                                "version" => "main",
                                "genres" => ["rock"],
                                "is_clear_premium" => true,
                                "exercise_info" => ["description" => ""],
                            ],
                        ],
                    ],
                ],
                [
                    "title" => "Избранное",
                    "item_id" => "626266c7671a65bf62e4a335",
                    "item_type" => "collection",
                    "identifier" => "Favorites",
                    "algorithm_id" => "exercise_bundle",
                    "algorithm_params" => (object)[],
                    "items" => [
                        [
                            "id" => "5c4e8624e8dec316298bbd0a",
                            "type" => "song",
                            "details" => [
                                "_id" => "64759753a19ba17d1be375b1",
                                "genres" => ["metal"],
                                "instrument" => "guitar",
                                "complexity" => "основные",
                                "part_count" => 10,
                                "published_on" => "2023-05-30T06:27:35Z",
                                "audios" => [
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/a965de6a-cf54-44ff-b0e1-d15c4fe98164.ogg",
                                        "key" =>
                                            "songs/audio/a965de6a-cf54-44ff-b0e1-d15c4fe98164.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-Territory-inE-fullmix-v6.ogg",
                                        "_id" => "5c81251eb3984c64d6ac91f3",
                                        "type" => "main",
                                        "name" => "main",
                                    ],
                                ],
                                "public" => true,
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "key" =>
                                            "artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "original_file_name" => "Sepultura Big.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "key" =>
                                            "artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "original_file_name" => "bundle-Sepultura Big.jpg",
                                    ],
                                ],
                                "restricted_countries" => ["JP", "AR"],
                                "version" => "main",
                                "original_publish_date" => "2019-01-28T04:33:40Z",
                                "doc_id" => "5c4e8624e8dec316298bbd0a",
                                "owner" => "5851d7986a774519c4866f54",
                                "search" =>
                                    "territory (e)|5c4e8624e8dec316298bbd0a|sepultura|metal|5c41b39fe8dec35ffd13e1ad|64759753a19ba17d1be375b1|main riff|5c41b189e8dec35ffd13d5d7|sepultura territory (e)",
                                "is_licensed" => false,
                                "name" => "main riff",
                                "meta" => ["simplePlayCount" => 12016],
                                "artist" => "Sepultura",
                                "artist_id" => "5c41b189e8dec35ffd13d5d7",
                                "song" => "5c41b39fe8dec35ffd13e1ad",
                                "arrangement" => "рифф",
                                "track_id" => 0,
                                "play_count" => 9315.100000002853,
                                "exercise" => [
                                    "metadata" => [
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 58],
                                            "lowest" => ["pitch" => 40],
                                        ],
                                        "track_names" => ["main riff 05"],
                                        "time_signature" => [
                                            "numerator" => 4,
                                            "denominator" => 4,
                                        ],
                                        "song_key" => [
                                            "mode" => "major",
                                            "root_name" => "C",
                                            "fifths" => 0,
                                        ],
                                        "annotations" => [],
                                        "time_info" => [
                                            "average_tempo" => [
                                                "quarter_notes_per_minute" => 152.00000081066668,
                                                "beats_per_minute" => 152.00000081066668,
                                            ],
                                            "exercise_length" => 282.0369524,
                                        ],
                                        "part_names" => [
                                            "Вступление",
                                            "Куплет 1",
                                            "Припев 1",
                                            "Куплет 2",
                                            "Припев 2",
                                            "Бридж",
                                            "Соло",
                                            "Куплет 3",
                                            "Припев 3",
                                            "Концовка",
                                        ],
                                        "tuning" => [
                                            "notes" => [64, 59, 55, 50, 45, 40],
                                            "capo" => 0,
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "type" => "mxl",
                                    "file_id" => "64759755a19ba17d1be375b2",
                                ],
                                "videos" => [
                                    "gameplay_preview" => [
                                        "img_url" =>
                                            "http://127.0.0.1:8535/assets/exercises/image/a33ab7ad-24cd-447c-9f99-a5ae98a23d75.jpg",
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/exercises/video/d2fbdbdc-d61a-435f-a689-47368d150785.mp4",
                                        "img_id" => "5fd31f055b1bfb1f2c01f735",
                                        "file_id" => "5fd31f055b1bfb1f2c01f734",
                                    ],
                                ],
                                "title" => "Territory (E)",
                                "hidden" => false,
                                "derived_tags" => [],
                                "tags" => [],
                                "level" => 5,
                                "restriction_mode" => 2,
                                "type" => 0,
                                "is_clear_premium" => true,
                                "exercise_info" => ["description" => ""],
                            ],
                        ],
                        [
                            "id" => "5c4e8659e8dec316298bbd19",
                            "type" => "song",
                            "details" => [
                                "_id" => "649c08c78ec7a4301ed8166c",
                                "videos" => [
                                    "gameplay_preview" => [
                                        "img_url" =>
                                            "http://127.0.0.1:8535/assets/exercises/image/8aedd392-ad1b-47d6-b252-f04acf2bd9d4.jpg",
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/exercises/video/2f3b6d00-b824-400a-949d-c91a6e1dc6a3.mp4",
                                        "file_id" => "5fd3da9c5b1bfb1f2c0202dc",
                                        "img_id" => "5fd3da9c5b1bfb1f2c0202dd",
                                    ],
                                ],
                                "hidden" => false,
                                "doc_id" => "5c4e8659e8dec316298bbd19",
                                "song" => "5c41b368e8dec35ffd13e19f",
                                "part_count" => 10,
                                "title" => "Territory (D)",
                                "preview" => false,
                                "artist" => "Sepultura",
                                "genres" => ["metal"],
                                "restricted_countries" => ["JP", "AR"],
                                "owner" => "5851d7986a774519c4866f54",
                                "exercise_info" => ["description" => ""],
                                "is_licensed" => false,
                                "original_publish_date" => "2019-01-28T04:34:33Z",
                                "name" => "full riff (d tuning)",
                                "exercise" => [
                                    "type" => "mxl",
                                    "metadata" => [
                                        "song_key" => [
                                            "fifths" => 0,
                                            "mode" => "major",
                                            "root_name" => "C",
                                        ],
                                        "time_info" => [
                                            "exercise_length" => 282.0369524,
                                            "average_tempo" => [
                                                "quarter_notes_per_minute" => 152.00000081066668,
                                                "beats_per_minute" => 152.00000081066668,
                                            ],
                                        ],
                                        "tuning" => [
                                            "capo" => 0,
                                            "notes" => [62, 57, 53, 48, 43, 38],
                                        ],
                                        "time_signature" => [
                                            "denominator" => 4,
                                            "numerator" => 4,
                                        ],
                                        "track_names" => ["full riff 10"],
                                        "annotations" => [],
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 58],
                                            "lowest" => ["pitch" => 38],
                                        ],
                                        "part_names" => [
                                            "Вступление",
                                            "Куплет 1",
                                            "Припев 1",
                                            "Куплет 2",
                                            "Припев 2",
                                            "Бридж",
                                            "Соло",
                                            "Куплет 3",
                                            "Припев 3",
                                            "Концовка",
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "file_id" => "649c08ca8ec7a4301ed8166d",
                                ],
                                "search" =>
                                    "5c41b368e8dec35ffd13e19f|5c4e8659e8dec316298bbd19|full riff (d tuning)|sepultura|metal|sepultura territory (d)|649c08c78ec7a4301ed8166c|5c41b189e8dec35ffd13d5d7|territory (d)",
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "key" =>
                                            "artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "original_file_name" => "Sepultura Big.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "key" =>
                                            "artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "original_file_name" => "bundle-Sepultura Big.jpg",
                                    ],
                                ],
                                "restriction_mode" => 2,
                                "level" => 10,
                                "play_count" => 2760.2999999997587,
                                "instrument" => "guitar",
                                "published_on" => "2023-06-28T10:17:47Z",
                                "derived_tags" => [],
                                "artist_id" => "5c41b189e8dec35ffd13d5d7",
                                "tags" => [],
                                "meta" => [
                                    "simplePlayCount" => 4240,
                                    "preview_video_processing_requested" => true,
                                ],
                                "audios" => [
                                    "leadtrack" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/f6d2dcef-56dc-4656-89ea-9e31115b02bd.ogg",
                                        "key" =>
                                            "songs/audio/f6d2dcef-56dc-4656-89ea-9e31115b02bd.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-Territory-inD-solovoc-v6.ogg",
                                        "_id" => "5c81251fb3984c64d6ac942a",
                                        "type" => "leadtrack",
                                        "name" => "leadtrack",
                                    ],
                                    "backingtrack" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/f3e25081-3d1d-4ddb-a23b-5cc45839d867.ogg",
                                        "key" =>
                                            "songs/audio/f3e25081-3d1d-4ddb-a23b-5cc45839d867.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-Territory-inD-novoc-v6fix.ogg",
                                        "_id" => "5c81251fb3984c64d6ac942b",
                                        "type" => "backingtrack",
                                        "name" => "backingtrack",
                                    ],
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/d969791b-6b9b-499f-b25a-224feca8abc5.ogg",
                                        "key" =>
                                            "songs/audio/d969791b-6b9b-499f-b25a-224feca8abc5.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-Territory-inD-fullmix-v6fix.ogg",
                                        "_id" => "5c81251fb3984c64d6ac942c",
                                        "type" => "main",
                                        "name" => "main",
                                    ],
                                ],
                                "arrangement" => "рифф",
                                "type" => 0,
                                "track_id" => 0,
                                "public" => true,
                                "complexity" => "полные",
                                "version" => "main",
                                "is_clear_premium" => true,
                            ],
                        ],
                        [
                            "id" => "5c4e8586e8dec316298bbce0",
                            "type" => "song",
                            "details" => [
                                "_id" => "6475974ba19ba17d1be375a7",
                                "genres" => ["metal"],
                                "instrument" => "guitar",
                                "complexity" => "основные",
                                "part_count" => 8,
                                "published_on" => "2023-05-30T06:27:26Z",
                                "audios" => [
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/3a4a0a38-acaa-46bc-8f8c-92812477bf7f.ogg",
                                        "key" =>
                                            "songs/audio/3a4a0a38-acaa-46bc-8f8c-92812477bf7f.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-RefuseResist-inE-fullmix-v6fix.ogg",
                                        "_id" => "5c81251db3984c64d6ac90dd",
                                        "type" => "main",
                                        "name" => "main",
                                    ],
                                ],
                                "public" => true,
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "key" =>
                                            "artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "original_file_name" => "Sepultura Big.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "key" =>
                                            "artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "original_file_name" => "bundle-Sepultura Big.jpg",
                                    ],
                                ],
                                "restricted_countries" => ["JP", "AR"],
                                "version" => "main",
                                "original_publish_date" => "2019-01-28T04:31:02Z",
                                "doc_id" => "5c4e8586e8dec316298bbce0",
                                "owner" => "5851d7986a774519c4866f54",
                                "search" =>
                                    "6475974ba19ba17d1be375a7|sepultura|sepultura refuse / resist (e)|metal|refuse / resist (e)|90\'srock|5c41b436e8dec35ffd13e1d7|main riff|5c41b189e8dec35ffd13d5d7|5c4e8586e8dec316298bbce0",
                                "is_licensed" => false,
                                "name" => "main riff",
                                "meta" => ["simplePlayCount" => 10342],
                                "artist" => "Sepultura",
                                "artist_id" => "5c41b189e8dec35ffd13d5d7",
                                "song" => "5c41b436e8dec35ffd13e1d7",
                                "arrangement" => "рифф",
                                "track_id" => 0,
                                "play_count" => 8127.875,
                                "exercise" => [
                                    "metadata" => [
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 57],
                                            "lowest" => ["pitch" => 40],
                                        ],
                                        "track_names" => ["main riff 05"],
                                        "time_signature" => [
                                            "numerator" => 4,
                                            "denominator" => 4,
                                        ],
                                        "song_key" => [
                                            "mode" => "major",
                                            "root_name" => "G",
                                            "fifths" => 1,
                                        ],
                                        "annotations" => [],
                                        "time_info" => [
                                            "average_tempo" => [
                                                "quarter_notes_per_minute" => 118.00000005326389,
                                                "beats_per_minute" => 118.00000005326389,
                                            ],
                                            "exercise_length" => 199.7914264,
                                        ],
                                        "part_names" => [
                                            "Вступление",
                                            "Куплет 1",
                                            "Куплет 2",
                                            "Припев 1",
                                            "Соло",
                                            "Куплет 3",
                                            "Припев 2",
                                            "Концовка",
                                        ],
                                        "tuning" => [
                                            "notes" => [64, 59, 55, 50, 45, 40],
                                            "capo" => 0,
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "type" => "mxl",
                                    "file_id" => "6475974da19ba17d1be375a8",
                                ],
                                "videos" => [
                                    "gameplay_preview" => [
                                        "img_url" =>
                                            "http://127.0.0.1:8535/assets/exercises/image/c7c222f8-8d07-48a4-b77e-6309fdf4df56.jpg",
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/exercises/video/698faf36-5be2-4d79-9f89-eca4cd5c6678.mp4",
                                        "img_id" => "5fd318865b1bfb1f2c01f6b7",
                                        "file_id" => "5fd318865b1bfb1f2c01f6b6",
                                    ],
                                ],
                                "title" => "Refuse / Resist (E)",
                                "hidden" => false,
                                "derived_tags" => ["90\'srock"],
                                "tags" => ["90\'srock"],
                                "level" => 5,
                                "restriction_mode" => 2,
                                "type" => 0,
                                "is_clear_premium" => true,
                                "exercise_info" => ["description" => ""],
                            ],
                        ],
                        [
                            "id" => "5c4e85bae8dec316298bbcef",
                            "type" => "song",
                            "details" => [
                                "_id" => "6475974fa19ba17d1be375ac",
                                "genres" => ["metal"],
                                "instrument" => "guitar",
                                "complexity" => "полные",
                                "part_count" => 8,
                                "published_on" => "2023-05-30T06:27:31Z",
                                "audios" => [
                                    "leadtrack" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/00e528f6-850d-4f48-8314-4cf834e55c3f.ogg",
                                        "key" =>
                                            "songs/audio/00e528f6-850d-4f48-8314-4cf834e55c3f.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-RefuseResist-inD-solovoc-v6.ogg",
                                        "_id" => "5c81251db3984c64d6ac90ca",
                                        "type" => "leadtrack",
                                        "name" => "leadtrack",
                                    ],
                                    "main" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/6f5b462f-fbe8-43fd-8561-a431f9e75dd8.ogg",
                                        "key" =>
                                            "songs/audio/6f5b462f-fbe8-43fd-8561-a431f9e75dd8.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-RefuseResist-inD-fullmix-v6fix.ogg",
                                        "_id" => "5c81251db3984c64d6ac90cb",
                                        "type" => "main",
                                        "name" => "main",
                                    ],
                                    "backingtrack" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/songs/audio/8abfc793-9d3c-4ff7-9301-05debb889d08.ogg",
                                        "key" =>
                                            "songs/audio/8abfc793-9d3c-4ff7-9301-05debb889d08.ogg",
                                        "original_file_name" =>
                                            "bm-Sepultura-RefuseResist-inD-novoc-v6fix.ogg",
                                        "_id" => "5c81251db3984c64d6ac90cc",
                                        "type" => "backingtrack",
                                        "name" => "backingtrack",
                                    ],
                                ],
                                "public" => true,
                                "images" => [
                                    "preview" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "key" =>
                                            "artists/image/37c5d4b3-6295-4ed8-b7c0-b95486b11e5e.jpg",
                                        "original_file_name" => "Sepultura Big.jpg",
                                    ],
                                    "bundle" => [
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "key" =>
                                            "artists/image/635734a7-987a-4e3b-9364-4502efc39f90.jpg",
                                        "original_file_name" => "bundle-Sepultura Big.jpg",
                                    ],
                                ],
                                "restricted_countries" => ["JP", "AR"],
                                "version" => "main",
                                "original_publish_date" => "2019-01-28T04:31:54Z",
                                "doc_id" => "5c4e85bae8dec316298bbcef",
                                "owner" => "5851d7986a774519c4866f54",
                                "search" =>
                                    "5c4e85bae8dec316298bbcef|full riff (d tuning)|sepultura|metal|90\'srock|5c41b403e8dec35ffd13e1c9|refuse / resist (d)|sepultura refuse / resist (d)|5c41b189e8dec35ffd13d5d7|6475974fa19ba17d1be375ac",
                                "is_licensed" => false,
                                "name" => "full riff (d tuning)",
                                "meta" => ["simplePlayCount" => 3435],
                                "artist" => "Sepultura",
                                "artist_id" => "5c41b189e8dec35ffd13d5d7",
                                "song" => "5c41b403e8dec35ffd13e1c9",
                                "arrangement" => "рифф",
                                "track_id" => 0,
                                "play_count" => 2814.25,
                                "exercise" => [
                                    "metadata" => [
                                        "pitch_range" => [
                                            "highest" => ["pitch" => 57],
                                            "lowest" => ["pitch" => 38],
                                        ],
                                        "track_names" => ["full riff 10"],
                                        "time_signature" => [
                                            "numerator" => 4,
                                            "denominator" => 4,
                                        ],
                                        "song_key" => [
                                            "mode" => "major",
                                            "root_name" => "F",
                                            "fifths" => -1,
                                        ],
                                        "annotations" => [],
                                        "time_info" => [
                                            "average_tempo" => [
                                                "quarter_notes_per_minute" => 118.00000005326389,
                                                "beats_per_minute" => 118.00000005326389,
                                            ],
                                            "exercise_length" => 199.7914264,
                                        ],
                                        "part_names" => [
                                            "Вступление",
                                            "Куплет 1",
                                            "Куплет 2",
                                            "Припев 1",
                                            "Соло",
                                            "Куплет 3",
                                            "Припев 2",
                                            "Концовка",
                                        ],
                                        "tuning" => [
                                            "notes" => [62, 57, 53, 48, 43, 38],
                                            "capo" => 0,
                                        ],
                                        "version" => ["music_xml_tool" => "1.0.2"],
                                        "annotation_texts" => (object)[],
                                    ],
                                    "type" => "mxl",
                                    "file_id" => "64759751a19ba17d1be375ad",
                                ],
                                "videos" => [
                                    "gameplay_preview" => [
                                        "img_url" =>
                                            "http://127.0.0.1:8535/assets/exercises/image/b1902705-80cf-4f6a-8a97-2f0e2b9a7438.jpg",
                                        "url" =>
                                            "http://127.0.0.1:8535/assets/exercises/video/ae684053-1463-4de3-8a1b-ea2ddd0268e3.mp4",
                                        "img_id" => "5fd3e4875b1bfb1f2c02036e",
                                        "file_id" => "5fd3e4875b1bfb1f2c02036d",
                                    ],
                                ],
                                "title" => "Refuse / Resist (D)",
                                "hidden" => false,
                                "derived_tags" => ["90\'srock"],
                                "tags" => ["90\'srock"],
                                "level" => 10,
                                "restriction_mode" => 2,
                                "type" => 0,
                                "is_clear_premium" => true,
                                "exercise_info" => ["description" => ""],
                            ],
                        ],
                    ],
                ]
            ]
        ];
        return $response->withJson($objectJson);
    }

    public function userProgress(ServerRequest $request, Response $response)
    {

        foreach ($request->getParsedBody()['syllabus_progress']['tasks'] as $task_id => $task) {
            $tasksQuery[] = array_merge($task, ['user_id' => session()->get('user')['_id'], 'task_id' => $task_id, 'instrument' => 'guitar', 'version' => 'main',]);
        }

        foreach ($request->getParsedBody()['syllabus_progress']['songs'] as $song_id => $song) {
            $songsQuery[] = ['user_id' => session()->get('user')['_id'], 'song_id' => $song_id, 'instrument' => 'guitar', 'version' => 'main', 'data' => json_encode($song)];
        }

        if (
            UserProgressTask::upsert($tasksQuery, ['user_id', 'task_id', 'instrument', 'version'], ['completion', 'stars']) &&
            UserProgressSong::upsert($songsQuery, ['user_id', 'song_id', 'instrument', 'version'], ['data'])
        ) {
            $objectJson = [
                "badges" => [],
                "streak" => [
                    "current" => 1,
                    "longest" => 1,
                    "is_done_for_current_period" => true,
                ],
            ];
            return $response->withJson($objectJson);
        } else {
            abort(403);
        }
    }

}