<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'tbl_usuarios';
    protected $primaryKey = 'idUsuario';


    protected $fillable = [
        'idRol',
        'idMembresia',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'fechaNacimiento',
        'celular',
        'idSexo',
        'email',
        'password',
        'passwordVisible',
        'fechaUltimoPago',
        'fechaVigencia',
        'pagoMensualEsperado',
        'eliminado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fechaNacimiento'   => 'date',
        'fechaUltimoPago'   => 'datetime',
        'fechaVigencia'     => 'datetime',
    ];

    public function esAdmin()
    {
        return $this->idRol == 1;
    }

    public function reservas()
    {
        return $this->hasMany(ReservaClase::class, 'idUsuario', 'idUsuario');
    }
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'idUsuario', 'idUsuario');
    }
    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'idMembresia', 'idMembresia');
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'idUsuario', 'idUsuario');
    }

    private function resolverEstatusVigenciaDetallado(): string
    {
        $hoy = \Carbon\Carbon::today();

        if (!$this->fechaVigencia) {
            return 'Sin vigencia';
        }

        $vigencia = \Carbon\Carbon::parse($this->fechaVigencia)->startOfDay();

        if ($vigencia->lt($hoy)) {
            return 'Vencido';
        }

        if ($vigencia->equalTo($hoy)) {
            return 'Vence hoy';
        }

        if ($vigencia->equalTo($hoy->copy()->addDay())) {
            return 'Vence mañana';
        }

        if ($vigencia->lte($hoy->copy()->endOfMonth())) {
            return 'Vence pronto';
        }

        return 'Vigente';
    }

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellidoPaterno . ' ' . $this->apellidoMaterno);
    }
    public function getFechaUltimoPagoTextoAttribute()
    {
        if (!$this->fechaUltimoPago) {
            return 'Sin registro';
        }
        return \Carbon\Carbon::parse($this->fechaUltimoPago)->translatedFormat('d \d\e F \d\e Y');
    }
    public function getFechaVigenciaTextoAttribute()
    {
        if (!$this->fechaVigencia) {
            return 'Sin vigencia';
        }

        return \Carbon\Carbon::parse($this->fechaVigencia)->translatedFormat('d \d\e F \d\e Y');
    }

    public function getEstatusMembresiaAttribute()
    {
        return $this->resolverEstatusVigenciaDetallado();
    }
    public function getEstatusVigenciaAttribute()
    {
        $estatus = $this->resolverEstatusVigenciaDetallado();

        return match ($estatus) {
            'Vence mañana', 'Vence pronto' => 'Vigente',
            default => $estatus,
        };
    }
    public function getBadgeMembresiaAttribute()
    {
        return match ($this->estatus_membresia) {
            'Vigente'       => 'badge-status-success',
            'Vence hoy'     => 'badge-status-warning',
            'Vence mañana'  => 'badge-status-warning',
            'Vence pronto'  => 'badge-status-soon',
            'Vencido'       => 'badge-status-danger',
            default         => 'badge-status-secondary',
        };
    }
    public function getBadgeVigenciaAttribute()
    {
        return match ($this->estatus_vigencia) {
            'Vigente'       => 'badge-status-success',
            'Vence hoy'     => 'badge-status-warning',
            'Vencido'       => 'badge-status-danger',
            default         => 'badge-status-secondary',
        };
    }
    public function getBadgeCobranzaAttribute()
    {
        return match ($this->estatus_pago ?? null) {
            'Vigente'           => 'badge-status-success',
            'Vence hoy'         => 'badge-status-warning',
            'Vence mañana'      => 'badge-status-warning',
            'Vence pronto'      => 'badge-status-soon',
            'Vencido'           => 'badge-status-danger',
            'Sin vigencia'      => 'badge-status-secondary',
            default             => 'badge-status-secondary',
        };
    }

    public function getMontoUltimoPagoAttribute()
    {

        if ($this->relationLoaded('pagos') && $this->pagos->isNotEmpty()) {
            return $this->pagos->first()->monto;
        }

        $ultimoPago = $this->pagos()
            ->where('eliminado', 0)
            ->orderByDesc('fechaPago')
            ->first();

        return $ultimoPago?->monto;
    }
    public function getDiferenciaPagoAttribute()
    {
        if (is_null($this->monto_ultimo_pago) || is_null($this->pagoMensualEsperado)) {
            return null;
        }

        return $this->monto_ultimo_pago - $this->pagoMensualEsperado;
    }
    public function getEstadoPagoAttribute()
    {
        if (is_null($this->monto_ultimo_pago)) {
            return 'Sin pago';
        }

        if (is_null($this->pagoMensualEsperado)) {
            return 'Sin referencia';
        }

        $diff = $this->diferencia_pago;

        if ($diff == 0) {
            return 'Correcto';
        }

        if ($diff < 0) {
            return 'Menor';
        }

        return 'Mayor';
    }
    public function getBadgePagoAttribute()
    {
        return match ($this->estado_pago) {
            'Correcto' => 'badge-status-success',
            'Menor' => 'badge-status-danger',
            'Mayor' => 'badge-status-warning',
            'Sin pago' => 'badge-status-secondary',
            default => 'badge-status-secondary',
        };
    }



    public static function getUsuario($idUsuario)
    {

        $usuario = DB::table('tbl_usuarios')
            ->join('cat_roles', 'tbl_usuarios.idRol', '=', 'cat_roles.idRol')
            ->join('cat_sexos', 'tbl_usuarios.idSexo', '=', 'cat_sexos.idSexo')
            ->where('tbl_usuarios.eliminado', '=', 0)
            ->where('tbl_usuarios.idUsuario', '=', $idUsuario)
            ->select(
                'tbl_usuarios.idUsuario',
                'tbl_usuarios.idRol',
                'cat_roles.rol',
                'tbl_usuarios.nombre',
                'tbl_usuarios.apellidoPaterno',
                'tbl_usuarios.apellidoMaterno',
                'tbl_usuarios.celular',
                'tbl_usuarios.idSexo',
                'cat_sexos.sexo',
                'tbl_usuarios.fechaNacimiento',
                'tbl_usuarios.email',
                'tbl_usuarios.password',
                'tbl_usuarios.passwordVisible',

                'tbl_usuarios.fechaUltimoPago',
                'tbl_usuarios.fechaVigencia',
                'tbl_usuarios.created_at'
            )
            ->first();

        return $usuario;

    }
    public static function getAllAUsuarios($idStatus)
    {
        $usuarios = DB::table('tbl_usuarios')
            ->join('cat_roles', 'tbl_usuarios.idRol', '=', 'cat_roles.idRol')
            ->where('tbl_usuarios.eliminado',  0)
            ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
            })
            ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
            })
            ->select(
                'tbl_usuarios.idUsuario',
                'tbl_usuarios.idRol',
                'cat_roles.rol',
                'tbl_usuarios.nombre',
                'tbl_usuarios.apellidoPaterno',
                'tbl_usuarios.apellidoMaterno',
                'tbl_usuarios.celular',
                'tbl_usuarios.idSexo',
                'tbl_usuarios.fechaNacimiento',
                'tbl_usuarios.email',
                'tbl_usuarios.password',
                'tbl_usuarios.passwordVisible',

                'tbl_usuarios.fechaUltimoPago',
                'tbl_usuarios.fechaVigencia',
            )
            ->orderBy('idUsuario','DESC')
            ->paginate(100);

        return $usuarios;

    }
    public static function getAllAUsuariosLike($txtBuscar,$idStatus)
    {

        $usuarios = DB::table('tbl_usuarios')
            ->join('cat_roles', 'tbl_usuarios.idRol', '=', 'cat_roles.idRol')
            ->where(function($query) use ($txtBuscar,$idStatus) {
                $query->where('tbl_usuarios.nombre', "LIKE", "%$txtBuscar%")
                    ->where('tbl_usuarios.eliminado',0)
                    ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
                    })
                    ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
                    });
            })
            ->orWhere(function($query) use ($txtBuscar,$idStatus) {
                $query->where('tbl_usuarios.apellidoPaterno', "LIKE", "%$txtBuscar%")
                    ->where('tbl_usuarios.eliminado',0)
                    ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
                    })
                    ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
                    });
            })
            ->orWhere(function($query) use ($txtBuscar,$idStatus) {
                $query->where('tbl_usuarios.apellidoMaterno', "LIKE", "%$txtBuscar%")
                    ->where('tbl_usuarios.eliminado',0)
                    ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
                    })
                    ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
                    });
            })
            ->orWhere(function ($query) use ($txtBuscar,$idStatus) {
                $query->where(DB::raw("CONCAT_WS(' ',tbl_usuarios.apellidoPaterno,tbl_usuarios.apellidoMaterno,tbl_usuarios.nombre)"), "LIKE", "%$txtBuscar%")
                    ->where('tbl_usuarios.eliminado',0)
                    ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
                    })
                    ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
                    });
            })
            ->orWhere(function ($query) use ($txtBuscar,$idStatus) {
                $query->where(DB::raw("CONCAT_WS(' ',tbl_usuarios.nombre,tbl_usuarios.apellidoPaterno,tbl_usuarios.apellidoMaterno)"), "LIKE", "%$txtBuscar%")
                    ->where('tbl_usuarios.eliminado',0)
                    ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
                    })
                    ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
                    });
            })
            ->orWhere(function($query) use ($txtBuscar,$idStatus) {
                $query->where('tbl_usuarios.email', "LIKE", "%$txtBuscar%")
                    ->where('tbl_usuarios.eliminado',0)
                    ->when(!empty($idStatus) && $idStatus == 1, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','>=',\Carbon\Carbon::now());
                    })
                    ->when(!empty($idStatus) && $idStatus == 2, function ($query) use ($idStatus) {
                        return $query->where('tbl_usuarios.fechaVigencia','<',\Carbon\Carbon::now())->orWhereNull('tbl_usuarios.fechaVigencia');
                    });
            })
            ->select(
                'tbl_usuarios.idUsuario',
                'tbl_usuarios.idRol',
                'cat_roles.rol',
                'tbl_usuarios.nombre',
                'tbl_usuarios.apellidoPaterno',
                'tbl_usuarios.apellidoMaterno',
                'tbl_usuarios.celular',
                'tbl_usuarios.idSexo',
                'tbl_usuarios.fechaNacimiento',
                'tbl_usuarios.email',
                'tbl_usuarios.password',
                'tbl_usuarios.passwordVisible',

                'tbl_usuarios.fechaUltimoPago',
                'tbl_usuarios.fechaVigencia'
            )
            ->orderBy('idUsuario','DESC')
            ->paginate(100);

        return $usuarios;

    }
    public static function getAllAUsuariosLikeExport($txtBuscar, $idStatus)
    {
        $now = \Carbon\Carbon::now();

        $usuarios = DB::table('tbl_usuarios as u')
            ->join('cat_roles as r', 'u.idRol', '=', 'r.idRol')
            ->join('cat_sexos as s', 'u.idSexo', '=', 's.idSexo')
            ->where('u.eliminado', 0)
            ->when(!empty($idStatus) && (int)$idStatus === 1, function ($q) use ($now) {
                $q->where('u.fechaVigencia', '>=', $now);
            })
            ->when(!empty($idStatus) && (int)$idStatus === 2, function ($q) use ($now) {
                $q->where(function ($qq) use ($now) {
                    $qq->where('u.fechaVigencia', '<', $now)->orWhereNull('u.fechaVigencia');
                });
            })
            ->when(!empty($txtBuscar), function ($q) use ($txtBuscar) {
                $like = '%' . $txtBuscar . '%';

                $q->where(function ($qq) use ($like) {
                    $qq->where('u.nombre', 'like', $like)
                        ->orWhere('u.apellidoPaterno', 'like', $like)
                        ->orWhere('u.apellidoMaterno', 'like', $like)
                        ->orWhere('u.email', 'like', $like)
                        ->orWhereRaw("CONCAT_WS(' ', u.apellidoPaterno, u.apellidoMaterno, u.nombre) like ?", [$like])
                        ->orWhereRaw("CONCAT_WS(' ', u.nombre, u.apellidoPaterno, u.apellidoMaterno) like ?", [$like]);
                });
            })
            ->select(
                'u.idUsuario',
                'u.idRol',
                'r.rol',
                'u.nombre',
                'u.apellidoPaterno',
                'u.apellidoMaterno',
                'u.celular',
                'u.idSexo',
                's.sexo',
                'u.fechaNacimiento',
                'u.email',
                'u.password',
                'u.passwordVisible',
                'u.fechaUltimoPago',
                'u.fechaVigencia',
                'u.created_at',
                DB::raw("(SELECT p.monto FROM tbl_pagos p WHERE p.idUsuario = u.idUsuario AND p.eliminado = 0 ORDER BY p.fechaPago DESC LIMIT 1) as montoUltimoPago"),
            )
            ->orderByDesc('u.idUsuario')
            ->get();

        return $usuarios;
    }
    public static function getStatusUsuario($idStatus)
    {
        if($idStatus == 1){
            return 'Activo';
        }
        else{
            return 'Inactivo';
        }
    }



}
