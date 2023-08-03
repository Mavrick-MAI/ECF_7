<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

use WebAppSeller\Models\Equipe;

class EquipeController extends ControllerBase
{

    public function indexAction()
    {
        $equipeHTML = "";
        $equipeList = Equipe::find();
        $listColumnName = ['Nom', 'Prénom', 'Niveau', 'Role'];

        foreach ($equipeList as $equipe) {

            $equipeHTML .= "<h2 class='mt-4'>".$equipe->getNom()."</h2>";

            $equipeHTML .= "<table class='table'>";
            $equipeHTML .= "<thead class='table-dark fs-5'>";
            $equipeHTML .= "<tr>";

            foreach ($listColumnName as $colName) {
                $equipeHTML .= "<td>$colName</td>";
            }

            $equipeHTML .= "</tr>";
            $equipeHTML .= "</thead>";
            $equipeHTML .= "<tbody class='table-group-divider'>";

            $chefEquipe = $equipe->ChefDeProjet->Collaborateur;

            $equipeHTML .= "<tr>";
            $equipeHTML .= "<td>".$chefEquipe->getNom()."</td>";
            $equipeHTML .= "<td>".$chefEquipe->getPrenom()."</td>";
            $equipeHTML .= "<td>".$chefEquipe->getNiveauLibelle()."</td>";
            $equipeHTML .= "<td>Chef d'équipe</td>";
            $equipeHTML .= "</tr>";

            foreach ($equipe->CompositionEquipe as $dev) {

                $devCompetence = $dev->Developpeur->getCompetenceLibelle();
                $collab = $dev->Developpeur->Collaborateur;

                $equipeHTML .= "<tr>";
                $equipeHTML .= "<td>".$collab->getNom()."</td>";
                $equipeHTML .= "<td>".$collab->getPrenom()."</td>";
                $equipeHTML .= "<td>".$collab->getNiveauLibelle()."</td>";
                $equipeHTML .= "<td>Développeur ".$devCompetence."</td>";
                $equipeHTML .= "</tr>";
            }
            $equipeHTML .= "</tbody>";
            $equipeHTML .= "</table>";
        }

        $this->view->setVar('equipe', $equipeHTML);
    }

}