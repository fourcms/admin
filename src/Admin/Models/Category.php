<?php

namespace FourCms\Admin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Longman\LaravelMultiLang\Models\Localizable;
use Longman\Platfourm\Category\Models\Eloquent\Category as BaseCategory;
use Longman\Platfourm\Database\Eloquent\ActionLog\ActionLogTrait;
use Longman\Platfourm\Database\Eloquent\EntityLock\EntityLockTrait;
use Longman\Platfourm\Database\Eloquent\Traits\ArrayAsPrimary;
use Longman\Platfourm\Database\Eloquent\Traits\UuidForPrimary;

class Category extends BaseCategory
{
    use ActionLogTrait, SoftDeletes, Localizable, EntityLockTrait,
        UuidForPrimary, ArrayAsPrimary, NodeTrait;

    protected $fillable = ['title', 'lang', 'parent_id'];

    protected $searchableFields = ['title'];

    protected $sortableFields = ['title'];

    public $incrementing = false;

    protected $primaryKey = ['id', 'lang'];

}
