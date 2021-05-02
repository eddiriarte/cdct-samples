@extends('layouts.main')

@section('content')
    <h1 class="title">
        Order Details
    </h1>
    <p class="subtitle">
        This is a detailed view for a selected order!
    </p>

    <div class="card">
        <div class="card-content">
            <div class="content">
                <h2 class="title">Order {{ $order->getId() }}</h2>
                <p class="subtitle">Ordered at: {{ $order->getOrderedAt() }}</p>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 30px">
        <div class="card-content">
            <div class="content">
                <h2 class="title">Basket</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th><abbr title="Article Number">Art. No</abbr></th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price (gross)</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->getBasket() as $item)
                        <tr>
                            <td>{{ $item->getArticleNumber() }}</td>
                            <td>{{ $item->getDescription() }}</td>
                            <td>{{ $item->getQuantity() }}</td>
                            <td>{{ $item->getUnitPriceGross() }}</td>
                            <td>{{ $item->getQuantity() * $item->getUnitPriceGross() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @foreach($order->getPayments() as $payment)
    <div class="card" style="margin-top: 30px">
        <div class="card-content">
            <div class="content">
                <h4 class="title">{{ $payment->getDescription() }}</h4>
                <p>{{ $payment->getAmount() }}</p>
            </div>
        </div>
    </div>
    @endforeach

@endsection
