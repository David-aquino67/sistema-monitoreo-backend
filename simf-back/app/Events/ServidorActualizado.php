class ServidorActualizado implements ShouldBroadcast
{
use Dispatchable, InteractsWithSockets, SerializesModels;

public $servidor;

public function __construct($servidor)
{
$this->servidor = $servidor; // Los datos del servidor actualizado
}

public function broadcastOn(): array
{
// Canal público donde todos los dashboards escuchan
return [
new Channel('monitoreo-global'),
];
}
}
