<?php 

namespace App\Libraries;

class HeadingPointer {
    public function show(array $params)
    {
        return view('layouts/components/heading_pointer', $params);
    }
}
?>