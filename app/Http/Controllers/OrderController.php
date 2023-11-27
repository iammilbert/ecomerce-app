<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ResponseHelper;

    public function index()
    {
        $this->items = Order::with(['user', 'product']);
        return $this->sendSuccess($this->items, 'List of Order');
    }



    public function update(Request $request, $orderId)
    {
        $validatedData = Validator::make($request->all(), [
            'order_date'=>'string|max:225',
            'unit_price'=>'string|max:225',
            'quantity'=>'string|max:225',
            'total_amount'=>'string|max:225',
        ]);
        $this->update = Order::find($orderId)->update($validatedData);
        return $this->sendSuccess($this->update, 'Order updated successfully', 200);
    }


    public function show($orderId)
    {
        $this->details = Order::query()->find($orderId)->with(['user', 'product']);;
        return sendSuccess($this->details, 'Items Details', 200);
    }


    public function pending_order($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->where('status', 'Pending');
        return sendSuccess($this->details, 'Pending Order', 200);
    }


    public function processing_order($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->orWhere('status', 'processing');
        return sendSuccess($this->details, 'Order Processing', 200);
    }


       public function delivered_order($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->orWhere('status', 'processing');
        return sendSuccess($this->details, 'Order Delivered', 200);
    }


    public function cancelled_order($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->Where('status', 'Cancelled');
        return sendSuccess($this->details, 'Customer Details', 200);
    }

      public function order_onhold($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->Where('status', 'On Hold');
        return sendSuccess($this->details, 'Customer Details', 200);
    }


    public function order_refunded($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->Where('status', 'ProductRefunded');
        return sendSuccess($this->details, 'Customer Details', 200);
    }


    public function order_returned($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->Where('status', 'Returned');
        return sendSuccess($this->details, 'Customer Details', 200);
    }


        public function order_payment_failed($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->Where('status', 'PaymentFailed');
        return sendSuccess($this->details, 'Customer Details', 200);
    }


 public function order_fraud_review($userId)
    {
        $this->details = Order::query()->find($userId)
                                ->with(['product'])
                                ->Where('status', 'FraudReview');
        return sendSuccess($this->details, 'Customer Details', 200);
    }


    public function delete($id)
    {
        $this->delete = Country::query()->find($id)->delete();
        return $this->sendSuccess( $this->delete, 'Country deleted successfully', 200);
    }

}
