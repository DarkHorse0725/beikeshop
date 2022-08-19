<?php

namespace Beike\Admin\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public string $type;
    public string $msg;

    public function __construct(?string $type = 'success', string $msg)
    {
        $this->type = $type ?? 'success';
        $this->msg = $msg;
    }

    public function render()
    {
        return view('admin::components.alert');
    }
}
