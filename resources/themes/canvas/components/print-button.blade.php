@props([
    'text' => null,
    'tooltip' => __('tools.printResult'),
])
<button data-bs-toggle="tooltip" title="{{ $tooltip }}" {!! $attributes->merge(['class' => 'btn btn-outline-primary rounded-' . ($text ? 'pill' : 'circle'), 'id']) !!}>
    <i class="an an-print"></i>
    
        <span>Download PDF</span>
    
</button>
