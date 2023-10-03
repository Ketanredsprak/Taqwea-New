<?php 
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ClassExists
{    
    /**
     * Method scopeCheckExists
     * 
     * @param Builder $query 
     * @param string  $startTime 
     * @param string  $endTime 
     * @param string  $startColumn 
     * @param string  $endColumn 
     *
     * @return void
     */
    public function scopeCheckExists(
        Builder $query,
        string $startTime,
        string $endTime,
        string $startColumn = 'start_time',
        string $endColumn = 'end_time'
    ) {
        $query->where(
            function ($query) use ($endTime, $startTime, $startColumn, $endColumn) {
                $query->where(
                    function ($query) use ($startTime, $endTime, $startColumn, $endColumn) {
                        $query->where($startColumn, '>=', $startTime)
                            ->where($endColumn, '<=', $endTime);
                    }
                ) 
                ->orWhere(
                    function ($query) use ($startTime, $endTime, $startColumn, $endColumn) {
                        $query->where($endColumn, '>=', $startTime)
                            ->where($endColumn, '<=', $endTime);
                    }
                )
                ->orWhere(
                    function ($query) use ($startTime, $endTime, $startColumn, $endColumn) {
                        $query->where($startColumn, '>=', $startTime)
                            ->where($startColumn, '<=', $endTime);
                    }
                )
                ->orWhere(
                    function ($query) use ($startTime, $endTime, $startColumn, $endColumn) {
                        $query->where($startColumn, '<', $startTime)
                            ->where($endColumn, '>', $endTime);
                    }
                );
            }   
        );

        return $query;
    }
}