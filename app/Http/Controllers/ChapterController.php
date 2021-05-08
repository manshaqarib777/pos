<?php
/**
 * This file implements Chapter Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  ChapterController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Chapter;
use App\ChapterInfo;
use App\DataTables\ChapterDataTable;
use App\Events\LogActivity;
use Illuminate\Http\Request;
use Session;

/**
 * Controls the data flow into a chapter object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  ChapterController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class ChapterController extends Controller
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('hasOpenedChapter')->only('create', 'store');
    }

    /**
     *  Display a listing of the resource.
     *
     * @param \App\DataTables\ChapterDataTable $dataTable The data table
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChapterDataTable $dataTable)
    {
        $this->authorize('manage', Chapter::class);
        return $dataTable->render('portal.chapters.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('open', Chapter::class);
        return view('portal.chapters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('open', Chapter::class);
        $chapter = Chapter::create(
            [
                'user_id' => $request->user ?? auth()->user()->id,
                'key' => 'Chap#' . auth()->user()->id . '-' . time(),
                'status' => 1,
                'total_cash_in_hands' => $request->total_cash_in_hands,

            ]
        );
        if ($request->adminAction) {
            event(
                new LogActivity(
                    $chapter->key,
                    ' ' . trans('feed.openedSuccessfullyByAdmin'),
                    trans('feed.chapter')
                )
            );
            return redirect(route('chapter.show', $chapter))
                ->with('success', trans('feed.chapter') . ' ' . $chapter->key . ' ' . trans('feed.openedForUser'));
        }
        event(
            new LogActivity(
                $chapter->key,
                ' ' . trans('feed.openedSuccessfullyBySelf'),
                trans('feed.chapter')
            )
        );
        return redirect(route('pos.index'))
            ->with(
                'info',
                trans('feed.chapter') . ' ' . $chapter->key . ' ' . trans('feed.chapterOpenedNote')
            );
    }

    /**
     * Displays Chapter
     *
     * @param \App\Chapter $chapter The chapter
     *
     * @return \Illuminate\View\View
     */
    public function show(Chapter $chapter)
    {
        $chapterInfo = new ChapterInfo($chapter);
        $info = $chapterInfo->info();
        return view('portal.chapters.show', compact(['chapter', 'info']));
    }

    /**
     * Close Chapter
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Chapter             $chapter The chapter
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close(Request $request, Chapter $chapter)
    {
        $this->authorize('close', Chapter::class);
        $holding = explode(",", $chapter->holdOnOrders);
        if (!$request->forceClearHolding && count($holding) > 0) {
            event(
                new LogActivity(
                    $chapter->key,
                    ' ' . trans('feed.attemptedToClose'),
                    trans('feed.chapter')
                )
            );
            return back()->with(
                'message',
                trans('feed.clearAllHoldingNote')
            );
        }
        //Pin confirmation
        if ($chapter->status
            && $chapter->user->pin === $request->authKey
        ) {
            //Forget Holding orders
            if (count($holding) > 0) {
                foreach ($holding as $value) {
                    Session::forget($value);
                }
            }
            //Update chapter to closed.
            $chapter->update(
                [
                    'status' => 0,
                    'closed_at' => now(),
                    //'holdOnOrders'=>'[]'
                ]
            );
            event(
                new LogActivity(
                    $chapter->key,
                    ' ' . trans('feed.closedSuccessfully'),
                    trans('feed.chapter')
                )
            );
            return redirect(route('home'))
                ->with('success', $chapter->key . ' ' . trans('feed.closedSuccessfully'));
        }
        event(
            new LogActivity(
                $chapter->key,
                ' ' . trans('feed.attemptedToCloseWithInvalidPin'),
                trans('feed.chapter')
            )
        );
        return back()->with(
            'warning',
            trans('feed.mayYourNotMatch')
        );
    }

    /**
     * Opened Chapter for point of sale
     *
     * @return mixed
     */
    public function pos()
    {
        return trim($this->activeChapter()->holdOnOrders, ',');
    }
}
