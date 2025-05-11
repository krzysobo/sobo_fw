<?php
namespace App\Views;

use Sobo_fw\Utils\App\AppMain;
use Sobo_fw\Utils\App\AppKernel;
use Soboutils\SoboTemplate;

// You can use both class-based and function-based views and mix them as you wish.
// Class-based views are just COLLECTIONS.
// Sobo_Fw doesn't impose any "Controller" interfaces by design, but you may
// create some if you find them useful (I don't).


function get_menu()
{
    $res = SoboTemplate::instance()->renderPathArray(
        [AppMain::instance()->getTemplatePath(),
            'sobo_template', 'whole_page', 'parts', 'menu.phtml'],
        ['items' => get_menu_items()]);
    return $res;
}

function get_menu_items()
{
    $items = [
        ["/", "Home Page", 0],
        ["/about-us", "About Us", 0],
        ["/help", "Help", 0],
        ["/contact-us", "Contact Us", 0],
        ["/privacy-policy", "Privacy Policy", 0],
    ];

    $req = AppKernel::instance()->getRequest();
    $path_info = $req->getPathInfo();
    foreach($items as $i=> $item) {
        if ($item[0] == $path_info) {
            $items[$i][2] = 1;
        }
    }

    return $items;
}

