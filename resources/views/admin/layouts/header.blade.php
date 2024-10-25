<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Menu -->

    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href=""
          style="color: #3B79C9; font-weight: bold; text-transform: uppercase; display: flex; align-items: center;"
          class="app-brand-link">
          <img src="{{ asset('/images/logo-staynest.jpg')}}" alt="Logo" style="width: 50px; height: fit-content; ">
          <span style="margin-left: 10px; margin-top: 15px;">StayNest</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item">
          <a href="{{route('admin.index')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Trang Chủ</div>
          </a>
        </li>

        <!-- Layouts -->
        <!-- Forms & Tables -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Quản Trị StayNest</span></li>
        <!-- Forms -->

        </li>
        <!-- Tables -->
        <li class="menu-item">
          <a href="{{route('admin.viewuser')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Tables">User</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="" class="menu-link">
            <i class="menu-icon tf-icons bx bx-hotel"></i>
            <div data-i18n="Tables">Hotel</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.viewpost')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-news"></i>
            <div data-i18n="Tables">Post</div>
          </a>
        </li>
        <li class="menu-item has-dropdown">
          <a href="#" class="menu-link" data-bs-toggle="collapse" data-bs-target="#room-dropdown" aria-expanded="false">
            <i class="menu-icon tf-icons bx bx-home"></i>
            <div data-i18n="Tables">Room</div>
            <i class="bx bx-chevron-down arrow-icon"></i>
          </a>
          <ul class="collapse" id="room-dropdown">
            <li class="menu-item">
              <a href="{{route('admin.viewroom')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Room List">Danh sách phòng</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="Room Type">Loại phòng</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bulb"></i> 
                <div data-i18n="Room Amenities">Tiện Nghi Phòng</div>
              </a>
            </li>
          </ul>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.viewvoucher')}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-gift"></i>
            <div data-i18n="Tables">Voucher</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="" class="menu-link">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Tables">Quản lý đặt phòng</div>
          </a>
        </li>

        <!-- Misc -->

      </ul>
    </aside>
    <!-- / Menu -->

    <!-- Layout container -->   
    <div class="layout-page">
      <!-- Navbar -->