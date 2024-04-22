<?php

declare(strict_types=1);

namespace App\Http\DTO\Posts;

final readonly class NewPostDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly array $tags,
        public readonly string $userId,
    ) {
    }

    /**
     * @return array{title:string,content:string,tags:array} $data
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'tags' => $this->tags,
            'user_id' => $this->userId,
        ];
    }

    /**
     * @param array{title:string,content:string,tags:array,user_id:string} $data
     * @return NewPostDTO
     */
    public static function fromRequest(array $data): NewPostDTO
    {
        return new NewPostDTO(
            title: $data['title'],
            content: $data['content'],
            tags: $data['tags'],
            userId: $data['user_id'],
        );
    }
}
