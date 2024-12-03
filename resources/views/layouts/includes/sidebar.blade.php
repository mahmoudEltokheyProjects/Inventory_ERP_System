  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- ++++++++++++++++++++++++++ Sidebar Avatar Photo ++++++++++++++++++++++++++ -->
        <div class="user-panel mt-3 pb-3 d-flex">
            @php
                $photo = App\Models\Admin\AdminPanelSetting::where('com_code',auth()->user()->com_code)->value('photo');
            @endphp
            {{-- +++++++++++++ Avatar photo +++++++++++++ --}}
            <div class="image">
                @if (!empty($photo) && file_exists(public_path('assets/admin/uploads/'.$photo)))
                    <img src="{{ asset('assets/admin/uploads/'.$photo) }}" style="width:40px !important;height:40px !important;border:3px solid #fff; !important;" class="bg-white rounded-circle" alt="avatar photo">
                @else
                    <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User photo">
                @endif
            </div>
            <div class="info mt-1">
                <a href="{{ route('admin.dashboard') }}" class="d-block" style="font-size: 18px;">
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>
        <!-- ++++++++++++++++++++++++++ Sidebar System Name ++++++++++++++++++++++++++ -->
        <div class="user-panel mt-1 mb-1 d-flex">
            <div class="info">
                @php
                    $systemName = App\Models\Admin\AdminPanelSetting::where('com_code',auth()->user()->com_code)->value('system_name');
                @endphp
                <h4 style="color:#fff;">{{ $systemName }}</h4>
            </div>
        </div>

        <!-- ++++++++++++++++++++++++++ Sidebar Menu  ++++++++++++++++++++ -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- ================ General Setting : الضبط العام ================ --}}
                {{-- لو فاتح اي لينك من لينكات الضبط العام فهيفتح لي قائمة الضبط العام --}}
                {{-- لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تتفتح  --}}
                <li class="nav-item has-treeview {{ request()->is('admin/admin-panel-setting*') || request()->is('admin/treasuries*')  ? 'menu-open' : '' }}">
                    {{--  يعني لون الخلفية ازرق active لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تكون  --}}
                    <a href="#" class="nav-link {{ request()->is('admin/admin-panel-setting*') || request()->is('admin/treasuries*')  ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        الضبط العام
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++ Admin Panel Settings ++++++++++++  --}}
                        <li class="nav-item">
                            {{-- admin/admin-panel-setting* : فقط وفيه اي حاجة جايه بعده سواء / او مفيش admin/admin-panel-setting معني ال * انه لما يجد اللينك --}}
                            <a href="{{ route('admin.adminPanelSetting.index') }}" class="nav-link {{ request()->is('admin/admin-panel-setting*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;الاعدادات
                            </a>
                        </li>
                        {{-- ++++++++++++ Treasuries ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.treasury.index') }}" class="nav-link {{ request()->is('admin/treasuries*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;الخزن
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ================ Stores Setting : ضبط المخازن ================ -->
                {{-- لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تتفتح  --}}
                <li class="nav-item has-treeview {{ request()->is('admin/stores*') || request()->is('admin/sales_material_types*') || request()->is('admin/uoms*') || request()->is('admin/inv_item_card_categories*') || request()->is('admin/inv_item_cards*')   ? 'menu-open' : '' }}">
                    {{--  يعني لون الخلفية ازرق active لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تكون  --}}
                    <a href="#" class="nav-link {{ request()->is('admin/stores*') || request()->is('admin/sales_material_types*') || request()->is('admin/uoms*') || request()->is('admin/inv_item_card_categories*') || request()->is('admin/inv_item_cards*')  ? 'active' : '' }}">
                    <i class="nav-icon fa fa-cog"></i>
                    <p>
                        ضبط المخازن
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++ Stores ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.stores.index') }}" class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-store"></i> &nbsp;المخازن
                            </a>
                        </li>
                        {{-- ++++++++++++ Sales Material Types ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.sales_material_types.index') }}" class="nav-link {{ request()->is('admin/sales_material_types*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-file-invoice"></i> &nbsp;فئات الفواتير
                            </a>
                        </li>
                        {{-- ++++++++++++ uoms [ unit of measurments ] ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.uoms.index') }}" class="nav-link {{ request()->is('admin/uoms/*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-scale-unbalanced-flip"></i> &nbsp;الوحدات
                            </a>
                        </li>
                        {{-- ++++++++++++ inv_item_card_category ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('inv_item_card_categories.index') }}" class="nav-link {{ request()->is('admin/inv_item_card_categories*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-boxes-stacked"></i> &nbsp;فئات الاصناف
                            </a>
                        </li>
                        {{-- ++++++++++++ inv_item_card ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="{{ route('inv_item_cards.index') }}" class="nav-link {{ request()->is('admin/inv_item_cards*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-table-list"></i> &nbsp; الاصناف
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ accounting : الحسابات ================ --}}
                {{-- لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تتفتح  --}}
                <li class="nav-item has-treeview {{ request()->is('admin/accountTypes*') || request()->is('admin/accounts*') || request()->is('admin/customers*') || request()->is('admin/suppliers_categories*') || request()->is('admin/suppliers*') && !request()->is('admin/suppliers_orders*')  ? 'menu-open' : '' }}">
                    {{--  يعني لون الخلفية ازرق active لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تكون  --}}
                    <a href="#" class="nav-link {{ request()->is('admin/accountTypes*') || request()->is('admin/accounts*') || request()->is('admin/customers*') || request()->is('admin/suppliers_categories*') || request()->is('admin/suppliers*') && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="fa-solid fa-vault"></i>
                        <p>
                            الحسابات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++ انواع الحسابات المالية ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.accountTypes.index') }}" class="nav-link {{ request()->is('admin/accountTypes*')  ? 'active' : '' }}">
                                <i class="nav-icon fa fa-hand-holding-usd"></i> &nbsp;انواع الحسابات المالية
                            </a>
                        </li>
                        {{-- ++++++++++++ كل الحسابات المالية ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.accounts.index') }}" class="nav-link {{ request()->is('admin/accounts*')  ? 'active' : '' }}">
                                <i class="nav-icon fa fa-money-bill-wave"></i> &nbsp; كل الحسابات المالية
                            </a>
                        </li>
                        {{-- ++++++++++++ حسابات العملاء ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('customers.index') }}" class="nav-link {{ request()->is('admin/customers*')  ? 'active' : '' }}">
                                <i class="nav-icon fa fa-users"></i> &nbsp; حسابات العملاء
                            </a>
                        </li>
                        {{-- ++++++++++++ حسابات فئات الموردين ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.suppliers_categories.index') }}" class="nav-link {{ request()->is('admin/suppliers_categories*')  ? 'active' : '' }}">
                                <i class="fa fa-truck-ramp-box"></i> &nbsp;حسابات فئات الموردين
                            </a>
                        </li>
                        {{-- ++++++++++++ حسابات الموردين ++++++++++++  --}}
                        <li class="nav-item">
                            {{--  يعني لون الخلفية ابيض active لما اضغط علي اللينك هخلي لون اللينك يكون  --}}
                            <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->is('admin/suppliers*') && !request()->is('admin/suppliers_categories*') && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-truck-field"></i> &nbsp; حسابات الموردين
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ Store movements : حركات مخزنية ================ --}}
                {{-- لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تتفتح  --}}
                <li class="nav-item has-treeview {{ request()->is('admin/suppliers_orders*') && !request()->is('admin/accountTypes*') ? 'menu-open' : '' }}">
                    {{--  يعني لون الخلفية ازرق active لما اضغط علي اي لينك بداخل القائمة هخلي القائمة تكون  --}}
                    <a href="#" class="nav-link {{ request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-arrow-right-arrow-left"></i>
                        <p>
                            حركات مخزنية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++ فواتير المشتريات ++++++++++++ --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.suppliers_orders.index') }}" class="nav-link {{ request()->is('admin/suppliers_orders*') && !request()->is('admin/accountTypes*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-file-invoice"></i> &nbsp; فواتير المشتريات
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++ --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ sales : المبيعات ================ --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-bullhorn"></i>
                    <p>
                        المبيعات
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ internal and external services : خدمات داخلية و خارجية ================ --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa  fa-hand-holding-hand"></i>
                    <p>
                        خدمات داخلية و خارجية
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ Treasury shift movement : حركة شيفت الخزينة ================ --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-money-bill-transfer"></i>
                        <p>
                            حركة شيفت الخزينة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ permissions : الصلاحيات ================ --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-user-lock"></i>
                    <p>
                        الصلاحيات
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ reports : التقارير ================ --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-scroll"></i>
                    <p>
                        التقارير
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ================ Monitoring and technical support : المراقبة والدعم الفني ================ --}}
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa  fa-headset"></i>
                    <p>
                        المراقبة والدعم الفني
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i> &nbsp;
                            </a>
                        </li>
                        {{-- ++++++++++++  ++++++++++++  --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-vault"></i> &nbsp;
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
