<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>
</head>
<body>

<h2>Total Bayar: Rp {{ number_format($order->total_price) }}</h2>

<button id="pay-button">Bayar Sekarang</button>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            alert("Pembayaran Berhasil");
            console.log(result);
        },
        onPending: function(result){
            alert("Menunggu Pembayaran");
            console.log(result);
        },
        onError: function(result){
            alert("Pembayaran Gagal");
            console.log(result);
        }
    });
};
</script>

</body>
</html>
