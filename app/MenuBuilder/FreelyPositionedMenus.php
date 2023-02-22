<?php
/*
17.12.2019
FreelyPositionedMenus,php
*/

namespace App\MenuBuilder;

class FreelyPositionedMenus{

    private static function renderDropdown($data, $prefixClass){
        if(array_key_exists('slug', $data) && $data['slug'] === 'dropdown'){
            echo '<li class="' . $prefixClass . 'nav-item dropdown">';
            echo '<a class="' . $prefixClass . 'nav-link dropdown-toggle" data-coreui-toggle="dropdown" role="button" aria-expanded="false" href="#">';
            if($data['hasIcon'] === true && $data['iconType'] === 'coreui'){
                //echo '<i class="' . $data['icon'] . ' ' . $prefixClass . 'nav-icon"></i>';    
                echo '<svg class="nav-icon">';
                echo '    <use xlink:href="'.asset("vendors/@coreui/icons/sprites/free.svg#".$data['icon']).'"></use>';
                echo '</svg>';
            }
            echo $data['name'] . '</a>';
            echo '<div class="dropdown-menu">';
            self::renderDropdown( $data['elements'], $prefixClass );
            echo '</div></li>';
        }else{
            for($i = 0; $i < count($data); $i++){
                if( $data[$i]['slug'] === 'link' ){
                    // echo '<a class="' . $prefixClass . 'dropdown-item" href="' . env('APP_URL', '') . $data[$i]['href'] . '">';
                    echo '<a class="' . $prefixClass . 'dropdown-item" href="' . $data[$i]['href'] . '">';
                    echo '<span class="' . $prefixClass . 'nav-icon"></span>' . $data[$i]['name'] . '</a>';
                }elseif( $data[$i]['slug'] === 'dropdown' ){
                    self::renderDropdown( $data[$i], $prefixClass );
                }
            }
        }
    }

    /**
     * Render menu nav
     * @param  $data - array, result of GetSidebarMenu->get function
     * @param  $prefixClass - prefix to be placed before detailed classes
     * @param  $navClass - class to be placed in nav 
     */
    public static function render($data, $prefixClass = '', $navClass = ''){
        echo '<ul class="' . $prefixClass . 'nav ' . $navClass . '">';
        foreach($data as $d){
            if($d['slug'] === 'link'){
                echo '<li class="' . $prefixClass .'nav-item">';
                // echo '<a class="' . $prefixClass . 'nav-link" href="' . env('APP_URL', '') . $d['href'] . '">';
                echo '<a class="' . $prefixClass . 'nav-link" href="' . $d['href'] . '">';
                if($d['hasIcon'] === true){
                    if($d['iconType'] === 'coreui'){
                        echo '<i class="' . $d['icon'] . ' ' . $prefixClass . 'nav-icon"></i>';
                    }
                } 
                echo $d['name'];
                echo '</a>';
                echo '</li>';
            }elseif($d['slug'] === 'dropdown'){
                self::renderDropdown($d, $prefixClass);
            }elseif($d['slug'] === 'title'){
                echo '<li class="' . $prefixClass . 'nav-title">';
                if($d['hasIcon'] === true){
                    if($d['iconType'] === 'coreui'){
                        echo '<i class="' . $d['icon'] . ' ' . $prefixClass . 'nav-icon"></i>';
                    }
                } 
                echo $d['name'];
                echo '</li>';
            }
        }
        echo '</ul>';
    }

}