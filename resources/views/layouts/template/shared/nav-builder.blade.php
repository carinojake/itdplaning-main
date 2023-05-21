<?php
/*
    $data = $menuel['elements']
*/

if(!function_exists('renderDropdown')){
    function renderDropdown($data){
        if(array_key_exists('slug', $data) && $data['slug'] === 'dropdown'){
            echo '<li class="nav-group">';
            echo '<a class="nav-link nav-group-toggle" href="#">';
            if($data['hasIcon'] === true && $data['iconType'] === 'coreui'){
                echo '<svg class="nav-icon">';
                echo '    <use xlink:href="'.asset("vendors/@coreui/icons/sprites/free.svg#".$data['icon']).'"></use>';
                echo '</svg>';
            }
            echo $data['name'] . '</a>';
            echo '<ul class="nav-group-items">';
            renderDropdown( $data['elements'] );
            echo '</ul></li>';
        }else{
            for($i = 0; $i < count($data); $i++){
                if( $data[$i]['slug'] === 'link' ){
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . url($data[$i]['href']) . '">';
                    echo '<span class="nav-icon"></span>' . $data[$i]['name'] . '</a></li>';
                }elseif( $data[$i]['slug'] === 'dropdown' ){
                    renderDropdown( $data[$i] );
                }
            }
        }
    }
}
?>

<div class="sidebar sidebar-dark sidebar-fixed bg-dark-gradient" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset("assets/brand/coreui.svg#full") }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset("assets/brand/coreui.svg#signet") }}"></use>
        </svg>
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        @if(isset($appMenus['sidebar menu']))
            @foreach($appMenus['sidebar menu'] as $menuel)
                @if($menuel['slug'] === 'link')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($menuel['href']) }}">
                        @if($menuel['hasIcon'] === true)
                            @if($menuel['iconType'] === 'coreui')
                                <svg class="nav-icon">
                                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#".$menuel['icon'])}}"></use>
                                </svg>
                            @endif
                        @endif
                        {{ $menuel['name'] }}
                        </a>
                    </li>
                @elseif($menuel['slug'] === 'dropdown')
                    <?php renderDropdown($menuel) ?>
                @elseif($menuel['slug'] === 'title')
                    <li class="nav-title">
                        @if($menuel['hasIcon'] === true)
                            @if($menuel['iconType'] === 'coreui')
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#".$menuel['icon'])}}"></use>
                            </svg>
                            @endif
                        @endif
                        {{ $menuel['name'] }}
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
