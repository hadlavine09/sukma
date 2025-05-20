<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-name">John Doe</p>
      <p class="app-sidebar__user-designation">Frontend Developer</p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item active" href="{{ asset('assets_backend/dashboard.html')}}"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
    <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-laptop"></i><span class="app-menu__label">User Management</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ asset('assets_backend/bootstrap-components.html')}}"><i class="icon bi bi-circle-fill"></i> User</a></li>
        <li><a class="treeview-item" href="https://icons.getbootstrap.com/" target="_blank" rel="noopener"><i class="icon bi bi-circle-fill"></i> Role</a></li>
        <li><a class="treeview-item" href="{{ route('permission.index')}}"><i class="icon bi bi-circle-fill"></i> Permissions</a></li>
        <li><a class="treeview-item" href="{{ route('hakakses.index')}}"><i class="icon bi bi-circle-fill"></i> Hakakses</a></li>
      </ul>
    </li>
    <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Manajemen Produk</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ route('tag.index')}}"><i class="icon bi bi-circle-fill"></i> Tag</a></li>
        <li><a class="treeview-item" href="{{ route('kategori.index')}}"><i class="icon bi bi-circle-fill"></i> Kategori</a></li>
        <li><a class="treeview-item" href="{{ route('produk.index')}}"><i class="icon bi bi-circle-fill"></i> Produk</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/form-samples.html')}}"><i class="icon bi bi-circle-fill"></i> Supplier</a></li>
      </ul>
    </li>
    <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-table"></i><span class="app-menu__label">Tables</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ asset('assets_backend/table-basic.html')}}"><i class="icon bi bi-circle-fill"></i> Basic Tables</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/table-data-table.html')}}"><i class="icon bi bi-circle-fill"></i> Data Tables</a></li>
      </ul>
    </li>
    <li class="treeview"><a class="app-menu__item" href="{{ asset('assets_backend/#')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-file-earmark"></i><span class="app-menu__label">Pages</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ asset('assets_backend/blank-page.html')}}"><i class="icon bi bi-circle-fill"></i> Blank Page</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/page-login.html')}}"><i class="icon bi bi-circle-fill"></i> Login Page</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/page-lockscreen.html')}}"><i class="icon bi bi-circle-fill"></i> Lockscreen Page</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/page-user.html')}}"><i class="icon bi bi-circle-fill"></i> User Page</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/page-invoice.html')}}"><i class="icon bi bi-circle-fill"></i> Invoice Page</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/page-mailbox.html')}}"><i class="icon bi bi-circle-fill"></i> Mailbox</a></li>
        <li><a class="treeview-item" href="{{ asset('assets_backend/page-error.html')}}"><i class="icon bi bi-circle-fill"></i> Error Page</a></li>
      </ul>
    </li>
    <li><a class="app-menu__item" href="{{ asset('assets_backend/docs.html')}}"><i class="app-menu__icon bi bi-code-square"></i><span class="app-menu__label">Docs</span></a></li>
  </ul>
</aside>
