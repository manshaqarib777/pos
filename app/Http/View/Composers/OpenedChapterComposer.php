<?php
namespace App\Http\View\Composers;

use App\ChapterInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OpenedChapterComposer
{
    public function compose(View $view)
    {
        $chapter = Auth::user()->chapters->where('status', '1')->first();
        $chapterData = new ChapterInfo($chapter);
        $view->with('openedChapter', $chapter)->with('info', $chapterData->info());
    }
}
