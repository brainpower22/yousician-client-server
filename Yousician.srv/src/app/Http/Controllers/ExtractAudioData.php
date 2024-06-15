<?php

namespace App\Http\Controllers;

use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Curl\Client;

class ExtractAudioData
{
    protected string $ffmpeg = 'Yousician.srv\tools\ffmpeg\bin\ffmpeg.exe';
    protected string $extractor = 'Yousician.app\Yousician_Data\Managed\Extractor.exe';
    protected string $youtubePath = '/assets/songs/youtube/';
    protected string $extractedDir = 'Yousician.srv\src\public\assets\songs\youtube\\';


    public function youtube(ServerRequest $request, Response $response)
    {
        $serverAddress = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost() . ':' . $request->getUri()->getPort();
        $fileNameWithoutExtension = $request->getAttribute('id');

        $needDownloadOriginal = true;

        $needConvert = true;

        $needExtract = true;
        $needExtractExtensions = ['onset', 'chroma', 'peak'];

        $fileDir = $_SERVER['scriptDir'] . $this->extractedDir . $request->getAttribute('id');
        if (file_exists($fileDir)) {
            $existsExtensions = [];
            $exclude = ['.', '..'];
            $scanDir = scandir($fileDir);

            foreach ($scanDir as $key => $item) {
                if (is_file($fileDir . DIRECTORY_SEPARATOR . $item) && !in_array($item, $exclude)) {
                    $extension = pathinfo($item)['extension'];
                    if ($extension == 'mp3' || $extension == 'm4a' || $extension == 'webm') {
                        $originalFile = $_SERVER['scriptDir'] . $this->extractedDir
                            . $request->getAttribute('id')
                            . DIRECTORY_SEPARATOR
                            . pathinfo($item)['filename']
                            . '.' . $extension;
                        $needDownloadOriginal = false;
                    }
                    if ($extension == 'ogg') {
                        $needConvert = false;
                    }
                    $existsExtensions[] = pathinfo($item)['extension'];
                    $fileNameWithoutExtension = pathinfo($item)['filename'];
                }
            }

            if (count(array_intersect($existsExtensions, $needExtractExtensions)) == count($needExtractExtensions)) {
                $needExtract = false;
            }
        }

        if ($needDownloadOriginal) {
            $youtube = new YouTubeDownloader();
            try {

                $downloadOptions = $youtube->getDownloadLinks('https://www.youtube.com/watch?v=' . $request->getAttribute('id'));

                if ($audios = $downloadOptions->getAudioFormats()) {

                    $maxBitrateFileIndex = array_search(max(array_column($audios, 'bitrate')), array_column($audios, 'bitrate'));
                    $maxBitrateFileModel = $audios[$maxBitrateFileIndex];

                    $mimeType = explode(';', $maxBitrateFileModel->mimeType)[0];
                    $fileNameWithoutExtension = slug($downloadOptions->getInfo()->title);

                    $originalFile = $_SERVER['scriptDir'] . $this->extractedDir
                        . $request->getAttribute('id')
                        . DIRECTORY_SEPARATOR
                        . $fileNameWithoutExtension
                        . '.' . $this->getExtByMimeType($mimeType);

                    $headers = [
                        'Accept' => '*/*',
                        'Accept-Encoding' => 'gzip, deflate, br, zstd',
                        'Accept-Language' => 'ru-RU,ru;q=0.9',
                        'Cache-Control' => 'no-cache',
                        'Connection' => 'keep-alive',
                        'Pragma' => 'no-cache',
                        'Range' => 'bytes=0-',
                        'Referer' => $maxBitrateFileModel->url,
                        'Sec-Ch-Ua' => '"Chromium";v="124", "Google Chrome";v="124", "Not-A.Brand";v="99"',
                        'Sec-Ch-Ua-Mobile' => '?0',
                        'Sec-Ch-Ua-Platform' => '"Windows"',
                        'Sec-Fetch-Dest' => 'video',
                        'Sec-Fetch-Mode' => 'no-cors',
                        'Sec-Fetch-Site' => 'same-origin',
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                    ];

                    $client = new Client();
                    $youtubeResponse = $client->get($maxBitrateFileModel->url, null, $headers);
                    chkDir($originalFile);
                    file_put_contents($originalFile, $youtubeResponse->body);

                }

            } catch (YouTubeException $e) {
                $objectJson['error'] = 'Something went wrong: ' . $e->getMessage();
                return $response->withJson($objectJson);
            }
        }

        $oggFileName = $fileNameWithoutExtension . '.ogg';

        $oggFilePath = $_SERVER['scriptDir'] . $this->extractedDir
            . $request->getAttribute('id')
            . DIRECTORY_SEPARATOR
            . $oggFileName;

        if ($needConvert) {
            $shellCommand = $_SERVER['scriptDir'] . $this->ffmpeg . ' -y -i "' . $originalFile . '" -acodec libvorbis -aq 4 -vn -ac 2 -map_metadata 0 "' . $oggFilePath . '" 2>&1';
            exec($shellCommand);
        }

        if ($needExtract) {
            $shellCommand = $_SERVER['scriptDir'] . $this->extractor . ' "' . $oggFilePath . '" 2>&1';
            exec($shellCommand);
        }

        $objectJson = [
            '_id' => mongoObjectId(),
            'type' => 'youtube',
            'external_id' => $request->getAttribute('id'),
            'resource_update_time' => date("Y-m-d\TH:i:s\Z"),
            'extraction_time' => date("Y-m-d\TH:i:s\Z"),
            'data_urls' => [
                'xtalk_mono_files' => null,
                'xtalk_stereo_files' => null,
                'onsets_files' => [
                    [
                        'url' => $serverAddress . $this->youtubePath . $request->getAttribute('id') . '/' . $fileNameWithoutExtension . '.onset',
                        'extractor_version' => '1.0.0',
                    ]
                ],
                'chroma_files' => [
                    [
                        'url' => $serverAddress . $this->youtubePath . $request->getAttribute('id') . '/' . $fileNameWithoutExtension . '.chroma',
                        'extractor_version' => '1.0.0',
                    ]
                ],
                'peak_files' => [
                    [
                        'url' => $serverAddress . $this->youtubePath . $request->getAttribute('id') . '/' . $fileNameWithoutExtension . '.peak',
                        'extractor_version' => '1.0.0',
                    ]
                ],
                'chords_files' => null,
                'melody_files' => null,
                'bass_files' => null,
            ]
        ];

        return $response->withJson($objectJson);
    }

    public function getExtByMimeType($mimeType): string
    {
        $types = [
            'audio/mp4' => 'm4a',
            'audio/webm' => 'webm',
            'audio/mpeg' => 'mp3',
        ];
        return $types[$mimeType] ?? 'audio';
    }


}
