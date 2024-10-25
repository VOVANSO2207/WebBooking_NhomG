<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;

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

        return view('admin.user_add', compact('roles'));
    }


    public function getUserDetail($user_id)
    {
        $user = User::findUserById($user_id);

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
            'password' => 'required|min:8',
            'phone_number' => 'required|regex:/^0[0-9]{9}$/',
            'role_id' => 'required|integer',
            'status' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:20480', // Kích thước tối đa 20MB
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
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại không hợp lệ',
            'role_id.required' => 'Vui lòng chọn vai trò',
            'status.required' => 'Trạng thái là bắt buộc',
            'avatar.image' => 'Ảnh phải là định dạng JPEG, PNG, hoặc JPG.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 20MB.',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phone_number;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        // Xử lý upload ảnh
        if ($request->hasFile('avatar')) {
            // Lưu ảnh vào thư mục public/images
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
        $user = User::find($user_id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Người dùng đã được xóa.']);
        }

        return response()->json(['success' => false, 'message' => 'Người dùng không tồn tại.'], 404);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('search');
        $results = User::where('username', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->paginate(5);

        return view('admin.search_results_user', compact('results'));
    }


    public function editUser($user_id)
    {
        $user = User::findUserById($user_id);

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
            'username' => 'required|min:3|max:50|unique:users,username,' . $user_id . ',user_id',
            'email' => 'required|email|unique:users,email,' . $user_id . ',user_id',
            'password' => 'nullable|min:8|confirmed',
            'phone_number' => 'required|regex:/^0[0-9]{9}$/',
            'role_id' => 'required|integer',
            'status' => 'required|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:20480', // Kích thước tối đa 20MB
        ], [
            'username.required' => 'Vui lòng nhập tên người dùng',
            'username.min' => 'Tên người dùng phải có ít nhất 3 ký tự',
            'username.max' => 'Tên người dùng không được quá 50 ký tự',
            'username.unique' => 'Tên người dùng đã tồn tại',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu không khớp',
            'phone_number.required' => 'Vui lòng nhập số điện thoại',
            'phone_number.regex' => 'Số điện thoại không hợp lệ',
            'role_id.required' => 'Vui lòng chọn vai trò',
            'status.required' => 'Trạng thái là bắt buộc',
            'avatar.image' => 'Ảnh phải là định dạng JPEG, PNG, hoặc JPG.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 20MB.',
        ]);

        $user = User::find($user_id);
        if (!$user) {
            return redirect()->route('admin.viewuser')->with('error', 'Người dùng không tồn tại.');
        }

        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
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

}
