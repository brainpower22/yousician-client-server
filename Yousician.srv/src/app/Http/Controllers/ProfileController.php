<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLocation;
use App\Models\UserProgressSong;
use App\Models\UserProgressTask;
use App\Support\Auth;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class ProfileController
{

    public function switch(ServerRequest $request, Response $response)
    {
        $switchInstrument = $request->getParsedBody()['instrument'];
        $result = User::where('_id', session()->get('user')['_id'])->update([
            'last_used_instrument' => $request->getParsedBody()['instrument']
        ]);
        if ($result) {
            session()->set('last_used_instrument', $switchInstrument);
        }
        $objectJson = [
            'can_switch' => true,
        ];
        return $response->withJson($objectJson);
    }

    public function profile(ServerRequest $request, Response $response)
    {
        if ($request->hasHeader('authorization')) {
            $authorizationData = substr($request->getHeader('authorization')[0], 6);
            $authorizationData = base64_decode($authorizationData);
            list($email, $password) = explode(':', $authorizationData);
            if (User::where(compact('email'))->exists()) {
                Auth::attempt($email, $password);
            } else {
                $this->register($email, $password);
                Auth::attempt($email, $password);
            }
        }

        if ($user = Auth::user()) {
            $objectJson = $this->getUserData($user);
        } else {
            abort(403);
        }

        return $response->withJson($objectJson);
    }

    public function register($email, $password)
    {
        $validator = session()->validator(compact('email', 'password'), [
            'email' => 'required',
            'password' => 'required',
        ],
            [
                'email.required' => 'Email required',
                'password.required' => 'Password required'
            ]);

        if ($validator->fails()) abort(403);

        User::forceCreate([
            "email" => $email,
            "password" => $password,
            "email_confirmation_status" => 0,
            "logged_once" => 1,
            "locale" => 'ru',
            "last_used_instrument" => 'guitar',
            "notPublic" => 0,
            "settings" => '{}',
            "signup_time" => date("Y-m-d\TH:i:s\Z"),
            "data_sales" => 'allowed',
            "is_linked_to_apple" => 0,
            "is_from_google" => 0
        ]);

        $user = User::where(compact('email', 'password'))->first();

        UserLocation::create(
            [
                'user_id' => $user->_id,
                'country' => 'US',
                'region' => 'Mid Atlantic',
                'city' => 'New York City',
            ]
        );

    }

    public function getUserData($user)
    {

        $userArray = $user->toArray();
        $userArray['username'] = explode('@', $userArray['email'])[0];
        $userArray['password_set'] = !empty(session()->get('user')['password']);
        $userArray['settings'] = (object)$userArray['settings'];
        $userArray['first_name'] = (string)$userArray['first_name'];
        $userArray['last_name'] = (string)$userArray['last_name'];

        return array_merge($userArray, [
            'resend_email' => false,
            "licensed_content" => true,
            "subscription_type" => "adyen",
            "subscription-plan" => "yearly_all",
            "subscribed_instrument" => "all",
            "notification_topics" => ["content", "lesson_reminder", "social"],
            "onboarding_completed" => [
                "guitar" => true,
                "piano" => true,
                "voice" => true,
            ],
            "subscription" => $this->getSubscription(),
            "preferences" => [
                "GdprShown" => true,
                "ColdStartQuestionnaireCompleted" => true,
                "hasSeenCoursesAnnouncementGuitar" => false,
                "hasSeenCoursesAnnouncementUkulele" => false,
                "LanguageSelectionOnLocalizableInstruments" => 9,
                "ConsumedPlaytime" => [
                    "guitar" => [
                        "elapsed_time" => "00:15:00",
                        "current_limitation_index" => 2,
                        "sync_date" => "2022-08-06T03:33:41.4538296+00:00",
                    ],
                    "piano" => [
                        "elapsed_time" => "00:00:00",
                        "current_limitation_index" => 0,
                        "sync_date" => "2022-08-05T12:32:11.2619654+02:00",
                    ],
                    "voice" => [
                        "elapsed_time" => "00:00:00",
                        "current_limitation_index" => 0,
                        "sync_date" => "2022-08-06T00:33:59.5484749+02:00",
                    ],
                ],
                "HadPlayedSongsGuitar" => true,
                "lastMissionClicked_guitar" => "539aae177cef0c58c17c01e5",
                "lastMissionClicked" => "539aae177cef0c58c17c01e5",
                "inputLevelMax" => 123,
                "inputLevelMin" => 345,
            ],
            "location" => $user->location()->first(),
            "marketing_services_status" => [
                "performance_analytics" => "allowed",
                "tracking_advertising" => "allowed",
            ],
            "currentSyllabusData" => [
                "_id" => "62e9d5507ef5c0c5c7928642",
                "syllabus" => session()->get('last_used_instrument'),
                "uid" => $user->_id,
                "master_level" => 0,
                "tasks" => (object)[],//$user->tasksProgress(session()->get('last_used_instrument'), 'main'),
                "songs" => (object)[],//$user->songsProgress(session()->get('last_used_instrument'), 'main'),
                "AdsCurrentLessonIndex" => 0,
                "AdsCurrentAdIndex" => 0,
                "source" => (object)[],
                "collection" => (object)[],
            ],
            "daily_lesson_status" => [
                "status_code" => 2
            ],
            "features" => [],
            "source" => (object)[],
            "collection" => (object)[],
        ]);
    }

    public function getSubscription()
    {
        return [
            "adyen_details" => [
                "card_brand" => "visa",
                "card_expiration" => "2099-12-31T00:00:00Z",
                "card_number_last4" => "1234",
                "payment_method" => "debit",
                "payment_method_variant" => "visasuperpremiumdebit",
            ],
            "billing" => [
                "incident" => null,
                "next" => [
                    "date" => "2099-12-31T00:00:00.715000+00:00",
                    "discount" => null,
                    "full_plan_price" => ["amount" => 8299, "currency" => "EUR"],
                    "price" => ["amount" => 8299, "currency" => "EUR"],
                ],
                "previous" => null,
            ],
            "billing_incident" => null,
            "current_plan" => [
                "adyen" => [
                    "free_trial_available" => true,
                    "free_trial_duration" => ["number" => 0, "unit" => "day"],
                    "id" => "yearly_licensed_alt_a",
                    "introductory_offer" => null,
                    "price" => [
                        "amount" => 8299,
                        "currency" => "EUR",
                        "discount" => null,
                    ],
                    "purchase_trigger" => null,
                ],
                "core_plan_data" => [
                    "billing_period" => ["number" => 1, "unit" => "year"],
                    "features" => [
                        "all_instruments" => true,
                        "family" => false,
                        "instrument" => "all",
                        "licensed_content" => true,
                    ],
                    "is_upgradable" => true,
                    "price" => ["amount" => 8299, "currency" => "EUR"],
                    "renewable" => true,
                    "subscription_period" => ["number" => 1, "unit" => "year"],
                ],
                "core_plan_id" => "yearly_licensed_alt_a",
                "core_plan_name" => "Yearly Premium+ Subscription",
                "gateway" => "adyen",
                "googleplay" => null,
                "itunes" => null,
            ],
            "fixed" => null,
            "free_trial_info" => ["current_state" => "not_used"],
            "free_trial_state" => "not_used",
            "gateway" => "adyen",
            "given_by_admin" => false,
            "googleplay_details" => null,
            "itunes_details" => null,
            "policies" => [
                "can_resubscribe" => false,
                "can_switch_to_premium_plus" => false,
                "can_upgrade" => true,
            ],
            "renewable" => [
                "canceled" => false,
                "cancellation_date" => null,
                "period_end_date" => "2099-12-31T00:00:00.715000+00:00",
                "period_start_date" => "2000-01-01T00:00:00.715000+00:00",
            ],
            "subscribed_instrument" => "all",
        ];
    }

    public function devRights(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'rights' => []
        ];
        return $response->withJson($objectJson);
    }

    public function available(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'available' => !User::where('email', $request->getParsedBody()['email'])->exists()
        ];
        return $response->withJson($objectJson);
    }

    public function preferences(ServerRequest $request, Response $response)
    {
        $objectJson = (object)[];
        return $response->withJson($objectJson);
    }

    public function activity(ServerRequest $request, Response $response)
    {
        $objectJson = [
            "active_days_target" => 3,
            "active_days_total" => 1,
            "active_weeks_total" => 0,
            "activity_earliest_date" => "2023-10-02T00:00:00Z",
            "activity_goals" => [
                [
                    "best" => 0,
                    "targets" => (object)["0" => 30, "1" => 60, "2" => 90, "3" => 120],
                    "type" => 0,
                ],
                [
                    "best" => 75,
                    "targets" => (object)["1" => 600, "2" => 1200, "3" => 1800, "4" => 3600],
                    "type" => 1,
                ],
            ],
            "activity_goal_selection" => ["type" => "time", "target_key" => 1],
            "activity_targets" => [
                "chords" => 1,
                "notes" => 1,
                "stars" => 1,
                "time" => 60,
            ],
            "current_date" => "2023-10-05T00:00:00Z",
            "current_day" => 3,
            "current_week" => 40,
            "days" => (object)[
                "0" => ["chords" => 0, "notes" => 0, "stars" => 0, "time" => 28],
                "1" => ["chords" => 0, "notes" => 0, "stars" => 0, "time" => 4],
                "3" => ["chords" => 0, "notes" => 0, "stars" => 0, "time" => 75],
            ],
            "weeks" => [
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-08-14T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 33,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-08-21T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 34,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-08-28T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 35,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-09-04T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 36,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-09-11T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 37,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-09-18T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 38,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 0,
                    "chords" => 0,
                    "date" => "2023-09-25T00:00:00Z",
                    "days" => (object)[],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 0,
                    "week_number" => 39,
                ],
                [
                    "active_days_target" => 3,
                    "active_days_total" => 1,
                    "chords" => 0,
                    "date" => "2023-10-02T00:00:00Z",
                    "days" => (object)[
                        "0" => [
                            "chords" => 0,
                            "notes" => 0,
                            "stars" => 0,
                            "time" => 28,
                        ],
                        "1" => ["chords" => 0, "notes" => 0, "stars" => 0, "time" => 4],
                        "3" => [
                            "chords" => 0,
                            "notes" => 0,
                            "stars" => 0,
                            "time" => 75,
                        ],
                    ],
                    "notes" => 0,
                    "stars" => 0,
                    "time" => 107,
                    "week_number" => 40,
                ],
            ],
            "streak" => [
                "current" => 1,
                "longest" => 1,
                "is_done_for_current_period" => true,
            ],
        ];
        return $response->withJson($objectJson);
    }

    public function updateProgress(ServerRequest $request, Response $response)
    {


        foreach ($request->getParsedBody()['songs'] as $song_id => $song) {
            $songsQuery[] = [
                'user_id' => session()->get('user')['_id'],
                'song_id' => $song_id,
                'instrument' => $request->getParsedBody()['syllabus'],
                'version' => 'main', 'data' => json_encode($song)
            ];
        }

        if (UserProgressSong::upsert($songsQuery, ['user_id', 'song_id', 'instrument', 'version'], ['data'])) {
            $objectJson = (object)[];
            return $response->withJson($objectJson);
        } else {
            abort(403);
        }
    }

    public function thirdPartyServiceStatus(ServerRequest $request, Response $response)
    {
        $objectJson = [
            'youtube_content_available' => true,
            'personal_youtube_content_available' => true,
        ];
        return $response->withJson($objectJson);
    }
}