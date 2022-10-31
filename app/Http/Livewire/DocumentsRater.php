<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentsRater extends Component
{
    public User $user;

    /**
     * @var DocumentCategory
     */
    public $category;

    public ?Document $document = null;

    public string $comment = '';

    /**
     * @var Collection<Comment>|null
     */
    public ?Collection $comments = null;

    public function mount(): void
    {
        $this->document = $this->user->documentBy($this->category);
        $this->comments = $this->document?->comments;
        if ($this->comments == null) {
            $this->comments = Collection::empty();
        }
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.documents-rater', [
            'category' => $this->category,
        ]);
    }

    public function download(): ?StreamedResponse
    {
        if ($this->document != null && $this->document->path != null) {
            $name = Str::snake($this->user->full_name.' '.$this->category->displayName());

            return Storage::disk()->download($this->document->path, $name);
        }

        return null;
    }

    public function state(): string
    {
        if ($this->document == null) {
            return '🤷‍';
        }

        return match ($this->document->state) {
            DocumentState::Approved => '✅',
            DocumentState::Submitted => '⬆️',
            DocumentState::Declined => '⛔️',
            default => '🤷‍',
        };
    }

    public function approve(): void
    {
        if ($this->document != null) {
            $this->document->state = DocumentState::Approved;
            $this->document->save();
        }
    }

    public function decline(): void
    {
        if ($this->document != null) {
            $this->document->state = DocumentState::Declined;
            $this->document->save();
        }
    }

    public function saveComment(): void
    {
        if (blank($this->comment)) {
            return;
        }
        $this->document?->createComment($this->comment, $this->user->getAuthIdentifier());
    }

    public function updatedComment(string $value): void
    {
        $this->comment = trim($value);
    }
}
