<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Message extends Model
{
    //
    protected $fillable = [
        'from_id', 'to_id', 'thread_uuid', 'message'
    ];


    /**
     * Method scopeOnlyUnread
     *
     * @param $query $query [explicite description]
     *
     * @return void
     */
    public function scopeOnlyUnread($query)
    {
        $now = Carbon::now()->subDays(config('services.message_day'));
        $message_date = $now->format('Y-m-d H:i:s');
        return $query->where('is_readed', '0')
            ->whereHas(
                "thread",
                function ($qry) use ($message_date) {
                    $qry->where("threads.created_at", ">=", $message_date);
                }
            );
    }

    /**
     * Method getUnReadCount
     *
     * @param User $user [explicite description]
     *
     * @return Collection|null
     */
    public static function getUnReadCount(?User $user) 
    {
        if (!$user) {
            return null;
        }
        $query = self::where('to_id', $user->id)->OnlyUnread();
        return $query->count();
    }

    /**
     * Method Thread
     *
     * @return mixed
     */
    public function thread()
    {
        return $this->belongsTo(
            Thread::class,
            'thread_id',
            'id'
        );
    }
}
