
// namespace App\Http\Controllers;

// use App\Models\Orders;
// use App\Models\OrderItem;
// use Illuminate\Http\Request;

// class OrderController extends Controller
// {
//     // Create new order
//     public function store(Request $request)
//     {
//         $data = $request->all();

//         // Hitung total harga
//         $total = 0;
//         foreach ($data['items'] as $item) {
//             $total += $item['price'] * $item['qty'];
//         }

//         // Buat order
//         $order = Orders::create([
//             'user_id' => $data['user_id'],
//             'total_price' => $total,
//             'status' => 'pending'
//         ]);

//         // Masukkan item
//         foreach ($data['items'] as $item) {
//             OrderItem::create([
//                 'order_id'     => $order->id,
//                 'product_name' => $item['name'],
//                 'quantity'     => $item['qty'],
//                 'price'        => $item['price']
//             ]);
//         }

//         return response()->json([
//             'message' => 'Order berhasil dibuat!',
//             'order_id' => $order->id
//         ]);
//     }

//     // Admin melihat seluruh order
//     public function index()
//     {
//         return Orders::with('items', 'items')->get();
//     }
// }
