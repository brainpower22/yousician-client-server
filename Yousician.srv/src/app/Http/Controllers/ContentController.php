<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Song;
use App\Models\SongGenre;
use App\Models\UserFavoriteSong;
use App\Support\Mutator;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use DB;

class ContentController extends Controller
{
    public function collectionGroups(ServerRequest $request, Response $response)
    {
        /*
        display_type: 0 - Small, 1 - Medium, 2 - Large
        page_ids: [0 - Popular, 1 - Home, 2 - MySongs, 3 - Workouts]
        */
        $objectJson = [
            'groups' => [
                [
                    "_id" => "653d95b3c8a99d0a48dfe5dd",
                    "title" => "My Songs & Favorites",
                    "page_ids" => [0, 1, 2],
                    "display_type" => 1,
                    "collections" => $this->groupByUser()
                ],
                [
                    "_id" => "653d95cac0cd60d9fbdcd66d",
                    "title" => "Select You Genre",
                    "page_ids" => [0, 1, 2],
                    "display_type" => 1,
                    "collections" => $this->groupByGenres()
                ]
            ]
        ];
        return $response->withJson($objectJson);
    }

    public function collectionMy(ServerRequest $request, Response $response)
    {   /*
        origin: 0 - Admin_pages, 1 - User
        type: 0 - Manual, 1 - Smart, 2 - Link
        */
        $staticCollections = $this->groupByUser();
        $dynamicCollections = Collection::where('owner', session()->get('user')['_id'])->get();
        $dynamicCollections = $dynamicCollections->map(function ($collection) {
            $id = $collection['id'];
            unset($collection['id']);
            return [
                'id' => $id,
                'details' => $collection,
            ];
        })->toArray();
        $objectJson = [
            "collections" => array_merge($staticCollections, $dynamicCollections),
        ];
        return $response->withJson($objectJson);
    }

    public function collectionRemoveItems(ServerRequest $request, Response $response)
    {
        $collectionData = $request->getParsedBody();
        CollectionItem::where('collection_id', $request->getAttribute('_id'))
            ->where('item_id', $collectionData['items'][0])
            ->delete();
        return $response->withJson((object)[]);
    }

    public function collectionUpdate(ServerRequest $request, Response $response)
    {
        Collection::where('_id', $request->getAttribute('_id'))->update($request->getParsedBody());
        return $response->withJson((object)[]);
    }

    public function collectionRemove(ServerRequest $request, Response $response)
    {
        if(Collection::where('_id', $request->getAttribute('_id'))->delete()){
            if(CollectionItem::where('collection_id', $request->getAttribute('_id'))->delete()){
                return $response->withJson((object)[]);
            }
        }
    }

    public function groupByUser()
    {   /*
        origin: 0 - Admin_pages, 1 - User
        type: 0 - Manual, 1 - Smart, 2 - Link
        */
        return [
            [
                "id" => "625e90caaf02dbdf58b0aa48",
                "details" => [
                    "_id" => "mysongs",
                    "title" => "My Songs",
                    "instrument" => "guitar",
                    "owner" => "dfcf743e6af4b340c2eace3b",
                    "owner_username" => "fan",
                    "owner_data" => [
                        "user_id" => "dfcf743e6af4b340c2eace3b",
                        "username" => "fan1",
                        "is_private" => false,
                    ],
                    "public" => true,
                    "origin" => 0,
                    "show_title" => true,
                    "type" => 1,
                    "thumb_image" => "http://127.0.0.1:8535/assets/collections/image/mysongs_thumb_image.png",
                    "cover_image" => "http://127.0.0.1:8535/assets/collections/image/mysongs_cover_image.png",
                    "featured_image" => "http://127.0.0.1:8535/assets/collections/image/mysongs_featured_image.png",
                    "description" => "The songs you have created or added will appear here.",
                ],
            ],
            [
                "id" => "625e90caaf02dbdf58b0aa47",
                "details" => [
                    "_id" => "favorite",
                    "title" => "Favorite songs",
                    "instrument" => "guitar",
                    "owner" => "dfcf743e6af4b340c2eace3b",
                    "owner_username" => "fan",
                    "owner_data" => [
                        "user_id" => "dfcf743e6af4b340c2eace3b",
                        "username" => "fan1",
                        "is_private" => false,
                    ],
                    "public" => true,
                    "origin" => 0,
                    "show_title" => true,
                    "type" => 1,
                    "thumb_image" => "http://127.0.0.1:8535/assets/collections/image/favorite_thumb_image.png",
                    "cover_image" => "http://127.0.0.1:8535/assets/collections/image/favorite_cover_image.png",
                    "featured_image" => "http://127.0.0.1:8535/assets/collections/image/favorite_featured_image.png",
                    "description" => "The songs you've marked as favorites will appear here. Let's find you songs!",
                ],
            ],
        ];
    }

