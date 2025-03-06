namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
public function index()
{
return view('welcome', [
'categories' => Category::withCount('products')->take(3)->get(),
'featuredProducts' => Product::where('featured', true)->take(4)->get(),
]);
}
}
