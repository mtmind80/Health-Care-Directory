<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use ToolTrait;

class BaseModel extends Model
{

    use ToolTrait;

    protected $hidden = ['disabled'];

    /** scopes */

    public function scopeActive($query, $amount = null)
    {
        $query->where('disabled', 0);
        if ( ! empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('d_sort');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeRandom($query, $amount = null)
    {
        $query->orderByRaw("RAND()");
        if ( ! empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeFeatured($query, $amount = null)
    {
        $query->where('featured', 1);
        if ( ! empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeLatest($query, $amount = null)
    {
        $query->orderBy('created_at', 'DESC');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Mutators and Accessors */

    public function getHtmlCreatedAtAttribute()
    {
        return !empty($this->created_at) ? $this->created_at->format('m/d/Y') : '';
    }

    public function getHtmlStartedAtAttribute()
    {
        return !empty($this->started_at) ? $this->started_at->format('m/d/Y') : '';
    }

    public function getHtmlEndedAtAttribute()
    {
        return !empty($this->ended_at) ? $this->ended_at->format('m/d/Y') : '';
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value, '-');
    }

    public function getLocationAttribute()
    {
        return $this->buildAddress($this->address, $this->city, $this->state->full_name, $this->zipcode, $this->state->country->name, '<br>', $this->address_2);
    }

    public function setStartedAtAttribute($value)
    {
        $this->attributes['started_at'] = !empty($value) ? $value : null;
    }

    public function setEndedAtAttribute($value)
    {
        $this->attributes['ended_at'] = !empty($value) ? $value : null;
    }

    public function setExpiredAtAttribute($value)
    {
        $this->attributes['expired_at'] = !empty($value) ? $value : null;
    }

    public function setIssuedAtAttribute($value)
    {
        $this->attributes['issued_at'] = !empty($value) ? $value : null;
    }

    /** Methods */

    public function getMaxIndex()
    {
        return $this->where('d_sort', '<', 1000)->max('d_sort');
    }

    static public function mergeAssoc($arr1, $arr2)
    {
        if (!is_array($arr1)) {
            $arr1 = [];
        }
        if (!is_array($arr2)) {
            $arr2 = [];
        }

        $keys1 = array_keys($arr1);
        $keys2 = array_keys($arr2);
        $keys = array_merge($keys1, $keys2);
        $vals1 = array_values($arr1);
        $vals2 = array_values($arr2);
        $vals = array_merge($vals1, $vals2);
        $ret = [];

        foreach ($keys as $key) {
            list(, $val) = each($vals);
            $ret[$key] = $val;
        }

        return $ret;
    }

    public function ownFillable()
    {
        return $this->fillable;
    }

}
