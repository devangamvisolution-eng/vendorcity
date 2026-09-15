
                                                <span class="stack-top">{{ $orders->user_name }}</span>
                                                <span class="stack-bottom">{!! isset($orders->items[0]) ? Helper::subservicename($orders->items[0]->subservice_id) : '-' !!}</span>
                                            
