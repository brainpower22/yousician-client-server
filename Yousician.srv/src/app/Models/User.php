<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'password'];

    protected $fillable = [
        'password', 'email', 'email_confirmation_status', 'first_name', 'last_name', 'last_used_instrument', 'signup_time',
        'settings', 'notPublic', 'logged_once', 'locale', 'data_sales', 'is_linked_to_apple', 'is_from_google',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'notPublic' => 'boolean',
        'logged_once' => 'boolean',
        'is_linked_to_apple' => 'boolean',
        'is_from_google' => 'boolean',
    ];

    public function location()
    {
        return $this->hasOne(UserLocation::class, 'user_id', '_id');
    }

    public function favoriteSongs()
    {
        return $this->hasMany(UserFavoriteSong::class, 'user_id', '_id');
    }

    public function tasksProgress($instrument, $version)
    {
        return $this->hasMany(UserProgressTask::class, 'user_id', '_id')
            ->where('instrument', $instrument)
            ->where('version', $version)
            ->get()
            ->keyBy('task_id')->map(function ($task){
                unset($task->task_id);
                return $task;
            });
    }
    public function songsProgress($instrument, $version)
    {
        return $this->hasMany(UserProgressSong::class, 'user_id', '_id')
            ->where('instrument', $instrument)
            ->where('version', $version)
            ->get()
            ->keyBy('song_id')->map(function ($song){
                return (object)json_decode($song->data, true);
            });
    }
    public function missionsProgress($instrument, $version)
    {
        return $this->hasMany(UserProgressMission::class, 'user_id', '_id')
            ->where('instrument', $instrument)
            ->where('version', $version)
            ->get()
            ->keyBy('mission_id')->map(function ($mission){
                unset($mission->mission_id);
                return $mission;
            });
    }
    public function levelProgress($missionProgress)
    {
        return $missionProgress->groupBy('level')->map(function ($data){
            $level['average_stars'] = $data->pluck('stars')->avg();
            $level['mission_doc_ids'] = $data->map(function ($mission){
                return $mission->getRawOriginal('mission_id');
            });
            return $level;
        });
    }

}