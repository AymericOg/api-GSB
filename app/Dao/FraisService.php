<?php

namespace App\Dao;

use App\Models\Frai;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class FraisService
{
    public function getfrais($idFrais){
        try{
        $frais = Frai::query()
            ->select()->distinct()
            ->where('id_frais','=',$idFrais)
            ->join('etat','frais.id_etat','=','etat.id_etat')
            ->get();
        return $frais;
    }catch(Exception $e){
            throw new Exception($e->getMessage(),5);
        }
    }
    public function savefrais($frais)
    {
        try{
            $frais->save();
        }catch(Exception $e){
            throw new Exception($e->getMessage(),5);
        }
    }

    public function deleteFrai($idfrais){
        try{
            $res = Frai::destroy($idfrais);
            return $res;
        }catch (Exception $e ){
            throw new Exception($e->getMessage(),5);
        }
}
public function getlistefrais($id_visiteur){
        try{
            $listefrais = Frai::query()
                ->select()
                ->join('etat','etat.id_etat','=','frais.id_etat')
                ->where('id_visiteur','=',$id_visiteur)
                ->get();
            return $listefrais;

        }catch(Exception $e){
            throw new Exception($e->getMessage(),5);

        }
}


}
