<table>
    <thead>
        <tr>
            <th>Tanggal Kirim</th>
            <th>Relasi (Customer)</th>
            <th>Nama Barang</th>
            <th>Bahan/kg (Unit)</th>
            <th>Harga/kg</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            @foreach($order->orderDetails as $detail)
                <tr>
                    <td>{{ $order->order_date }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $detail->product->category->name ?? '--' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->unitcost }}</td>
                    <td>{{ $detail->total}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
