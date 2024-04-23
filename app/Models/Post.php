<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Post extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    /** @var array<int,string>  */
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    protected $with = [
        'author', 'tags'
    ];

    /**
     * Post author
     *
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the tags for the post.
     *
     * return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
