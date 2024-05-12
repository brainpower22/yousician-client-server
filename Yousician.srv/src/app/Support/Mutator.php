<?php

namespace App\Support;

class Mutator
{

    public static function song($song)
    {

        /*  $song->type
        0 - YousicianSong,
		1 - YousicianSkilltestSong,
		2 - YousicianUserSong,
		3 - YousicianWeeklyChallengeSong,
		4 - YousicianOnboardingSong,
		5 - YousicianSongTutorial
        */

        if ($audios = $song->getRelation('audios')) {
            if ($audio_link = $audios->first()) {
                $song->audio_link = $audio_link;
                $song->audio_link->type = 1;
                $song->audio = true;
            }
            $song->setRelation('audios', $audios->keyBy('type')->map(function ($audio) {
                return self::audio($audio);
            }));
        }
        if ($images = $song->getRelation('images')) {
            $images = $images->keyBy('type')->map(function ($image, $type) {
                return self::image($image, $type);
            });
            $song->setRelation('images', $images);
        }
        if ($derivedTags = $song->getRelation('derived_tags')) {
            $song->setRelation('derived_tags', $derivedTags->pluck('tag'));
        }
        if ($tags = $song->getRelation('tags')) {
            $song->setRelation('tags', $tags->pluck('tag'));
        }
        if ($genres = $song->getRelation('genres')) {
            $song->setRelation('genres', $genres->pluck('genre'));
        }
        if ($meta = $song->getRelation('meta')) {
            $song->unsetRelation('meta');
            $song->meta = array_filter($meta->toArray()) ? array_filter($meta->toArray()) : (object)[];
        }

        $song->ef_type = 1; // 0 - gp, 1 - mxl

        if (is_null($song['preview'])) unset($song['preview']);
        if (is_null($song['part_count'])) unset($song['part_count']);
        if (is_null($song['alignment'])) unset($song['alignment']);
        if (is_null($song['complexity'])) unset($song['complexity']);
        if (is_null($song['playable_parts'])) unset($song['playable_parts']);
        if (is_null($song['is_clear_premium'])) unset($song['is_clear_premium']);
        if (is_null($song['original_publish_date']) && !empty($song['published_on'])) {
            $song['original_publish_date'] = $song['published_on'];
        } else {
            unset($song['original_publish_date']);
        }
        return $song;
    }

    public static function audio($audio)
    {
        if (is_null($audio['key'])) $audio['key'] = substr($audio->getRawOriginal('url'), 1);
        if (is_null($audio['original_file_name'])) $audio['original_file_name'] = pathinfo($audio->getRawOriginal('url'))['basename'];
        return $audio;
    }

    public static function image($image, $type)
    {
        $image->type = $type;
        if (is_null($image['key'])) $image['key'] = substr($image->getRawOriginal('url'), 1);
        if (is_null($image['original_file_name'])) $image['original_file_name'] = pathinfo($image->getRawOriginal('url'))['basename'];
        return $image;
    }
}