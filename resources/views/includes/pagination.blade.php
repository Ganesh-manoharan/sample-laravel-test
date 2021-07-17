<div class="d-flex justify-content-start default-pagination">
    {{ $data->appends(request()->query())->links() }}
    <div class="ml-2">{{__('pagination.viewing')}} @if(count($data) > 0) {{ $data->firstItem() }} - {{ $data->lastItem() }} of @endif {{ $data->total() }} {{__('pagination.entries')}}</div>
</div>