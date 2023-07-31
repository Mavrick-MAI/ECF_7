<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

use WebAppSeller\Models\Equipe;

class EquipeController extends ControllerBase
{

    public function indexAction()
    {
        $equipeList = Equipe::find();
        $listColumnName = ['Nom', 'Prénom', 'Niveau', 'Role'];

        foreach ($equipeList as $equipe) {

            $equipeName = $equipe->getNom();
            $equipeChef = $equipe->getRelated('ChefDeProjet')->getRelated('Collaborateur');

            $compoEquipe = $equipe->getRelated('CompositionEquipe');

            $equipeHTML .= "<h2 class='mt-4'>$equipeName</h2>";

            $equipeHTML .= "<table class='table'>";
            $equipeHTML .= "<thead class='table-dark fs-5'>";
            $equipeHTML .= "<tr>";

            foreach ($listColumnName as $colName) {
                $equipeHTML .= "<td>$colName</td>";
            }

            $equipeHTML .= "</tr>";
            $equipeHTML .= "</thead>";
            $equipeHTML .= "<tbody class='table-group-divider'>";

            $equipeHTML .= "<tr>";
            $equipeHTML .= "<td>".$equipeChef->getNom()."</td>";
            $equipeHTML .= "<td>".$equipeChef->getPrenom()."</td>";
            $equipeHTML .= "<td>".$equipeChef->getNiveauLibelle()."</td>";
            $equipeHTML .= "<td>Chef d'équipe</td>";
            $equipeHTML .= "</tr>";

            foreach ($compoEquipe as $dev) {

                $collabCompetence = $dev->getRelated('Developpeur')->getCompetenceLibelle();
                $collab = $dev->getRelated('Developpeur')->getRelated('Collaborateur');

                $equipeHTML .= "<tr>";
                $equipeHTML .= "<td>".$collab->getNom()."</td>";
                $equipeHTML .= "<td>".$collab->getPrenom()."</td>";
                $equipeHTML .= "<td>".$collab->getNiveauLibelle()."</td>";
                $equipeHTML .= "<td>Développeur ".$collabCompetence."</td>";
                $equipeHTML .= "</tr>";
            }
            $equipeHTML .= "</tbody>";
            $equipeHTML .= "</table>";
        }

        $this->view->setVar('equipe', $equipeHTML);
    }

}