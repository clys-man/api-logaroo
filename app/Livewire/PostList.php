<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    public function render()
    {
        $posts = Post::all();
        return view('livewire.post-list')->with('posts', $posts);
    }
}
