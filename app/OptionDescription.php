<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionDescription extends Model
{
    protected $table = 'oc_option_description';
    public $timestamps = false;

    protected $fillable = ['option_id', 'language_id', 'name'];

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query
            ->where('option_id', '=', $this->getAttribute('option_id'))
            ->where('language_id', '=', $this->getAttribute('language_id'));
        return $query;

    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
