<?php

namespace App\Views;


// You can use both class-based and function-based views and mix them as you wish.
// Class-based views are just COLLECTIONS. 
// Sobo_Fw doesn't impose any "Controller" interfaces by design, but you may 
// create some if you find them useful (I don't).

class DashboardForUser {
    public function dashboard() {
        echo "Dashboard - the home page for logged-in users.";
    }
}
