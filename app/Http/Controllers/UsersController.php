<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class UsersController extends Controller

{
    // Hiển thị danh sách người dùng
    // Hiển thị danh sách người dùng với phân trang
    // Hiển thị danh sách người dùng với phân trang và sắp xếp
    public function index()
    {
        $users = User::orderBy('username')->paginate(5); // Sắp xếp theo username và phân trang 5 người dùng mỗi trang
        return view('admin.user', ['users' => $users]); // Trả về view với dữ liệu người dùng
    }


    // Hiển thị form thêm người dùng mới
    public function userAdd()
    {
        return view('admin.user.user_add'); // Trả về view form thêm người dùng
    }

    // Xử lý khi thêm người dùng mới
    public function storeUser(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|regex:/^[a-zA-Z0-9]*$/|min:6|max:25|not_regex:/\s/',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'phone_number' => 'required|string|min:10|max:15|regex:/^\d+$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản',
            'username.regex' => 'Tên tài khoản không chứa kí tự đặc biệt',
            'username.min' => 'Tên đăng nhập phải có từ 6 đến 25 ký tự.',
            'username.max' => 'Tên đăng nhập phải có từ 6 đến 25 ký tự.',
            'username.not_regex' => 'Tên đăng nhập không được chứa khoảng trắng.',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.unique' => 'Địa chỉ email này đã tồn tại. Vui lòng sử dụng địa chỉ khác.',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự, bao gồm cả chữ và số',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt (ví dụ: @, #, $, %, etc.)',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại di động gồm 10 chữ số hoặc số điện thoại cố định theo định dạng đúng. Đảm bảo rằng số điện thoại bao gồm mã mạng và không chứa ký tự đặc biệt'
        ]);

        // Kiểm tra xem có lỗi xác thực không
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Xử lý ảnh đại diện (avatar)
        if ($request->hasFile('avatar')) {
            // Tạo tên ảnh duy nhất
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            // Di chuyển ảnh đến thư mục 'public/images'
            $request->file('avatar')->move(public_path('images'), $avatarName);
        } else {
            $avatarName = 'default-avatar.png';
        }

        // Lưu người dùng mới vào CSDL
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->role_id = 2;
        $user->status = true;
        $user->avatar = $avatarName;
        $user->save();

        return redirect()->route('admin.viewuser')->with('success', 'User added successfully!');
    }


    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm người dùng theo username hoặc email và phân trang
        $users = User::where('username', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->paginate(5); // Phân trang 5 người dùng mỗi trang

        return view('admin.user', ['users' => $users]); // Trả về view với dữ liệu tìm kiếm
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user')); // Trả về view chi tiết người dùng
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user')); // Trả về view chỉnh sửa người dùng
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.viewuser')->with('success', 'User deleted successfully!'); // Chuyển hướng về danh sách sau khi xóa
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Xác thực dữ liệu nhập vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|regex:/^[a-zA-Z0-9]*$/|min:6|max:25|not_regex:/\s/',
            'email' => 'required|string|email|max:255|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'phone_number' => 'required|string|min:10|max:15|regex:/^\d+$/',
            'role_id' => 'required|integer',
            'status' => 'required|boolean',
            'avatar' => 'nullable|image|max:20480',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'not_regex:/^[^\w]*$/'
            ]
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản',
            'username.regex' => 'Tên tài khoản không chứa kí tự đặc biệt',
            'username.min' => 'Tên đăng nhập phải có từ 6 đến 25 ký tự.',
            'username.max' => 'Tên đăng nhập phải có từ 6 đến 25 ký tự.',
            'username.not_regex' => 'Tên đăng nhập không được chứa khoảng trắng.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự, bao gồm cả chữ và số.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ cái, một số, và một ký tự đặc biệt.',
            'password.not_regex' => 'Mật khẩu không được chỉ bao gồm ký tự đặc biệt, phải có cả chữ cái và số.',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.unique' => 'Địa chỉ email này đã tồn tại. Vui lòng sử dụng địa chỉ khác.'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cập nhật thông tin người dùng
        $user->username = $request->username;
        $user->email = $request->email; // Vẫn giữ dòng này để cập nhật email
        $user->phone_number = $request->phone_number;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        // Kiểm tra nếu có mật khẩu mới được nhập
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Xử lý ảnh đại diện
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar && file_exists(public_path('images/' . $user->avatar))) {
                unlink(public_path('images/' . $user->avatar));
            }

            // Lưu trữ ảnh mới
            $avatarFile = $request->file('avatar');
            $avatarName = time() . '_' . $avatarFile->getClientOriginalName();
            $avatarFile->move(public_path('images'), $avatarName);
            $user->avatar = $avatarName;
        }

        $user->save();

        return redirect()->route('admin.viewuser')->with('success', 'User updated successfully!');
    }
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'username' => 'required|string|max:25',
            'email' => 'required|string|email|max:255|min:5|regex:/^[^@.]+@[A-Za-z0-9-]+\.[A-Za-z0-9-]+$/',
            'phone_number' => 'required|string|regex:/^0[0-9]{9}$/',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.max' => 'Tên đăng nhập không được vượt quá 25 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được dài quá 255 ký tự.',
            'email.min' => 'Địa chỉ email phải từ 5 ký tự trở lên.',
            'email.regex' => 'Địa chỉ email không đúng định dạng.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại hợp lệ là ký tự số bắt đầu bằng 0 và có 10 chữ số.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Vui lòng xác nhận lại mật khẩu.',
        ]);
       
        // Đăng ký người dùng mới
        $user = User::register($request->all());
        $user->save();
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập.');
    }
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Thử đăng nhập bằng username hoặc email
        try {
            $user = User::login($credentials); // Gọi hàm login từ model
            Auth::login($user); // Đăng nhập người dùng
    
            // Kiểm tra vai trò và điều hướng đến trang tương ứng
            switch ($user->role_id) {
                case 1: // Giả sử role_id 1 là admin
                    return redirect()->route('admin'); // Chuyển hướng đến trang dashboard
                case 2: // Giả sử role_id 2 là user
                    return redirect()->route('home'); // Chuyển hướng đến trang welcome
                default: // Các quyền khác
                    return redirect()->route('error'); // Chuyển hướng đến trang lỗi
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput(); // Trả về lỗi nếu có
        }
    }

}
