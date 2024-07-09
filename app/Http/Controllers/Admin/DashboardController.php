<?php
namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Admin;
use App\Models\Property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $total_active_customers = User::where('status', 'Active')->count();
        $total_pending_customers = User::where('status', 'Pending')->count();
        $total_active_properties = Property::where('property_status', 'Active')->count();
        $total_pending_properties = Property::where('property_status', 'Pending')->count();
        
        return view('admin.home', compact('total_active_customers','total_pending_customers','total_active_properties','total_pending_properties'));
    }
}