@if(isset($data->settings['isLinhMucAdmin']) && $data->settings['isLinhMucAdmin'])
    @include('./adminlinhmuc')
@else
    @if(!empty($data->settings['page']))
        @include('./gp_phu_cuong')
    @endif
@endif