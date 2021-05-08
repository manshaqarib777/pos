<?php
/**
 * This file implements Group Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  GroupController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Group;
use App\Http\Requests\GroupRequest;
use App\Permission;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a group object
 * and updates the view whenever data changes.
 *
 * @category Class
 * @package  GroupController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class GroupController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('demoCheck')->only(['update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('manage', Group::class);
        return view('group.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Group::class);
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage
     *
     * @param \App\Http\Requests\GroupRequest $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        $this->authorize('create', Group::class);
        $group = Group::create($this->_validGroup($request));
        //create Permission batch against this group.
        if ($group->id) {
            Permission::create(['group_id' => $group->id]);
        }
        event(
            new LogActivity(
                $group->name,
                ' ' . trans('feed.newUserPermissionGroupCreated'),
                trans('feed.group')
            )
        );
        return redirect(route('group.index'))
            ->with('success', trans('feed.groupCreated'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Group $group The group
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Group $group)
    {
        return redirect(route('group.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Group $group The group
     *
     * @return mixed
     */
    public function edit(Group $group)
    {
        $this->authorize('manage', Group::class);
        if ($group->id < 2) {
            return redirect(route('home'))->with('info', trans('feed.noAccess'));
        }
        return view('group.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param \App\Http\Requests\GroupRequest $request The request
     * @param \App\Group                      $group   The group
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GroupRequest $request, Group $group)
    {
        $this->authorize('manage', Group::class);
        $group->update($this->_validGroup($request));
        event(
            new LogActivity(
                $group->name,
                ' ' . trans('feed.groupInformationUpdated'),
                trans('feed.group')
            )
        );
        return redirect(route('group.index'))
            ->with('success', trans('feed.groupUpdated'));
    }

    /**
     * Destroys the given group.
     *
     * @param \App\Group $group The group
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Group $group)
    {
        $this->authorize('manage', Group::class);
        if ($group->users->count() > 0) {
            return back()->with(
                'warning',
                trans('feed.unableToRemoveAssigned')
            );
        }
        //Remove permission batch first
        $group->permissions->delete();
        event(
            new LogActivity(
                $group->name,
                ' ' . trans('feed.groupRemoved'),
                trans('feed.group')
            )
        );
        $group->delete();
        return redirect(route('group.index'))
            ->with('success', trans('feed.groupRemoved'));
    }

    /**
     * Gives group details
     *
     * @param mixed $request The request
     *
     * @return array
     */
    private function _validGroup($request)
    {
        return [
            'name' => $request->name,
            'details' => $request->details,
        ];
    }
}
