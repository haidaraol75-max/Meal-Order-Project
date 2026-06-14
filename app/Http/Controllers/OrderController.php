<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RestaurantTable;
use App\Models\MenuItem;
use App\Models\OrderItem;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'table_id' => 'required_if:order_type,dine_in|exists:restaurant_tables,id',
            'order_type' => 'required|in:dine_in,takeaway',
            'foods' => 'required|array|min:1',
            'foods.*.menu_item_id' => 'required|exists:menu_items,id',
            'foods.*.quantity' => 'required|integer|min:1',
            'foods.*.notes' => 'nullable|string', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

       

        DB::beginTransaction();

        try {
           
            $order = new Order();
            $order->table_id = $validatedData['table_id'] ?? null;
            $order->order_status = 'Preparing';
            $order->order_type = $validatedData['order_type'];
            $order->save();
            $totalOrderAmount = 0;
            foreach ($validatedData['foods'] as $itemData)
            {
                $menuItem = MenuItem::findOrFail($itemData['menu_item_id']);
                if (!$menuItem->availability)
                {
                    DB::rollBack();
                    return response()->json(['message' => "Menu item '{$menuItem->name}' is currently unavailable."], 400);
                }
                
                $itemPrice = $menuItem->price; 
                $quantity = $itemData['quantity'];
                $notes = $itemData['notes'] ?? null; 
                $subtotal = $itemPrice * $quantity;
                $totalOrderAmount += $subtotal;
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $itemData['menu_item_id'],
                    'quantity' => $quantity,
                    'price' => $itemPrice, 
                    'notes' => $notes,
                ]);
            }
            $order->total_amount = $totalOrderAmount;
            $order->save();
            DB::commit();
            $order->load('menuItems', 'restaurantTable'); 
            return response()->json([
                'message' => 'Order placed successfully!',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
         

            DB::rollBack();
             Log::error('Order creation failed: ' . $e->getMessage() . ' Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Failed to place order. Please try again later.'], 500);
        }
    }

    public function getOrdersByTable(int $tableId)
    {
      
        $table = RestaurantTable::find($tableId);
        if (!$table) 
        {
            return response()->json(['message' => 'Table not found.'], 404);
        }

        $orders = Order::with(['menuItems', 'restaurantTable'])
                       ->where('table_id', $tableId)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return response()->json(['data' => $orders]);
    }

        /**
     * Update the status of a specific order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), 
        [
            'order_status' => 'required|in:Preparing,Ready,Delivered',
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::find($orderId);

        if (!$order) 
        {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $order->order_status = $request->order_status;
        $order->save();
        return response()->json([
            'message' => 'Order status updated successfully.',
            'data' => $order->load('menuItems', 'restaurantTable') // تحميل العلاقات للعرض
        ]);
    }


    public function show( $orderId)
    {
        if (!is_numeric($orderId)) 
        {
             return response()->json([
            'message' => 'Invalid order id.'
              ], 400);
        }
        $order = Order::with([
        'menuItems',
        'restaurantTable'
        ])->find($orderId);

        if (!$order)
        {
           return response()->json([
            'message' => 'Order not found.'
           ], 404);
        }

           return response()->json([
           'data' => $order
         ]);
    }

    public function index(Request $request)
    {
         $query = Order::query();

        if ($request->has('order_status'))
        {
           $query->where('order_status', $request->order_status);
        }

          $orders = $query
          ->orderBy('updated_at', 'desc')
          ->get();

        return response()->json([
        'data' => $orders
          ]);
       
    }
}




?>


