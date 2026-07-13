@if (! empty($blogSchemaLd['@graph']))
<script type="application/ld+json">
{!! json_encode($blogSchemaLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif
