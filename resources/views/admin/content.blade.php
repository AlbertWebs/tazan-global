@extends('admin.layout')

@section('title', 'Website copy')
@section('crumb', 'WEBSITE COPY')

@section('content')
<div class="studio-page-heading"><div><p class="studio-eyebrow">THE VOICE OF TAZAN GLOBAL</p><h1>Website copy</h1><p class="studio-subtitle">Shape the words across your homepage, all in one place.</p></div></div>
<form class="copy-form" method="post" action="{{ route('admin.content.update') }}">@csrf @method('PUT')
  <div class="copy-intro"><span>✳</span><div><b>Keep it considered.</b><p>Write one line per heading line. Your changes appear on the website as soon as you save.</p></div></div>
  @php($groups = ['First impression' => ['hero_label', 'hero_title', 'hero_copy'], 'Who we are' => ['intro_eyebrow', 'intro_title', 'intro_lead', 'intro_body'], 'How we invest' => ['strategy_title', 'strategy_body'], 'Our perspective' => ['statement_title', 'statement_body'], 'The difference' => ['benefits_title', 'benefits_body'], 'Investor information' => ['account_title', 'account_body'], 'A partnership for the long view' => ['quote_title'], 'Get in touch' => ['contact_title', 'contact_body']])
  @php($labels = ['hero_label' => 'Kicker above the main heading', 'hero_title' => 'Main heading', 'hero_copy' => 'Main introduction', 'intro_eyebrow' => 'Section kicker', 'intro_title' => 'Section heading', 'intro_lead' => 'Lead paragraph', 'intro_body' => 'About Tazan Global', 'strategy_title' => 'Strategy heading', 'strategy_body' => 'Strategy introduction', 'statement_title' => 'Statement', 'statement_body' => 'Supporting perspective', 'benefits_title' => 'Section heading', 'benefits_body' => 'Section introduction', 'account_title' => 'Section heading', 'account_body' => 'Investor information introduction', 'quote_title' => 'Closing headline', 'contact_title' => 'Contact heading', 'contact_body' => 'Contact introduction'])
  @foreach ($groups as $group => $fields)
    <section class="copy-section"><div class="copy-section-heading"><span>{{ sprintf('%02d', $loop->iteration) }}</span><h2>{{ $group }}</h2><i></i></div><div class="copy-fields">
      @foreach ($fields as $field)<div class="copy-field"><label for="{{ $field }}">{{ $labels[$field] }}</label>@if (str_ends_with($field, '_title'))<textarea id="{{ $field }}" name="{{ $field }}" rows="2" required>{{ old($field, $content[$field]) }}</textarea><small>Each line becomes a new line on the page.</small>@elseif (strlen($content[$field]) > 180)<textarea id="{{ $field }}" name="{{ $field }}" rows="4" required>{{ old($field, $content[$field]) }}</textarea>@else<input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $content[$field]) }}" required>@endif @error($field)<span class="field-error">{{ $message }}</span>@enderror</div>@endforeach
    </div></section>
  @endforeach
  <div class="copy-submit"><span>All changes appear on your public homepage.</span><button class="studio-button studio-button-dark" type="submit">Save website copy <span>↗</span></button></div>
</form>
@endsection
