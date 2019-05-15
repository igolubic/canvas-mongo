<?php

namespace Canvas;

use Carbon\CarbonPeriod;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class View extends Eloquent
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'canvas_views';

    /**
     * Get the post relationship.
     *
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Return a view count for the last [X] days.
     *
     * @param int $days
     * @return array
     */
    public static function viewTrend($views, int $days): array
    {
        // Filter the view data to only include created_at date strings
        $collection = collect();
        $views->sortBy('created_at')->each(function ($item, $key) use ($collection) {
            $collection->push($item->created_at->toDateString());
        });

        // Count the unique values and assign to their respective keys
        $views = array_count_values($collection->toArray());

        // Create a [X] day range to hold the default date values
        $period = CarbonPeriod::create(now()->subDays($days)->toDateString(), $days)->excludeStartDate();

        // Prep the array to perform a comparison with the actual view data
        $range = collect();
        foreach ($period as $key => $date) {
            $range->push($date->toDateString());
        }

        // Compare the view data and date range arrays, assigning view counts where applicable
        $total = collect();
        foreach ($range as $date) {
            if (array_key_exists($date, $views)) {
                $total->put($date, $views[$date]);
            } else {
                $total->put($date, 0);
            }
        }

        return $total->toArray();
    }
}
