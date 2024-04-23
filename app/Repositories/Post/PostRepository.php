<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use App\Http\DTO\Posts\NewPostDTO;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

final class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        protected readonly Post $model,
    ) {
    }

    public function all(?callable $callback = null): Collection
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

            $this->syncPostTags($post, $newPostDTO->tags);

            DB::commit();

            return $post;
        } catch (Throwable $th) {
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

            $this->syncPostTags($post, $newPostDTO->tags);

            $post->load(['tags', 'author']);
            $post->save();

            DB::commit();

            return $post;
        } catch (Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
        }
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    private function syncPostTags(Post $post, array $tags): void
    {
        $ids = [];
        foreach ($tags as $tag) {
            $ids[] = Tag::query()->firstOrCreate(['name' => $tag])->id;
        }

        $post->tags()->sync($ids);
    }
}
