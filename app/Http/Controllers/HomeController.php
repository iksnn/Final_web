<?php

    namespace App\Http\Controllers;

    use App\Models\About;
    use App\Models\Cart;
    use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
    use App\Models\Slider;
    use App\Models\Testimoni;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    class HomeController extends Controller
    {
        public function index()
        {
            $sliders = Slider::all();
            $categories = Category::all();
            $testimonis = Testimoni::all();
            $products = Product::skip(0)->take(4)->get();
            return view('home.index', compact('sliders', 'categories', 'testimonis', 'products'));
        }
        public function products($id_subcategory)
        {
            $products = Product::where('id_kategori', $id_subcategory)->get();
            return view('home.products', compact('products'));
        }
        public function product($id_product)
        {   
            $product = Product::find($id_product);
            $latest_products = Product::orderByDesc('created_at')->offset(0)->limit(10)->get();
            return view('home.product', compact('product', 'latest_products'));
        }

        public function add_to_cart(Request $request)
        {
            $input = $request->all();
            Cart::create($input);
        }   

        public function delete_from_cart(Cart $cart)
        {
            $cart->delete();
            return redirect('/cart');   
        }   

        public function cart()
        {
            if (!Auth::guard('webmember')->user()){
                return redirect('/login_member');
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e4cc0bdd6d22e1b830bea813a8c13d0a"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            }

            $provinsi = json_decode($response);
                
            $carts = Cart::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->get();
            $cart_total = Cart::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->sum('total');
            return view('home.cart', compact('carts', 'provinsi', 'cart_total'));
        }

        public function get_kota($id)
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e4cc0bdd6d22e1b830bea813a8c13d0a"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }
        }

        public function get_ongkir($destination, $weight)
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=153&destination=" . $destination . "&weight=" . $weight . "&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: e4cc0bdd6d22e1b830bea813a8c13d0a"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }
        }

        public function checkout_orders(Request $request)
        {
            $order_id = DB::table('orders')->insertGetId([
                'id_member' => $request->id_member,
                'invoice' => date('ymds'),
                'grand_total' => $request->grand_total,
                'status' => 'Baru',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            for ($i = 0; $i < count($request->id_produk); $i++) {
                DB::table('order_details')->insert([
                    'id_order' => $order_id, 
                    'id_produk' => $request->id_produk[$i],
                    'jumlah' => $request->jumlah[$i],
                    'total' => $request->total[$i],
                ]);
            }
            Cart::where('id_member', Auth::guard('webmember')->user()->id)->update([
                'is_checkout' => 1
            ]);

            // Tidak perlu melakukan $cart->save() karena Anda sudah melakukan update di atas.
        }


        public function checkout()
            {
                $about = About::first();
                
                // Ambil data pesanan pada saat checkout
                $orders = Order::where('id_member', Auth::guard('webmember')->user()->id)->latest()->first();

                // Pastikan pesanan ada sebelum melanjutkan
                if (!$orders) {
                    // Handle jika pesanan tidak ditemukan
                    // Misalnya, tampilkan pesan kesalahan atau redirect ke halaman lain
                }

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "key: e4cc0bdd6d22e1b830bea813a8c13d0a"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                }

                $provinsi = json_decode($response);

                return view('home.checkout', compact('about', 'orders', 'provinsi'));
            }


        public function payments(Request $request)
        {
            
            Payment::create([
                'id_order' => $request->id_order,
                'id_member' => Auth::guard('webmember')->user()->id,
                'jumlah' => $request->jumlah,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'detail_alamat' => $request->detail_alamat,
                'status' => 'MENUNGGU',
                'no_rekening' => $request->no_rekening,
                'atas_nama' => $request->atas_nama,
            ]);

            return redirect('/orders');
        }

        public function orders()
        {
            $orders = Order::where('id_member', Auth::guard('webmember')->user()->id)->get();
            $payments = Payment::where('id_member', Auth::guard('webmember')->user()->id)->get();
            return view('home.orders', compact('orders', 'payments'));
        }

        public function pesanan_selesai(Order $order)
        {
            $order->status = 'Selesai';
            $order->save();

            return redirect('/orders');
        }

        public function about()
        {
            $about = About::first();
            $testimonis = Testimoni::all();
            return view('home.about', compact('about', 'testimonis'));
        }
        public function contact()
        {
            $about = About::first();
            return view('home.contact', compact('about'));
        }
        public function faq()
        {
            return view('home.faq');
        }
    }
