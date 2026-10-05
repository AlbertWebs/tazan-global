@extends('admin.layout')

@section('title', 'Insights')
@section('crumb', 'INSIGHTS')

@section('content')
  <div class="studio-page-heading"><div><p class="studio-eyebrow">YOUR EDITORIAL DESK</p><h1>Insights</h1><p class="studio-subtitle">Thoughtful perspectives, ready for the world.</p></div><a class="studio-button studio-button-dark" href="{{ route('admin.insights.create') }}">Write an insight <span>＋</span></a></div>
  <div class="studio-stats"><div><span>ALL STORIES</span><b>{{ $insights->total() }}</b><small>Across your library</small></div><div><span>PUBLISHED</span><b>{{ $publishedCount }}</b><small>Live on your website</small></div><div><span>DRAFTS</span><b>{{ $draftCount }}</b><small>In your workspace</small></div><div class="studio-stat-quote"><span>EDITORIAL NOTE</span><p>Good ideas deserve<br>a considered point of view.</p><i>TAZAN GLOBAL</i></div></div>
  <section class="studio-table-card"><div class="studio-table-heading"><div><h2>Your stories</h2><p>Manage drafts and published insights.</p></div><a href="{{ route('insights.index') }}" target="_blank" rel="noopener">View public insights ↗</a></div>
    @if ($insights->isEmpty())<div class="studio-empty"><span>✳</span><h3>Your first story starts here.</h3><p>Share a market perspective or a note from the Tazan team.</p><a class="studio-button studio-button-dark" href="{{ route('admin.insights.create') }}">Create your first insight ↗</a></div>
    @else <div class="insight-table-wrap"><table class="insight-table"><thead><tr><th>STORY</th><th>STATUS</th><th>LAST UPDATED</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>
      @foreach ($insights as $insight)<tr><td><div class="table-story">@if ($insight->cover_image)<img src="{{ asset('storage/'.$insight->cover_image) }}" alt="">@else<div class="table-thumb">TG</div>@endif<div><strong>{{ $insight->title }}</strong><span>{{ $insight->category }} <i>·</i> {{ $insight->slug }}</span></div></div></td><td><span class="status-pill {{ $insight->is_published ? 'is-published' : 'is-draft' }}"><i></i>{{ $insight->is_published ? 'Published' : 'Draft' }}</span></td><td class="table-date">{{ $insight->updated_at->format('M j, Y') }}</td><td><div class="table-actions"><a href="{{ route('admin.insights.edit', $insight) }}">Edit <span>↗</span></a><form method="post" action="{{ route('admin.insights.destroy', $insight) }}" onsubmit="return confirm('Delete this insight permanently?')">@csrf @method('DELETE')<button type="submit" aria-label="Delete {{ $insight->title }}">⌫</button></form></div></td></tr>@endforeach
    </tbody></table></div>{{ $insights->links('admin.pagination') }}@endif
  </section>
@endsection
