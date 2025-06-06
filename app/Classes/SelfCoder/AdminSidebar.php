<?php

namespace App\Classes\SelfCoder;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;

class AdminSidebar
{
    /**
     * Aside menu
     * @param $item
     * @param null $parent
     * @param int $rec
     * @param bool $singleItem
     *
     * @return string
     */

     static $ignore_permission=['dashboard','profile','logout'];


    /**
     * Header menu
     * @param $item
     * @param null $parent
     * @param int  $rec
     */
    public static function renderHorMenu($item, $parent = null, $rec = 0)
    {
        self::checkRecursion($rec);
        if (!$item) {
            return "menu misconfiguration";
        }

        // render separator
        if (isset($item["separator"])) {
            echo '<li class="menu-separator"><span></span></li>';
        } elseif (isset($item["title"]) || isset($item["code"])) {
            $item_class = "";
            $item_attr = "";

            if (
                isset($item["submenu"]) &&
                self::isActiveHorMenuItem($item, request()->path())
            ) {
                $item_class .= " menu-item-open menu-item-here"; // m-menu__item--active

                if (
                    isset($item["submenu"]["type"]) &&
                    $item["submenu"]["type"] == "tabs"
                ) {
                    $item_class .= " menu-item-active-tab ";
                }
            } elseif (self::isActiveHorMenuItem($item, request()->path())) {
                $item_class .= " menu-item-active ";

                if (
                    isset($item["submenu"]["type"]) &&
                    $item["submenu"]["type"] == "tabs"
                ) {
                    $item_class .= " menu-item-active-tab ";
                }
            }

            if (isset($item["submenu"])) {
                $item_class .= " menu-item-submenu"; // m-menu__item--active

                if (isset($item["toggle"]) && $item["toggle"] == "click") {
                    $item_attr .= ' data-menu-toggle="click"';
                } elseif (
                    isset($item["submenu"]["type"]) &&
                    $item["submenu"]["type"] == "tabs"
                ) {
                    $item_attr .= ' data-menu-toggle="tab"';
                } else {
                    $item_attr .= ' data-menu-toggle="hover"';
                }
            }

            if (@isset($item["redirect"]) && $item["redirect"] === true) {
                $item_attr .= ' data-menu-redirect="1"';
            }

            if (isset($item["submenu"])) {
                if (!isset($item["submenu"]["type"])) {
                    // default option
                    $item["submenu"]["type"] = "classic";
                    $item["submenu"]["alignment"] = "right";
                }
                if (
                    $item["submenu"]["type"] == "classic" &&
                    isset($item["root"])
                ) {
                    $item_class .= " menu-item-rel";
                }

                if (
                    $item["submenu"]["type"] == "mega" &&
                    isset($item["root"]) &&
                    @$item["align"] != "center"
                ) {
                    $item_class .= " menu-item-rel";
                }

                if ($item["submenu"]["type"] == "tabs") {
                    $item_class .= " menu-item-tabs";
                }
            }

            if (
                isset($item["submenu"]["items"]) &&
                self::isActiveHorMenuItem($item["submenu"], request()->path())
            ) {
                $item_class .= " menu-item-open menu-item-here"; // m-menu__item--active
            }

            if (isset($item["custom-class"])) {
                $item_class .= " " . $item["custom-class"];
            }

            if (isset($item["icon-only"]) && $item["icon-only"] == true) {
                $item_class .= " menu-item-icon-only";
            }

            if (isset($item["heading"]) == false) {
                echo '<li class="menu-item ' .
                    $item_class .
                    '" ' .
                    $item_attr .
                    ' aria-haspopup="true">';
            }

            // check if code is provided instead of link
            if (isset($item["code"])) {
                echo $item["code"];
            } else {
                // insert title or heading
                if (isset($item["heading"]) == false) {
                    $url = "#";

                    if (isset($item["page"])) {
                        $url = url($item["page"]);
                    }

                    $target = "";
                    if (isset($item["new-tab"]) && $item["new-tab"] == true) {
                        $target = 'target="_blank"';
                    }

                    echo "<a " .
                        $target .
                        ' href="' .
                        $url .
                        '" class="menu-link ' .
                        (isset($item["submenu"]) ? "menu-toggle" : "") .
                        '">';
                } else {
                    echo '<h3 class="menu-heading menu-toggle">';
                }

                // put root level arrow
                if (isset($item["here"]) && $item["here"] === true) {
                    echo '<span class="menu-item-here"></span>';
                }

                // bullet
                $bullet = "";

                if (
                    (@$item["heading"] && @$item["bullet"] == "dot") ||
                    @$parent["bullet"] == "dot"
                ) {
                    $bullet = "dot";
                } elseif (
                    (@$item["heading"] && @$item["bullet"] == "line") ||
                    @$parent["bullet"] == "line"
                ) {
                    $bullet = "line";
                }

                // Menu icon OR bullet
                if ($bullet == "dot") {
                    echo '<i class="menu-bullet menu-bullet-dot"><span></span></i>';
                } elseif ($bullet == "line") {
                    echo '<i class="menu-bullet menu-bullet-line"><span></span></i>';
                } elseif (isset($item["icon"]) && !empty($item["icon"])) {
                    self::renderIcon($item["icon"]);
                }

                // Badge
                echo '<span class="menu-text">' . $item["title"] . "</span>";
                if (isset($item["label"])) {
                    echo '<span class="menu-badge"><span class="label ' .
                        $item["label"]["type"] .
                        '">' .
                        $item["label"]["value"] .
                        "</span></span>";
                }
                // Arrow
                if (
                    isset($item["submenu"]) &&
                    (!isset($item["arrow"]) || $item["arrow"] != false)
                ) {
                    // root down arrow
                    if (isset($item["root"])) {
                        // enable/disable root arrow
                        if (
                            config("layout.header.menu.self.root-arrow") !==
                            false
                        ) {
                            echo '<i class="menu-hor-arrow"></i>';
                        }
                    } else {
                        // inner menu arrow
                        echo '<i class="menu-hor-arrow"></i>';
                    }
                    echo '<i class="menu-arrow"></i>';
                }

                // closing title or heading
                if (isset($item["heading"]) == false) {
                    echo "</a>";
                } else {
                    echo '<i class="menu-arrow"></i></h3>';
                }

                if (isset($item["submenu"])) {
                    if (
                        in_array($item["submenu"]["type"], ["classic", "tabs"])
                    ) {
                        if (isset($item["submenu"]["alignment"])) {
                            $submenu_class =
                                " menu-submenu-" .
                                $item["submenu"]["alignment"];

                            if (
                                isset($item["submenu"]["pull"]) &&
                                $item["submenu"]["pull"] == true
                            ) {
                                $submenu_class .= " menu-submenu-pull";
                            }
                        }

                        if ($item["submenu"]["type"] == "tabs") {
                            $submenu_class .= " menu-submenu-tabs";
                        }

                        echo '<div class="menu-submenu menu-submenu-classic' .
                            $submenu_class .
                            '">';

                        echo '<ul class="menu-subnav">';
                        $items = [];
                        if (isset($item["submenu"]["items"])) {
                            $items = $item["submenu"]["items"];
                        } else {
                            $items = $item["submenu"];
                        }
                        foreach ($items as $submenu_item) {
                            self::renderHorMenu($submenu_item, $item, $rec++);
                        }
                        echo "</ul>";
                        echo "</div>";
                    } elseif ($item["submenu"]["type"] == "mega") {
                        $submenu_fixed_width = "";

                        if (intval(@$item["submenu"]["width"]) > 0) {
                            $submenu_class = " menu-submenu-fixed";
                            $submenu_fixed_width =
                                'style="width:' .
                                $item["submenu"]["width"] .
                                '"';
                        } else {
                            $submenu_class =
                                " menu-submenu-" . $item["submenu"]["width"];
                        }

                        if (isset($item["submenu"]["alignment"])) {
                            $submenu_class .=
                                " menu-submenu-" .
                                $item["submenu"]["alignment"];

                            if (
                                isset($item["submenu"]["pull"]) &&
                                $item["submenu"]["pull"] == true
                            ) {
                                $submenu_class .= " menu-submenu-pull";
                            }
                        }

                        echo '<div class="menu-submenu ' .
                            $submenu_class .
                            '" ' .
                            $submenu_fixed_width .
                            ">";

                        echo '<div class="menu-subnav">';
                        echo '<ul class="menu-content">';
                        foreach ($item["submenu"]["columns"] as $column) {
                            $item_class = "";
                            // mega menu column header active
                            if (
                                isset($column["items"]) &&
                                self::isActiveVerMenuItem(
                                    $column,
                                    request()->path()
                                )
                            ) {
                                $item_class .= " menu-item-open menu-item-here"; // m-menu__item--active
                            }

                            echo '<li class="menu-item ' . $item_class . '">';
                            if (isset($column["heading"])) {
                                self::renderHorMenu(
                                    $column["heading"],
                                    null,
                                    $rec++
                                );
                            }
                            echo '<ul class="menu-inner">';
                            foreach ($column["items"] as $column_submenu_item) {
                                self::renderHorMenu(
                                    $column_submenu_item,
                                    $column,
                                    $rec++
                                );
                            }
                            echo "</ul>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }

            if (isset($item["heading"]) == false) {
                echo "</li>";
            }
        } elseif (is_array($item)) {
            foreach ($item as $each) {
                self::renderHorMenu($each, $parent, $rec++);
            }
        }
    }

    // Check for active Vertical Menu item
    public static function isActiveVerMenuItem($item, $page, $rec = 0)
    {
        if (isset($item["redirect"]) && $item["redirect"] === true) {
            return false;
        }

        self::checkRecursion($rec);

        if (isset($item["page"]) && $item["page"] == $page) {
            return true;
        }

        if (is_array($item)) {
            foreach ($item as $each) {
                if (self::isActiveVerMenuItem($each, $page, $rec++)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Check for active Horizontal Menu item
    public static function isActiveHorMenuItem($item, $page, $rec = 0)
    {
        if (@isset($item["redirect"]) && $item["redirect"] === true) {
            return false;
        }

        self::checkRecursion($rec);

        if (isset($item["page"]) && $item["page"] == $page) {
            return true;
        }

        if (is_array($item)) {
            foreach ($item as $each) {
                if (self::isActiveHorMenuItem($each, $page, $rec++)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Checks recursion depth
    public static function checkRecursion($rec, $max = 10000)
    {
        if ($rec > $max) {
            echo "Too many recursions!!!";
            exit();
        }
    }

    // Render icon or bullet
    public static function renderIcon($icon)
    {

        echo '<i class="menu-icon ' . $icon . '"></i>';
        
    }

    public static function updateMenuHeader($data)
    {
        $starting_string = "<?php return ";
        $ending_string = ";";
        $header_top_shortcuts = $data->header_top_shortcuts;
        $quick_actions = $data->quick_actions;

        $return_data = [
            'items' => [
                [
                    'title' => 'Dashboard',
                    'root' => true,
                    'page' => '/admin/dashboard',
                    'new-tab' => false,
                ],

                [
                    'title' => 'Shortcuts',
                    'root' => true,
                    'toggle' => 'click',
                    'submenu' => [
                        'type' => 'classic',
                        'alignment' => 'left',
                        'items' => [
                            [
                                'title' => 'Users',
                                'page' => '/admin/users',
                                'new-tab' => false,
                                'icon' => 'fa-user',

                            ],

                            [
                                'title' => 'Admins',
                                'page' => '/admin/admins',
                                'new-tab' => false,
                                'icon' => 'fa-user',

                            ],
                        ]
                    ]
                ],
                [
                    'title' => 'Profile',
                    'root' => true,
                    'page' => '/admin/profile',
                    'new-tab' => false,
                ],

                [
                    'title' => 'Settings',
                    'root' => true,
                    'page' => '/admin/settings',
                    'new-tab' => false,
                ],


            ],
            'quick_actions' => [],

        ];
        $return_data['items'][1]['submenu']['items'] = $header_top_shortcuts;
        $return_data['quick_actions'] = $quick_actions;
        $menu_header_file = fopen(base_path("config/menu_header.php"), 'w');
        fwrite($menu_header_file, $starting_string . var_export($return_data, true) . $ending_string);
        Artisan::call('config:cache');
        Artisan::call('optimize:clear');
        return true;
    }
    public static function updateLeftSidebar($data)
    {
        $starting_string = "<?php return ";
        $ending_string = ";";
        $left_sidebar_menus_file = fopen(base_path("config/left_sidebar_menus.php"), 'w');
        fwrite($left_sidebar_menus_file, $starting_string . var_export($data, true) . $ending_string);
        Artisan::call('config:cache');
        Artisan::call('optimize:clear');

        return true;
    }

    public static function checkPermission($item)
    {
        $permission=false;
        if(isset($item['permission']) && $item['permission']!='')
        {
            $permission_keys = explode(',',$item['permission']);
            $permission_keys=array_diff($permission_keys, [null]);
            foreach($permission_keys as $permission_key)
            {
                if(!in_array($permission_key,self::$ignore_permission))
                {
                    $permission=Gate::allows($permission_key.'-view');
                }
                else
                {
                    $permission=true;
                }

                if($permission)
                {
                    return true;
                }
            }
            return false;

        }
        else
        {
            return true;
        }

    }

    public static function renderDragDropMenus($all_menus,$menus)
    {
        echo '<ol class="dd-list">';



        foreach($menus as $menu)
        {
            $active_class=$menu->is_active? "success":"danger";
            $active_title=$menu->is_active? "active":"inactive";

            echo '<li class="dd-item" data-id="' . $menu->id . '">
                        <div class="dd-handle bg-light-primary rounded">
                            <div class="dd-item-inner d-flex align-items-center justify-content-between">
                                <div class="dd-item-text">
                                    <span class="svg-icon menu-icon svg-icon-danger mr-5">
                                        <i class="lni lni-layout"></i>
                                    </span>'
                                    . $menu->title .
                                '</div>
                                <div class="dd-item-toolbar d-flex gap-3 align-items-center">
                                    <span class="badge badge-'.$active_class.'">'.$active_title.'</span>
                                    <ul class="trk-action__list dd-nodrag">
                                        <li class="trk-action"><a class="trk-action__item trk-action__item--warning" href="' . route('admin.admin-menus.edit', $menu->id) . '"><i
                                                class="lni lni-pencil-alt"></i></a>
                                        </li>
                                        <li class="trk-action">
                                            <a onclick="Delete(\'' . route('admin.admin-menus.destroy', $menu->id) . '\')" class="trk-action__item trk-action__item--danger">
                                                <i class="lni lni-trash-can"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>';

            if(isset($all_menus[$menu->id]))
            {
                $sub_menus=$all_menus[$menu->id];


                self::renderDragDropMenus($all_menus,$sub_menus);
                
            }
            

            echo '</li>';
        }

        echo '</ol>';    

        
    }


    public static function renderVerMenu($menuItems) {
        echo '<ul class="menu-nav metismenu" id="menu-nav">';
        foreach ($menuItems[0] as $menuItem) 
        {
            if(self::checkPermission($menuItem))
            {
                if (isset($menuItem['title'])) 
                {
                    if(isset($menuItem['submenu']))
                    {
                        echo '<li class="menu-item menu-item-submenu" aria-haspopup="false" data-menu-toggle="hover">';
                        echo '<a href="javascript:;" class="menu-link menu-toggle" aria-expanded="false">';
                    }
                    else
                    {
                        if('/'.request()->path()==$menuItem['page'])
                        {
                            echo '<li class="menu-item mm-active" aria-haspopup="true" data-menu-toggle="hover">';
                        }
                        else
                        {
                            echo '<li class="menu-item" aria-haspopup="true" data-menu-toggle="hover">';
                        }
                        echo '<a href="'.url(isset($menuItem['page'])? $menuItem['page']:'').'" class="menu-link menu-toggle">';
                    }
                    echo '<span class="menu-icon"><i class="' . $menuItem['icon'] . '" aria-hidden="true"></i></span>';
                    echo '<span class="menu-text">' . $menuItem['title'] . '</span>';

                    // echo '<span class="menu-label">
                    //             <span class="label label-rounded label-warning">6</span>
                    //         </span>';

                    if (isset($menuItem['submenu'])) 
                    {
            
                        echo '<i class="menu-arrow"></i>';
        
                        echo '</a>';
                        echo '<ul class="submenu">';
                        foreach($menuItem['submenu'] as $subOfMain)
                        {
                            echo '<li class="menu-item" aria-haspopup="false" data-menu-toggle="hover">';
                            self::generateSidebarSubMenuItem($subOfMain);
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    else
                    {
                        echo '</a>';
                    }
        
                    echo '</li>';
                } 
                else if (isset($menuItem['section'])) 
                {
                    echo '<li class="menu-section"><h6 class="menu-text">' . $menuItem['section'] . '</h6></li>';
                }
                else if (isset($menuItem['separator'])) 
                {
                    echo '<span class="divider"><hr></span>';
                }
            }
            
        }
        echo '</ul>';
    }


    public static function generateSidebarSubMenuItem($subOfMain)
    {
        if(self::checkPermission($subOfMain))
        {
            if (isset($subOfMain['title'])) 
            {
                if(!isset($subOfMain['submenu']))
                {
                    echo '<a href="'.url($subOfMain['page']).'" class="menu-link menu-toggle">';
                    echo '<span class="menu-text">'.$subOfMain['title'].'</span>';
                        
                    // echo '<span class="menu-label">
                    //             <span class="label label-rounded label-warning">6</span>
                    //         </span>';

                    
                    echo '</a>';
                }
                else
                {
                    echo '<a href="javascript:;" class="menu-link submenu-toggle">';
                    echo '<span class="menu-text">'.$subOfMain['title'].'</span>';
                        
                    // echo '<span class="menu-label">
                    //             <span class="label label-rounded label-warning">6</span>
                    //         </span>';

                    echo '<i class="menu-arrow"></i>';

                    echo '</a>';

                    echo '<ul class="submenu">';
                    foreach($subOfMain['submenu'] as $subOfSub)
                    {
                        echo '<li class="menu-item" aria-haspopup="false" data-menu-toggle="hover">';
                        self::generateSidebarSubMenuItem($subOfSub);
                        echo '</li>';
                    }
                    echo '</ul>';
                }
            }
            else if (isset($subOfMain['section'])) 
            {
                echo '<li class="menu-section"><h6 class="menu-text">' . $subOfMain['section'] . '</h6></li>';
            }
            else if (isset($subOfMain['separator'])) 
            {
                echo '<span class="divider"><hr></span>';
            }
        }
            
    }

}
