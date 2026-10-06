<?php

namespace App\Http\Controllers;

use App\Models\RestorationProject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestorationController extends Controller
{
    public function index(Request $request): View
    {
        $type = in_array($request->query('type'), RestorationProject::TYPES, true) ? $request->query('type') : null;

        return view('restore.index', [
            'projects' => RestorationProject::published()->when($type, fn ($q) => $q->where('type', $type))->orderBy('sort_order')->get(),
            'type' => $type,
        ]);
    }

    public function show(RestorationProject $project): View
    {
        abort_unless($project->is_published, 404);

        return view('restore.show', ['project' => $project]);
    }
}
