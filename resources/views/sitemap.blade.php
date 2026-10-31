{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://tazanglobal.com/</loc>
  </url>
  <url>
    <loc>https://tazanglobal.com/insights</loc>
  </url>
@foreach ($insights as $insight)
  <url>
    <loc>{{ 'https://tazanglobal.com/insights/'.$insight->slug }}</loc>
    <lastmod>{{ $insight->updated_at->toAtomString() }}</lastmod>
  </url>
@endforeach
</urlset>
