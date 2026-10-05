<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use App\Support\RichText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function index(): View
    {
        return view('admin.insights.index', [
            'insights' => Insight::query()->latest('updated_at')->paginate(12),
            'publishedCount' => Insight::published()->count(),
            'draftCount' => Insight::query()->where('is_published', false)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.insights.form', ['insight' => new Insight]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $request->user()->id;
        $data['body'] = RichText::clean($data['body']);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? now()) : null;
        $data['cover_image'] = $request->file('cover_image')?->store('insights', 'public');
        Insight::query()->create($data);

        return redirect()->route('admin.insights.index')->with('status', 'Insight saved.');
    }

    public function show(Insight $insight): RedirectResponse
    {
        return redirect()->route('admin.insights.edit', $insight);
    }

    public function edit(Insight $insight): View
    {
        return view('admin.insights.form', ['insight' => $insight]);
    }

    public function update(Request $request, Insight $insight): RedirectResponse
    {
        $data = $this->validatedData($request, $insight);
        $data['body'] = RichText::clean($data['body']);
        $data['slug'] = $this->uniqueSlug($data['title'], $insight);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? $insight->published_at ?? now()) : null;

        if ($request->hasFile('cover_image')) {
            if ($insight->cover_image !== null) {
                Storage::disk('public')->delete($insight->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('insights', 'public');
        } else {
            unset($data['cover_image']);
        }

        $insight->update($data);

        return redirect()->route('admin.insights.index')->with('status', 'Insight updated.');
    }

    public function destroy(Insight $insight): RedirectResponse
    {
        if ($insight->cover_image !== null) {
            Storage::disk('public')->delete($insight->cover_image);
        }

        $insight->delete();

        return redirect()->route('admin.insights.index')->with('status', 'Insight deleted.');
    }

    /** @return array{title: string, category: string, excerpt: string, body: string, published_at: ?string, cover_image?: mixed} */
    private function validatedData(Request $request, ?Insight $insight = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['required', 'string', 'max:320'],
            'body' => ['required', 'string', 'max:500000'],
            'published_at' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    private function uniqueSlug(string $title, ?Insight $insight = null): string
    {
        $base = Str::slug($title) ?: 'insight';
        $slug = $base;
        $suffix = 2;

        while (Insight::query()->where('slug', $slug)->when($insight, fn ($query) => $query->whereKeyNot($insight->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
