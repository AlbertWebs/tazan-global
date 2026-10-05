<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteContentController extends Controller
{
    public function index(): View
    {
        return view('admin.content', ['content' => SiteContent::currentCopy()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach (SiteContent::defaults() as $key => $default) {
            $rules[$key] = ['required', 'string', 'max:'.(strlen($default) > 250 ? '2000' : '500')];
        }

        SiteContent::saveCopy($request->validate($rules));

        return back()->with('status', 'Website copy updated.');
    }
}
