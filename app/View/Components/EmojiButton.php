<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmojiButton extends Component
{
    public $preguntaId;
    public $emojiId;

    public function __construct($preguntaId, $emojiId)
    {
        $this->preguntaId = $preguntaId;
        $this->emojiId = $emojiId;
    }

    public function render()
    {
        return view('components.emoji-button');
    }
}
