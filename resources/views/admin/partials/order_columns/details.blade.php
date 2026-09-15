<span class="stack-top text-primary">#{{ $orders->format_order_id }}</span>
<span class="stack-bottom">{{ date('d M, Y', strtotime($orders->created_at)) }}</span>
