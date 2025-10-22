<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings\Basic;
use App\Models\Shop\Product;
use App\Models\Shop\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  //index
  public function index(Request $request)
  {
    $misc = new MiscellaneousController();

    $language = $misc->getLanguage();
    $information['bgImg'] = $misc->getBreadcrumb();
    $information['pageHeading'] = $misc->getPageHeading($language);

    $information['orders'] = ProductOrder::join('product_purchase_items', 'product_purchase_items.product_order_id', '=', 'product_orders.id')
      ->join('product_contents', 'product_contents.product_id', 'product_purchase_items.product_id')
      ->where('product_contents.language_id', $language->id)
      ->where('product_orders.user_id', Auth::guard('web')->user()->id)
      ->when($request->product, function ($query) use ($request) {
        $query->where(function ($subQuery) use ($request) {
          $subQuery->where('product_orders.order_number', 'like', '%' . $request->product . '%')
            ->orWhere('product_purchase_items.title', 'like', '%' . $request->product . '%');
        });
      })
      ->select(
        'product_contents.title',
        'product_contents.slug',
        'product_orders.payment_status',
        'product_orders.order_status',
        'product_orders.id',
      'product_orders.created_at',
      )
      ->orderBy('product_orders.id', 'desc')
      ->paginate(10);

    return view('frontend.user.order.index', $information);
  }
  //details
  public function details($id)
  {
    $misc = new MiscellaneousController();

    $queryResult['bgImg'] = $misc->getBreadcrumb();

    $language = $misc->getLanguage();
    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    $order = ProductOrder::query()->find($id);
    if ($order) {
      if ($order->user_id != Auth::guard('web')->user()->id) {
        return redirect()->route('user.dashboard');
      }

      $queryResult['order'] = $order;

      $queryResult['tax'] = Basic::select('product_tax_amount')->first();

      $items = $order->item()->get();

      $items->map(function ($item) use ($language) {
        $product = $item->productInfo()->first();
        $item['price'] = $product->current_price;
        $item['productType'] = $product->product_type;
        $item['inputType'] = $product->input_type;
        $item['link'] = $product->link;
        $content = $product->content()->where('language_id', $language->id)->first();

        $item['productTitle'] = $content ? $content->title : '';
        $item['slug'] = $content ? $content->slug : '';
      });

      $queryResult['items'] = $items;

      return view('frontend.user.order.details', $queryResult);
    } else {
      return view('errors.404');
    }
  }

  public function download($id)
  {
    $product = Product::findOrFail($id);
    $filePath = public_path('assets/file/products/' . $product->file);

    // Get the file name from the file path
    $fileName = pathinfo($filePath, PATHINFO_FILENAME);

    // Return a download response
    return response()->download($filePath, $fileName);
  }
}
