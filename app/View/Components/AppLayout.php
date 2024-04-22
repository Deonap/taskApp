<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\ProjetoUser;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $projetos = ProjetoUser::all();
        $notsPorVer = false;

        foreach($projetos as $p){
            if(!$p->notificacaoVista){
                $notsPorVer = true;
                break;
            }
        }

        return view('layouts.app', compact(['notsPorVer']));
    }
}
