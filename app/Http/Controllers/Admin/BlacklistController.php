<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blacklist\StoreBlacklistRequest;
use App\Http\Requests\Admin\Blacklist\UpdateBlacklistRequest;
use App\Repositories\BlacklistRepository;
use Exception;

class BlacklistController extends Controller
{
    private $blacklistRepository;

    public function __construct(BlacklistRepository $blacklistRepository)
    {
        $this->blacklistRepository = $blacklistRepository;
    }

    public function index()
    {
        $blacklists = $this->blacklistRepository->paginateBySearch();
        return view('admin.blacklists.index', compact('blacklists'));
    }

    public function create()
    {
        $users = $this->blacklistRepository->getUserNotBlock();
        return view('admin.blacklists.create', compact('users'));
    }

    public function store(StoreBlacklistRequest $request)
    {
        try {
            $this->blacklistRepository->store($request);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('blacklists.create');
    }

    public function edit($id)
    {
        $block_user = $this->blacklistRepository->findById($id);
        $users = $this->blacklistRepository->getUserNotBlock($block_user['user_id']);
        return view('admin.blacklists.edit', compact('block_user', 'users'));
    }

    public function update(UpdateBlacklistRequest $request, $id)
    {
        try {
            $this->blacklistRepository->update($request, $id);
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('blacklists.edit', $id);
    }

    public function destroy($id)
    {
        try {
            $block_user = $this->blacklistRepository->findById($id);
            $block_user->delete();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('blacklists.index');
    }
}
