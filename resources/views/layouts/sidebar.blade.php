<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">@lang('sidebar.navigation')</li>

                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fe-airplay"></i>
                        <span> @lang('sidebar.dashboard') </span>
                    </a>

                </li>
                @can('policy','guard_catalog_view_self|guard_catalog_view|guard_company_view|guard_company_view_self|guard_lots_view|guard_lots_view_self|guard_purchase_view|guard_purchase_view_self|guard_discount')
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fe-pocket"></i>
                            <span> @lang('sidebar.catalogsAction') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            @can('policy','guard_catalog_view_self|guard_catalog_view')
                                <li>
                                    <a href="{{route('catalog.index')}}">@lang('sidebar.catalog')</a>
                                </li>
                            @endcan
                            @can('policy','guard_company_view|guard_company_view_self')
                                <li>
                                    <a href="{{route('company.index')}}">@lang('sidebar.companyFixPrice')</a>
                                </li>
                            @endcan
                            @can('policy','guard_lots_view|guard_lots_view_self')
                                <li>
                                    <a href="{{route('lots.index')}}">@lang('sidebar.fixPrice')</a>
                                </li>
                            @endcan
                            @can('policy','guard_purchase_view|guard_purchase_view_self')
                                <li>
                                    <a href="{{route('purchase.index')}}">@lang('sidebar.purchase')</a>
                                </li>
                            @endcan
                            @can('policy','guard_discount')
                                <li>
                                    <a href="{{route('discount.form')}}">@lang('sidebar.manageDiscount')</a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

<!--                <li>
                    <a href="#">
                        <i class=" fab fa-wpforms"></i>
                        <span> @lang('sidebar.contacts') </span>
                    </a>

                </li>-->
                @can('policy','guard_issuance_of_finance_view')
                    <li>
                        <a href="{{route('issuanceOfFinance.index')}}">
                            <i class="fas fa-money-bill-wave"></i>
                            <span> @lang('sidebar.salary') </span>
                        </a>
                    </li>
                @endcan
<!--                <li>
                    <a href="#">
                        <i class="fas fa-balance-scale"></i>
                        <span> @lang('sidebar.lots.metal') </span>
                    </a>

                </li>-->
                @can('policy','guard_tasks_view|guard_tasks_view_self|guard_task_priorities_view|guard_task_statuses_view')
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fas fa-tasks"></i>
                            <span> @lang('sidebar.tasks') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            @can('policy','guard_tasks_view|guard_tasks_view_self')
                                <li>
                                    <a href="{{route('tasks.index')}}">@lang('sidebar.tasks')</a>
                                </li>
                            @endcan
                            @can('policy','guard_task_statuses_view')
                                <li>
                                    <a href="{{route('taskStatus.index')}}">@lang('sidebar.taskStatus')</a>
                                </li>
                            @endcan
                            @can('policy','guard_task_priorities_view')
                                <li>
                                    <a href="{{route('taskPriority.index')}}">@lang('sidebar.taskPriority')</a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

<!--                <li>
                    <a href="#">
                        <i class="fas fa-mail-bulk"></i>
                        <span> @lang('sidebar.emails') </span>
                    </a>

                </li>-->
<!--                <li>
                    <a href="#">
                        <i class=" far fa-newspaper"></i>
                        <span> @lang('sidebar.documents') </span>
                    </a>

                </li>-->

<!--                <li>
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i>
                        <span> @lang('sidebar.calendars') </span>
                    </a>

                </li>-->
                @can('policy','guard_clients_view|guard_clients_view_self')
                    <li>
                        <a href="{{route('client.index')}}">
                            <i class="fas fa-users"></i>
                            <span> @lang('sidebar.clients') </span>
                        </a>

                    </li>
                @endcan

<!--                <li>
                    <a href="#">
                        <i class=" fas fa-business-time"></i>
                        <span> @lang('sidebar.logistic') </span>
                    </a>

                </li>-->
                @can('policy','guard_stock_view|guard_stock_view_self')
                    <li>
                        <a href="{{route('stock.index')}}">
                            <i class="fas fa-warehouse"></i>
                            <span> @lang('sidebar.warehouse') </span>
                        </a>

                    </li>
                @endcan
<!--                <li>
                    <a href="#">
                        <i class=" fab fa-meetup"></i>
                        <span> @lang('sidebar.meetings') </span>
                    </a>

                </li>-->

<!--                <li>
                    <a href="#">
                        <i class="fas fa-phone-volume"></i>
                        <span> @lang('sidebar.calls') </span>
                    </a>

                </li>-->
                @can('policy','guard_users_view|guard_users_view_self')
                    <li>
                        <a href="{{route('users.index')}}">
                            <i class="fas fa-users"></i>
                            <span> @lang('sidebar.users') </span>
                        </a>
                    </li>
                @endcan

                <li>
                    <a href="javascript: void(0);">
                        <i class=" fas fa-receipt"></i>
                        <span> @lang('sidebar.reports') </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
<!--                        <li>
                            <a href="#">@lang('sidebar.reports')</a>
                        </li>-->
                        @can('policy','guard_purchaseReports_view|guard_purchaseReports_view_self')
                            <li>
                                <a href="{{route('purchaseReports.index')}}">@lang('sidebar.reports.purchase')</a>
                            </li>
                        @endcan
<!--                        <li>
                            <a href="#">@lang('sidebar.reports.routes')</a>
                        </li>-->

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);">
                        <i class=" fas fa-receipt"></i>
                        <span> @lang('sidebar.administrating') </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                    <!--                        <li>
<a href="{{route('space.index')}}">@lang('sidebar.spaces')</a>
</li>-->
                        @can('policy','guard_industry_view')
                            <li>
                                <a href="{{route('industry.index')}}">@lang('sidebar.industry')</a>
                            </li>
                        @endcan
                        @can('policy','guard_brand_view')
                            <li>
                                <a href="{{route('brand.index')}}">@lang('sidebar.brand')</a>
                            </li>
                        @endcan
                        @can('policy','guard_team_view')
                            <li>
                                <a href="{{route('team.index')}}">@lang('sidebar.team')</a>
                            </li>
                        @endcan
                        @can('policy','guard_purchase_statuses_view')
                            <li>
                                <a href="{{route('purchaseStatus.index')}}">@lang('sidebar.purchaseStatus')</a>
                            </li>
                        @endcan
                        @can('policy','guard_purchase_payment_type_view')
                            <li>
                                <a href="{{route('purchasePaymentType.index')}}">@lang('sidebar.purchasePaymentType')</a>
                            </li>
                        @endcan
                        @can('policy','guard_client_type_view')
                            <li>
                                <a href="{{route('clientType.index')}}">@lang('sidebar.clientType')</a>
                            </li>
                        @endcan
                        @can('policy','guard_client_group_type_view')
                            <li>
                                <a href="{{route('clientGroupType.index')}}">@lang('sidebar.clientGroupType')</a>
                            </li>
                        @endcan
                        @can('policy','guard_waste_types_view')
                            <li>
                                <a href="{{route('wasteTypes.index')}}">@lang('sidebar.wasteTypes')</a>
                            </li>
                        @endcan
                        @can('policy','guard_permissions_view')
                            <li>
                                <a href="{{route('permissions.index')}}">@lang('sidebar.permissions')</a>
                            </li>
                        @endcan
                        @can('policy','guard_roles_view')
                            <li>
                                <a href="{{route('roles.index')}}">@lang('sidebar.roles')</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
