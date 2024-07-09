<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use DB;
use Auth;

class PropertyCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $property_category = PropertyCategory::orderBy('id', 'asc')->get();
        return view('admin.property_category_view', compact('property_category'));
    }

    public function create() {
        $property_category = PropertyCategory::get();
        return view('admin.property_category_create', compact('property_category'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $request->validate([
            'property_category_name' => 'required|unique:property_categories',
            'property_category_slug' => 'unique:property_categories',
            'property_category_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'property_category_name.required' => ERR_NAME_REQUIRED,
            'property_category_name.unique' => ERR_NAME_EXIST,
            'property_category_slug.unique' => ERR_SLUG_UNIQUE,
            'property_category_photo.required' => ERR_PHOTO_REQUIRED,
            'property_category_photo.image' => ERR_PHOTO_IMAGE,
            'property_category_photo.mimes' => ERR_PHOTO_JPG_PNG_GIF,
            'property_category_photo.max' => ERR_PHOTO_MAX
        ]);

        $statement = DB::select("SHOW TABLE STATUS LIKE 'property_categories'");
        $ai_id = $statement[0]->Auto_increment;

        $ext = $request->file('property_category_photo')->extension();
        $rand_value = md5(mt_rand(11111111,99999999));
        $final_name = $rand_value.'.'.$ext;
        $request->file('property_category_photo')->move(public_path('uploads/property_category_photos/'), $final_name);

        $property_category = new PropertyCategory();
        $data = $request->only($property_category->getFillable());
        if(empty($data['property_category_slug'])) {
            unset($data['property_category_slug']);
            $data['property_category_slug'] = Str::slug($request->property_category_name);
        }

        if(preg_match('/\s/',$data['property_category_slug'])) {
            return Redirect()->back()->with('error', ERR_SLUG_WHITESPACE);
        }

        unset($data['property_category_photo']);
        $data['property_category_photo'] = $final_name;
        
        $property_category->fill($data)->save();

        return redirect()->route('admin_property_category_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $property_category = PropertyCategory::findOrFail($id);
        return view('admin.property_category_edit', compact('property_category'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $property_category = PropertyCategory::findOrFail($id);
        $data = $request->only($property_category->getFillable());

        if ($request->hasFile('property_category_photo')) {

            $request->validate([
                'property_category_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ],[
                'property_category_photo.image' => ERR_PHOTO_IMAGE,
                'property_category_photo.mimes' => ERR_PHOTO_JPG_PNG_GIF,
                'property_category_photo.max' => ERR_PHOTO_MAX
            ]);

            @unlink(public_path('uploads/property_category_photos/'.$property_category->property_category_photo));

            // Uploading the file
            $ext = $request->file('property_category_photo')->extension();
            $rand_value = md5(mt_rand(11111111,99999999));
            $final_name = $rand_value.'.'.$ext;
            $request->file('property_category_photo')->move(public_path('uploads/property_category_photos/'), $final_name);

            unset($data['property_category_photo']);
            $data['property_category_photo'] = $final_name;
        }

        $request->validate([
            'property_category_name'   =>  [
                'required',
                Rule::unique('property_categories')->ignore($id),
            ],
            'property_category_slug'   =>  [
                Rule::unique('property_categories')->ignore($id),
            ]
        ],[
            'property_category_name.required' => ERR_NAME_REQUIRED,
            'property_category_name.unique' => ERR_NAME_EXIST,
            'property_category_slug.unique' => ERR_SLUG_UNIQUE,
        ]);

        if(empty($data['property_category_slug']))
        {
            unset($data['property_category_slug']);
            $data['property_category_slug'] = Str::slug($request->property_category_name);
        }

        if(preg_match('/\s/',$data['property_category_slug']))
        {
            return Redirect()->back()->with('error', ERR_SLUG_WHITESPACE);
        }

        $property_category->fill($data)->save();

        return redirect()->route('admin_property_category_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id)
    {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        
        $tot = Property::where('property_category_id',$id)->count();
        if($tot) {
            return Redirect()->back()->with('error', ERR_ITEM_DELETE);   
        }

        $property_category = PropertyCategory::findOrFail($id);
        @unlink(public_path('uploads/property_category_photos/'.$property_category->property_category_photo));
        $property_category->delete();

        // Success Message and redirect
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

}
