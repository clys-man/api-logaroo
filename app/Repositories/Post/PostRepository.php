<?php

namespace App\Repositories\Post;

use App\Http\DTO\Posts\NewPostDTO;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        protected readonly Post $model,
    ) {
    }

    public function all(?callable $callback = null): collection
    {
        $query = $this->model->query();

        if ($callback) {
            $callback($query);
        }

        return $query->all();
    }

    public function paginate(int $perPage = 20, ?callable $callback = null): Paginator
    {
        $query = $this->model->query();

        if ($callback) {
            $callback($query);
        }

        return $query->paginate($perPage);
    }

    public function find(string $id): ?Post
    {
        return $this->model->query()->find($id);
    }

    public function create(NewPostDTO $newPostDTO): Post
    {
        DB::beginTransaction();

        try {
            /** @var Post */
            $post = $this->model->query()->create([
                'title' => $newPostDTO->title,
                'content' => $newPostDTO->content,
                'user_id' => $newPostDTO->userId
            ]);

            $ids = Tag::whereIn('name', $newPostDTO->tags)->pluck('id')->toArray();
            $post->tags()->sync($ids);

            DB::commit();

            return $post;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function update(Post $post, NewPostDTO $newPostDTO): Post
    {
        DB::beginTransaction();

        try {
            /** @var Post */
            $post = $post->fill([
                'title' => $newPostDTO->title,
                'content' => $newPostDTO->content,
                'user_id' => $newPostDTO->userId
            ]);

            $ids = Tag::whereIn('name', $newPostDTO->tags)->pluck('id')->toArray();
            $post->tags()->sync($ids);
            $post->load(['tags', 'author']);
            $post->save();

            DB::commit();

            return $post;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
        }
    }
}
