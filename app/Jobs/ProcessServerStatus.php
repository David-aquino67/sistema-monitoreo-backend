namespace App\Jobs;

use App\Models\Heartbeat;
use App\Events\ServerStatusCambio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessServerStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mapeo;

    public function __construct($mapeo)
    {
        $this->mapeo = $mapeo;
    }

    public function handle()
    {
        // Buscamos el estado en MariaDB (Kuma)
        $ultimoEstado = Heartbeat::where('monitor_id', $this->mapeo->FK_id_monitor_kuma)
            ->orderBy('time', 'desc')
            ->first();

        if ($ultimoEstado) {
            // Disparamos el evento
            event(new ServerStatusCambio([
                'sibop_id' => $this->mapeo->FK_id_unidad,
                'status'   => $ultimoEstado->status,
                'ping'     => $ultimoEstado->ping,
                'time'     => $ultimoEstado->time
            ]));
        }
    }
}