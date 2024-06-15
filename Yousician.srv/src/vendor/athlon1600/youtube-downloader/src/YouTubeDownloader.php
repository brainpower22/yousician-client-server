<?php

namespace YouTube;

use YouTube\Exception\TooManyRequestsException;
use YouTube\Exception\VideoNotFoundException;
use YouTube\Exception\YouTubeException;
use YouTube\Models\VideoInfo;
use YouTube\Models\YouTubeCaption;
use YouTube\Models\YouTubeConfigData;
use YouTube\Responses\PlayerApiResponse;
use YouTube\Responses\VideoPlayerJs;
use YouTube\Responses\WatchVideoPage;
use YouTube\Utils\Utils;

class YouTubeDownloader
{
    protected Browser $client;

    function __construct()
    {
        $this->client = new Browser();
    }

    // Specify network options to be used in all network requests
    public function getBrowser(): Browser
    {
        return $this->client;
    }

    /**
     * @param string $query
     * @return array
     */
    public function getSearchSuggestions(string $query): array
    {
        $query = rawurlencode($query);

        $response = $this->client->get('http://suggestqueries.google.com/complete/search', [
            'client' => 'firefox',
            'ds' => 'yt',
            'q' => $query
        ]);
        $json = json_decode($response->body, true);

        if (is_array($json) && count($json) >= 2) {
            return $json[1];
        }

        return [];
    }

    public function getVideoInfo(string $videoId): ?VideoInfo
    {
        $page = $this->getPage($videoId);
        return $page->getVideoInfo();
    }

    public function getPage(string $url): WatchVideoPage
    {
        $video_id = Utils::extractVideoId($url);

        // exact params as used by youtube-dl... must be there for a reason
        $response = $this->client->get("https://www.youtube.com/watch?" . http_build_query([
                'v' => $video_id,
                'gl' => 'US',
                'hl' => 'en',
                'has_verified' => 1,
                'bpctr' => 9999999999
            ]));

        return new WatchVideoPage($response);
    }

