<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use App\Helpers\IdEncoder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class UsersController extends Controller
{
    public function viewUser()
    {
        $users = User::getAllUsers();
        return view('admin.user', compact('users'));
    }

    public function userAdd()
    {
        // Lấy tất cả vai trò từ bảng roles
        $roles = Roles::all();
        // Lấy thông tin người dùng hiện tại (nếu cần)
        $user = auth()->user(); // Lấy người dùng đã xác thực
            
        return view('admin.user_add', compact('roles', 'user')); // Truyền cả $roles và $user vào view
    }


    public function getUserDetail($user_id)
    {
        // Giải mã ID nếu cần
        $decodedId = IdEncoder::decodeId($user_id);
        $user = User::findUserById($decodedId);

        if (!$user) {
            return response()->json(['error' => 'Người dùng không tồn tại'], 404);
        }

        return response()->json([
            'username' => $user->username,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'role_id' => $user->role->role_name ?? 'N/A',
            'status' => $user->status,
            'avatar' => $user->avatar
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&#]/',
            'phone_number' => 'required|regex:/^0[0-9]{9}$/|size:10',
            'role_id' => 'required|integer',
            'status' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Kích thước tối đa 2MB
        ], [
            'username.required' => 'Vui lòng nhập tên người dùng',
            'username.min' => 'Tên người dùng phải có ít nhất 3 ký tự',
            'username.max' => 'Tên người dùng không được quá 50 ký tự',
            'username.unique' => 'Tên người dùng đã tồn tại',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất một chữ cái, một số và một ký tự đặc biệt.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại không hợp lệ',
            'phone_number.size' => 'Số điện thoại phải có 10 ký tự.',
            'role_id.required' => 'Vui lòng chọn vai trò',
            'status.required' => 'Trạng thái là bắt buộc',
            'avatar.image' => 'Ảnh phải là định dạng JPEG, PNG, hoặc JPG.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);        

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->phone_number = $request->phone_number;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        // Xử lý upload ảnh
        if ($request->hasFile('avatar')) {
            // Lưu ảnh vào thư mục public/storage/images
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images'), $avatarName);
            $user->avatar = $avatarName; // Lưu tên ảnh vào cơ sở dữ liệu
        } else {
            $user->avatar = 'default-avatar.png';
        }

        $user->save();

        return redirect()->route('admin.viewuser')->with('success', 'Thêm người dùng thành công.');
    }

    public function deleteUser($user_id)
    {
        // Giải mã ID trước khi thao tác
        $decodedId = IdEncoder::decodeId($user_id);
        $user = User::find($decodedId);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Người dùng đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Người dùng không tồn tại.'], 404);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('search');
        if (empty($keyword)) {
            // Nếu từ khóa tìm kiếm trống, hiển thị tất cả kết quả
            $results = User::getAllUsers();
        } else {
            // Nếu có từ khóa, tìm kiếm theo từ khóa
            $results = User::whereRaw('MATCH(username, email) AGAINST(? IN BOOLEAN MODE)', [$keyword])
                ->paginate(5);
        }
        return view('admin.search_results_user', compact('results'));
    }
    public function editUser($user_id)
    {
        // Giải mã ID
        $decodedId = IdEncoder::decodeId($user_id);
        $user = User::findUserById($decodedId);

        if (!$user) {
            return redirect()->route('admin.viewuser')->with('error', 'Người dùng không tồn tại.');
        }

        // Lấy tất cả vai trò từ bảng roles
        $roles = Roles::all();

        return view('admin.user_edit', compact('user', 'roles'));
    }

    public function update(Request $request, $user_id)
    {
        $request->validate([
            'username' => 'required|min:3|max:50|:users,username,' . $user_id . ',user_id',
            'email' => 'required|email|:users,email,' . $user_id . ',user_id',
            'password' => 'nullable|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&#]/',
            'phone_number' => 'required|regex:/^0[0-9]{9}$/|size:10',
            'role_id' => 'required|integer',
            'status' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Kích thước tối đa 2MB
        ], [
            'username.required' => 'Vui lòng nhập tên người dùng',
            'username.min' => 'Tên người dùng phải có ít nhất 3 ký tự',
            'username.max' => 'Tên người dùng không được quá 50 ký tự',
            'username.unique' => 'Tên người dùng đã tồn tại',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất một chữ cái, một số và một ký tự đặc biệt.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại không hợp lệ',
            'phone_number.size' => 'Số điện thoại phải có 10 ký tự.',
            'role_id.required' => 'Vui lòng chọn vai trò',
            'status.required' => 'Trạng thái là bắt buộc',
            'avatar.image' => 'Ảnh phải là định dạng JPEG, PNG, hoặc JPG.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);
        

        $user = User::find($user_id);
        if (!$user) {
            return redirect()->route('admin.viewuser')->with('error', 'Người dùng không tồn tại.');
        }

        // Cập nhật các trường khác
        $user->username = $request->username;
        $user->email = $request->email;

        // Chỉ cập nhật mật khẩu nếu có giá trị
        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->phone_number = $request->phone_number;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            // Lưu ảnh vào thư mục public/images
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images'), $avatarName);
            $user->avatar = $avatarName; // Cập nhật tên ảnh vào trường avatar
        }

        $user->save();

        return redirect()->route('admin.viewuser')->with('success', 'Cập nhật người dùng thành công.');
    }


    public function encodeId($id)
    {
        $encodedId = IdEncoder::encodeId($id);
        return response()->json(['encoded_id' => $encodedId]);
    }

    public function decodeId($encodedId)
    {
        $decodedId = IdEncoder::decodeId($encodedId);
        return response()->json(['decoded_id' => $decodedId]);
    }
}
