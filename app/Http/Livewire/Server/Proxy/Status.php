<?php

namespace App\Http\Livewire\Server\Proxy;

use App\Jobs\ProxyContainerStatusJob;
use App\Models\Server;
use Livewire\Component;

class Status extends Component
{
    public Server $server;
    protected $listeners = ['proxyStatusUpdated', 'serverValidated' => 'proxyStatusUpdated'];
    public function proxyStatusUpdated()
    {
        $this->server->refresh();
    }
    public function proxyStatus()
    {
        try {
            dispatch(new ProxyContainerStatusJob(
                server: $this->server
            ));
            $this->emit('proxyStatusUpdated');
        } catch (\Exception $e) {
            ray($e->getMessage());
        }
    }
}
