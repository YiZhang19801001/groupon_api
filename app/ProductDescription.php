<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $table = 'oc_product_description';
    public $timestamps = false;

    protected $fillable = ['product_id', 'language_id', 'name'];
    protected $hidden = [
        'description',
        'tag',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    protected $attributes = [
        'description' => '',
        'tag' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_keyword' => '',
    ];

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

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
