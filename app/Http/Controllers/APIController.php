<?php

namespace App\Http\Controllers;


use App\User;
use App\Setting;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Events\LogActivity;


class APIController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);
        $credentials['isActive'] = 1;
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);


        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();


        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function social_login(Request $request)
    {
        $request->validate([
            'username'   => 'required',
            'email' => 'required|string|email'
        ]);
        if (!User::where('email', '=', $request->email)->count() > 0) {
            $request['password'] = bcrypt("secret");
            User::create($request->all());
        }
        $credentials = request(["email"]);
        $credentials["password"] = "secret";
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);


        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();


        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function forgot(Request $request)
    {
        $setting = Setting::find('1');
        $input =  $request->all();
        if (User::where('email', '=', $request->email)->count() > 0) {
            // user found
            $admin = User::where('email', '=', $request->email)->firstOrFail();
            $autopass = Str::random(8);
            $input['password'] = bcrypt($autopass);
            $admin->update($input);
            $subject = "Reset Password Request";
            $msg = "Your New Password is : " . $autopass;

            $headers = "From: " . $setting->site_name . "<" . $setting->default_email . ">";
            mail($request->email, $subject, $msg, $headers);
            return response()->json('Your Password Reseted Successfully. Please Check your email for new Password.');
        } else {
            // user not found
            return response()->json(array('errors' => [0 => 'No Account Found With This Email.']), 403);
        }
    }
    public function profile(Request $request)
    {

        $user = $request->user();

        $user->image = asset("assets/user/propics/") . '/' . $user->image;

        $data['user'] = $user;
        $data['total_cars'] = Car::where('user_id', Auth::user()->id)->count();
        $data['featured_total_cars'] = Car::where('user_id', Auth::user()->id)->where('featured', 1)->count();
        $data['social_links'] = !empty($user->socialsetting) ? ($user->socialsetting->f_status + $user->socialsetting->i_status + $user->socialsetting->g_status + $user->socialsetting->t_status + $user->socialsetting->l_status + $user->socialsetting->d_status) : 0;
        $data['recent_cars_added'] = Car::where('user_id', $user->id)->orderBy('id', 'DESC')->limit(10)->get();

        return $data;
    }


    public function update_profile(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'about' => 'nullable|max:300',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $in = $request->all();
        $user = User::find(Auth::user()->id);
        $user->fill($in)->save();

        $msg = ['success' => 'ok', 'message' => 'Data Updated Successfully.'];
        return response()->json($msg);
    }


    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'max:225'], 'phone' => ['required'],
            'company' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'country_id' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        $token = md5(time().$request->name.$request->email);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()), 403);
        }
        $data = $request->all();
        $image = 'default_img/no_image.png';
        if (request()->hasFile('image')) {
            request()->validate(
                [
                    'image' => 'required|image|file',
                ]
            );
            $image = request()->image->store('uploads/user', 'public');
        }
        $user = User::create(
            [
                'group_id' => $this->bluePrints()->default_group ?? 1,
                'pin' => '12345',
                'name' => $data['name'],
                'email' => $data['email'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'company' => $data['company'],
                'country_id' => $data['country_id'],
                'image' => $image,
                'isActive' => 0,
                'password' => bcrypt($data['password']),
            ]
        );
        $setting = Setting::find('1');

        $to = $request->email;
        $subject = 'Verify your email address.';
        $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('register/verify/'.$token).">Simply click here to verify. </a>";
        $headers = "From: $setting->site_name <$setting->default_email> \r\n";
        $headers .= "Reply-To: $setting->site_name <$setting->default_email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to,$subject,$msg,$headers);
        event(new LogActivity($user->name, 'New user created', 'User',$user));

        $message = array("success" => "ok", "message" => "Place check your email for verification");
        return response()->json($message, 200);
    }
    public function car_detail(Request $request)
    {

        $data['brands'] = Brand::where('status', 1)->get();
        $data['cats'] = Category::where('status', 1)->get();
        $data['subcats'] = Subcategory::where('status', 1)->get();
        $data['conditions'] = Condtion::where('status', 1)->get();
        $data['btypes'] = BodyType::where('status', 1)->get();
        $data['ftypes'] = FuelType::where('status', 1)->get();
        $data['ttypes'] = TransmissionType::where('status', 1)->get();
        $data['boughtPlan'] = Plan::find(Auth::user()->current_plan);
        return $data;
    }

    public function featured()
    {

        $featured = Car::where('user_id', Auth::user()->id)->where('featured', 1)->orderBy('id', 'desc')->get();

        return $featured;
    }

    public function all_cars()
    {

        $cars = Car::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return $cars;
    }


    public function package()
    {

        $data['plans'] = Plan::where('status', 1)->orderBy('id', 'DESC')->get();

        $data['boughtPlan'] = '';

        if (!empty(Auth::user()->current_plan)) {
            $data['boughtPlan'] = Plan::find(Auth::user()->current_plan);
        }


        return $data;
    }


    public function add_car(Request $request)
    {

        if (Auth()->user()->ads == 0) {
            $msg = 'You have to buy a package to post ad.';
            return response()->json($msg);
        }

        $messages = [
            'label.*.required' => 'Specification label cannot be blank',
            'value.*.required' => 'Specification value cannot be blank',
            'brand_id.required' => 'Brand is required',
            'brand_model_id.required' => 'Model is required',
            'condtion_id.required' => 'Condtion is required',
        ];

        //--- Validation Section
        $rules = [
            'title' => 'required',
            'brand_id' => 'required',
            'top_speed' => 'required|numeric',
            'brand_model_id' => 'required',
            'currency_code' => 'required|max:20',
            'currency_symbol' => 'required',
            'regular_price' => 'required',
            'condtion_id' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
            'images' => 'required',
            'year' => 'required|integer',
            'mileage' => 'required|numeric',
            'label.*' => 'required',
            'value.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }


        $in = $request->all();
        $in['user_id'] = Auth::user()->id;
        if ($request->filled('featured_image')) {
            $image = $request->featured_image;
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $image = base64_decode($image);
            $image_name = uniqid() . '.jpg';

            $path = 'assets/front/images/cars/featured/' . $image_name;
            file_put_contents($path, $image);

            $in['featured_image'] = $image_name;
        }
        if ($request->filled('sale_price')) {
            $in['search_price'] = $request->sale_price;
        } else {
            $in['search_price'] = $request->regular_price;
        }
        $in['label'] = json_encode($request->label);
        $in['value'] = json_encode($request->value);
        $car = Car::create($in);

        if ($request->filled('images')) {
            $imgs = [];
            $imgs = $request->images;
            foreach ($imgs as $key => $img) {
                list($type, $img) = explode(';', $img);
                list(, $img)      = explode(',', $img);
                $img = base64_decode($img);
                $img_name = uniqid() . '.jpg';

                $path = 'assets/front/images/cars/sliders/' . $img_name;
                file_put_contents($path, $img);

                $carimg = new CarImage;
                $carimg->car_id = $car->id;
                $carimg->image = $img_name;
                $carimg->save();
            }
        }

        $user = Auth::user();
        $user->ads = $user->ads - 1;
        $user->save();

        $msg = 'Car Added Successfully.';
        return response()->json($msg);
    }


    public function change_car_status(Request $request)
    {

        $rules = [
            'car_id' => 'required',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }



        $gs = Generalsetting::first();

        $data = Car::findOrFail($request->car_id);
        $data->status = $request->status;
        $data->update();

        $headers = "From: $setting->from_name <$setting->from_email> \r\n";
        $headers .= "Reply-To: $setting->from_name <$setting->from_email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if ($request->status == 1) {
            $message = "Your ad is published.<br /><strong>Ad Title: </strong><a href='" . url("/details/$data->id") . "'>" . $data->title . "</a>";

            @mail($data->user->email, "Ad published", $message, $headers);
        } elseif ($request->status == 0) {
            $message = "Your ad is rejected.<br /><strong>Ad Title: </strong><a href='" . url("/details/$data->id") . "'>" . $data->title . "</a>";

            @mail($data->user->email, "Ad Rejected", $message, $headers);
        }


        return json_encode(array("success" => "ok", "message" => "Car Status Changed Successfully"));
    }

    public function blogcategory(Request $request)
    {
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $request->slug))->first();
        $blogs = $bcat->blogs()->orderBy('id', 'DESC')->get();
        $bcats = BlogCategory::all();
        if ($request->ajax()) {
            return view('front.pagination.blog', compact('blogs'));
        }
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));

        $data['blog_categories'] = $bcats;
        $data['blogs'] = $blogs;
        $data['current_blog_category'] = $bcat;

        $data['tags'] = $tags;

        return $data;
    }



    public function faq()
    {
        $faqs = Faq::all();
        return $faqs;
    }



    public function search_cars(Request $request)
    {

        $data['brands'] = Brand::where('status', 1)->get();
        $data['cats'] = Category::where('status', 1)->get();
        $data['conditions'] = Condtion::where('status', 1)->get();
        $data['btypes'] = BodyType::where('status', 1)->get();
        $data['ftypes'] = FuelType::where('status', 1)->get();
        $data['ttypes'] = TransmissionType::where('status', 1)->get();

        $data['minprice'] = Car::min('regular_price');
        $data['maxprice'] = Car::max('regular_price');

        $minprice = $request->minprice;
        $maxprice = $request->maxprice;
        $category = $request->category_id;
        $brands = $request->brand_id;
        $ftype = $request->fuel_type_id;
        $ttype = $request->transmission_type_id;
        $condition = $request->condition_id;
        $sort = !empty($request->sort) ? $request->sort : 'desc';
        $view = !empty($request->view) ? $request->view : 10;
        $type = !empty($request->type) ? $request->type : 'all';

        $data['cars'] = Car::with('category')->with('brand')->with('brand_model')->with('body_type')->with('fuel_type')->with('transmission_type')->with('condtion')->when($category, function ($query, $category) {
            return $query->where('category_id', $category);
        })
            ->when($minprice, function ($query, $minprice) {
                return $query->where('search_price', '>=', $minprice);
            })
            ->when($maxprice, function ($query, $maxprice) {
                return $query->where('search_price', '<=', $maxprice);
            })
            ->when($brands, function ($query, $brands) {
                return $query->whereIn('brand_id', $brands);
            })
            ->when($ftype, function ($query, $ftype) {
                return $query->where('fuel_type_id', $ftype);
            })
            ->when($ttype, function ($query, $ttype) {
                return $query->where('transmission_type_id', $ttype);
            })
            ->when($condition, function ($query, $condition) {
                return $query->where('condtion_id', $condition);
            })
            ->when($sort, function ($query, $sort) {
                if ($sort == 'desc') {
                    return $query->orderBy('id', 'DESC');
                } elseif ($sort == 'asc') {
                    return $query->orderBy('id', 'ASC');
                } elseif ($sort == 'price_desc') {
                    return $query->orderBy('search_price', 'DESC');
                } elseif ($sort == 'price_asc') {
                    return $query->orderBy('search_price', 'ASC');
                }
            })
            ->when($type, function ($query, $type) {
                if ($type == 'featured') {
                    return $query->where('featured', 1);
                }
            })
            ->where('status', 1)->where('admin_status', 1)->paginate($view);


        return $data;
    }

    public function edit_car(Request $request)
    {
        $data['brands'] = Brand::where('status', 1)->get();
        $data['cats'] = Category::where('status', 1)->get();
        $data['conditions'] = Condtion::where('status', 1)->get();
        $data['btypes'] = BodyType::where('status', 1)->get();
        $data['ftypes'] = FuelType::where('status', 1)->get();
        $data['ttypes'] = TransmissionType::where('status', 1)->get();
        $car = Car::findOrFail($request->car_id);
        $data['car']  = $car;
        $data['labels'] = json_decode($car->label, true);
        $data['values'] = json_decode($car->value, true);


        return $data;
    }

    public function update_car(Request $request)
    {
        $images = is_array($request->images) ? $request->images : [];
        $imagesdb = is_array($request->imagesdb) ? $request->imagesdb : [];

        $messages = [
            'label.*.required' => 'Specification label cannot be blank',
            'value.*.required' => 'Specification value cannot be blank',
            'brand_id.required' => 'Brand is required',
            'brand_model_id.required' => 'Model is required',
            'condtion_id.required' => 'Condtion is required',
        ];

        //--- Validation Section
        $rules = [
            'title' => 'required',
            'brand_id' => 'required',
            'brand_model_id' => 'required',
            'regular_price' => 'required',
            'condtion_id' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
            'images_helper' => [
                function ($attribute, $value, $fail) use ($images, $imagesdb) {
                    if (count($images) + count($imagesdb) == 0) {
                        $fail("Slider image is required");
                    }
                },
            ],
            'year' => 'required|integer',
            'mileage' => 'required|numeric',
            'label.*' => 'required',
            'value.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }


        $car = Car::find($request->car_id);
        $in = $request->all();
        if ($request->filled('featured_image')) {
            if ($request->featured_image != $car->featured_image) {
                $image = $request->featured_image;
                list($type, $image) = explode(';', $image);
                list(, $image)      = explode(',', $image);
                $image = base64_decode($image);
                $image_name = uniqid() . '.jpg';

                $path = 'assets/front/images/cars/featured/' . $image_name;
                file_put_contents($path, $image);
                @unlink('assets/front/images/cars/featured/' . $car->featured_image);

                $in['featured_image'] = $image_name;
            }
        }
        $in['label'] = json_encode($request->label);
        $in['value'] = json_encode($request->value);

        $car->fill($in)->save();

        // bring all the product images of that product
        $carimgs = CarImage::where('car_id', $car->id)->get();


        // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
        foreach ($carimgs as $carimg) {
            if (!in_array($carimg->image, $request->imagesdb)) {
                @unlink('assets/front/images/cars/sliders/' . $carimg->image);
                $carimg->delete();
            }
        }

        if ($request->filled('images')) {
            $imgs = [];
            $imgs = $request->images;
            foreach ($imgs as $key => $img) {
                list($type, $img) = explode(';', $img);
                list(, $img)      = explode(',', $img);
                $img = base64_decode($img);
                $img_name = uniqid() . '.jpg';

                $path = 'assets/front/images/cars/sliders/' . $img_name;
                file_put_contents($path, $img);

                $carimg = new CarImage;
                $carimg->car_id = $car->id;
                $carimg->image = $img_name;
                $carimg->save();
            }
        }
        $msg = ["success" => "ok", "messsage" => "Car Updated Successfully"];
        return response()->json($msg);
    }

    public function view_car(Request $request)
    {

        $car = Car::findOrFail($request->id);

        $data = null;

        if ($car->admin_status == 1 && $car->status == 1) {
            $car->views = $car->views + 1;
            $car->save();

            $data['car'] = $car;
        }

        return $data;
    }

    public function expert_review(Request $request)
    {
        $blogs = Blog::orderBy('id', 'DESC')->get();

        $bcats = BlogCategory::all();
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));


        $data['blogs'] = $blogs;
        $data['blog_category'] = $bcats;
        $data['tags'] = $tagz;


        return $data;
    }
    public function countries(Request $request)
    {

        $data['countries'] = Country::where('active', 1)->get();
        return $data;
    }
    public function states(Request $request, $id)
    {
        $country = Country::where('active', 1)->where('id', $id)->get()->first();
        $data['cities'] = City::where('active', 1)->where('country_code', $country->code)->get();
        $data['states'] = Subdivision1::where('active', 1)->where('country_code', $country->code)->get();
        return $data;
    }
    public function substates(Request $request, $id)
    {
        $state = Subdivision1::where('active', 1)->where('id', $id)->get()->first();
        $data['cities'] = City::where('active', 1)->where('subadmin1_code', $state->code)->where('country_code', $state->country_code)->get();
        $data['substates'] = Subdivision2::where('active', 1)->where('subadmin1_code', $state->code)->where('country_code', $state->country_code)->get();
        return $data;
    }
    public function cities(Request $request, $id)
    {
        $substate = Subdivision2::where('active', 1)->where('id', $id)->get()->first();
        $data['cities'] = City::where('active', 1)->where('subadmin2_code', $substate->code)->where('subadmin1_code', $substate->subadmin1_code)->where('country_code', $substate->country_code)->get();
        return $data;
    }
    public function getreviews($id)
    {
        $ratings = Rating::with('user')->where('car_id', $id)->get();
        return $ratings;
    }
    public function postreview(Request $request, $id)
    {
        $rules = [
            'rating' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $car = Car::findOrFail($id);
        $rating = new Rating();
        $rating->user_id = Auth::user()->id;
        $rating->rating = $request->input('rating');
        $rating->message = $request->input('message');
        $car->ratings()->save($rating);
        $ratings = Rating::with('user')->where('car_id', $id)->get();
        return $ratings;
    }
    public function get_cars_across_category()
    {
        $categories = Category::with(['cars' => function ($query) {
            $query->with('category')->with('brand')->with('brand_model')->with('body_type')->with('fuel_type')->with('transmission_type')->with('condtion')->get();
        }])->get();
        return $categories;
    }
    public function getsubcategories($id)
    {
        $subcategory = Subcategory::with('category')->where('cat_id', $id)->get();
        return $subcategory;
    }
    public function getallinpectors()
    {
        $getinspectors = User::where('type', 3)->get();
        return $getinspectors;
    }
    public function getsingleinpector($id)
    {
        $GetSingleInspector = User::where('type', 3)->where('id', $id)->get();
        return $GetSingleInspector;
    }
    public function sendmailtoinspector(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $ps = PS::first();
        $name = $request->name;
        $from = $request->email;
        $to = $request->inspector;
        $subject = $request->subject;
        $headers = "From: $name <$from> \r\n";
        $headers .= "Reply-To: $name <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = $request->message . '<br>Please Inspect this Car <br>Car Name: ' . $request->title . '<br>Car Brand: ' . $request->brand . '<br>Car Category: ' . $request->category . '<br>Car Model: ' . $request->model . '<br>Car Top Speed: ' . $request->top_speed;

        @mail($to, $subject, $message, $headers);
        return response()->json("Mail sent successfully to the Inspector..Please wait he inspector will contatct u !");
    }
    public function get()
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });


        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
            ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text
        ]);
        return response()->json($message);
    }
    public function logout()
    {
        Auth::logout();
        return true;
    }
}
