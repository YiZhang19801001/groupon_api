<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LayoutText extends Model
{
    protected $table = "layout_text";
    protected $primaryKey = "layout_text_id";
    public $timestamps = false;

    protected $fillable = ["name"];

    public function descriptions()
    {
        return $this->hasMany("App\LayoutTextDescription", "layout_text_id", "layout_text_id");
    }
}
