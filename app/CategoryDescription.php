<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    protected $table = 'oc_category_description';

    public $timestamps = false;

    protected $fillable = ['category_id', 'language_id', 'name'];

    protected $attributes = [
        'description' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_keyword' => '',
    ];

    protected $hidden = [
        'language_id',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {

        $query
            ->where('category_id', '=', $this->getAttribute('category_id'))
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
