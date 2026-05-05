<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Services\LabelService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabelController extends Controller
{
    public function index():View
    {
        $labels = app(LabelService::class)->getAllByUser(auth()->id());

        return view('labels.index', ['labels' => $labels]);
    }

    public function createView():View
    {
        return view('labels.create');
    }
    public function store(Request $request)
    {
        $name = $request->get('name');
        $color = $request->get('color');

        app(LabelService::class)->create(
            name: $name,
            userId: auth()->user()->id,
            color: $color);

        return redirect()->route('labels.index');
    }

    public function edit(Label $label):View
    {
        return view('labels.edit', ['label' => $label]);
    }

    public function update(Request $request, Label $label)
    {
        $name = $request->get('name');
        $color = $request->get('color');

        app(LabelService::class)->update($label, $name, $color);
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        app(LabelService::class)->delete($label);
        return redirect()->route('labels.index');
    }
}