    // Downloading android player API JSON
    protected function getPlayerApiResponse(string $video_id, YouTubeConfigData $configData, string $clientName = 'android_music'): PlayerApiResponse
    {
        $clientName = strtolower($clientName);

        // exact params matter, because otherwise "slow" download links will be returned
        // INNERTUBE_CLIENTS
        $client = [
            // "android" client broken
            "android" => [
                "context" => [
                    "client" => [
                        "androidSdkVersion" => 30,
                        "clientName" => "ANDROID",
                        "clientVersion" => "19.09.37",
                        "userAgent" => "com.google.android.youtube/19.09.37 (Linux; U; Android 11) gzip",
                    ],
                ],
            ],
            "android_music" => [
                "context" => [
                    "client" => [
                        "androidSdkVersion" => 30,
                        "clientName" => "ANDROID_MUSIC",
                        "clientVersion" => "6.42.52",
                        "userAgent" => "com.google.android.apps.youtube.music/6.42.52 (Linux; U; Android 11) gzip",
                    ],
                ],
            ],
            "ios" => [
                "context" => [
                    "client" => [
                        "clientName" => "IOS",
                        "clientVersion" => "19.09.3",
                        "deviceModel" => "iPhone14,3",
                        "userAgent" => "com.google.ios.youtube/19.09.3 (iPhone14,3; U; CPU iOS 15_6 like Mac OS X)",
                    ],
                ],
            ],
            "web" => [
                "context" => [
                    "client" => [
                        "clientName" => "WEB",
                        "clientVersion" => "2.20220801.00.00",
                    ],
                ],
            ],
        ];
        foreach(["hl" => "en", "timeZone" => "UTC", "utcOffsetMinutes" => 0] as $k => $v){
            $client[$clientName]['context']['client'][$k] = $v;
        }

        $this->client->setUserAgent($client[$clientName]['context']['client']['userAgent']
                                    ?? $_SERVER['HTTP_USER_AGENT']
                                    ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36');
        $response = $this->client->post("https://www.youtube.com/youtubei/v1/player?key=" . $configData->getApiKey(), json_encode(
            array_merge($client[$clientName], [
                "videoId" => $video_id,
                "playbackContext" => [
                    "contentPlaybackContext" => [
                        "html5Preference" => "HTML5_PREF_WANTS"
                    ]
                ],
                "racyCheckOk" => true
            ])), [
                'Content-Type' => 'application/json',
                'X-Goog-Visitor-Id' => $configData->getGoogleVisitorId(),
                'X-Youtube-Client-Name' => $configData->getClientName(),
                'X-Youtube-Client-Version' => $configData->getClientVersion()
            ]);

        return new PlayerApiResponse($response);
    }

    /**
     *
     * @param string $video_id
     * @param array $clients    the 1st in the array leading
     * @param array $extra
     * @return DownloadOptions
     * @throws TooManyRequestsException
     * @throws VideoNotFoundException
     * @throws YouTubeException
     */
    public function getDownloadLinks(string $video_id, $clients = array('android_music', 'ios'), array $extra = []): DownloadOptions
    {
        $video_id = Utils::extractVideoId($video_id);

        if (!$video_id) {
            throw new \InvalidArgumentException("Invalid Video ID: " . $video_id);
        }

        $page = $this->getPage($video_id);

        if ($page->isTooManyRequests()) {
            throw new TooManyRequestsException($page);
        } elseif (!$page->isStatusOkay()) {
            throw new YouTubeException('Page failed to load. HTTP error: ' . $page->getResponse()->error);
        } elseif ($page->isVideoNotFound()) {
            throw new VideoNotFoundException();
        } elseif ($page->getPlayerResponse()->getPlayabilityStatusReason()) {
            throw new YouTubeException($page->getPlayerResponse()->getPlayabilityStatusReason());
        }

        // a giant JSON object holding useful data
        $youtube_config_data = $page->getYouTubeConfigData();

        // the most reliable way of fetching all download links no matter what
        // query: /youtubei/v1/player for some additional data
        $links = [];
        foreach($clients as $clientName) {
            $player_response = $this->getPlayerApiResponse($video_id, $youtube_config_data, $clientName);
            // throws exception if player response does not belong to the requested video
            preg_match('/"videoId":\s"([^"]+)"/', print_r($player_response, true), $matches);
            if ($matches[1] != $video_id)
                throw new YouTubeException('Invalid player response: got player response for video "' . $matches[1] . '" instead of "' . $video_id .'"');

            // get player.js location that holds URL signature decipher function
            $player_url = $page->getPlayerScriptUrl();
            $response = $this->getBrowser()->get($player_url);
            $player = new VideoPlayerJs($response);

            $links = array_merge($links, SignatureLinkParser::parseLinks($player_response, $player));
        }
        // sorting order: combined (smaller itag first) -> video (higher resolution -> smaller itag) -> audio (lower quality first)
        usort($links, fn($a,$b) => $b->mimeType[0] <=> $a->mimeType[0] ?:
                                   ($a->mimeType[0]=='v' ? ((bool)$a->audioQuality ? $a->itag : 999) : str_replace(['_','D','H'], ['L','M','S'], substr($a->audioQuality,-4,1)))
                                       <=> ($b->mimeType[0]=='v' ? ((bool)$b->audioQuality ? $b->itag : 999) : str_replace(['_','D','H'], ['L','M','S'], substr($b->audioQuality,-4,1))) ?:
                                   $b->height <=> $a->height ?:
                                   $a->itag <=> $b->itag
        );
        // remove duplicated formats
        if (count($clients) > 1) {
            foreach($links as $k=>$v) {
                if ($v->itag == ($i ?? 0))
                    unset($links[$k]);
                else
                    $i = $v->itag;
            }
        }

        // since we already have that information anyways...
        $info = VideoInfoMapper::fromInitialPlayerResponse($page->getPlayerResponse());

        return new DownloadOptions($links, $info);
    }

    /**
     * @param string $videoId
     * @return YouTubeCaption[]
     */
    public function getCaptions(string $videoId): array
    {
        $pageResponse = $this->getPage($videoId);
        $data = $pageResponse->getPlayerResponse();

        return array_map(function ($item) {
            $baseUrl = Utils::arrayGet($item, "baseUrl");

            $temp = new YouTubeCaption();
            $temp->name = Utils::arrayGet($item, "name.simpleText") ?? Utils::arrayGet($item, "name.runs.0.text");
            $temp->baseUrl = ($baseUrl[0] == '/' ? 'https://www.youtube.com' : '') . $baseUrl;
            $temp->languageCode = Utils::arrayGet($item, "languageCode");
            $vss = Utils::arrayGet($item, "vssId");
            $temp->isAutomatic = Utils::arrayGet($item, "kind") === "asr" || strpos($vss, "a.") !== false;
            return $temp;

        }, $data->getCaptionTracks());
    }

    public function getThumbnails(string $videoId): array
    {
        $videoId = Utils::extractVideoId($videoId);

        if ($videoId) {
            return [
                'default' => "https://img.youtube.com/vi/{$videoId}/default.jpg",
                'medium' => "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg",
                'high' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
                'standard' => "https://img.youtube.com/vi/{$videoId}/sddefault.jpg",
                'maxres' => "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg",
            ];
        }

        return [];
    }
}
