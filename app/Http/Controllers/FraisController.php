<?php

namespace App\Http\Controllers;

use App\Dao\FraisService;
use App\Models\Frai;
use Illuminate\Http\Request;
use Exception;

class FraisController extends Controller
{
    function getFrais($idFrais)
    {
        $ServicegetFrais = new FraisService();
        $frais = $ServicegetFrais->getfrais($idFrais);
        return response()->json($frais);
    }

    function ajoutFrais(Request $Request)
    {
        $frais = new Frai();
        $frais->id_etat = 2;
        $frais->anneemois = $Request->json('anneemois');
        $frais->id_visiteur = $Request->json('id_visiteur');
        $frais->nbjustificatifs = $Request->json('nbjustificatifs');
        $frais->datemodification = now();
        $Service = new FraisService();
        $Service->savefrais($frais);
        $id_frais = $frais->id_frais;

        return response()->json(['message ' => 'Insertion réalisée', 'id_frais' => $id_frais]);
    }

    function modif(Request $Request){
        $frais = new Frai();
        $frais->id_etat = $Request->json('id_frais');
        $frais->anneemois = $Request->json('anneemois');
        $frais->id_visiteur = $Request->json('id_visiteur');
        $frais->nbjustificatifs = $Request->json('nbjustificatifs');
        $frais->id_etat = $Request->json('id_etat');
        $frais->datemodification = now();
        $Service = new FraisService();
        $Service->savefrais($frais);

        return response()->json(['message'=>'Modificaiton réalisée','id_frais'=>$frais->id_frais]);


    }


    function supprimerFrais(Request $request){
       $idFrais = $request->json('id_frais');
       try{
           $service = new FraisService();
           if( $service->deleteFrai($idFrais)){
               return response()->json(['Statuts'=>'Frais supprimer']);
           }else{
               return response()->json(['Statuts'=>'Frais non existant']);
           }
       }catch(Exception $exeception){
           return response()->json(['Status'=> $exeception->getMessage()]);
       }
   }

   function getlistefrais($id_visiteur)
   {
       try {
           $servicelistefrais = new FraisService();
           $listefrais =$servicelistefrais->getlistefrais($id_visiteur);
           return response()->json($listefrais);
       } catch (Exception $e) {
           return response()->json(['Status'=>$e->getMessage()]);
       }
   }

}
