<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Queries\Dashboard\DashboardHandler;
use App\Queries\Dashboard\DashboardQuery;
use App\Queries\Note\NoteHandler;
use App\Queries\Note\NoteQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = AuthHelper::getUser();

        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('perPage', 10);

        $data = [];
        $dashboardQuery = new DashboardQuery(userId: $user->getKey());
        $systemMetrics = app(DashboardHandler::class)->execute($dashboardQuery);

        $noteQuery = new NoteQuery(
            page: $page,
            perPage: $perPage,
            userId: $user->getKey()
        );

        $notes = app(NoteHandler::class)->execute($noteQuery);

        $data['metrics'] = $systemMetrics;
        $data['notes'] = $notes;
        return view('notes.dashboard', $data);
    }
}
