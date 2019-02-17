<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LayoutTextDescription extends Model
{
    protected $table = "layout_text_description";
    public $timestamps = false;

    protected $fillable = ["layout_text_id", "language_id", "text"];
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $query
            ->where('layout_text_id', '=', $this->getAttribute('layout_text_id'))
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
