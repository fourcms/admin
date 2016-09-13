<?php

namespace FourCms\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Longman\LaravelMultiLang\Models\Localizable;

class Content extends Model
{
    use SoftDeletes, Localizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content';

    protected $dates = ['deleted_at'];

    public function getUrl()
    {
        return lang_url('content/' . $this->id);
    }

    public function getImage()
    {
        return asset($this->image);
    }

}
