<!-- 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        // Simpan ke tabel transaksi
        $transaksiId = DB::table('transaksi')->insertGetId([
            'nama'      => $data['nama'],
            'telepon'   => $data['telepon'],
            'alamat'    => $data['alamat'],
            'kecamatan' => $data['kecamatan'],
            'kota'      => $data['kota'],
            'ongkir'    => $data['ongkir'],
            'total'     => $data['total'],
            'status'    => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan item
        foreach ($data['items'] as $item) {
            DB::table('OrdersItems')->insert([
                'transaksi_id' => $transaksiId,
                'nama_produk'  => $item['name'],
                'qty'          => $item['quantity'],
                'harga'        => $item['price'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dikirim!',
            'transaksi_id' => $transaksiId
        ]);
    }
} -->