    /*
        public function collectionItems(ServerRequest $request, Response $response)
        {
            $objectJson = [
                'items' => [
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
                            "type" => 2,
                            "audio" => true,
                            "audio_link" => [
                                "url" =>
                                    "http://127.0.0.1:8535/assets/songs/audio/afacfbad-b897-435b-aaab-1c7cc9940e44.ogg",
                                "key" =>
                                    "songs/audio/afacfbad-b897-435b-aaab-1c7cc9940e44.ogg",
                                "original_file_name" =>
                                    "bm-UpInTheAir110-2020version-v2.ogg",
                                "_id" => "5c81251cb3984c64d6ac8c5c",
                                "type" => 1,
                                "name" => "bm-UpInTheAir110-2020version-v2.ogg",
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
                                        "http://127.0.0.1:8535/assets/collections/image/d6860dff-811e-4da2-bc3f-44434054dcbd.png",
                                    "key" =>
                                        "collections/image/d6860dff-811e-4da2-bc3f-44434054dcbd.png",
                                    "original_file_name" => "Up In The Air 560x560.png",
                                ],
                                "bundle" => [
                                    "url" =>
                                        "http://127.0.0.1:8535/assets/collections/image/532800dd-ae4b-4357-a5f0-7d7f32d5e720.png",
                                    "key" =>
                                        "collections/image/532800dd-ae4b-4357-a5f0-7d7f32d5e720.png",
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
                            "thumbnail_square" => "http://127.0.0.1:8535/assets/collections/image/bb9dff4d-6029-4483-8a2c-c5c38ec88f52.png",
                            "image_medium" => "http://127.0.0.1:8535/assets/collections/image/99033cbf-cd0e-41ba-904e-fed139ddb94b.jpg",
                            "ef_type" => 1
                        ],
                    ],
                ]
            ];
            return $response->withJson($objectJson);
        }
        */
    public function collectionItems(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'items' => $this->getSongs(
                $request->getParam('instrument'),
                $request->getAttribute('id'),
                $request->getParam('skip'),
                $request->getParam('count'),
                $request->getParam('min_level'),
                $request->getParam('max_level'),
            ),
            //'log' => DB::getQueryLog()
        ];
        return $response->withJson($objectJson);
    }

    public function getSongs($instrument, $id, $skip = 0, $count = 10, $minLevel = null, $maxLevel = null)
    {

        $songs = Song::where('instrument', $instrument);
        if (strlen($id) == 24) {
            $songs->whereIn('doc_id', CollectionItem::where('collection_id', $id)->get()->pluck('item_id')->toArray());
        } else {
            switch ($id) {
                case 'mysongs':
                    $songs->where('owner', session()->get('user')['_id']);
                    break;
                case 'favorite':
                    $songs->whereIn('doc_id', UserFavoriteSong::where('user_id', session()->get('user')['_id'])->get()->pluck('song_id')->toArray());
                    break;
                default:
                    $songs->whereIn('id', SongGenre::where('genre', $id)->get()->pluck('song_id')->toArray());
                    break;
            }
        }

        $songs->with(['audios', 'exercise', 'derived_tags', 'tags', 'images', 'meta', 'genres', 'exercise_info']);
        if ($minLevel !== null) {
            $songs->where('level', '>=', $minLevel);
        }

        if ($maxLevel !== null) {
            $songs->where('level', '<=', $maxLevel);
        }

        $songs = $songs->skip($skip)->take($count)->get();
        return $songs->map(function ($song) {
            return [
                'id' => $song->_id,
                'type' => 'song',
                'details' => Mutator::song($song)
            ];
        });
    }

    public function groupByGenres()
    {
        $genres = SongGenre::groupBy('genre')->get();
        return $genres->map(function ($genre, $key) {
            return [
                "id" => $key,
                "details" => [
                    "_id" => $genre->genre,
                    "title" => $this->genresData($genre->genre, 'title'),
                    "public" => true,
                    "show_title" => true,
                    "type" => 1,
                    "thumb_image" => assets($this->genresData($genre->genre, 'thumb_image')),
                    "cover_image" => assets($this->genresData($genre->genre, 'cover_image')),
                    "featured_image" => assets($this->genresData($genre->genre, 'featured_image')),
                    "description" => $this->genresData($genre->genre, 'description'),
                ]
            ];
        });
    }

    public function collectionAdd(ServerRequest $request, Response $response)
    {

        $collectionData = $request->getParsedBody();
        $collection = Collection::create(
            [
                '_id' => mongoObjectId(),
                'owner' => session()->get('user')['_id'],
                'title' => $collectionData['title'],
                'description' => $collectionData['description'],
                'public' => $collectionData['public'],
                'instrument' => $collectionData['instrument'],
                'syllabus' => $collectionData['syllabus'],
                'origin' => 'user',
                'type' => 'manual',
            ]
        );

        return $response->withJson([
            'id' => $collection->_id,
            'details' => $collection
        ]);
    }

    public function collectionAddItems(ServerRequest $request, Response $response)
    {
        $collectionData = $request->getParsedBody();
        foreach ($collectionData['items'] as $item) {
            $data[] = [
                'collection_id' => $request->getAttribute('_id'),
                'type' => $item['type'],
                'item_id' => $item['id'],
                'instrument' => $collectionData['instrument'],
                'syllabus' => $collectionData['syllabus'],
            ];
        }
        CollectionItem::insert($data);
        return $response->withJson((object)[]);
    }

    public function genresData($genre, $field)
    {
        $genresData = [
            "rock" => [
                "title" => "Rock On!",
                "description" =>
                    "Huge sounds, great grooves, and lots of attitude. Let’s play!",
                "thumb_image" =>
                    "/collections/image/bb9dff4d-6029-4483-8a2c-c5c38ec88f52.png",
                "cover_image" =>
                    "/collections/image/8ec17a99-47eb-47e4-b842-7ff3abc74e1f.png",
                "featured_image" =>
                    "/collections/image/bd481dc0-3537-4056-a6fa-3a79d6db4837.png",
            ],
            "pop" => [
                "title" => "Pop Star",
                "description" =>
                    "Beautiful melodies, catchy hooks, classic chords. Let's play, pop star!",
                "thumb_image" =>
                    "/collections/image/4fcc3d78-53c9-4b09-95db-87d8a23cae0a.png",
                "cover_image" =>
                    "/collections/image/716b7ab6-767c-441f-800e-48f765305008.png",
                "featured_image" =>
                    "/collections/image/de6d17bb-ffb8-4eab-9bdf-e28ebc165cae.png",
            ],
            "blues" => [
                "title" => "Playin' The Blues",
                "description" =>
                    "Intense, groovy, dramatic, and fun. Play it like you mean it!",
                "thumb_image" =>
                    "/collections/image/ae8fbc9f-b297-47a0-b2b1-9423822c0c39.png",
                "cover_image" =>
                    "/collections/image/a180340f-79be-4ac6-92cb-da1c92245f1b.png",
                "featured_image" =>
                    "/collections/image/6590434d-ce2d-46e0-b516-8e612c5c568e.png",
            ],
            "metal" => [
                "title" => "Metal Mayhem",
                "description" =>
                    "Machine-gun riffs and screaming solos. Muscle up, let's play!",
                "thumb_image" =>
                    "/collections/image/102edc6e-8504-4b4b-bfa0-be2a81e8ffda.png",
                "cover_image" =>
                    "/collections/image/02b6cdcc-eed5-4643-ab14-13d447926e0b.png",
                "featured_image" =>
                    "/collections/image/1fb6fa5d-ab57-43e1-baf3-9b6bd263b4b8.png",
            ],
            "country" => [
                "title" => "Country & Roots",
                "description" =>
                    "Time for everything Americana - folk, bluegrass, and more.",
                "thumb_image" =>
                    "/collections/image/9b38d598-dd0f-46e1-a60a-df351938b5e0.png",
                "cover_image" =>
                    "/collections/image/7773b2b2-1b82-4407-b000-01375ac52d5a.png",
                "featured_image" =>
                    "/collections/image/51d299ff-6903-41e5-9b5b-f6612191c9bc.png",
            ],
            "classical" => [
                "title" => "Classical Picks",
                "description" =>
                    "Amazing songs from history's greatest composers. Let's play!",
                "thumb_image" =>
                    "/collections/image/584105f1-1fed-4a80-97f8-12cdac4dead6.png",
                "cover_image" =>
                    "/collections/image/acf6a38a-cb09-48e3-a368-cb1954003386.png",
                "featured_image" =>
                    "/collections/image/b1228d85-080a-46de-a0b6-dc9431094a8f.png",
            ],
            "folk" => [
                "title" => "Chill Out",
                "description" =>
                    "Time to sit down, relax, and unwind with these beautiful songs.",
                "thumb_image" =>
                    "/collections/image/782fe47a-3ce2-4290-ae08-91755a1557fb.png",
                "cover_image" =>
                    "/collections/image/36fd8c83-ec6b-4278-9d3a-facd983d27ab.png",
                "featured_image" =>
                    "/collections/image/75ab2a23-cfb8-425b-9fc5-8b9e4741a2ce.png",
            ],
            "latin" => [
                "title" => "Traditional Tunes",
                "description" =>
                    "Let\'s learn some well-known songs. Lots of fun, and great for kids!",
                "thumb_image" =>
                    "/collections/image/b594a1aa-9807-4c64-bb03-72221454b2ab.png",
                "cover_image" =>
                    "/collections/image/af1abd42-49ce-47c4-8e2c-06ed2d440bc9.png",
                "featured_image" =>
                    "/collections/image/86f71546-31c6-40f5-b0a2-f4d360875139.png",
            ],
            "alternative" => [
                "title" => "Indie & Alternative",
                "description" =>
                    "From punk and ska to quirky pop and indie rock. Let's explore!",
                "thumb_image" =>
                    "/collections/image/df589365-6de4-42d9-8c0f-22471feca467.png",
                "cover_image" =>
                    "/collections/image/5768900c-f726-49de-aa90-145899179bc3.png",
                "featured_image" =>
                    "/collections/image/f01fef08-37dd-4975-802a-8e450471f6a0.png",
            ],
            "jazz" => [
                "title" => "Jazz It Up",
                "description" =>
                    "Hip chords, classy melodies, and cool grooves. Let's jam!",
                "thumb_image" =>
                    "/collections/image/e36c81da-a3a1-4034-a2fc-c35a4f3f30a0.png",
                "cover_image" =>
                    "/collections/image/da9e5735-f4fa-4272-87a0-0e0ecce11449.png",
                "featured_image" =>
                    "/collections/image/4539e95b-e862-4590-92a6-d18cd6761eb6.png",
            ],
            "funk" => [
                "title" => "Funk & Soul",
                "description" =>
                    "Great riffs, tricky chords, and unstoppable grooves. Let's play!",
                "thumb_image" =>
                    "/collections/image/e55c308d-005e-45d0-bb35-e1b24ce8e167.png",
                "cover_image" =>
                    "/collections/image/e2b4880c-5763-46f4-9381-52f37a888110.png",
                "featured_image" =>
                    "/collections/image/5899e18c-64c7-4dac-9c2b-688bc9d55f78.png",
            ],
            "electronic" => [
                "title" => "Electronica",
                "description" =>
                    "Bleeps, bloops, and very catchy tunes. If human=true then play=true!",
                "thumb_image" =>
                    "/collections/image/5227f97d-6675-41bb-aeec-10bb14c1cd94.png",
                "cover_image" =>
                    "/collections/image/3841e3fa-76b7-4351-b776-68452a54e665.png",
                "featured_image" =>
                    "/collections/image/2de40441-3602-40f8-9b95-b56cfe98e636.png",
            ],
            "world" => [
                "title" => "Around The World",
                "description" => "Go for the gold with songs from all over the globe.",
                "thumb_image" =>
                    "/collections/image/0ed2849e-d071-47e1-8707-492fef38bb95.png",
                "cover_image" =>
                    "/collections/image/eb3fad05-0b29-4975-8d1e-e0c94a474c3d.png",
                "featured_image" =>
                    "/collections/image/790c75f2-721d-4b68-8f8a-d2ea52793359.png",
            ],
            "default" => [
                "title" => ucfirst($genre),
                "description" => ucfirst($genre),
                "thumb_image" => "/collections/image/" . $genre . "_thumb_image.png",
                "cover_image" => "/collections/image/" . $genre . "_cover_image.png",
                "featured_image" => "/collections/image/" . $genre . "_featured_image.png",
            ],
        ];
        if (isset($genresData[$genre])) {
            return $genresData[$genre][$field];
        } else {
            return $genresData['default'][$field];
        }
    }
}