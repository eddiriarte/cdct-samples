@extends('layouts.main')

@section('content')
    <h1 class="title">
        Order Summary
    </h1>
    <p class="subtitle">
        This is a list of all orders you made!
    </p>

    <div class="card">
        <div class="card-content">
            <div class="content">

                <table class="table is-hoverable">
                    <thead>
                    <tr>
                        <th><abbr title="Order ID">ID</abbr></th>
                        <th>Date</th>
                        <th>Address</th>
                        <th>Currency</th>
                        <th>Net Amount</th>
                        <th>Tax Amount</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <th>
                                <a href="/orders/{{ $order->getId() }}">{{ $order->getId() }}</a>
                            </th>
                            <td>{{ $order->getOrderedAt() }}</td>
                            <td>{{ $order->getAddress() }}</td>
                            <td>{{ $order->getCurrency() }}</td>
                            <td>{{ number_format( $order->getNetAmount(), 2) }}</td>
                            <td>{{ number_format( $order->getTaxAmount(), 2) }}</td>
                            <td>{{ number_format( $order->getGrossTotal(), 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
