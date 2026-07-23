<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use LaraGrid\Actions\Action;
use LaraGrid\Aggregate;
use LaraGrid\Columns\ComputedColumn;
use LaraGrid\Columns\DateColumn;
use LaraGrid\Columns\DecimalColumn;
use LaraGrid\Columns\IntegerColumn;
use LaraGrid\Columns\SerialColumn;
use LaraGrid\Columns\TextColumn;
use LaraGrid\Filters\SelectFilter;
use LaraGrid\Grid;
use LaraGrid\GridDensity;
use LaraGrid\Livewire\WithLaraGrid;
use LaraGrid\Support\CellHtml;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Orders')]
class Index extends Component
{
    use WithLaraGrid;

    /**
     * The grids this host exposes, keyed by name.
     */
    protected function grids(): array
    {
        $orderTable = (new Order)->getTable();
        return [
            'orders' => Grid::make('orders')
                ->query(fn (): Builder => $this->ordersQuery())
                ->authorize(fn () => Gate::authorize('viewAny', Order::class))
                ->paginate(25, [10, 25, 50, 100])
                ->defaultSort('order_date', 'desc')
                ->searchable(['order_number', 'customer_name'])
                ->filters([
                    SelectFilter::make('status')->label(__('Status'))->column($orderTable.'.status')->options([
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'fulfilled' => __('Fulfilled'),
                        'cancelled' => __('Cancelled'),
                    ]),
                ])
                ->columns([
                    SerialColumn::make(),
                    TextColumn::make('order_number')->label(__('Order number'))->sortable($orderTable.'.order_number')->width(130),
                    TextColumn::make('customer_name')->label(__('Customer'))->sortable($orderTable.'.customer_name')->grow(),
                    DateColumn::make('order_date')->label(__('Ordered'))->sortable($orderTable.'.order_date')->width(120),
                    ComputedColumn::make('status_badge')->label(__('Status'))->html()->width(110)
                        ->state(fn (array $row): string => $this->statusBadge((string) $row['status'])),
                    IntegerColumn::make('items_count')->label(__('Lines'))->sortable('items_count')->width(80),
                    DecimalColumn::make('total')->label(__('Total, $'))->scale(2)->sortable($orderTable.'.total')->width(130),
                    TextColumn::make('created_by')->label(__('Owner'))->sortable('created_by')->width(150),
                ])
                ->footer([Aggregate::sum('total')->format('number', ['scale' => 2])])
                ->exportable(['csv', 'xlsx', 'pdf'], fileName: 'orders')
                ->savedViews()
                ->actions([
                    Action::make('fulfill')->label(__('Fulfill'))->icon('✓')
                        ->visible(fn (array $row): bool => $row['status'] === 'confirmed')
                        ->confirm(__('Mark this order as fulfilled?'))
                        ->call(function (array $row): void {
                            $order = Order::query()
                                ->where('id', $row['id'])
                                ->firstOrFail();

                            Gate::authorize('update', $order);

                            $order->update(['status' => 'fulfilled']);
                        }),
                ])
                ->toolbarActions([
                    Action::make('new')->label(__('New order'))->icon('+')->url(fn (): string => route('orders.create')),
                ])
                ->persistWidths()
                ->stickyHeader()
                ->striped()
                ->density(GridDensity::Compact)
                ->theme('amber')
                ->maxHeight('68vh'),
        ];
    }

    public function render(): View
    {
        return view('livewire.orders.index');
    }

    /**
     * @return Builder<Order>
     */
    private function ordersQuery(): Builder
    {
        $orderTable = (new Order)->getTable();
        $userTable = (new User)->getTable();

        return Order::query()
            ->select($orderTable.'.*')
            ->addSelect([
                'created_by' => User::query()
                    ->select('name')
                    ->whereColumn($userTable.'.id', $orderTable.'.user_id')
                    ->limit(1),
            ])
            ->withCount('items');
    }

    private function statusBadge(string $status): string
    {
        return match ($status) {
            'confirmed' => CellHtml::badge('blue', __('Confirmed')),
            'fulfilled' => CellHtml::badge('green', __('Fulfilled')),
            'cancelled' => CellHtml::badge('red', __('Cancelled')),
            default => CellHtml::badge('amber', __('Pending')),
        };
    }
}
